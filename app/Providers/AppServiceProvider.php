<?php

namespace App\Providers;

use App\Models\User;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
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

        // Apply SMTP settings from DB at runtime so all mail goes through the admin-configured mailer
        $this->applySmtpFromDatabase();
    }

    private function applySmtpFromDatabase(): void
    {
        try {
            $host = setting('smtp_host', '');
            if (! $host) {
                return;
            }

            $encryption = setting('smtp_encryption', 'tls');

            Config::set('mail.default', 'smtp');
            Config::set('mail.mailers.smtp.host', $host);
            Config::set('mail.mailers.smtp.port', (int) setting('smtp_port', '587'));
            Config::set('mail.mailers.smtp.username', setting('smtp_username', ''));
            Config::set('mail.mailers.smtp.password', setting('smtp_password', ''));
            Config::set('mail.mailers.smtp.encryption', $encryption === 'none' ? null : $encryption);
            Config::set('mail.from.address', setting('smtp_from_address', setting('company_email', '')));
            Config::set('mail.from.name', setting('smtp_from_name', setting('company_name', 'Redis Solution')));
        } catch (\Throwable) {
            // DB not ready (migrations, fresh installs) — fall back to .env
        }
    }
}
