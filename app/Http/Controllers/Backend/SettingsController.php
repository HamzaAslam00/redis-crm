<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = Setting::all()->keyBy('key');

        return view('backend.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'theme' => ['required', 'in:dark,light'],
            'company_name' => ['nullable', 'string', 'max:150'],
            'company_email' => ['nullable', 'email', 'max:150'],
            'company_email2' => ['nullable', 'email', 'max:150'],
            'company_phone' => ['nullable', 'string', 'max:30'],
            'company_address' => ['nullable', 'string', 'max:500'],
            'whatsapp_number' => ['nullable', 'string', 'max:30'],
            'whatsapp_default_message' => ['nullable', 'string', 'max:255'],
            'company_tagline' => ['nullable', 'string', 'max:200'],
            'company_copyright' => ['nullable', 'string', 'max:200'],
            'google_maps_url' => ['nullable', 'url', 'max:500'],
            'ga_tracking_id' => ['nullable', 'string', 'max:50'],
            'meta_pixel_id' => ['nullable', 'string', 'max:50'],
            'counter_projects' => ['nullable', 'integer', 'min:0'],
            'counter_clients' => ['nullable', 'integer', 'min:0'],
            'counter_years' => ['nullable', 'integer', 'min:0'],
            'counter_satisfaction' => ['nullable', 'integer', 'min:0', 'max:100'],
            'social_facebook' => ['nullable', 'url', 'max:255'],
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'social_linkedin' => ['nullable', 'url', 'max:255'],
            'social_twitter' => ['nullable', 'url', 'max:255'],
            'social_youtube' => ['nullable', 'url', 'max:255'],
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
        }

        return back()->with('success', 'General settings saved.');
    }

    public function updateRecaptcha(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'recaptcha_enabled' => ['boolean'],
            'recaptcha_version' => ['required', 'in:v2,v3'],
            'recaptcha_site_key' => ['nullable', 'string', 'max:255'],
            'recaptcha_secret_key' => ['nullable', 'string', 'max:255'],
            'recaptcha_threshold' => ['nullable', 'numeric', 'min:0', 'max:1'],
        ]);

        Setting::updateOrCreate(['key' => 'recaptcha_enabled'], ['value' => $request->boolean('recaptcha_enabled') ? '1' : '0']);
        Setting::updateOrCreate(['key' => 'recaptcha_version'], ['value' => $data['recaptcha_version']]);
        Setting::updateOrCreate(['key' => 'recaptcha_site_key'], ['value' => $data['recaptcha_site_key'] ?? '']);
        Setting::updateOrCreate(['key' => 'recaptcha_secret_key'], ['value' => $data['recaptcha_secret_key'] ?? '']);
        Setting::updateOrCreate(['key' => 'recaptcha_threshold'], ['value' => $data['recaptcha_threshold'] ?? '0.5']);

        return back()->with('success', 'reCAPTCHA settings saved.');
    }

    public function updateTheme(Request $request): RedirectResponse
    {
        $request->validate(['theme' => ['required', 'in:dark,light']]);

        Setting::updateOrCreate(['key' => 'theme'], ['value' => $request->theme]);

        return back()->with('success', 'Theme updated.');
    }
}
