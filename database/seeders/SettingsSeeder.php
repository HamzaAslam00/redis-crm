<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Theme
            ['key' => 'theme',                   'value' => 'dark',                      'group' => 'appearance'],

            // General
            ['key' => 'company_name',         'value' => 'Redis Solution Pvt. Ltd.', 'group' => 'general'],
            ['key' => 'company_phone',         'value' => '+92 XXX XXXXXXX',           'group' => 'general'],
            ['key' => 'company_email',         'value' => 'info@redissolution.com',    'group' => 'general'],
            ['key' => 'company_address',       'value' => 'Rawalpindi, Pakistan',      'group' => 'general'],
            ['key' => 'company_whatsapp',      'value' => '',                          'group' => 'general'],
            ['key' => 'whatsapp_number',       'value' => '',                          'group' => 'general'],
            ['key' => 'whatsapp_default_message', 'value' => 'Hello! I am interested in your services.', 'group' => 'general'],
            ['key' => 'social_facebook',       'value' => '',                          'group' => 'general'],
            ['key' => 'social_linkedin',       'value' => '',                          'group' => 'general'],
            ['key' => 'social_twitter',        'value' => '',                          'group' => 'general'],
            ['key' => 'social_instagram',      'value' => '',                          'group' => 'general'],

            // SMTP
            ['key' => 'smtp_host',             'value' => '',                          'group' => 'smtp'],
            ['key' => 'smtp_port',             'value' => '587',                       'group' => 'smtp'],
            ['key' => 'smtp_username',         'value' => '',                          'group' => 'smtp'],
            ['key' => 'smtp_password',         'value' => '',                          'group' => 'smtp'],
            ['key' => 'smtp_encryption',       'value' => 'tls',                       'group' => 'smtp'],
            ['key' => 'smtp_from_name',        'value' => 'Redis Solution',            'group' => 'smtp'],

            // reCAPTCHA
            ['key' => 'recaptcha_enabled',     'value' => '0',                         'group' => 'recaptcha'],
            ['key' => 'recaptcha_site_key',    'value' => '',                          'group' => 'recaptcha'],
            ['key' => 'recaptcha_secret_key',  'value' => '',                          'group' => 'recaptcha'],
            ['key' => 'recaptcha_version',     'value' => 'v2',                        'group' => 'recaptcha'],

            // Proposals
            ['key' => 'proposal_default_terms', 'value' => "Payment is due within 7 days of project completion.\nAll work remains property of Redis Solution until full payment is received.", 'group' => 'proposal'],

            // Social proof counters
            ['key' => 'counter_projects',      'value' => '100',                       'group' => 'counters'],
            ['key' => 'counter_clients',       'value' => '100',                       'group' => 'counters'],
            ['key' => 'counter_years',         'value' => '4',                         'group' => 'counters'],
            ['key' => 'counter_satisfaction',  'value' => '98',                        'group' => 'counters'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
