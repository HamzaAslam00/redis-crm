<?php

namespace Database\Seeders;

use App\Models\SeoBacklink;
use App\Models\SeoKeyword;
use App\Models\SeoPage;
use Illuminate\Database\Seeder;

class SeoPageSeeder extends Seeder
{
    public function run(): void
    {
        $domain = 'https://redissolution.com';

        $pages = [

            // ─── HOME ────────────────────────────────────────────────────────
            [
                'route_name' => 'home',
                'page_label' => 'Home Page',
                'meta_title' => 'Redis Solution — AI Agents & Web Development Pakistan',
                'meta_description' => 'Pakistan\'s #1 AI-first digital agency. We build custom AI agents, LLM integrations, web apps & mobile apps for businesses worldwide. Get a free consultation.',
                'meta_keywords' => 'web development company Pakistan, AI development Pakistan, mobile app development Pakistan, AI agents Pakistan, software company Pakistan, digital marketing Pakistan, Redis Solution, AI integration Pakistan, custom software Pakistan, Laravel development Pakistan',
                'og_title' => 'Redis Solution — AI Agents, Web & Mobile Development Pakistan',
                'og_description' => 'Custom AI agents, LLM integrations, web apps, mobile apps & digital marketing — Pakistan\'s leading AI-first digital agency trusted by 100+ businesses worldwide.',
                'og_image' => 'assets/og/home.jpg',
                'og_type' => 'website',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'Redis Solution — AI Agents & Web Development Pakistan',
                'twitter_description' => 'Custom AI agents, web apps & mobile apps built by Pakistan\'s #1 AI-first digital agency. 100+ happy clients. Get your free consultation today.',
                'canonical_url' => $domain,
                'noindex' => false,
                'nofollow' => false,
                'is_active' => true,
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'Organization',
                            '@id' => $domain.'/#organization',
                            'name' => 'Redis Solution',
                            'url' => $domain,
                            'logo' => $domain.'/assets/images/logo.png',
                            'description' => 'Pakistan\'s leading AI-first digital agency specialising in custom AI agents, LLM integrations, web development, mobile apps and digital marketing.',
                            'foundingDate' => '2020',
                            'numberOfEmployees' => ['@type' => 'QuantitativeValue', 'value' => 15],
                            'telephone' => '+92-349-3614440',
                            'email' => 'hello@redissolution.com',
                            'address' => [
                                '@type' => 'PostalAddress',
                                'addressCountry' => 'PK',
                                'addressRegion' => 'Punjab',
                            ],
                            'sameAs' => [],
                            'knowsAbout' => ['AI Agents', 'LLM Integration', 'Web Development', 'Mobile App Development', 'Digital Marketing', 'Software Development', 'RAG Pipeline', 'n8n Automation'],
                        ],
                        [
                            '@type' => 'WebSite',
                            '@id' => $domain.'/#website',
                            'url' => $domain,
                            'name' => 'Redis Solution',
                            'publisher' => ['@id' => $domain.'/#organization'],
                            'potentialAction' => [
                                '@type' => 'SearchAction',
                                'target' => ['@type' => 'EntryPoint', 'urlTemplate' => $domain.'/search?q={search_term_string}'],
                                'query-input' => 'required name=search_term_string',
                            ],
                        ],
                        [
                            '@type' => 'WebPage',
                            '@id' => $domain.'/#webpage',
                            'url' => $domain,
                            'name' => 'Redis Solution — AI Agents & Web Development Pakistan',
                            'isPartOf' => ['@id' => $domain.'/#website'],
                            'publisher' => ['@id' => $domain.'/#organization'],
                            'description' => 'Pakistan\'s #1 AI-first digital agency building custom AI agents, LLM integrations, web apps & mobile apps.',
                        ],
                    ],
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            // ─── ABOUT ───────────────────────────────────────────────────────
            [
                'route_name' => 'about',
                'page_label' => 'About Us',
                'meta_title' => 'About Redis Solution — AI & Web Dev Agency Pakistan',
                'meta_description' => 'Pakistan-based AI-first digital agency since 2020. 100+ clients worldwide. We build AI agents, web apps & mobile platforms that scale for businesses globally.',
                'meta_keywords' => 'about Redis Solution, digital agency Pakistan, web development team Pakistan, AI agency Pakistan, software company Pakistan, IT company Pakistan',
                'og_title' => 'About Redis Solution — Pakistan\'s AI-First Digital Agency',
                'og_description' => 'Founded in 2020, Redis Solution has delivered 100+ projects across AI, web, mobile and digital marketing for clients in Pakistan and worldwide.',
                'og_image' => 'assets/og/about.jpg',
                'og_type' => 'website',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'About Redis Solution — AI-First Digital Agency Pakistan',
                'twitter_description' => 'Pakistan-based AI & web development agency since 2020. 100+ satisfied clients. Meet the team behind the code.',
                'canonical_url' => $domain.'/about',
                'noindex' => false,
                'nofollow' => false,
                'is_active' => true,
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'AboutPage',
                    'url' => $domain.'/about',
                    'name' => 'About Redis Solution',
                    'description' => 'Redis Solution is Pakistan\'s leading AI-first digital agency. Founded in 2020, we build AI agents, web apps, mobile apps and digital marketing solutions for businesses worldwide.',
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'Redis Solution',
                        'url' => $domain,
                    ],
                    'mainEntity' => [
                        '@type' => 'Organization',
                        'name' => 'Redis Solution',
                        'foundingDate' => '2020',
                        'numberOfEmployees' => ['@type' => 'QuantitativeValue', 'value' => 15],
                        'url' => $domain,
                        'description' => 'Pakistan\'s leading AI-first digital agency specialising in AI agents, web development, mobile apps and digital marketing.',
                    ],
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            // ─── SERVICES ────────────────────────────────────────────────────
            [
                'route_name' => 'services',
                'page_label' => 'Services',
                'meta_title' => 'AI Agents, Web & App Development Services — Redis Solution',
                'meta_description' => 'Custom AI agents, LLM integrations, web development, mobile apps & digital marketing. Pakistan\'s most comprehensive AI-first digital services agency.',
                'meta_keywords' => 'AI agents Pakistan, LLM integration Pakistan, web development services Pakistan, mobile app development services, AI development services, digital marketing Pakistan, ERP development Pakistan, software development services Pakistan, n8n automation, RAG pipeline development',
                'og_title' => 'AI Agents, Web & App Development Services | Redis Solution Pakistan',
                'og_description' => 'Explore Redis Solution\'s complete service stack: custom AI agents, LLM pipelines, web apps, Flutter mobile apps, ERP systems and digital marketing — all under one roof.',
                'og_image' => 'assets/og/services.jpg',
                'og_type' => 'website',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'AI Agents, Web & App Development — Redis Solution Pakistan',
                'twitter_description' => 'AI agents, LLM integrations, web apps & mobile platforms. Pakistan\'s #1 AI-first digital agency offers a complete digital service stack.',
                'canonical_url' => $domain.'/services',
                'noindex' => false,
                'nofollow' => false,
                'is_active' => true,
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'ItemList',
                    'url' => $domain.'/services',
                    'name' => 'Redis Solution Digital Services',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'AI Agents & Integrations', 'description' => 'Custom AI agents, LLM integrations, RAG pipelines and n8n workflow automation.', 'url' => $domain.'/services#ai-applications'],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Web Development', 'description' => 'Full-stack web development with Laravel, React, Vue.js and Next.js.', 'url' => $domain.'/services#web-development'],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => 'Mobile App Development', 'description' => 'Cross-platform mobile apps with Flutter for iOS and Android.', 'url' => $domain.'/services#mobile-apps'],
                        ['@type' => 'ListItem', 'position' => 4, 'name' => 'Digital Marketing', 'description' => 'Google Ads, Meta Ads, SEO and social media marketing.', 'url' => $domain.'/services#digital-marketing'],
                        ['@type' => 'ListItem', 'position' => 5, 'name' => 'Software Development', 'description' => 'Custom SaaS platforms, ERPs and enterprise software.', 'url' => $domain.'/services#software-development'],
                        ['@type' => 'ListItem', 'position' => 6, 'name' => 'ERP & CMS Development', 'description' => 'Bespoke ERP systems and content management platforms.', 'url' => $domain.'/services#erp-cms'],
                    ],
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            // ─── PORTFOLIO ───────────────────────────────────────────────────
            [
                'route_name' => 'portfolio',
                'page_label' => 'Portfolio',
                'meta_title' => 'Our Work — AI, Web & Mobile Projects | Redis Solution',
                'meta_description' => 'Browse 100+ completed projects — AI agents, web apps, Flutter mobile apps & ERP systems delivered for clients across Pakistan and worldwide. Real results.',
                'meta_keywords' => 'Redis Solution portfolio, web development projects Pakistan, mobile app projects Pakistan, AI projects Pakistan, software projects Pakistan, digital agency work Pakistan',
                'og_title' => 'Portfolio — AI, Web & Mobile Projects by Redis Solution',
                'og_description' => '100+ completed projects across AI, web, mobile and ERP — real results for real businesses in Pakistan and worldwide.',
                'og_image' => 'assets/og/portfolio.jpg',
                'og_type' => 'website',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'Portfolio — AI, Web & Mobile Projects | Redis Solution',
                'twitter_description' => '100+ projects delivered. Explore our work in AI agents, web development, mobile apps and digital marketing.',
                'canonical_url' => $domain.'/portfolio',
                'noindex' => false,
                'nofollow' => false,
                'is_active' => true,
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'CollectionPage',
                    'url' => $domain.'/portfolio',
                    'name' => 'Redis Solution Portfolio',
                    'description' => '100+ completed AI, web development, mobile app and ERP projects by Redis Solution Pakistan.',
                    'publisher' => ['@type' => 'Organization', 'name' => 'Redis Solution', 'url' => $domain],
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            // ─── CONTACT ─────────────────────────────────────────────────────
            [
                'route_name' => 'contact',
                'page_label' => 'Contact Us',
                'meta_title' => 'Contact Redis Solution — Get a Free Project Quote',
                'meta_description' => 'Contact Redis Solution for a free quote on AI agents, web development, mobile apps or digital marketing. Pakistan-based team, worldwide delivery. 24h response.',
                'meta_keywords' => 'contact Redis Solution, hire web developer Pakistan, hire AI developer Pakistan, web development quote Pakistan, mobile app quote Pakistan, software agency contact Pakistan',
                'og_title' => 'Contact Redis Solution — Free Quote for Your Project',
                'og_description' => 'Get in touch with Redis Solution\'s team for a free project consultation. AI agents, web development, mobile apps and digital marketing — Pakistan-based, worldwide delivery.',
                'og_image' => 'assets/og/contact.jpg',
                'og_type' => 'website',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'Contact Redis Solution — Free Project Quote',
                'twitter_description' => 'Reach out to Pakistan\'s #1 AI-first digital agency for a free consultation. Response within 24 hours.',
                'canonical_url' => $domain.'/contact',
                'noindex' => false,
                'nofollow' => false,
                'is_active' => true,
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'ContactPage',
                    'url' => $domain.'/contact',
                    'name' => 'Contact Redis Solution',
                    'description' => 'Contact Redis Solution for AI agents, web development, mobile app or digital marketing projects.',
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'Redis Solution',
                        'url' => $domain,
                        'telephone' => '+92-349-3614440',
                        'email' => 'hello@redissolution.com',
                        'contactPoint' => [
                            '@type' => 'ContactPoint',
                            'contactType' => 'customer service',
                            'telephone' => '+92-349-3614440',
                            'availableLanguage' => ['English', 'Urdu'],
                            'hoursAvailable' => 'Mo-Fr 09:00-18:00',
                        ],
                    ],
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            // ─── FAQS ────────────────────────────────────────────────────────
            [
                'route_name' => 'faqs',
                'page_label' => 'FAQs',
                'meta_title' => 'FAQs — Web, AI & Mobile Development | Redis Solution',
                'meta_description' => 'Answers to common questions about Redis Solution\'s AI, web, mobile and marketing services. Pricing, timelines and process explained clearly.',
                'meta_keywords' => 'Redis Solution FAQ, web development FAQ Pakistan, how much does web development cost Pakistan, AI development cost, mobile app development cost Pakistan, how long website take Pakistan',
                'og_title' => 'Frequently Asked Questions — Redis Solution',
                'og_description' => 'Got questions? We\'ve answered the most common ones about our AI, web, mobile and marketing services — pricing, timelines and process.',
                'og_image' => 'assets/og/faqs.jpg',
                'og_type' => 'website',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'FAQs — Redis Solution AI & Web Development Pakistan',
                'twitter_description' => 'Common questions about Redis Solution\'s services, pricing and process. Everything you need to know before starting your project.',
                'canonical_url' => $domain.'/faqs',
                'noindex' => false,
                'nofollow' => false,
                'is_active' => true,
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    'url' => $domain.'/faqs',
                    'name' => 'FAQs — Redis Solution',
                    'mainEntity' => [
                        [
                            '@type' => 'Question',
                            'name' => 'What services does Redis Solution offer?',
                            'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Redis Solution offers custom AI agents, LLM integrations, web development, mobile app development (Flutter), digital marketing, ERP systems and software development. We are a full-service AI-first digital agency based in Pakistan.'],
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'How much does web development cost in Pakistan?',
                            'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Web development costs at Redis Solution start from affordable packages for landing pages and scale to enterprise-level platforms. Contact us for a free, no-obligation quote tailored to your requirements.'],
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'Can you build custom AI agents and chatbots?',
                            'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Yes — we specialise in building custom AI agents using Claude API, OpenAI GPT-4o and open-source LLMs. Our agents can browse the web, call APIs, process documents and complete multi-step tasks autonomously. We also build RAG pipelines and n8n workflow automation.'],
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'How long does it take to build a mobile app?',
                            'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'A standard Flutter mobile app typically takes 6–12 weeks from discovery to App Store submission, depending on complexity. We follow an agile process with bi-weekly sprint demos to keep you informed throughout.'],
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'Do you work with international clients?',
                            'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Yes, Redis Solution works with clients from Pakistan, UK, USA, UAE and across the globe. We communicate in English and Urdu and are flexible with time zones.'],
                        ],
                        [
                            '@type' => 'Question',
                            'name' => 'What is your technology stack?',
                            'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Our primary stack includes Laravel, React, Vue.js, Next.js, Flutter, Python, FastAPI, LangChain, Claude API, OpenAI, n8n, MySQL, PostgreSQL, Redis and Docker. We choose the right tools for each project.'],
                        ],
                    ],
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            // ─── FREE AUDIT ──────────────────────────────────────────────────
            [
                'route_name' => 'free-audit',
                'page_label' => 'Free SEO Audit',
                'meta_title' => 'Free Website SEO Audit Tool — Redis Solution Pakistan',
                'meta_description' => 'Get an instant, free SEO audit for any website. Check Core Web Vitals, page speed, meta tags, broken links and keyword rankings — 100% free, no signup required.',
                'meta_keywords' => 'free SEO audit tool, website SEO checker Pakistan, free website audit, SEO analysis tool, Core Web Vitals check, page speed test Pakistan, website performance check',
                'og_title' => 'Free Website SEO Audit — Instant Results | Redis Solution',
                'og_description' => 'Run a free, instant SEO audit on any website. We analyse Core Web Vitals, meta tags, page speed, mobile usability and more — completely free from Redis Solution.',
                'og_image' => 'assets/og/free-audit.jpg',
                'og_type' => 'website',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'Free SEO Audit Tool — Instant Website Analysis',
                'twitter_description' => 'Analyse your website\'s SEO health, Core Web Vitals and performance score in seconds. 100% free from Redis Solution.',
                'canonical_url' => $domain.'/free-audit',
                'noindex' => false,
                'nofollow' => false,
                'is_active' => true,
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'WebApplication',
                    'url' => $domain.'/free-audit',
                    'name' => 'Free Website SEO Audit Tool by Redis Solution',
                    'description' => 'Instant free SEO audit tool — check Core Web Vitals, meta tags, page speed, mobile usability and keyword rankings for any website.',
                    'applicationCategory' => 'BusinessApplication',
                    'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD', 'description' => 'Free SEO audit for any website.'],
                    'provider' => ['@type' => 'Organization', 'name' => 'Redis Solution', 'url' => $domain],
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            // ─── FREE CONSULTATION ───────────────────────────────────────────
            [
                'route_name' => 'free-consultation',
                'page_label' => 'Free Consultation',
                'meta_title' => 'Free Consultation — AI & Web Development | Redis Solution',
                'meta_description' => 'Book a free 30-minute consultation with Redis Solution\'s experts. Get a custom roadmap and quote for your AI agent, web app or mobile project. No obligations.',
                'meta_keywords' => 'free consultation web development Pakistan, book meeting software company Pakistan, free project consultation AI Pakistan, web development quote Pakistan, hire developer Pakistan free consultation',
                'og_title' => 'Book a Free Consultation — Redis Solution Pakistan',
                'og_description' => 'Schedule a free 30-minute call with Redis Solution\'s technical experts. Get clarity on your project scope, technology choices and estimated budget — no strings attached.',
                'og_image' => 'assets/og/free-consultation.jpg',
                'og_type' => 'website',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'Free Consultation — AI, Web & Mobile Dev | Redis Solution',
                'twitter_description' => 'Book a free 30-minute consultation with Pakistan\'s top AI & web development team. Get a custom project roadmap at zero cost.',
                'canonical_url' => $domain.'/free-consultation',
                'noindex' => false,
                'nofollow' => false,
                'is_active' => true,
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Service',
                    'url' => $domain.'/free-consultation',
                    'name' => 'Free Project Consultation',
                    'description' => 'A free 30-minute consultation call with Redis Solution\'s technical team to discuss your AI, web or mobile project requirements.',
                    'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD', 'description' => 'Free 30-minute project consultation.'],
                    'provider' => [
                        '@type' => 'Organization',
                        'name' => 'Redis Solution',
                        'url' => $domain,
                        'telephone' => '+92-349-3614440',
                    ],
                    'areaServed' => ['Pakistan', 'United Kingdom', 'United States', 'United Arab Emirates', 'Worldwide'],
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            // ─── BLOG ────────────────────────────────────────────────────────
            [
                'route_name' => 'blog.index',
                'page_label' => 'Blog',
                'meta_title' => 'AI, Web Dev & Digital Marketing Blog — Redis Solution',
                'meta_description' => 'Expert insights on AI agents, LLM integrations, web development, Flutter mobile apps and digital marketing from Pakistan\'s leading AI-first digital agency.',
                'meta_keywords' => 'AI development blog Pakistan, web development blog, digital marketing blog Pakistan, Laravel blog, Flutter blog, AI agents tutorial, LLM integration guide, software development insights Pakistan',
                'og_title' => 'Blog — AI, Web Dev & Marketing Insights | Redis Solution',
                'og_description' => 'Read our expert articles on AI agents, LLM integrations, web development, mobile apps and digital marketing strategies for growing businesses.',
                'og_image' => 'assets/og/blog.jpg',
                'og_type' => 'website',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'AI & Web Dev Blog — Redis Solution Pakistan',
                'twitter_description' => 'Practical guides, tutorials and insights on AI agents, web development and digital marketing from Redis Solution\'s expert team.',
                'canonical_url' => $domain.'/blog',
                'noindex' => false,
                'nofollow' => false,
                'is_active' => true,
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Blog',
                    'url' => $domain.'/blog',
                    'name' => 'Redis Solution Blog',
                    'description' => 'Expert articles on AI agents, web development, mobile apps and digital marketing by Redis Solution Pakistan.',
                    'publisher' => ['@type' => 'Organization', 'name' => 'Redis Solution', 'url' => $domain],
                    'inLanguage' => 'en-PK',
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            // ─── PRIVACY POLICY ──────────────────────────────────────────────
            [
                'route_name' => 'privacy-policy',
                'page_label' => 'Privacy Policy',
                'meta_title' => 'Privacy Policy — Redis Solution',
                'meta_description' => 'Read Redis Solution\'s privacy policy to understand how we collect, use, store and protect your personal data when using our website and digital services.',
                'meta_keywords' => 'Redis Solution privacy policy, data protection Pakistan',
                'og_title' => 'Privacy Policy — Redis Solution',
                'og_description' => 'How Redis Solution collects, uses and protects your personal data.',
                'og_image' => 'assets/og/home.jpg',
                'og_type' => 'website',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'Privacy Policy — Redis Solution',
                'twitter_description' => 'Our privacy policy explains how we handle your personal data.',
                'canonical_url' => $domain.'/privacy-policy',
                'noindex' => false,
                'nofollow' => true,
                'is_active' => true,
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'url' => $domain.'/privacy-policy',
                    'name' => 'Privacy Policy — Redis Solution',
                    'publisher' => ['@type' => 'Organization', 'name' => 'Redis Solution', 'url' => $domain],
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

            // ─── REFUND POLICY ───────────────────────────────────────────────
            [
                'route_name' => 'refund-policy',
                'page_label' => 'Refund Policy',
                'meta_title' => 'Refund & Cancellation Policy — Redis Solution',
                'meta_description' => 'Understand Redis Solution\'s refund and cancellation policy for web development, mobile apps, AI systems and digital marketing projects. Fair, transparent terms.',
                'meta_keywords' => 'Redis Solution refund policy, cancellation policy software Pakistan',
                'og_title' => 'Refund & Cancellation Policy — Redis Solution',
                'og_description' => 'Fair and transparent refund and cancellation terms for all Redis Solution\'s digital services.',
                'og_image' => 'assets/og/home.jpg',
                'og_type' => 'website',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'Refund Policy — Redis Solution',
                'twitter_description' => 'Our refund and cancellation policy for web, mobile and AI development projects.',
                'canonical_url' => $domain.'/refund-policy',
                'noindex' => false,
                'nofollow' => true,
                'is_active' => true,
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'WebPage',
                    'url' => $domain.'/refund-policy',
                    'name' => 'Refund & Cancellation Policy — Redis Solution',
                    'publisher' => ['@type' => 'Organization', 'name' => 'Redis Solution', 'url' => $domain],
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ],

        ];

        foreach ($pages as $page) {
            SeoPage::updateOrCreate(
                ['route_name' => $page['route_name']],
                $page
            );
        }

        $this->seedKeywords($domain);
        $this->seedBacklinks($domain);
    }

    private function seedKeywords(string $domain): void
    {
        $keywords = [
            ['keyword' => 'web development company Pakistan', 'target_url' => $domain, 'priority' => 'high', 'current_position' => 8, 'monthly_volume' => 1900, 'difficulty' => 45, 'notes' => 'Primary homepage keyword', 'last_checked_at' => now()],
            ['keyword' => 'AI agents Pakistan', 'target_url' => $domain.'/services', 'priority' => 'high', 'current_position' => 4, 'monthly_volume' => 720, 'difficulty' => 28, 'notes' => 'Emerging high-intent keyword', 'last_checked_at' => now()],
            ['keyword' => 'mobile app development Pakistan', 'target_url' => $domain.'/services', 'priority' => 'high', 'current_position' => 12, 'monthly_volume' => 2400, 'difficulty' => 52, 'notes' => 'High volume, mid difficulty', 'last_checked_at' => now()],
            ['keyword' => 'Laravel development company Pakistan', 'target_url' => $domain.'/services', 'priority' => 'medium', 'current_position' => 6, 'monthly_volume' => 590, 'difficulty' => 35, 'notes' => 'Tech-specific keyword', 'last_checked_at' => now()],
            ['keyword' => 'digital marketing agency Pakistan', 'target_url' => $domain.'/services', 'priority' => 'medium', 'current_position' => 18, 'monthly_volume' => 3600, 'difficulty' => 62, 'notes' => 'Competitive — long-term target', 'last_checked_at' => now()],
            ['keyword' => 'LLM integration Pakistan', 'target_url' => $domain.'/services', 'priority' => 'high', 'current_position' => 2, 'monthly_volume' => 320, 'difficulty' => 18, 'notes' => 'Low competition, fast-growing niche', 'last_checked_at' => now()],
            ['keyword' => 'Flutter app development Pakistan', 'target_url' => $domain.'/services', 'priority' => 'medium', 'current_position' => 9, 'monthly_volume' => 880, 'difficulty' => 40, 'notes' => 'Cross-platform mobile keyword', 'last_checked_at' => now()],
            ['keyword' => 'free SEO audit tool Pakistan', 'target_url' => $domain.'/free-audit', 'priority' => 'medium', 'current_position' => 5, 'monthly_volume' => 480, 'difficulty' => 22, 'notes' => 'Free tool — drives top-of-funnel traffic', 'last_checked_at' => now()],
            ['keyword' => 'custom ERP development Pakistan', 'target_url' => $domain.'/services', 'priority' => 'low', 'current_position' => 14, 'monthly_volume' => 390, 'difficulty' => 38, 'notes' => 'Enterprise keyword — good ROI per lead', 'last_checked_at' => now()],
            ['keyword' => 'n8n automation Pakistan', 'target_url' => $domain.'/services', 'priority' => 'low', 'current_position' => 3, 'monthly_volume' => 210, 'difficulty' => 15, 'notes' => 'Very low competition, rank fast', 'last_checked_at' => now()],
        ];

        foreach ($keywords as $kw) {
            SeoKeyword::firstOrCreate(
                ['keyword' => $kw['keyword']],
                $kw
            );
        }
    }

    private function seedBacklinks(string $domain): void
    {
        $backlinks = [
            [
                'source_url' => 'https://techblog.com.pk/best-web-dev-companies-pakistan',
                'source_domain' => 'techblog.com.pk',
                'target_url' => $domain,
                'anchor_text' => 'Redis Solution',
                'link_type' => 'dofollow',
                'domain_authority' => 42,
                'status' => 'active',
                'discovered_at' => now()->subDays(30),
                'last_checked_at' => now()->subDays(2),
                'notes' => 'Listicle — top 10 web dev companies Pakistan',
            ],
            [
                'source_url' => 'https://startupspk.io/ai-agencies-to-watch-2024',
                'source_domain' => 'startupspk.io',
                'target_url' => $domain.'/services',
                'anchor_text' => 'AI development agency Pakistan',
                'link_type' => 'dofollow',
                'domain_authority' => 35,
                'status' => 'active',
                'discovered_at' => now()->subDays(60),
                'last_checked_at' => now()->subDays(5),
                'notes' => 'Featured in AI startups to watch article',
            ],
            [
                'source_url' => 'https://clutch.co/profile/redis-solution',
                'source_domain' => 'clutch.co',
                'target_url' => $domain,
                'anchor_text' => 'Redis Solution',
                'link_type' => 'nofollow',
                'domain_authority' => 78,
                'status' => 'active',
                'discovered_at' => now()->subDays(90),
                'last_checked_at' => now()->subDays(1),
                'notes' => 'High DA profile on Clutch — important brand citation',
            ],
            [
                'source_url' => 'https://pakistanitsummit.pk/sponsors/redis-solution',
                'source_domain' => 'pakistanitsummit.pk',
                'target_url' => $domain,
                'anchor_text' => 'Redis Solution — AI & Web Development',
                'link_type' => 'dofollow',
                'domain_authority' => 29,
                'status' => 'active',
                'discovered_at' => now()->subDays(45),
                'last_checked_at' => now()->subDays(7),
                'notes' => 'Event sponsorship backlink',
            ],
            [
                'source_url' => 'https://freelancepk.net/top-flutter-developers-pakistan',
                'source_domain' => 'freelancepk.net',
                'target_url' => $domain.'/services',
                'anchor_text' => 'best Flutter developers Pakistan',
                'link_type' => 'dofollow',
                'domain_authority' => 31,
                'status' => 'active',
                'discovered_at' => now()->subDays(20),
                'last_checked_at' => now()->subDays(3),
                'notes' => 'Niche directory for Pakistan developers',
            ],
        ];

        foreach ($backlinks as $bl) {
            SeoBacklink::firstOrCreate(
                ['source_url' => $bl['source_url']],
                $bl
            );
        }
    }
}
