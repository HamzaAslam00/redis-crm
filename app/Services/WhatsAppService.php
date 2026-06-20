<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * WhatsApp notifications via Callmebot (free, no paid API).
 *
 * Setup for each user:
 *  1. Save +34 644 10 28 72 in their phone as "CallMeBot"
 *  2. Send WhatsApp message: "I allow callmebot to send me messages"
 *  3. Bot replies with an API key — save it in user.callmebot_key
 *
 * API: GET https://api.callmebot.com/whatsapp.php?phone=PHONE&text=TEXT&apikey=KEY
 */
class WhatsAppService
{
    private const API_URL = 'https://api.callmebot.com/whatsapp.php';

    public function send(string $phone, string $apiKey, string $message): bool
    {
        $phone = preg_replace('/[^0-9+]/', '', $phone);

        try {
            $response = Http::timeout(15)->get(self::API_URL, [
                'phone' => $phone,
                'text' => $message,
                'apikey' => $apiKey,
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::warning('Callmebot WhatsApp failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'phone' => $phone,
            ]);

            return false;
        } catch (\Throwable $e) {
            Log::error('Callmebot WhatsApp exception', [
                'error' => $e->getMessage(),
                'phone' => $phone,
            ]);

            return false;
        }
    }
}
