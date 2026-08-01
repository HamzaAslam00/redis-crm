<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $staticPages = [
            ['url' => 'https://redissolution.com',                 'freq' => 'weekly',  'priority' => '1.0'],
            ['url' => 'https://redissolution.com/services',        'freq' => 'monthly', 'priority' => '0.9'],
            ['url' => 'https://redissolution.com/portfolio',       'freq' => 'weekly',  'priority' => '0.8'],
            ['url' => 'https://redissolution.com/blog',            'freq' => 'daily',   'priority' => '0.8'],
            ['url' => 'https://redissolution.com/about',           'freq' => 'monthly', 'priority' => '0.7'],
            ['url' => 'https://redissolution.com/contact',         'freq' => 'monthly', 'priority' => '0.7'],
            ['url' => 'https://redissolution.com/faqs',            'freq' => 'monthly', 'priority' => '0.6'],
            ['url' => 'https://redissolution.com/free-audit',      'freq' => 'monthly', 'priority' => '0.7'],
            ['url' => 'https://redissolution.com/privacy-policy',  'freq' => 'yearly',  'priority' => '0.3'],
            ['url' => 'https://redissolution.com/refund-policy',   'freq' => 'yearly',  'priority' => '0.3'],
        ];

        $posts = BlogPost::where('status', 'published')
            ->orderByDesc('published_at')
            ->get(['slug', 'published_at', 'updated_at']);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($staticPages as $page) {
            $xml .= "    <url>\n";
            $xml .= "        <loc>{$page['url']}</loc>\n";
            $xml .= "        <changefreq>{$page['freq']}</changefreq>\n";
            $xml .= "        <priority>{$page['priority']}</priority>\n";
            $xml .= "    </url>\n";
        }

        foreach ($posts as $post) {
            $lastmod = ($post->updated_at ?? $post->published_at)?->toAtomString() ?? now()->toAtomString();
            $url = 'https://redissolution.com/blog/'.$post->slug;
            $xml .= "    <url>\n";
            $xml .= "        <loc>{$url}</loc>\n";
            $xml .= "        <lastmod>{$lastmod}</lastmod>\n";
            $xml .= "        <changefreq>weekly</changefreq>\n";
            $xml .= "        <priority>0.7</priority>\n";
            $xml .= "    </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
