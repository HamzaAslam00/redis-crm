<?php

namespace App\Livewire\Backend;

use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class SettingsSmtp extends Component
{
    public string $smtp_host = '';

    public string $smtp_port = '587';

    public string $smtp_username = '';

    public string $smtp_password = '';

    public string $smtp_encryption = 'tls';

    public string $smtp_from_address = '';

    public string $smtp_from_name = '';

    public string $mail_to = '';

    public string $mail_cc = '';

    public string $mail_test_to = '';

    public bool $showPassword = false;

    public bool $testing = false;

    public function mount(): void
    {
        $this->smtp_host = setting('smtp_host', '');
        $this->smtp_port = setting('smtp_port', '587');
        $this->smtp_username = setting('smtp_username', '');
        $this->smtp_password = setting('smtp_password', '');
        $this->smtp_encryption = setting('smtp_encryption', 'tls');
        $this->smtp_from_address = setting('smtp_from_address', '');
        $this->smtp_from_name = setting('smtp_from_name', '');
        $this->mail_to = setting('mail_to', '');
        $this->mail_cc = setting('mail_cc', '');
        $this->mail_test_to = setting('mail_test_to', 'info@redissolution.com');
    }

    public function save(): void
    {
        $this->validate([
            'smtp_host' => ['nullable', 'string', 'max:255'],
            'smtp_port' => ['required', 'integer', 'min:1', 'max:65535'],
            'smtp_username' => ['nullable', 'string', 'max:255'],
            'smtp_password' => ['nullable', 'string', 'max:255'],
            'smtp_encryption' => ['required', 'in:tls,ssl,none'],
            'smtp_from_address' => ['nullable', 'email', 'max:255'],
            'smtp_from_name' => ['nullable', 'string', 'max:150'],
            'mail_to' => ['nullable', 'email', 'max:255'],
            'mail_cc' => ['nullable', 'string', 'max:1000'],
            'mail_test_to' => ['nullable', 'email', 'max:255'],
        ]);

        // Normalise CC: trim spaces, remove empty entries
        $this->mail_cc = collect(explode(',', $this->mail_cc))
            ->map(fn (string $e): string => trim($e))
            ->filter()
            ->implode(', ');

        $keys = ['smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 'smtp_encryption', 'smtp_from_address', 'smtp_from_name', 'mail_to', 'mail_cc', 'mail_test_to'];

        foreach ($keys as $key) {
            Setting::updateOrCreate(['key' => $key], ['value' => $this->$key ?? '']);
        }

        $this->dispatch('toast', type: 'success', message: 'SMTP settings saved.');
    }

    public function sendTestEmail(): void
    {
        if (! $this->smtp_host || ! $this->smtp_from_address) {
            $this->dispatch('toast', type: 'error', message: 'Fill in SMTP Host and From Address first.');

            return;
        }

        $this->testing = true;

        // Apply settings dynamically for this request
        Config::set('mail.default', 'smtp');
        Config::set('mail.mailers.smtp.host', $this->smtp_host);
        Config::set('mail.mailers.smtp.port', (int) $this->smtp_port);
        Config::set('mail.mailers.smtp.username', $this->smtp_username);
        Config::set('mail.mailers.smtp.password', $this->smtp_password);
        Config::set('mail.mailers.smtp.encryption', $this->smtp_encryption === 'none' ? null : $this->smtp_encryption);
        Config::set('mail.from.address', $this->smtp_from_address);
        Config::set('mail.from.name', $this->smtp_from_name ?: 'Redis Solution');

        $recipient = $this->mail_test_to ?: auth()->user()->email;

        try {
            Mail::raw('This is a test email from Redis Solution CRM. Your SMTP settings are working correctly!', function ($msg) use ($recipient) {
                $msg->to($recipient)->subject('✅ SMTP Test — Redis Solution CRM');
            });

            $this->dispatch('toast', type: 'success', message: 'Test email sent to '.$recipient.'!');
        } catch (\Throwable $e) {
            $this->dispatch('toast', type: 'error', message: 'Failed: '.$e->getMessage());
        } finally {
            $this->testing = false;
        }
    }

    public function render(): View
    {
        return view('livewire.backend.settings-smtp');
    }
}
