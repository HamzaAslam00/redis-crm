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
            ['key' => 'company_name',         'value' => 'Redis Solution Pvt. Ltd.',                                         'group' => 'general'],
            ['key' => 'company_phone',         'value' => '+923493614440',                                                    'group' => 'general'],
            ['key' => 'company_email',         'value' => 'info@redissolution.com',                                           'group' => 'general'],
            ['key' => 'company_address',       'value' => 'Office#1 2nd Floor, ABC Plaza, 4th Road, Commercial Market Rd, Rawalpindi, 46000', 'group' => 'general'],
            ['key' => 'company_whatsapp',      'value' => '+923493614440',                                                    'group' => 'general'],
            ['key' => 'whatsapp_number',       'value' => '+923493614440',                                                    'group' => 'general'],
            ['key' => 'whatsapp_default_message', 'value' => 'Hello! I am interested in your services.',                     'group' => 'general'],
            ['key' => 'social_facebook',       'value' => 'https://www.facebook.com/softwarehouseinpakistan1',                'group' => 'general'],
            ['key' => 'social_linkedin',       'value' => 'https://www.linkedin.com/company/redis-solution-pvt-ltd1/',        'group' => 'general'],
            ['key' => 'social_twitter',        'value' => '',                                                                 'group' => 'general'],
            ['key' => 'social_instagram',      'value' => '',                                                                 'group' => 'general'],

            // SMTP
            ['key' => 'smtp_host',             'value' => 'smtp.gmail.com',            'group' => 'smtp'],
            ['key' => 'smtp_port',             'value' => '465',                       'group' => 'smtp'],
            ['key' => 'smtp_username',         'value' => 'hamzaaslam016@gmail.com',   'group' => 'smtp'],
            ['key' => 'smtp_password',         'value' => 'dzlg zpep ndwm lvtw',      'group' => 'smtp'],
            ['key' => 'smtp_encryption',       'value' => 'ssl',                       'group' => 'smtp'],
            ['key' => 'smtp_from_address',     'value' => 'hamzaaslam016@gmail.com',   'group' => 'smtp'],
            ['key' => 'smtp_from_name',        'value' => 'Redis Solution',            'group' => 'smtp'],

            // Email recipients
            ['key' => 'mail_to',               'value' => 'info@redissolution.com',                        'group' => 'smtp'],
            ['key' => 'mail_cc',               'value' => 'junikhan209@gmail.com, hamzaaslam016@gmail.com', 'group' => 'smtp'],
            ['key' => 'mail_test_to',          'value' => 'info@redissolution.com',                        'group' => 'smtp'],

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
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
