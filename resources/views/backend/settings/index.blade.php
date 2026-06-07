<x-layouts.backend title="Settings">

    {{-- Page header --}}
        <div style="margin-bottom:2rem">
            <h1 class="page-title">Settings</h1>
            <p class="page-subtitle">Manage website theme, company info, and social links.</p>
        </div>

        @if(session('success'))
            <div style="background:rgba(52,211,153,0.1);border:1px solid rgba(52,211,153,0.3);border-radius:10px;padding:0.875rem 1.25rem;margin-bottom:1.5rem;color:#34D399;font-size:0.875rem;display:flex;align-items:center;gap:0.5rem">
                <i class="ri-checkbox-circle-line"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            @method('PUT')

            {{-- ── Theme Toggle ─────────────────────────────────────────── --}}
            <div class="crm-card" style="margin-bottom:1.5rem">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap">
                    <div>
                        <h2 style="font-size:1rem;font-weight:700;color:var(--crm-text);margin-bottom:0.25rem">Website Theme</h2>
                        <p style="font-size:0.82rem;color:var(--crm-text-muted)">Applied to both the public website and CRM panel.</p>
                    </div>

                    {{-- Toggle pill --}}
                    <div style="display:flex;background:var(--crm-input);border:1px solid var(--crm-border);border-radius:50px;padding:4px;gap:4px;flex-shrink:0">
                        @foreach(['dark' => ['ri-moon-line', 'Dark'], 'light' => ['ri-sun-line', 'Light']] as $val => [$icon, $label])
                            <label style="cursor:pointer">
                                <input type="radio" name="theme" value="{{ $val }}"
                                       {{ ($settings['theme']->value ?? 'dark') === $val ? 'checked' : '' }}
                                       style="display:none"
                                       onchange="updateThemePreview('{{ $val }}')">
                                <span class="theme-pill {{ ($settings['theme']->value ?? 'dark') === $val ? 'theme-pill--active' : '' }}"
                                      id="pill-{{ $val }}"
                                      style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.45rem 1.1rem;border-radius:50px;font-size:0.82rem;font-weight:600;transition:all 0.2s ease;white-space:nowrap;
                                             {{ ($settings['theme']->value ?? 'dark') === $val ? 'background:#FF6400;color:#fff' : 'background:transparent;color:var(--crm-text-muted)' }}">
                                    <i class="{{ $icon }}"></i> {{ $label }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Preview cards --}}
                <div class="form-grid-2" style="margin-top:1.5rem">
                    <div style="border-radius:10px;overflow:hidden;border:2px solid transparent;transition:border-color 0.2s" id="preview-dark" class="{{ ($settings['theme']->value ?? 'dark') === 'dark' ? 'preview-active' : '' }}">
                        <div style="background:#100F1A;padding:1rem;border-radius:8px">
                            <div style="display:flex;gap:0.5rem;margin-bottom:0.75rem">
                                <div style="width:10px;height:10px;border-radius:50%;background:#FF5F56"></div>
                                <div style="width:10px;height:10px;border-radius:50%;background:#FFBD2E"></div>
                                <div style="width:10px;height:10px;border-radius:50%;background:#27C93F"></div>
                            </div>
                            <div style="background:#1A1829;border-radius:6px;padding:0.75rem;border:1px solid rgba(255,255,255,0.07)">
                                <div style="width:60%;height:8px;background:rgba(255,255,255,0.15);border-radius:4px;margin-bottom:0.5rem"></div>
                                <div style="width:40%;height:6px;background:rgba(255,255,255,0.07);border-radius:4px"></div>
                            </div>
                            <div style="display:flex;gap:0.5rem;margin-top:0.5rem">
                                <div style="flex:1;height:6px;background:rgba(255,255,255,0.07);border-radius:4px"></div>
                                <div style="width:28px;height:6px;background:#FF6400;border-radius:4px"></div>
                            </div>
                        </div>
                    </div>
                    <div style="border-radius:10px;overflow:hidden;border:2px solid transparent;transition:border-color 0.2s" id="preview-light" class="{{ ($settings['theme']->value ?? 'dark') === 'light' ? 'preview-active' : '' }}">
                        <div style="background:#F0EFF8;padding:1rem;border-radius:8px">
                            <div style="display:flex;gap:0.5rem;margin-bottom:0.75rem">
                                <div style="width:10px;height:10px;border-radius:50%;background:#FF5F56"></div>
                                <div style="width:10px;height:10px;border-radius:50%;background:#FFBD2E"></div>
                                <div style="width:10px;height:10px;border-radius:50%;background:#27C93F"></div>
                            </div>
                            <div style="background:#FFFFFF;border-radius:6px;padding:0.75rem;border:1px solid rgba(26,24,41,0.09)">
                                <div style="width:60%;height:8px;background:rgba(26,24,41,0.2);border-radius:4px;margin-bottom:0.5rem"></div>
                                <div style="width:40%;height:6px;background:rgba(26,24,41,0.08);border-radius:4px"></div>
                            </div>
                            <div style="display:flex;gap:0.5rem;margin-top:0.5rem">
                                <div style="flex:1;height:6px;background:rgba(26,24,41,0.08);border-radius:4px"></div>
                                <div style="width:28px;height:6px;background:#FF6400;border-radius:4px"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <p style="font-size:0.75rem;color:var(--crm-text-muted);margin-top:0.75rem">
                    <i class="ri-information-line"></i>
                    Theme changes take effect after saving. The CRM sidebar always remains dark.
                </p>
            </div>

            {{-- ── Company Info ─────────────────────────────────────────── --}}
            <div class="crm-card" style="margin-bottom:1.5rem">
                <h2 style="font-size:1rem;font-weight:700;color:var(--crm-text);margin-bottom:1.25rem">Company Information</h2>

                <div class="form-grid-2">
                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror"
                               value="{{ old('company_name', $settings['company_name']->value ?? '') }}"
                               placeholder="Redis Solution Pvt. Ltd.">
                        @error('company_name')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="company_email" class="form-control @error('company_email') is-invalid @enderror"
                               value="{{ old('company_email', $settings['company_email']->value ?? '') }}"
                               placeholder="hello@redissolution.com">
                        @error('company_email')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="company_phone" class="form-control @error('company_phone') is-invalid @enderror"
                               value="{{ old('company_phone', $settings['company_phone']->value ?? '') }}"
                               placeholder="+92 300 0000000">
                        @error('company_phone')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label">WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" class="form-control @error('whatsapp_number') is-invalid @enderror"
                               value="{{ old('whatsapp_number', $settings['whatsapp_number']->value ?? '') }}"
                               placeholder="+92 300 0000000">
                        @error('whatsapp_number')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group" style="margin-bottom:0;grid-column:span 2">
                        <label class="form-label">Office Address</label>
                        <textarea name="company_address" class="form-control @error('company_address') is-invalid @enderror"
                                  rows="2" placeholder="Street, City, Country">{{ old('company_address', $settings['company_address']->value ?? '') }}</textarea>
                        @error('company_address')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ── Social Links ─────────────────────────────────────────── --}}
            <div class="crm-card" style="margin-bottom:1.5rem">
                <h2 style="font-size:1rem;font-weight:700;color:var(--crm-text);margin-bottom:1.25rem">Social Media Links</h2>

                <div class="form-grid-2">
                    @foreach([
                        'social_facebook'  => ['ri-facebook-line',  'Facebook',  'https://facebook.com/...'],
                        'social_instagram' => ['ri-instagram-line', 'Instagram', 'https://instagram.com/...'],
                        'social_linkedin'  => ['ri-linkedin-line',  'LinkedIn',  'https://linkedin.com/company/...'],
                        'social_twitter'   => ['ri-twitter-x-line', 'X (Twitter)', 'https://x.com/...'],
                        'social_youtube'   => ['ri-youtube-line',   'YouTube',   'https://youtube.com/...'],
                    ] as $key => [$icon, $label, $placeholder])
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label" style="display:flex;align-items:center;gap:0.35rem">
                                <i class="{{ $icon }}"></i> {{ $label }}
                            </label>
                            <input type="url" name="{{ $key }}" class="form-control @error($key) is-invalid @enderror"
                                   value="{{ old($key, $settings[$key]->value ?? '') }}"
                                   placeholder="{{ $placeholder }}">
                            @error($key)<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ── Save button ──────────────────────────────────────────── --}}
            <div style="display:flex;justify-content:flex-end">
                <button type="submit" class="btn btn-primary">
                    <i class="ri-save-line"></i> Save Settings
                </button>
            </div>

        </form>

    @push('styles')
    <style>
        .preview-active { border-color: #FF6400 !important; }
    </style>
    @endpush

    @push('scripts')
    <script>
        function updateThemePreview(theme) {
            document.querySelectorAll('[id^="pill-"]').forEach(el => {
                el.style.background = 'transparent';
                el.style.color = 'var(--crm-text-muted)';
            });
            const active = document.getElementById('pill-' + theme);
            if (active) { active.style.background = '#FF6400'; active.style.color = '#fff'; }

            ['dark', 'light'].forEach(t => {
                const el = document.getElementById('preview-' + t);
                if (el) el.classList.toggle('preview-active', t === theme);
            });
        }
    </script>
    @endpush

</x-layouts.backend>
