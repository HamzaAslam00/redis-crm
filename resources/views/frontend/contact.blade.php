<x-layouts.frontend title="Contact Us — Redis Solution">

    {{-- ═══════════════════════════════════════════════
         PAGE HERO
    ═══════════════════════════════════════════════ --}}
    <section class="photo-hero">
        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=1600&q=80&auto=format&fit=crop" alt="Contact us" class="photo-hero__img">
        <div class="photo-hero__overlay"></div>
        <div class="container photo-hero__content" style="text-align:center">
            <p class="photo-hero__eye">Get in Touch</p>
            <h1 class="photo-hero__title" style="text-align:center">Let's Build Something<br><span>Great Together</span></h1>
            <p class="photo-hero__sub" style="margin:0 auto">Whether you have a fully scoped project or just a rough idea — we'd love to hear from you.</p>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         CONTACT GRID
    ═══════════════════════════════════════════════ --}}
    <section class="section">
        <div class="container">

            @if(session('success'))
                <div style="padding:1rem 1.5rem;border-radius:10px;background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);color:#10B981;margin-bottom:2rem;display:flex;align-items:center;gap:0.75rem" data-gsap-fade>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="contact-grid">

                {{-- LEFT: Company info --}}
                <div data-gsap-stagger>

                    <div style="margin-bottom:2.5rem">
                        <p style="font-size:0.75rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:#FF6400;margin-bottom:0.75rem">Find Us</p>
                        <h2 style="font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:700;color:var(--fg-heading);margin-bottom:0.5rem">Contact Information</h2>
                        <p style="color:var(--fg-text-muted);font-size:0.92rem;line-height:1.7">Reach us through any of the channels below. We typically respond within a few hours during business hours (Mon–Sat, 9am–6pm PKT).</p>
                    </div>

                    <div style="display:flex;flex-direction:column;gap:1rem;margin-bottom:2rem">

                        <div class="contact-info-item">
                            <div class="contact-info-item__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FF6400" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                            </div>
                            <div>
                                <p class="contact-info-item__label">Office Address</p>
                                <p class="contact-info-item__val">{{ setting('company_address', 'Rawalpindi, Punjab, Pakistan') }}</p>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-item__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FF6400" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg>
                            </div>
                            <div>
                                <p class="contact-info-item__label">Phone</p>
                                <a class="contact-info-item__val" href="tel:{{ setting('company_phone', '+923001234567') }}" style="text-decoration:none;color:inherit">{{ setting('company_phone', '+92 300 123 4567') }}</a>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-item__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FF6400" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                            </div>
                            <div>
                                <p class="contact-info-item__label">Email</p>
                                <a class="contact-info-item__val" href="mailto:{{ setting('company_email', 'hello@redissolution.com') }}" style="text-decoration:none;color:inherit">{{ setting('company_email', 'hello@redissolution.com') }}</a>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-info-item__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FF6400" style="width:18px;height:18px"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" /></svg>
                            </div>
                            <div>
                                <p class="contact-info-item__label">WhatsApp</p>
                                <a class="contact-info-item__val" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('company_whatsapp', '+923001234567')) }}" target="_blank" rel="noopener" style="text-decoration:none;color:inherit">{{ setting('company_whatsapp', '+92 300 123 4567') }}</a>
                            </div>
                        </div>

                    </div>

                    {{-- Social links --}}
                    <div style="margin-bottom:2rem">
                        <p style="font-size:0.8rem;font-weight:600;color:var(--fg-text-muted);margin-bottom:0.75rem;text-transform:uppercase;letter-spacing:0.08em">Follow Us</p>
                        <div style="display:flex;gap:0.75rem">
                            @php
                                $socials = [
                                    ['label' => 'LinkedIn', 'url' => setting('social_linkedin', '#'), 'icon' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z'],
                                    ['label' => 'Facebook', 'url' => setting('social_facebook', '#'), 'icon' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z'],
                                    ['label' => 'Instagram', 'url' => setting('social_instagram', '#'), 'icon' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z'],
                                ];
                            @endphp
                            @foreach($socials as $social)
                                <a href="{{ $social['url'] }}" target="_blank" rel="noopener" aria-label="{{ $social['label'] }}" style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:8px;background:var(--fg-card);border:1px solid var(--fg-card-border);transition:border-color 0.2s" onmouseover="this.style.borderColor='#FF6400'" onmouseout="this.style.borderColor='var(--fg-card-border)'">
                                    <svg viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;color:var(--fg-text-muted)"><path d="{{ $social['icon'] }}" /></svg>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Free consultation callout --}}
                    <div style="padding:1.5rem;border-radius:14px;background:rgba(255,100,0,0.08);border:1px solid rgba(255,100,0,0.2)">
                        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.75rem">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FF6400" style="width:22px;height:22px;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" /></svg>
                            <p style="font-weight:700;color:var(--fg-heading);font-family:'Syne',sans-serif">Free Consultation</p>
                        </div>
                        <p style="color:var(--fg-text-muted);font-size:0.88rem;line-height:1.7">
                            Not sure where to start? Book a free 30-minute strategy call. We'll listen to your goals and suggest the best approach — no obligation.
                        </p>
                    </div>

                </div>

                {{-- RIGHT: Contact form --}}
                <div class="contact-form-card" data-gsap-fade>

                    <div style="margin-bottom:2rem">
                        <h2 style="font-family:'Syne',sans-serif;font-size:1.4rem;font-weight:700;color:var(--fg-heading);margin-bottom:0.4rem">Send Us a Message</h2>
                        <p style="color:var(--fg-text-muted);font-size:0.9rem">Fill in the details below and we'll get back to you within one business day.</p>
                    </div>

                    <form action="{{ route('contact.store') }}" method="POST" novalidate>
                        @csrf

                        <div class="form-row">

                            {{-- Name --}}
                            <div>
                                <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--fg-text);margin-bottom:0.4rem">Full Name <span style="color:#FF6400">*</span></label>
                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="John Smith"
                                    style="width:100%;padding:0.7rem 1rem;border-radius:8px;background:var(--fg-body);border:1px solid {{ $errors->has('name') ? '#EF4444' : 'var(--fg-border)' }};color:var(--fg-heading);font-size:0.9rem;outline:none;box-sizing:border-box;transition:border-color 0.2s"
                                    onfocus="this.style.borderColor='#FF6400'"
                                    onblur="this.style.borderColor='{{ $errors->has('name') ? '#EF4444' : 'var(--fg-border)' }}'"
                                />
                                @error('name')
                                    <p style="color:#EF4444;font-size:0.78rem;margin-top:0.3rem">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--fg-text);margin-bottom:0.4rem">Email Address <span style="color:#FF6400">*</span></label>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="john@company.com"
                                    style="width:100%;padding:0.7rem 1rem;border-radius:8px;background:var(--fg-body);border:1px solid {{ $errors->has('email') ? '#EF4444' : 'var(--fg-border)' }};color:var(--fg-heading);font-size:0.9rem;outline:none;box-sizing:border-box;transition:border-color 0.2s"
                                    onfocus="this.style.borderColor='#FF6400'"
                                    onblur="this.style.borderColor='{{ $errors->has('email') ? '#EF4444' : 'var(--fg-border)' }}'"
                                />
                                @error('email')
                                    <p style="color:#EF4444;font-size:0.78rem;margin-top:0.3rem">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div class="form-row">

                            {{-- Phone --}}
                            <div>
                                <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--fg-text);margin-bottom:0.4rem">Phone Number <span style="color:#FF6400">*</span></label>
                                <input
                                    type="tel"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="+92 300 000 0000"
                                    style="width:100%;padding:0.7rem 1rem;border-radius:8px;background:var(--fg-body);border:1px solid {{ $errors->has('phone') ? '#EF4444' : 'var(--fg-border)' }};color:var(--fg-heading);font-size:0.9rem;outline:none;box-sizing:border-box;transition:border-color 0.2s"
                                    onfocus="this.style.borderColor='#FF6400'"
                                    onblur="this.style.borderColor='{{ $errors->has('phone') ? '#EF4444' : 'var(--fg-border)' }}'"
                                />
                                @error('phone')
                                    <p style="color:#EF4444;font-size:0.78rem;margin-top:0.3rem">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Company --}}
                            <div>
                                <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--fg-text);margin-bottom:0.4rem">Company <span style="color:var(--fg-text-muted);font-weight:400">(optional)</span></label>
                                <input
                                    type="text"
                                    name="company"
                                    value="{{ old('company') }}"
                                    placeholder="Acme Inc."
                                    style="width:100%;padding:0.7rem 1rem;border-radius:8px;background:var(--fg-body);border:1px solid var(--fg-border);color:var(--fg-heading);font-size:0.9rem;outline:none;box-sizing:border-box;transition:border-color 0.2s"
                                    onfocus="this.style.borderColor='#FF6400'"
                                    onblur="this.style.borderColor='var(--fg-border)'"
                                />
                            </div>

                        </div>

                        <div class="form-row">

                            {{-- Service --}}
                            <div>
                                <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--fg-text);margin-bottom:0.4rem">Service Needed <span style="color:#FF6400">*</span></label>
                                <select
                                    name="service"
                                    style="width:100%;padding:0.7rem 1rem;border-radius:8px;background:var(--fg-body);border:1px solid {{ $errors->has('service') ? '#EF4444' : 'var(--fg-border)' }};color:var(--fg-heading);font-size:0.9rem;outline:none;box-sizing:border-box;cursor:pointer"
                                >
                                    <option value="" disabled {{ old('service') ? '' : 'selected' }}>Select a service…</option>
                                    @foreach(['Web Development','Mobile Apps','Digital Marketing','ERP & CMS','AI Applications','Software Development'] as $svc)
                                        <option value="{{ $svc }}" {{ old('service') === $svc ? 'selected' : '' }}>{{ $svc }}</option>
                                    @endforeach
                                </select>
                                @error('service')
                                    <p style="color:#EF4444;font-size:0.78rem;margin-top:0.3rem">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Budget --}}
                            <div>
                                <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--fg-text);margin-bottom:0.4rem">Project Budget <span style="color:#FF6400">*</span></label>
                                <select
                                    name="budget"
                                    style="width:100%;padding:0.7rem 1rem;border-radius:8px;background:var(--fg-body);border:1px solid {{ $errors->has('budget') ? '#EF4444' : 'var(--fg-border)' }};color:var(--fg-heading);font-size:0.9rem;outline:none;box-sizing:border-box;cursor:pointer"
                                >
                                    <option value="" disabled {{ old('budget') ? '' : 'selected' }}>Select a range…</option>
                                    @foreach(['Under $500','$500 – $2,000','$2,000 – $5,000','$5,000+'] as $budget)
                                        <option value="{{ $budget }}" {{ old('budget') === $budget ? 'selected' : '' }}>{{ $budget }}</option>
                                    @endforeach
                                </select>
                                @error('budget')
                                    <p style="color:#EF4444;font-size:0.78rem;margin-top:0.3rem">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- Message --}}
                        <div style="margin-bottom:1.75rem">
                            <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--fg-text);margin-bottom:0.4rem">Your Message <span style="color:#FF6400">*</span></label>
                            <textarea
                                name="message"
                                rows="5"
                                placeholder="Tell us about your project, goals, timeline or anything else that's relevant…"
                                style="width:100%;padding:0.7rem 1rem;border-radius:8px;background:var(--fg-body);border:1px solid {{ $errors->has('message') ? '#EF4444' : 'var(--fg-border)' }};color:var(--fg-heading);font-size:0.9rem;outline:none;box-sizing:border-box;resize:vertical;font-family:inherit;transition:border-color 0.2s"
                                onfocus="this.style.borderColor='#FF6400'"
                                onblur="this.style.borderColor='{{ $errors->has('message') ? '#EF4444' : 'var(--fg-border)' }}'"
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <p style="color:#EF4444;font-size:0.78rem;margin-top:0.3rem">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn-primary" style="width:100%;justify-content:center;font-size:1rem;padding:0.85rem 1.5rem">
                            Send Message
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:18px;height:18px;margin-left:0.5rem"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" /></svg>
                        </button>

                        <p style="text-align:center;font-size:0.8rem;color:var(--fg-text-muted);margin-top:1rem">
                            We respect your privacy. Your information will never be shared with third parties.
                        </p>

                    </form>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         FAQ TEASER
    ═══════════════════════════════════════════════ --}}
    <section class="section" style="background:var(--fg-surface)">
        <div class="container">

            <div class="sh" data-gsap-fade>
                <p class="sh__eye">Quick Answers</p>
                <h2 class="sh__title">Common Questions</h2>
                <p class="sh__sub">A few things people usually ask before reaching out.</p>
            </div>

            <div style="max-width:780px;margin:3rem auto 0" data-gsap-stagger>

                @php
                    $faqs = [
                        ['q' => 'How quickly can you start on my project?', 'a' => 'For most projects we can begin within 5–10 business days of signing a contract and receiving the initial deposit. Rush starts can often be arranged — just mention your deadline in your message.'],
                        ['q' => 'Do you work with clients outside Pakistan?', 'a' => 'Absolutely. We currently work with clients in the UK, UAE, Canada and the US. All project communication is in English and we use tools like Notion, Linear and Slack to keep remote teams aligned.'],
                        ['q' => 'What information do you need to give me a quote?', 'a' => 'A rough description of what you need, your target launch date and a budget range is enough to get started. We\'ll ask follow-up questions on a free call to refine the estimate before anything is committed.'],
                    ];
                @endphp

                @foreach($faqs as $index => $faq)
                    <div class="faq-item" data-open="false">
                        <button class="faq-item__btn" type="button">
                            <span>{{ $faq['q'] }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;flex-shrink:0;transition:transform 0.3s"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                        </button>
                        <div class="faq-item__body">
                            <p>{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach

                <div style="text-align:center;margin-top:2rem">
                    <a href="{{ route('faqs') }}" class="btn-outline">View All FAQs</a>
                </div>

            </div>
        </div>
    </section>

</x-layouts.frontend>
