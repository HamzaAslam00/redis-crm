<?php

namespace Database\Seeders;

use App\Models\NotificationSetting;
use Illuminate\Database\Seeder;

class NotificationSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'event_key' => 'new_contact_message',
                'label' => 'New Contact Form Message',
                'description' => 'When someone submits the website contact form.',
                'in_app_enabled' => true,
                'email_enabled' => true,
            ],
            [
                'event_key' => 'hosting_renewal_30d',
                'label' => 'Hosting Renewal — 30 Days',
                'description' => '30 days before a hosting client renewal date.',
                'in_app_enabled' => true,
                'email_enabled' => true,
            ],
            [
                'event_key' => 'hosting_renewal_7d',
                'label' => 'Hosting Renewal — 7 Days',
                'description' => '7 days before a hosting client renewal date.',
                'in_app_enabled' => true,
                'email_enabled' => true,
            ],
            [
                'event_key' => 'project_deadline_7d',
                'label' => 'Project Deadline — 7 Days',
                'description' => '7 days before a project deadline.',
                'in_app_enabled' => true,
                'email_enabled' => false,
            ],
            [
                'event_key' => 'proposal_viewed',
                'label' => 'Proposal Viewed by Client',
                'description' => 'When a client opens/views a sent proposal.',
                'in_app_enabled' => true,
                'email_enabled' => true,
            ],
            [
                'event_key' => 'proposal_accepted',
                'label' => 'Proposal Accepted',
                'description' => 'When a client accepts a proposal.',
                'in_app_enabled' => true,
                'email_enabled' => true,
            ],
            [
                'event_key' => 'new_user_created',
                'label' => 'New User Added to System',
                'description' => 'When a new CRM user account is created.',
                'in_app_enabled' => true,
                'email_enabled' => false,
            ],
        ];

        foreach ($events as $event) {
            NotificationSetting::updateOrCreate(
                ['event_key' => $event['event_key']],
                $event
            );
        }
    }
}
