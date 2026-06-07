<?php

namespace App\Providers;

use App\Models\User;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('SEOMeta', SEOMeta::class);
        $loader->alias('OpenGraph', OpenGraph::class);
        $loader->alias('TwitterCard', TwitterCard::class);
        $loader->alias('SEOTools', SEOTools::class);
    }

    public function boot(): void
    {
        // Super-admin bypasses all permission checks
        Gate::before(fn (User $user, string $ability) => $user->hasRole('super-admin') ? true : null);
    }
}
