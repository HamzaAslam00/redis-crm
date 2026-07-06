<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class WhatsAppSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'ultramsg_instance',       'value' => 'instance183887',     'group' => 'whatsapp'],
            ['key' => 'ultramsg_token',           'value' => 'r8yqcm9f26tqm6pq',  'group' => 'whatsapp'],
            ['key' => 'whatsapp_notify_number',   'value' => '+923493614440',      'group' => 'whatsapp'],
            ['key' => 'whatsapp_notify_enabled',  'value' => '1',                  'group' => 'whatsapp'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
