<?php

namespace App\Services;

use App\Models\SeoPage;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;

class SeoMetaService
{
    public function applyForRoute(string $routeName): void
    {
        $page = SeoPage::findByRoute($routeName);

        if ($page) {
            $this->applyFromModel($page);
        } else {
            $this->applyDefaults();
        }
    }

    public function applyFromModel(SeoPage $page): void
    {
        $siteName = setting('company_name', config('app.name'));

        // Core meta
        if ($page->meta_title) {
            SEOMeta::setTitle($page->meta_title);
            SEOMeta::setTitleSeparator(' | ');
        }
        if ($page->meta_description) {
            SEOMeta::setDescription($page->meta_description);
        }
        if ($page->meta_keywords) {
            SEOMeta::setKeywords(explode(',', $page->meta_keywords));
        }
        if ($page->canonical_url) {
            SEOMeta::setCanonical($page->canonical_url);
        }

        // Robots
        $robots = [];
        if ($page->noindex) {
            $robots[] = 'noindex';
        }
        if ($page->nofollow) {
            $robots[] = 'nofollow';
        }
        if (! empty($robots)) {
            SEOMeta::addMeta('robots', implode(', ', $robots));
        }

        // Open Graph
        OpenGraph::setSiteName($siteName);
        OpenGraph::setType($page->og_type ?: 'website');
        OpenGraph::setTitle($page->og_title ?: $page->meta_title ?: $siteName);
        if ($page->og_description ?: $page->meta_description) {
            OpenGraph::setDescription($page->og_description ?: $page->meta_description);
        }
        if ($page->og_image) {
            OpenGraph::addImage(asset($page->og_image));
        }

        // Twitter Card
        TwitterCard::setType($page->twitter_card ?: 'summary_large_image');
        TwitterCard::setTitle($page->twitter_title ?: $page->og_title ?: $page->meta_title ?: $siteName);
        if ($page->twitter_description ?: $page->og_description ?: $page->meta_description) {
            TwitterCard::setDescription($page->twitter_description ?: $page->og_description ?: $page->meta_description);
        }
        if ($page->og_image) {
            TwitterCard::setImage(asset($page->og_image));
        }

        // JSON-LD Schema
        if ($page->schema_json) {
            SEOMeta::addMeta('schema', $page->schema_json, 'application/ld+json');
        }
    }

    protected function applyDefaults(): void
    {
        $siteName = setting('company_name', config('app.name'));

        SEOMeta::setTitle($siteName);
        OpenGraph::setSiteName($siteName);
        OpenGraph::setType('website');
        OpenGraph::setTitle($siteName);
        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle($siteName);
    }
}
