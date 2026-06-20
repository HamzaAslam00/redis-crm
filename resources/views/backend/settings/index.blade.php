<x-layouts.backend title="Settings">

    <div style="margin-bottom:1.75rem">
        <h1 class="page-title">Settings</h1>
        <p class="page-subtitle">Configure your company info, email, and security options.</p>
    </div>

    @if(session('success'))
        <div style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.3);border-radius:10px;padding:0.875rem 1.25rem;margin-bottom:1.5rem;color:#34D399;font-size:0.875rem;display:flex;align-items:center;gap:0.5rem">
            <i class="ri-checkbox-circle-line"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Tab nav --}}
    <div x-data="{ tab: 'general' }">

        <div style="display:flex;border-bottom:2px solid var(--crm-border);margin-bottom:1.75rem">
            @foreach(['general' => 'General', 'smtp' => 'SMTP / Email', 'templates' => 'Email Templates', 'notifications' => 'Notifications', 'recaptcha' => 'reCAPTCHA'] as $key => $label)
                <button
                    class="settings-tab"
                    :class="{ 'settings-tab--active': tab === '{{ $key }}' }"
                    @click="tab = '{{ $key }}'"
                >{{ $label }}</button>
            @endforeach
        </div>

        {{-- ══════════════════════════════════════════════════════
             TAB 1: GENERAL
        ══════════════════════════════════════════════════════ --}}
        <div x-show="tab === 'general'" x-cloak x-transition>
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf @method('PUT')

                {{-- Theme --}}
                <div class="crm-card" style="margin-bottom:1.25rem">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap">
                        <div>
                            <h2 style="font-size:0.95rem;font-weight:700;color:var(--crm-text);margin-bottom:0.2rem">Website Theme</h2>
                            <p style="font-size:0.8rem;color:var(--crm-text-muted)">Applies to both public website and CRM panel.</p>
                        </div>
                        <div style="display:flex;background:var(--crm-input);border:1px solid var(--crm-border);border-radius:50px;padding:4px;gap:4px;flex-shrink:0">
                            @foreach(['dark' => ['ri-moon-line', 'Dark'], 'light' => ['ri-sun-line', 'Light']] as $val => [$icon, $label])
                                <label style="cursor:pointer">
                                    <input type="radio" name="theme" value="{{ $val }}"
                                        {{ ($settings['theme']->value ?? 'dark') === $val ? 'checked' : '' }}
                                        style="display:none"
                                        onchange="updateThemePreview('{{ $val }}')">
                                    <span id="pill-{{ $val }}"
                                        style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.45rem 1.1rem;border-radius:50px;font-size:0.82rem;font-weight:600;transition:all 0.2s;white-space:nowrap;
                                            {{ ($settings['theme']->value ?? 'dark') === $val ? 'background:#FF6400;color:#fff' : 'background:transparent;color:var(--crm-text-muted)' }}">
                                        <i class="{{ $icon }}"></i> {{ $label }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-top:1.25rem">
                        <div id="preview-dark" style="border-radius:10px;border:2px solid {{ ($settings['theme']->value ?? 'dark') === 'dark' ? '#FF6400' : 'transparent' }};transition:border-color 0.2s">
                            <div style="background:#100F1A;padding:0.875rem;border-radius:8px">
                                <div style="display:flex;gap:0.4rem;margin-bottom:0.6rem">
                                    <div style="width:8px;height:8px;border-radius:50%;background:#FF5F56"></div>
                                    <div style="width:8px;height:8px;border-radius:50%;background:#FFBD2E"></div>
                                    <div style="width:8px;height:8px;border-radius:50%;background:#27C93F"></div>
                                </div>
                                <div style="background:#1A1829;border-radius:5px;padding:0.6rem;border:1px solid rgba(255,255,255,0.07)">
                                    <div style="width:55%;height:7px;background:rgba(255,255,255,0.15);border-radius:4px;margin-bottom:0.4rem"></div>
                                    <div style="width:35%;height:5px;background:rgba(255,255,255,0.07);border-radius:4px"></div>
                                </div>
                                <div style="display:flex;gap:0.4rem;margin-top:0.4rem">
                                    <div style="flex:1;height:5px;background:rgba(255,255,255,0.07);border-radius:4px"></div>
                                    <div style="width:24px;height:5px;background:#FF6400;border-radius:4px"></div>
                                </div>
                            </div>
                        </div>
                        <div id="preview-light" style="border-radius:10px;border:2px solid {{ ($settings['theme']->value ?? 'dark') === 'light' ? '#FF6400' : 'transparent' }};transition:border-color 0.2s">
                            <div style="background:#F0EFF8;padding:0.875rem;border-radius:8px">
                                <div style="display:flex;gap:0.4rem;margin-bottom:0.6rem">
                                    <div style="width:8px;height:8px;border-radius:50%;background:#FF5F56"></div>
                                    <div style="width:8px;height:8px;border-radius:50%;background:#FFBD2E"></div>
                                    <div style="width:8px;height:8px;border-radius:50%;background:#27C93F"></div>
                                </div>
                                <div style="background:#fff;border-radius:5px;padding:0.6rem;border:1px solid rgba(26,24,41,0.09)">
                                    <div style="width:55%;height:7px;background:rgba(26,24,41,0.2);border-radius:4px;margin-bottom:0.4rem"></div>
                                    <div style="width:35%;height:5px;background:rgba(26,24,41,0.08);border-radius:4px"></div>
                                </div>
                                <div style="display:flex;gap:0.4rem;margin-top:0.4rem">
                                    <div style="flex:1;height:5px;background:rgba(26,24,41,0.08);border-radius:4px"></div>
                                    <div style="width:24px;height:5px;background:#FF6400;border-radius:4px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Company Info --}}
                <div class="crm-card" style="margin-bottom:1.25rem">
                    <h2 style="font-size:0.95rem;font-weight:700;color:var(--crm-text);margin-bottom:1.25rem;padding-bottom:0.75rem;border-bottom:1px solid var(--crm-border)">
                        <i class="ri-building-line" style="color:#FF6400"></i> Company Information
                    </h2>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $settings['company_name']->value ?? '') }}" placeholder="Redis Solution Pvt. Ltd.">
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Tagline</label>
                            <input type="text" name="company_tagline" class="form-control" value="{{ old('company_tagline', $settings['company_tagline']->value ?? '') }}" placeholder="INNOVATE. CREATE. SUCCEED.">
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Primary Email</label>
                            <input type="email" name="company_email" class="form-control" value="{{ old('company_email', $settings['company_email']->value ?? '') }}" placeholder="info@redissolution.com">
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Secondary Email</label>
                            <input type="email" name="company_email2" class="form-control" value="{{ old('company_email2', $settings['company_email2']->value ?? '') }}" placeholder="contact@redissolution.com">
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="company_phone" class="form-control" value="{{ old('company_phone', $settings['company_phone']->value ?? '') }}" placeholder="+92 300 0000000">
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">WhatsApp Number</label>
                            <input type="text" name="whatsapp_number" class="form-control" value="{{ old('whatsapp_number', $settings['whatsapp_number']->value ?? '') }}" placeholder="+92 300 0000000">
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">WhatsApp Default Message</label>
                            <input type="text" name="whatsapp_default_message" class="form-control" value="{{ old('whatsapp_default_message', $settings['whatsapp_default_message']->value ?? '') }}" placeholder="Hello! I am interested in your services.">
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Google Maps Embed URL</label>
                            <input type="url" name="google_maps_url" class="form-control" value="{{ old('google_maps_url', $settings['google_maps_url']->value ?? '') }}" placeholder="https://maps.google.com/...">
                        </div>
                        <div class="form-group" style="margin-bottom:0;grid-column:span 2">
                            <label class="form-label">Office Address</label>
                            <textarea name="company_address" class="form-control" rows="2" placeholder="Street, City, Country">{{ old('company_address', $settings['company_address']->value ?? '') }}</textarea>
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Copyright Text</label>
                            <input type="text" name="company_copyright" class="form-control" value="{{ old('company_copyright', $settings['company_copyright']->value ?? '') }}" placeholder="© 2026 Redis Solution Pvt. Ltd.">
                        </div>
                    </div>
                </div>

                {{-- Stats Counters --}}
                <div class="crm-card" style="margin-bottom:1.25rem">
                    <h2 style="font-size:0.95rem;font-weight:700;color:var(--crm-text);margin-bottom:1.25rem;padding-bottom:0.75rem;border-bottom:1px solid var(--crm-border)">
                        <i class="ri-bar-chart-line" style="color:#FF6400"></i> Homepage Stats Counters
                    </h2>
                    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem">
                        @foreach([
                            'counter_projects'     => 'Projects Delivered',
                            'counter_clients'      => 'Happy Clients',
                            'counter_years'        => 'Years Experience',
                            'counter_satisfaction' => 'Satisfaction % (0–100)',
                        ] as $key => $label)
                            <div class="form-group" style="margin-bottom:0">
                                <label class="form-label">{{ $label }}</label>
                                <input type="number" name="{{ $key }}" class="form-control" value="{{ old($key, $settings[$key]->value ?? '') }}" min="0">
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Social Links --}}
                <div class="crm-card" style="margin-bottom:1.25rem">
                    <h2 style="font-size:0.95rem;font-weight:700;color:var(--crm-text);margin-bottom:1.25rem;padding-bottom:0.75rem;border-bottom:1px solid var(--crm-border)">
                        <i class="ri-share-line" style="color:#FF6400"></i> Social Media Links
                    </h2>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                        @foreach([
                            'social_facebook'  => ['ri-facebook-line',  'Facebook',     'https://facebook.com/...'],
                            'social_instagram' => ['ri-instagram-line', 'Instagram',    'https://instagram.com/...'],
                            'social_linkedin'  => ['ri-linkedin-line',  'LinkedIn',     'https://linkedin.com/company/...'],
                            'social_twitter'   => ['ri-twitter-x-line', 'X (Twitter)',  'https://x.com/...'],
                            'social_youtube'   => ['ri-youtube-line',   'YouTube',      'https://youtube.com/...'],
                        ] as $key => [$icon, $label, $placeholder])
                            <div class="form-group" style="margin-bottom:0">
                                <label class="form-label" style="display:flex;align-items:center;gap:0.35rem">
                                    <i class="{{ $icon }}"></i> {{ $label }}
                                </label>
                                <input type="url" name="{{ $key }}" class="form-control" value="{{ old($key, $settings[$key]->value ?? '') }}" placeholder="{{ $placeholder }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Analytics --}}
                <div class="crm-card" style="margin-bottom:1.25rem">
                    <h2 style="font-size:0.95rem;font-weight:700;color:var(--crm-text);margin-bottom:1.25rem;padding-bottom:0.75rem;border-bottom:1px solid var(--crm-border)">
                        <i class="ri-line-chart-line" style="color:#FF6400"></i> Analytics & Tracking
                    </h2>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Google Analytics ID</label>
                            <input type="text" name="ga_tracking_id" class="form-control" value="{{ old('ga_tracking_id', $settings['ga_tracking_id']->value ?? '') }}" placeholder="G-XXXXXXXXXX">
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Facebook Pixel ID</label>
                            <input type="text" name="meta_pixel_id" class="form-control" value="{{ old('meta_pixel_id', $settings['meta_pixel_id']->value ?? '') }}" placeholder="123456789012345">
                        </div>
                    </div>
                </div>

                <div style="display:flex;justify-content:flex-end">
                    <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Save General Settings</button>
                </div>
            </form>
        </div>

        {{-- ══════════════════════════════════════════════════════
             TAB 2: SMTP
        ══════════════════════════════════════════════════════ --}}
        <div x-show="tab === 'smtp'" x-cloak x-transition>
            <div class="crm-card">
                <h2 style="font-size:0.95rem;font-weight:700;color:var(--crm-text);margin-bottom:0.25rem">
                    <i class="ri-mail-settings-line" style="color:#FF6400"></i> SMTP Email Settings
                </h2>
                <p style="font-size:0.8rem;color:var(--crm-text-muted);margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1px solid var(--crm-border)">
                    Configure outgoing email. Used for contact replies, note reminders, and system notifications.
                </p>
                @livewire('backend.settings-smtp')
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════
             TAB 3: EMAIL TEMPLATES
        ══════════════════════════════════════════════════════ --}}
        <div x-show="tab === 'templates'" x-cloak x-transition>
            @livewire('backend.email-templates-editor')
        </div>

        {{-- ══════════════════════════════════════════════════════
             TAB 4: NOTIFICATIONS
        ══════════════════════════════════════════════════════ --}}
        <div x-show="tab === 'notifications'" x-cloak x-transition>
            <div class="crm-card">
                <h2 style="font-size:0.95rem;font-weight:700;color:var(--crm-text);margin-bottom:0.25rem">
                    <i class="ri-notification-3-line" style="color:#FF6400"></i> Notification Settings
                </h2>
                <p style="font-size:0.8rem;color:var(--crm-text-muted);margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1px solid var(--crm-border)">
                    Control which system events trigger in-app notifications and email alerts.
                </p>
                @livewire('backend.notification-settings-matrix')
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════
             TAB 5: reCAPTCHA
        ══════════════════════════════════════════════════════ --}}
        <div x-show="tab === 'recaptcha'" x-cloak x-transition>
            <form method="POST" action="{{ route('admin.settings.recaptcha') }}">
                @csrf @method('PUT')

                <div class="crm-card">
                    <h2 style="font-size:0.95rem;font-weight:700;color:var(--crm-text);margin-bottom:0.25rem">
                        <i class="ri-shield-check-line" style="color:#FF6400"></i> Google reCAPTCHA
                    </h2>
                    <p style="font-size:0.8rem;color:var(--crm-text-muted);margin-bottom:1.25rem;padding-bottom:1rem;border-bottom:1px solid var(--crm-border)">
                        Extra layer of bot protection on the contact form (on top of honeypot + rate limiting which are always active).
                        Get keys free at <strong style="color:var(--crm-text)">google.com/recaptcha</strong>.
                    </p>

                    {{-- Warning: enabled but keys missing --}}
                    @if(setting('recaptcha_enabled') === '1' && (! setting('recaptcha_site_key') || ! setting('recaptcha_secret_key')))
                        <div style="display:flex;align-items:flex-start;gap:0.6rem;padding:0.8rem 1rem;background:rgba(239,68,68,0.07);border:1px solid rgba(239,68,68,0.25);border-radius:8px;font-size:0.82rem;color:var(--crm-text);margin-bottom:1.25rem">
                            <i class="ri-error-warning-line" style="color:#ef4444;font-size:1rem;flex-shrink:0;margin-top:0.05rem"></i>
                            <span>reCAPTCHA is <strong>ON</strong> but {{ ! setting('recaptcha_site_key') ? 'Site Key' : 'Secret Key' }} is missing — the contact form will not show a CAPTCHA until both keys are saved below.</span>
                        </div>
                    @endif

                    {{-- Enable toggle --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem;background:var(--crm-hover);border-radius:10px;margin-bottom:1.25rem" x-data="{ enabled: {{ setting('recaptcha_enabled') === '1' ? 'true' : 'false' }} }">
                        <div>
                            <div style="font-weight:600;color:var(--crm-text);font-size:0.9rem">Enable reCAPTCHA</div>
                            <div style="font-size:0.78rem;color:var(--crm-text-muted)">Adds a verification check on the contact form submit.</div>
                        </div>
                        <div style="display:flex;align-items:center;gap:0.5rem">
                            <input type="hidden" name="recaptcha_enabled" value="0">
                            <input type="checkbox" name="recaptcha_enabled" value="1"
                                {{ setting('recaptcha_enabled') === '1' ? 'checked' : '' }}
                                x-model="enabled"
                                style="display:none">
                            <div @click="enabled = !enabled"
                                :style="{ background: enabled ? '#FF6400' : 'var(--crm-border)' }"
                                style="width:44px;height:24px;border-radius:50px;position:relative;transition:background 0.2s;cursor:pointer">
                                <div :style="{ left: enabled ? '22px' : '2px' }"
                                    style="position:absolute;top:2px;width:20px;height:20px;border-radius:50%;background:#fff;transition:left 0.2s;box-shadow:0 1px 4px rgba(0,0,0,0.2)"></div>
                            </div>
                            <span x-text="enabled ? 'ON' : 'OFF'" :style="{ color: enabled ? '#FF6400' : 'var(--crm-text-muted)' }"
                                style="font-size:0.78rem;font-weight:700;width:24px"></span>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.25rem">
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Version</label>
                            <select name="recaptcha_version" class="form-control">
                                <option value="v3" {{ setting('recaptcha_version', 'v2') === 'v3' ? 'selected' : '' }}>v3 — Invisible (recommended, best UX)</option>
                                <option value="v2" {{ setting('recaptcha_version', 'v2') === 'v2' ? 'selected' : '' }}>v2 — "I'm not a robot" checkbox</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">v3 Score Threshold <span style="color:var(--crm-text-muted);font-weight:400">(0.0–1.0, default 0.5)</span></label>
                            <input type="number" name="recaptcha_threshold" class="form-control" step="0.1" min="0" max="1"
                                value="{{ old('recaptcha_threshold', setting('recaptcha_threshold', '0.5')) }}"
                                placeholder="0.5">
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Site Key <span style="color:var(--crm-text-muted);font-weight:400">(public)</span></label>
                            <input type="text" name="recaptcha_site_key" class="form-control"
                                value="{{ old('recaptcha_site_key', setting('recaptcha_site_key', '')) }}"
                                placeholder="6Lc...">
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Secret Key <span style="color:var(--crm-text-muted);font-weight:400">(private — keep safe)</span></label>
                            <input type="password" name="recaptcha_secret_key" class="form-control"
                                value="{{ old('recaptcha_secret_key', setting('recaptcha_secret_key', '')) }}"
                                autocomplete="new-password"
                                placeholder="6Lc...">
                        </div>
                    </div>

                    <div style="padding:0.875rem 1rem;background:rgba(255,100,0,0.07);border:1px solid rgba(255,100,0,0.2);border-radius:8px;font-size:0.8rem;color:var(--crm-text-muted);line-height:1.6;margin-bottom:1.5rem">
                        <strong style="color:var(--crm-text)"><i class="ri-information-line" style="color:#FF6400"></i> Note:</strong>
                        Honeypot + rate limiting are <strong style="color:var(--crm-text)">always active</strong> regardless of this setting — they block most bots silently with zero UX impact.
                        reCAPTCHA is an optional additional layer for high-traffic forms.
                    </div>

                    <div style="display:flex;justify-content:flex-end">
                        <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Save reCAPTCHA Settings</button>
                    </div>
                </div>
            </form>
        </div>

    </div>{{-- end x-data tab --}}

    @push('styles')
    <style>
        [x-cloak] { display: none !important; }

        .settings-tab {
            padding: 0.8rem 1.4rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--crm-text-muted);
            background: none;
            border: none;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            cursor: pointer;
            white-space: nowrap;
            outline: none;
            border-radius: 0;
            transition: color 0.18s, border-color 0.18s;
            letter-spacing: 0.01em;
        }
        .settings-tab:hover {
            color: var(--crm-text);
        }
        .settings-tab--active {
            color: #FF6400 !important;
            border-bottom-color: #FF6400 !important;
            font-weight: 600;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        function updateThemePreview(theme) {
            ['dark', 'light'].forEach(t => {
                const pill = document.getElementById('pill-' + t);
                const preview = document.getElementById('preview-' + t);
                if (pill) {
                    pill.style.background = t === theme ? '#FF6400' : 'transparent';
                    pill.style.color = t === theme ? '#fff' : 'var(--crm-text-muted)';
                }
                if (preview) {
                    preview.style.borderColor = t === theme ? '#FF6400' : 'transparent';
                }
            });
        }
    </script>
    @endpush

</x-layouts.backend>
