<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\TemplateMail;
use App\Models\ContactInquiry;
use App\Models\EmailTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactSubmitController extends Controller
{
    private const FAKE_SUCCESS = 'Thank you! We received your message and will get back to you within 24 hours.';

    public function store(Request $request): RedirectResponse
    {
        // Layer 1: Honeypot — bots fill the hidden field, humans never see it
        if ($request->filled('hp_website')) {
            Log::info('Bot blocked via honeypot', ['ip' => $request->ip()]);

            return back()->with('success', self::FAKE_SUCCESS);
        }

        // Layer 2: Time check — real humans take at least 4 seconds to fill a form
        $loadedAt = (int) $request->input('form_loaded_at', 0);
        if ($loadedAt === 0 || (now()->timestamp - $loadedAt) < 4) {
            Log::info('Bot blocked via time check', ['ip' => $request->ip(), 'elapsed' => now()->timestamp - $loadedAt]);

            return back()->with('success', self::FAKE_SUCCESS);
        }

        // Layer 3: Validate fields
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'service' => ['nullable', 'string', 'max:100'],
            'budget' => ['nullable', 'string', 'max:50'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'message' => ['nullable', 'string', 'max:3000'],
        ]);

        // Layer 4: Spam content check — block if message has too many URLs or known spam triggers
        if ($this->isSpamMessage($data['message'] ?? '', $data['name'])) {
            Log::info('Bot blocked via spam check', ['ip' => $request->ip(), 'name' => $data['name']]);

            return back()->with('success', self::FAKE_SUCCESS);
        }

        // Layer 5: reCAPTCHA — only when enabled and keys are configured
        if (setting('recaptcha_enabled') === '1' && setting('recaptcha_secret_key')) {
            $token = $request->input('g-recaptcha-response', '');

            if (empty($token)) {
                return back()->withInput()->withErrors(['captcha' => 'Security check failed. Please try again.']);
            }

            try {
                $result = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => setting('recaptcha_secret_key'),
                    'response' => $token,
                    'remoteip' => $request->ip(),
                ])->json();

                if (! ($result['success'] ?? false)) {
                    Log::info('Bot blocked via reCAPTCHA failure', ['ip' => $request->ip()]);

                    return back()->withInput()->withErrors(['captcha' => 'Security verification failed. Please try again.']);
                }

                // v3 score threshold check — low score = likely bot, use fake success so it won't retry
                if (setting('recaptcha_version') === 'v3') {
                    $threshold = (float) setting('recaptcha_threshold', '0.5');
                    if (($result['score'] ?? 1.0) < $threshold) {
                        Log::info('Bot blocked via reCAPTCHA v3 score', ['ip' => $request->ip(), 'score' => $result['score'] ?? 0]);

                        return back()->with('success', self::FAKE_SUCCESS);
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('reCAPTCHA verification error — allowing through', ['error' => $e->getMessage()]);
            }
        }

        $inquiry = ContactInquiry::create($data);

        $this->sendEmails($inquiry, $data);

        return back()->with('success', self::FAKE_SUCCESS);
    }

    private function sendEmails(ContactInquiry $inquiry, array $data): void
    {
        $commonVars = [
            'company_name' => setting('company_name', 'Redis Solution Pvt. Ltd.'),
            'company_phone' => setting('company_phone', ''),
            'company_email' => setting('company_email', ''),
        ];

        // 1. Auto-reply to the person who submitted the form
        $autoReply = EmailTemplate::findBySlug('contact-auto-reply');
        if ($autoReply) {
            try {
                Mail::to($inquiry->email, $inquiry->name)->send(new TemplateMail($autoReply, [
                    ...$commonVars,
                    'client_name' => $inquiry->name,
                    'client_email' => $inquiry->email,
                    'message' => $inquiry->message ?? '',
                ]));
            } catch (\Throwable $e) {
                Log::error('Contact auto-reply failed', ['error' => $e->getMessage()]);
            }
        }

        // 2. Admin notification to mail_to with CC
        $adminNotify = EmailTemplate::findBySlug('contact-admin-notify');
        if ($adminNotify) {
            $primaryTo = setting('mail_to', setting('company_email', ''));
            if (! $primaryTo) {
                return;
            }

            $ccList = collect(explode(',', setting('mail_cc', '')))
                ->map(fn (string $e): string => trim($e))
                ->filter()
                ->values()
                ->toArray();

            try {
                $mailer = Mail::to($primaryTo);
                if ($ccList) {
                    $mailer->cc($ccList);
                }
                $mailer->send(new TemplateMail($adminNotify, [
                    ...$commonVars,
                    'client_name' => $inquiry->name,
                    'client_email' => $inquiry->email,
                    'client_phone' => $inquiry->phone ?? '',
                    'service_interest' => $inquiry->service ?? '',
                    'budget' => $inquiry->budget ?? '',
                    'message' => $inquiry->message ?? '',
                    'submitted_at' => now()->format('d M Y, h:i A'),
                ]));
            } catch (\Throwable $e) {
                Log::error('Contact admin notification failed', ['error' => $e->getMessage()]);
            }
        }
    }

    private function isSpamMessage(?string $message, string $name): bool
    {
        $text = strtolower(($message ?? '').' '.$name);

        // Too many URLs in message
        $urlCount = preg_match_all('/https?:\/\//i', $message ?? '');
        if ($urlCount >= 3) {
            return true;
        }

        // Common spam trigger words
        $spamWords = [
            'casino', 'viagra', 'cialis', 'bitcoin', 'crypto investment',
            'earn money fast', 'click here', 'free money', 'make money online',
            'seo service', 'buy backlinks', 'guaranteed ranking',
        ];

        foreach ($spamWords as $word) {
            if (str_contains($text, $word)) {
                return true;
            }
        }

        return false;
    }
}
