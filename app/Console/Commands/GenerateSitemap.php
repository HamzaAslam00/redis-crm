<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the sitemap.xml file in the public directory';

    public function handle(): int
    {
        $sitemap = Sitemap::create();

        $staticPages = [
            ['route' => 'home', 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['route' => 'services', 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['route' => 'portfolio', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['route' => 'blog.index', 'priority' => '0.8', 'changefreq' => 'daily'],
            ['route' => 'about', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['route' => 'contact', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['route' => 'faqs', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['route' => 'free-audit', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['route' => 'free-consultation', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['route' => 'privacy-policy', 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['route' => 'refund-policy', 'priority' => '0.3', 'changefreq' => 'yearly'],
        ];

        foreach ($staticPages as $page) {
            $sitemap->add(
                Url::create(route($page['route']))
                    ->setPriority((float) $page['priority'])
                    ->setChangeFrequency($page['changefreq'])
            );
        }

        BlogPost::published()
            ->orderByDesc('published_at')
            ->get()
            ->each(function (BlogPost $post) use ($sitemap): void {
                $url = Url::create(route('blog.show', $post->slug))
                    ->setPriority(0.7)
                    ->setChangeFrequency('weekly')
                    ->setLastModificationDate($post->updated_at);

                if ($post->featured_image) {
                    $url->addImage($post->featured_image, $post->title);
                }

                $sitemap->add($url);
            });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('sitemap.xml generated at '.public_path('sitemap.xml'));

        return self::SUCCESS;
    }
}
