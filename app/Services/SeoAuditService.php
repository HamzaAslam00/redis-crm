<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class SeoAuditService
{
    private const PSI_URL = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed';

    /** @var string[] */
    private const STOP_WORDS = [
        'the', 'a', 'an', 'and', 'or', 'but', 'is', 'are', 'was', 'were', 'be', 'been', 'being', 'have', 'has',
        'had', 'do', 'does', 'did', 'will', 'would', 'could', 'should', 'may', 'might', 'shall', 'can', 'to',
        'of', 'in', 'on', 'at', 'by', 'for', 'with', 'about', 'as', 'into', 'from', 'up', 'out', 'if', 'then',
        'that', 'this', 'these', 'those', 'it', 'its', 'we', 'you', 'your', 'they', 'their', 'them', 'our',
        'my', 'his', 'her', 'i', 'he', 'she', 'not', 'no', 'so', 'all', 'any', 'some', 'more', 'also', 'when',
        'what', 'which', 'who', 'how', 'than', 'there', 'here', 'just', 'get', 'use', 'used', 'very', 'page',
        'site', 'web', 'home', 'more', 'than', 'over', 'like', 'make', 'need', 'help', 'work', 'best', 'top',
    ];

    public function analyze(string $url): array
    {
        $url = $this->normalizeUrl($url);

        [$mobile, $desktop] = $this->fetchPageSpeed($url);
        [$html, $response] = $this->fetchPage($url);
        $onPage = $this->analyzeOnPage($url, $html, $response);

        return [
            'url' => $url,
            'analyzed_at' => now()->toIso8601String(),
            'scores' => $this->extractScores($mobile),
            'desktop_scores' => $this->extractScores($desktop),
            'metrics' => $this->extractMetrics($mobile),
            'desktop_metrics' => $this->extractMetrics($desktop),
            'opportunities' => $this->extractOpportunities($mobile),
            'page_info' => $this->extractPageInfo($mobile),
            'on_page' => $onPage,
        ];
    }

    private function normalizeUrl(string $url): string
    {
        $url = trim($url);
        if (! str_starts_with($url, 'http://') && ! str_starts_with($url, 'https://')) {
            $url = 'https://'.$url;
        }

        return rtrim($url, '/');
    }

    /** @return array{0: string, 1: Response|null} */
    private function fetchPage(string $url): array
    {
        try {
            $resp = Http::timeout(15)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; RedisSEOBot/1.0)'])
                ->get($url);

            return [$resp->body(), $resp];
        } catch (\Throwable) {
            return ['', null];
        }
    }

    /** @return array{0: array, 1: array} */
    private function fetchPageSpeed(string $url): array
    {
        $key = config('services.google.pagespeed_key', '');
        $base = self::PSI_URL.'?'.http_build_query(array_filter([
            'url' => $url,
            'locale' => 'en',
            'key' => $key,
        ]));

        // Google PSI requires repeated `category=` params — PHP array encoding breaks this
        $cats = 'category=performance&category=seo&category=accessibility&category=best-practices';

        $responses = Http::pool(fn (Pool $pool) => [
            $pool->as('mobile')->timeout(90)->get("{$base}&{$cats}&strategy=mobile"),
            $pool->as('desktop')->timeout(90)->get("{$base}&{$cats}&strategy=desktop"),
        ]);

        return [
            $responses['mobile']->json() ?? [],
            $responses['desktop']->json() ?? [],
        ];
    }

    private function extractScores(array $data): array
    {
        $cats = $data['lighthouseResult']['categories'] ?? [];

        return [
            'performance' => (int) round(($cats['performance']['score'] ?? 0) * 100),
            'seo' => (int) round(($cats['seo']['score'] ?? 0) * 100),
            'accessibility' => (int) round(($cats['accessibility']['score'] ?? 0) * 100),
            'best_practices' => (int) round(($cats['best-practices']['score'] ?? 0) * 100),
        ];
    }

    private function extractMetrics(array $data): array
    {
        $audits = $data['lighthouseResult']['audits'] ?? [];
        $pick = fn (string $key) => isset($audits[$key]) ? [
            'display' => $audits[$key]['displayValue'] ?? '—',
            'score' => $audits[$key]['score'] ?? null,
            'numeric' => $audits[$key]['numericValue'] ?? null,
        ] : ['display' => '—', 'score' => null, 'numeric' => null];

        return [
            'fcp' => $pick('first-contentful-paint'),
            'lcp' => $pick('largest-contentful-paint'),
            'tbt' => $pick('total-blocking-time'),
            'cls' => $pick('cumulative-layout-shift'),
            'tti' => $pick('interactive'),
            'speed_index' => $pick('speed-index'),
        ];
    }

    private function extractPageInfo(array $data): array
    {
        $audits = $data['lighthouseResult']['audits'] ?? [];
        $totalBytes = $audits['total-byte-weight']['numericValue'] ?? null;
        $requests = count($audits['network-requests']['details']['items'] ?? []);
        $loadTime = $audits['interactive']['displayValue'] ?? null;

        return [
            'size_kb' => $totalBytes ? (int) round($totalBytes / 1024) : null,
            'requests' => $requests ?: null,
            'load_time' => $loadTime,
        ];
    }

    /** @return array<int, array{title: string, description: string, savings_ms: float|null, score: float}> */
    private function extractOpportunities(array $data): array
    {
        $audits = $data['lighthouseResult']['audits'] ?? [];
        $out = [];

        foreach ($audits as $audit) {
            $type = $audit['details']['type'] ?? null;
            $score = $audit['score'] ?? null;
            if ($type === 'opportunity' && $score !== null && $score < 0.9) {
                $out[] = [
                    'title' => $audit['title'],
                    'description' => $audit['description'],
                    'savings_ms' => $audit['details']['overallSavingsMs'] ?? null,
                    'score' => $score,
                ];
            }
        }

        usort($out, fn ($a, $b) => ($b['savings_ms'] ?? 0) <=> ($a['savings_ms'] ?? 0));

        return array_slice($out, 0, 10);
    }

    private function analyzeOnPage(string $url, string $html, ?Response $response): array
    {
        if (! $html) {
            return $this->emptyOnPage();
        }

        $dom = new DOMDocument;
        @$dom->loadHTML($html, LIBXML_NOERROR);
        $xpath = new DOMXPath($dom);

        $host = (string) parse_url($url, PHP_URL_HOST);
        $scheme = parse_url($url, PHP_URL_SCHEME);
        $domain = $scheme.'://'.$host;

        // ── Title ──────────────────────────────────────────────────────────────
        $titleNode = $xpath->query('//title')->item(0);
        $title = $titleNode ? trim($titleNode->textContent) : null;
        $titleLen = $title ? mb_strlen($title) : 0;

        // ── Meta description ───────────────────────────────────────────────────
        $metaNode = $xpath->query('//meta[@name="description"]/@content')->item(0);
        $desc = $metaNode ? trim($metaNode->value) : null;
        $descLen = $desc ? mb_strlen($desc) : 0;

        // ── Headings ───────────────────────────────────────────────────────────
        $h1Nodes = $xpath->query('//h1');
        $h1Count = $h1Nodes->length;
        $h1Text = $h1Count > 0 ? trim($h1Nodes->item(0)->textContent) : null;
        $h2Count = $xpath->query('//h2')->length;
        $h3Count = $xpath->query('//h3')->length;
        $h4Count = $xpath->query('//h4')->length;

        // ── Images ─────────────────────────────────────────────────────────────
        $imgNodes = $xpath->query('//img');
        $totalImages = $imgNodes->length;
        $imgMissAlt = 0;
        foreach ($imgNodes as $img) {
            if (trim($img->getAttribute('alt')) === '') {
                $imgMissAlt++;
            }
        }

        // ── Links ──────────────────────────────────────────────────────────────
        $internalLinks = 0;
        $externalLinks = 0;
        foreach ($xpath->query('//a[@href]') as $a) {
            $href = $a->getAttribute('href');
            if (str_starts_with($href, 'http')) {
                str_contains($href, $host) ? $internalLinks++ : $externalLinks++;
            } elseif (str_starts_with($href, '/')) {
                $internalLinks++;
            }
        }

        // ── Meta / Technical tags ──────────────────────────────────────────────
        $canonical = $xpath->query('//link[@rel="canonical"]/@href')->item(0);
        $viewport = $xpath->query('//meta[@name="viewport"]/@content')->item(0);
        $ogTitle = $xpath->query('//meta[@property="og:title"]/@content')->item(0);
        $ogDesc = $xpath->query('//meta[@property="og:description"]/@content')->item(0);
        $ogImage = $xpath->query('//meta[@property="og:image"]/@content')->item(0);
        $twitterCard = $xpath->query('//meta[@name="twitter:card"]/@content')->item(0);
        $noindex = $xpath->query('//meta[@name="robots"][contains(@content,"noindex")]')->item(0);
        $isHttps = str_starts_with($url, 'https://');
        $htmlLang = $xpath->query('//html/@lang')->item(0)?->value ?? null;
        $hasFavicon = $xpath->query('//link[contains(@rel,"icon")]')->length > 0;
        $hasSchema = $xpath->query('//*[@type="application/ld+json"]')->length > 0;

        // ── Hreflang ───────────────────────────────────────────────────────────
        $hreflangNodes = $xpath->query('//link[@rel="alternate"][@hreflang]');
        $hreflangs = [];
        foreach ($hreflangNodes as $node) {
            $hreflangs[] = $node->getAttribute('hreflang');
        }

        // ── AMP ────────────────────────────────────────────────────────────────
        $hasAmp = $xpath->query('//link[@rel="amphtml"]')->length > 0;

        // ── Word count & keyword analysis ──────────────────────────────────────
        $bodyNode = $xpath->query('//body')->item(0);
        $bodyText = $bodyNode ? strip_tags($bodyNode->textContent) : '';
        $wordCount = str_word_count($bodyText);
        $keywords = $this->analyzeKeywords($bodyText, $title, $desc, $h1Text);

        // ── Social links ───────────────────────────────────────────────────────
        $socialLinks = $this->extractSocialLinks($xpath);

        // ── Email privacy ──────────────────────────────────────────────────────
        preg_match_all('/[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}/', $html, $emailMatches);
        $emailsFound = count(array_unique($emailMatches[0]));

        // ── Deprecated HTML ────────────────────────────────────────────────────
        $deprecatedTags = ['font', 'center', 'marquee', 'blink', 'strike', 'tt', 'basefont', 'applet'];
        $deprecatedFound = [];
        foreach ($deprecatedTags as $tag) {
            if ($xpath->query('//'.$tag)->length > 0) {
                $deprecatedFound[] = '<'.$tag.'>';
            }
        }

        // ── Inline styles ──────────────────────────────────────────────────────
        $inlineStyleCount = $xpath->query('//*[@style]')->length;

        // ── Resource counts ────────────────────────────────────────────────────
        $jsCount = $xpath->query('//script[@src]')->length;
        $cssCount = $xpath->query('//link[@rel="stylesheet"]')->length;
        $resources = [
            'js' => $jsCount,
            'css' => $cssCount,
            'images' => $totalImages,
            'total' => $jsCount + $cssCount + $totalImages,
        ];

        // ── Technology detection ────────────────────────────────────────────────
        $technologies = $this->detectTechnologies($html, $xpath, $response);

        // ── Server info ─────────────────────────────────────────────────────────
        $serverInfo = $this->extractServerInfo($response, $host);

        // ── robots.txt ─────────────────────────────────────────────────────────
        $hasRobots = false;
        try {
            $hasRobots = Http::timeout(8)->get($domain.'/robots.txt')->successful();
        } catch (\Throwable) {
        }

        // ── sitemap.xml ────────────────────────────────────────────────────────
        $hasSitemap = false;
        try {
            $hasSitemap = Http::timeout(8)->get($domain.'/sitemap.xml')->successful();
        } catch (\Throwable) {
        }

        // ── DMARC & SPF ────────────────────────────────────────────────────────
        [$dmarc, $spf] = $this->checkDnsRecords($host);

        return [
            // ─── On-page content ──────────────────────────────────────────────
            'title' => ['value' => $title, 'length' => $titleLen, 'status' => ! $title ? 'fail' : ($titleLen >= 50 && $titleLen <= 60 ? 'pass' : 'warn'), 'message' => ! $title ? 'Missing title tag' : ($titleLen < 50 ? "Too short ({$titleLen} chars — aim for 50–60)" : ($titleLen > 60 ? "Too long ({$titleLen} chars — aim for 50–60)" : "Good length ({$titleLen} chars)")), 'fix' => 'Write a unique, keyword-rich title for every page. Keep it 50–60 characters and place your primary keyword near the beginning.'],
            'description' => ['value' => $desc, 'length' => $descLen, 'status' => ! $desc ? 'fail' : ($descLen >= 120 && $descLen <= 160 ? 'pass' : 'warn'), 'message' => ! $desc ? 'Missing meta description' : ($descLen < 120 ? "Too short ({$descLen} chars — aim for 120–160)" : ($descLen > 160 ? "Too long ({$descLen} chars — aim for 120–160)" : "Good length ({$descLen} chars)")), 'fix' => 'Add a compelling meta description (120–160 chars) to every page. Include your primary keyword and a clear call to action.'],
            'h1' => ['count' => $h1Count, 'text' => $h1Text, 'status' => $h1Count === 1 ? 'pass' : ($h1Count === 0 ? 'fail' : 'warn'), 'message' => match (true) {
                $h1Count === 0 => 'No H1 tag found', $h1Count > 1 => "Multiple H1 tags ({$h1Count}) — use only one", default => 'Single H1 tag found'
            }, 'fix' => 'Every page should have exactly one H1 tag containing your primary keyword.'],
            'h2' => ['count' => $h2Count, 'h3_count' => $h3Count, 'h4_count' => $h4Count, 'status' => $h2Count > 0 ? 'pass' : 'warn', 'message' => $h2Count > 0 ? "{$h2Count} H2 · {$h3Count} H3 · {$h4Count} H4 headings found" : 'No H2 subheadings found', 'fix' => 'Use H2 tags to break content into logical sections. Include secondary keywords naturally.'],
            'images' => ['total' => $totalImages, 'without_alt' => $imgMissAlt, 'status' => $imgMissAlt === 0 ? 'pass' : ($imgMissAlt <= 2 ? 'warn' : 'fail'), 'message' => $imgMissAlt === 0 ? "All {$totalImages} images have alt text" : "{$imgMissAlt} of {$totalImages} images missing alt text", 'fix' => 'Add descriptive alt attributes to every image. Alt text improves accessibility and helps Google index your images.'],
            'links' => ['internal' => $internalLinks, 'external' => $externalLinks, 'status' => $internalLinks > 0 ? 'pass' : 'warn', 'message' => "{$internalLinks} internal · {$externalLinks} external links", 'fix' => 'Build a strong internal linking structure. Link related pages together to help users navigate.'],
            'word_count' => ['count' => $wordCount, 'status' => $wordCount >= 300 ? 'pass' : 'warn', 'message' => "{$wordCount} words on page — ".($wordCount >= 300 ? 'good for SEO' : 'aim for 300+ words'), 'fix' => 'Pages with fewer than 300 words are considered "thin content". Expand with useful, relevant information.'],
            'keywords' => $keywords,
            // ─── Technical meta ────────────────────────────────────────────────
            'canonical' => ['value' => $canonical?->value, 'status' => $canonical ? 'pass' : 'warn', 'message' => $canonical ? 'Canonical URL set' : 'No canonical tag found', 'fix' => 'Add <link rel="canonical" href="URL"> to prevent duplicate content issues.'],
            'viewport' => ['value' => $viewport?->value, 'status' => $viewport ? 'pass' : 'fail', 'message' => $viewport ? 'Viewport meta tag present' : 'Missing viewport meta tag — not mobile-friendly', 'fix' => 'Add <meta name="viewport" content="width=device-width, initial-scale=1"> to your <head>.'],
            'https' => ['status' => $isHttps ? 'pass' : 'fail', 'message' => $isHttps ? 'HTTPS enabled — connection is secure' : 'Site is not on HTTPS — critical security issue', 'fix' => "Install an SSL certificate (free from Let's Encrypt) and redirect all HTTP to HTTPS with 301 redirects."],
            'noindex' => ['status' => $noindex ? 'fail' : 'pass', 'message' => $noindex ? 'Page has noindex — Google will NOT index this page' : 'Page is indexable (no noindex directive)', 'fix' => 'Remove <meta name="robots" content="noindex"> if you want this page in search results.'],
            'lang_attr' => ['value' => $htmlLang, 'status' => $htmlLang ? 'pass' : 'warn', 'message' => $htmlLang ? "Language declared: {$htmlLang}" : 'Missing lang attribute on <html> tag', 'fix' => 'Add lang attribute to your root HTML element: <html lang="en">.'],
            'hreflang' => ['count' => count($hreflangs), 'values' => $hreflangs, 'status' => count($hreflangs) > 0 ? 'pass' : 'warn', 'message' => count($hreflangs) > 0 ? count($hreflangs).' hreflang tag(s) found' : 'No hreflang attributes — important for multi-language sites', 'fix' => 'Use hreflang tags if your site targets multiple languages or regions. Helps Google serve the right language to the right users.'],
            'amp' => ['status' => $hasAmp ? 'pass' : 'warn', 'message' => $hasAmp ? 'AMP version linked' : 'No AMP version detected', 'fix' => 'Consider AMP (Accelerated Mobile Pages) for faster mobile loading on article/blog pages.'],
            // ─── Social / OG ───────────────────────────────────────────────────
            'og_tags' => ['has_title' => (bool) $ogTitle, 'has_desc' => (bool) $ogDesc, 'has_image' => (bool) $ogImage, 'status' => ($ogTitle && $ogDesc && $ogImage) ? 'pass' : ($ogTitle ? 'warn' : 'warn'), 'message' => $ogTitle ? ('OG: title'.($ogDesc ? ', desc' : '').($ogImage ? ', image' : ' — no image').' set') : 'No Open Graph tags found', 'fix' => 'Add og:title, og:description, og:image, og:url to control how your page looks when shared on social media.'],
            'twitter_card' => ['value' => $twitterCard?->value, 'status' => $twitterCard ? 'pass' : 'warn', 'message' => $twitterCard ? "Twitter/X Card set: {$twitterCard->value}" : 'No Twitter/X Card meta tags found', 'fix' => 'Add <meta name="twitter:card" content="summary_large_image"> and twitter:title, twitter:description, twitter:image.'],
            'social_links' => $socialLinks,
            // ─── Crawlability ──────────────────────────────────────────────────
            'robots_txt' => ['status' => $hasRobots ? 'pass' : 'warn', 'message' => $hasRobots ? 'robots.txt found and accessible' : 'robots.txt not found at /robots.txt', 'fix' => 'Create a robots.txt file telling crawlers which pages to index.'],
            'sitemap' => ['status' => $hasSitemap ? 'pass' : 'warn', 'message' => $hasSitemap ? 'XML sitemap found and accessible' : 'sitemap.xml not found at /sitemap.xml', 'fix' => 'Generate an XML sitemap and submit it to Google Search Console.'],
            'schema' => ['status' => $hasSchema ? 'pass' : 'warn', 'message' => $hasSchema ? 'Schema.org structured data (JSON-LD) found' : 'No Schema.org structured data found', 'fix' => 'Add JSON-LD structured data markup to help Google show rich results.'],
            'favicon' => ['status' => $hasFavicon ? 'pass' : 'warn', 'message' => $hasFavicon ? 'Favicon defined in HTML' : 'No favicon link tag found', 'fix' => 'Add <link rel="icon" type="image/png" href="/favicon.png"> to your <head>.'],
            // ─── Privacy / Security ────────────────────────────────────────────
            'email_privacy' => ['emails_found' => $emailsFound, 'status' => $emailsFound === 0 ? 'pass' : ($emailsFound <= 1 ? 'warn' : 'fail'), 'message' => $emailsFound === 0 ? 'No plain text email addresses found' : "{$emailsFound} plain text email address(es) exposed", 'fix' => 'Replace plain text emails with a contact form or obfuscated links to prevent spam scrapers.'],
            'dmarc' => $dmarc,
            'spf' => $spf,
            // ─── Code quality ──────────────────────────────────────────────────
            'deprecated_html' => ['found' => $deprecatedFound, 'status' => count($deprecatedFound) === 0 ? 'pass' : 'warn', 'message' => count($deprecatedFound) === 0 ? 'No deprecated HTML tags found' : 'Deprecated tags found: '.implode(', ', $deprecatedFound), 'fix' => 'Remove deprecated HTML tags like <font>, <center>, <marquee>. Use CSS instead.'],
            'inline_styles' => ['count' => $inlineStyleCount, 'status' => $inlineStyleCount === 0 ? 'pass' : ($inlineStyleCount < 15 ? 'warn' : 'fail'), 'message' => $inlineStyleCount === 0 ? 'No inline styles found' : "{$inlineStyleCount} elements with inline styles", 'fix' => 'Move inline styles to CSS files for better maintainability and caching.'],
            // ─── Technology & Server ───────────────────────────────────────────
            'technologies' => $technologies,
            'server_info' => $serverInfo,
            'resources' => $resources,
        ];
    }

    private function analyzeKeywords(string $bodyText, ?string $title, ?string $desc, ?string $h1): array
    {
        $text = strtolower(preg_replace('/[^a-zA-Z\s]/', ' ', $bodyText));
        $words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        $words = array_filter($words, fn ($w) => strlen($w) >= 4 && ! in_array($w, self::STOP_WORDS, true));

        $counts = array_count_values($words);
        arsort($counts);
        $topWords = array_slice($counts, 0, 10, true);

        $titleLower = strtolower($title ?? '');
        $metaLower = strtolower($desc ?? '');
        $h1Lower = strtolower($h1 ?? '');

        $top = [];
        foreach ($topWords as $word => $count) {
            $top[] = [
                'word' => $word,
                'count' => $count,
                'in_title' => str_contains($titleLower, $word),
                'in_meta' => str_contains($metaLower, $word),
                'in_h1' => str_contains($h1Lower, $word),
            ];
        }

        $distributed = count(array_filter($top, fn ($k) => $k['in_title'] || $k['in_meta'] || $k['in_h1']));
        $status = $distributed >= 3 ? 'pass' : ($distributed >= 1 ? 'warn' : 'fail');

        return [
            'top' => $top,
            'status' => $status,
            'message' => $distributed >= 3 ? 'Keywords well distributed across title, meta & headings' : ($distributed >= 1 ? 'Some keywords found in tags — could be improved' : 'Main keywords not found in title, meta or H1'),
            'fix' => 'Include your top 2–3 keywords naturally in your title, meta description, and H1. Avoid keyword stuffing — write for humans first.',
        ];
    }

    /**
     * @return array<string, string>
     */
    private function extractSocialLinks(DOMXPath $xpath): array
    {
        $platforms = [
            'facebook' => ['facebook.com'],
            'twitter' => ['twitter.com', 'x.com'],
            'linkedin' => ['linkedin.com'],
            'instagram' => ['instagram.com'],
            'youtube' => ['youtube.com'],
        ];
        $found = [];

        foreach ($xpath->query('//a[@href]') as $a) {
            $href = $a->getAttribute('href');
            foreach ($platforms as $name => $domains) {
                if (isset($found[$name])) {
                    continue;
                }
                foreach ($domains as $d) {
                    if (str_contains($href, $d)) {
                        $found[$name] = $href;
                        break;
                    }
                }
            }
        }

        return $found;
    }

    /**
     * @return array<int, array{name: string, category: string}>
     */
    private function detectTechnologies(string $html, DOMXPath $xpath, ?Response $response): array
    {
        $patterns = [
            ['WordPress',        'CMS',           ['wp-content', 'wp-includes']],
            ['Elementor',        'Page Builder',   ['elementor']],
            ['WooCommerce',      'E-Commerce',     ['woocommerce']],
            ['Shopify',          'E-Commerce',     ['cdn.shopify.com']],
            ['jQuery',           'JavaScript',     ['jquery']],
            ['Bootstrap',        'CSS Framework',  ['bootstrap']],
            ['Font Awesome',     'Icon Library',   ['font-awesome', 'fontawesome']],
            ['Google Analytics', 'Analytics',      ['ga.js', 'analytics.js', 'gtag.js', 'google-analytics']],
            ['Google Tag Mgr',   'Analytics',      ['googletagmanager.com']],
            ['Swiper',           'Slider',         ['swiper']],
            ['SweetAlert2',      'JavaScript',     ['sweetalert']],
            ['Slick',            'Slider',         ['slick.js', 'slick.min']],
            ['Lightbox',         'JavaScript',     ['lightbox']],
            ['React',            'JavaScript',     ['react.js', 'react.min.js', 'react-dom']],
            ['Vue.js',           'JavaScript',     ['vue.js', 'vue.min.js']],
            ['Angular',          'JavaScript',     ['angular.js', 'angular.min.js']],
            ['Tailwind CSS',     'CSS Framework',  ['tailwind']],
            ['Laravel',          'PHP Framework',  ['laravel_session', 'XSRF-TOKEN']],
            ['Tiny Slider',      'Slider',         ['tiny-slider', 'tns-']],
        ];

        $htmlLower = strtolower($html);
        $techs = [];
        $added = [];

        foreach ($patterns as [$name, $category, $sigs]) {
            foreach ($sigs as $sig) {
                if (str_contains($htmlLower, strtolower($sig)) && ! in_array($name, $added, true)) {
                    $techs[] = ['name' => $name, 'category' => $category];
                    $added[] = $name;
                    break;
                }
            }
        }

        // Generator meta tag
        $gen = $xpath->query('//meta[@name="generator"]/@content')->item(0);
        if ($gen && ! in_array('WordPress', $added, true) && stripos($gen->value, 'wordpress') !== false) {
            $techs[] = ['name' => 'WordPress', 'category' => 'CMS'];
            $added[] = 'WordPress';
        }

        // Server & powered-by headers
        if ($response) {
            $server = $response->header('Server') ?: '';
            if ($server) {
                $sName = trim(explode('/', $server)[0]);
                if ($sName && ! in_array($sName, $added, true)) {
                    $techs[] = ['name' => $sName, 'category' => 'Web Server'];
                    $added[] = $sName;
                }
            }
            $xpb = $response->header('X-Powered-By') ?: '';
            if ($xpb && ! in_array($xpb, $added, true)) {
                $techs[] = ['name' => $xpb, 'category' => 'Backend'];
            }
        }

        return $techs;
    }

    private function extractServerInfo(?Response $response, string $host): array
    {
        $ip = null;
        try {
            $resolved = gethostbyname($host);
            $ip = $resolved !== $host ? $resolved : null;
        } catch (\Throwable) {
        }

        if (! $response) {
            return ['ip' => $ip, 'server' => null, 'charset' => null, 'compression' => null, 'content_type' => null];
        }

        $contentType = $response->header('Content-Type') ?? '';
        $charset = null;
        if (preg_match('/charset=([^\s;]+)/i', $contentType, $m)) {
            $charset = strtoupper($m[1]);
        }

        return [
            'ip' => $ip,
            'server' => $response->header('Server') ?: null,
            'charset' => $charset,
            'compression' => $response->header('Content-Encoding') ?: null,
            'content_type' => $contentType ?: null,
        ];
    }

    /** @return array{0: array, 1: array} */
    private function checkDnsRecords(string $host): array
    {
        $dmarc = [
            'status' => 'warn',
            'message' => 'No DMARC record found',
            'fix' => "Add a DMARC TXT record to your DNS: _dmarc.{$host} TXT \"v=DMARC1; p=none; rua=mailto:postmaster@{$host}\" — helps prevent email spoofing.",
        ];
        try {
            $records = @dns_get_record('_dmarc.'.$host, DNS_TXT) ?: [];
            foreach ($records as $record) {
                $txt = implode('', $record['entries'] ?? [$record['txt'] ?? '']);
                if (str_starts_with($txt, 'v=DMARC1')) {
                    $dmarc = ['status' => 'pass', 'message' => 'DMARC record found: '.substr($txt, 0, 70), 'fix' => ''];
                    break;
                }
            }
        } catch (\Throwable) {
        }

        $spf = [
            'status' => 'warn',
            'message' => 'No SPF record found',
            'fix' => 'Add an SPF TXT record to your DNS to specify authorised email servers: "v=spf1 include:_spf.google.com ~all"',
        ];
        try {
            $records = @dns_get_record($host, DNS_TXT) ?: [];
            foreach ($records as $record) {
                $txt = implode('', $record['entries'] ?? [$record['txt'] ?? '']);
                if (str_starts_with($txt, 'v=spf1')) {
                    $spf = ['status' => 'pass', 'message' => 'SPF record found: '.substr($txt, 0, 70), 'fix' => ''];
                    break;
                }
            }
        } catch (\Throwable) {
        }

        return [$dmarc, $spf];
    }

    private function emptyOnPage(): array
    {
        $fail = ['status' => 'fail', 'message' => 'Could not fetch page', 'fix' => ''];

        return array_fill_keys(
            [
                'title', 'description', 'h1', 'h2', 'images', 'links', 'word_count', 'keywords',
                'canonical', 'viewport', 'https', 'noindex', 'lang_attr', 'hreflang', 'amp',
                'og_tags', 'twitter_card', 'social_links', 'robots_txt', 'sitemap', 'schema',
                'favicon', 'email_privacy', 'dmarc', 'spf', 'deprecated_html', 'inline_styles',
                'technologies', 'server_info', 'resources',
            ],
            $fail
        );
    }
}
