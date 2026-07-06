<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * WhatsApp notifications via UltraMsg (ultramsg.com).
 *
 * Setup:
 *  1. Sign up at ultramsg.com → create an instance → scan QR with your WhatsApp
 *  2. Copy Instance ID and Token from the dashboard
 *  3. Save both in Admin → Settings → WhatsApp
 */
class WhatsAppService
{
    private const API_BASE = 'https://api.ultramsg.com';

    public function sendToAdmin(string $message): bool
    {
        $instance = setting('ultramsg_instance', '');
        $token = setting('ultramsg_token', '');
        $to = setting('whatsapp_notify_number', '');

        if (! $instance || ! $token || ! $to) {
            return false;
        }

        return $this->send($instance, $token, $to, $message);
    }

    public function send(string $instance, string $token, string $to, string $message): bool
    {
        $to = preg_replace('/[^0-9+]/', '', $to);

        try {
            $response = Http::timeout(15)
                ->asForm()
                ->post(self::API_BASE."/{$instance}/messages/chat", [
                    'token' => $token,
                    'to' => $to,
                    'body' => $message,
                ]);

            $json = $response->json();

            if ($response->successful() && isset($json['sent']) && $json['sent'] === 'true') {
                return true;
            }

            Log::warning('UltraMsg WhatsApp failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'to' => $to,
            ]);

            return false;
        } catch (\Throwable $e) {
            Log::error('UltraMsg WhatsApp exception', [
                'error' => $e->getMessage(),
                'to' => $to,
            ]);

            return false;
        }
    }
}
