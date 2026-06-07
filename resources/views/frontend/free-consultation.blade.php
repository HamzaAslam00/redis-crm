<x-layouts.frontend title="Free Consultation — Redis Solution">

    <section class="photo-hero">
        <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=1600&q=80&auto=format&fit=crop" alt="Free consultation" class="photo-hero__img">
        <div class="photo-hero__overlay"></div>
        <div class="container photo-hero__content" style="text-align:center">
            <p class="photo-hero__eye">Completely Free</p>
            <h1 class="photo-hero__title" style="text-align:center">Book Your <span>Free Consultation</span></h1>
            <p class="photo-hero__sub" style="margin:0 auto">Tell us about your project and we'll map out the best path forward — no commitment, no pressure.</p>
        </div>
    </section>

    <section class="section">
        <div class="container" style="max-width:680px">

            <div class="sh" data-gsap-fade>
                <span class="sh__eye">Schedule a Call</span>
                <h2 class="sh__title">Let's Talk About Your Project</h2>
                <p class="sh__sub">Fill in the form below and we'll get back to you within 24 hours to schedule a free 30-minute strategy call.</p>
            </div>

            <div class="contact-form-card" data-gsap-fade style="margin-top:2.5rem">

                @if(session('success'))
                <div style="padding:1rem 1.5rem;border-radius:10px;background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);color:#10B981;margin-bottom:1.5rem;display:flex;align-items:center;gap:0.75rem">
                    <i class="ri-checkbox-circle-line" style="font-size:1.25rem"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" novalidate>
                    @csrf
                    <input type="hidden" name="service" value="Free Consultation">

                    <div class="form-row">
                        <div>
                            <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--fg-text);margin-bottom:0.4rem">Full Name <span style="color:#FF6400">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Your full name" required>
                            @error('name')<p style="color:#EF4444;font-size:0.78rem;margin-top:0.3rem">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--fg-text);margin-bottom:0.4rem">Email Address <span style="color:#FF6400">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="you@company.com" required>
                            @error('email')<p style="color:#EF4444;font-size:0.78rem;margin-top:0.3rem">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div>
                            <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--fg-text);margin-bottom:0.4rem">Phone Number <span style="color:#FF6400">*</span></label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+92 300 000 0000" required>
                            @error('phone')<p style="color:#EF4444;font-size:0.78rem;margin-top:0.3rem">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--fg-text);margin-bottom:0.4rem">Budget Range</label>
                            <select name="budget">
                                <option value="" disabled {{ old('budget') ? '' : 'selected' }}>Select a range…</option>
                                @foreach(['Under $500','$500 – $2,000','$2,000 – $5,000','$5,000+'] as $b)
                                <option value="{{ $b }}" {{ old('budget')===$b ? 'selected' : '' }}>{{ $b }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom:1.75rem">
                        <label style="display:block;font-size:0.82rem;font-weight:600;color:var(--fg-text);margin-bottom:0.4rem">Tell Us About Your Project <span style="color:#FF6400">*</span></label>
                        <textarea name="message" rows="5" placeholder="Describe your project, goals, timeline or anything relevant…" required>{{ old('message') }}</textarea>
                        @error('message')<p style="color:#EF4444;font-size:0.78rem;margin-top:0.3rem">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn-primary" style="width:100%;justify-content:center;font-size:1rem;padding:0.875rem 1.5rem">
                        <i class="ri-calendar-check-line"></i> Request Free Consultation
                    </button>

                    <p style="text-align:center;font-size:0.8rem;color:var(--fg-text-muted);margin-top:1rem">
                        <i class="ri-shield-check-line"></i> We respect your privacy. No spam, ever.
                    </p>
                </form>
            </div>

        </div>
    </section>

    {{-- What to expect --}}
    <section class="section section-alt">
        <div class="container">
            <div class="sh" data-gsap-fade>
                <span class="sh__eye">What Happens Next</span>
                <h2 class="sh__title">Simple 3-Step Process</h2>
            </div>
            <div class="rg-3-gap2" style="margin-top:3rem" data-gsap-stagger>
                @foreach([
                    ['ri-message-3-line', '#FF6400', '1. You Submit', 'Fill in the form above with your project details. Takes less than 2 minutes.'],
                    ['ri-phone-line',     '#6366F1', '2. We Call Back', 'Our team reviews your request and reaches out within 24 hours to schedule your call.'],
                    ['ri-lightbulb-line', '#10B981', '3. Free Strategy', 'In a 30-minute call we map out the best approach for your project — completely free.'],
                ] as [$icon, $color, $title, $desc])
                <div class="bento-card" style="padding:2rem;text-align:center">
                    <div style="display:inline-flex;width:56px;height:56px;border-radius:14px;background:{{ $color }}15;border:1px solid {{ $color }}30;align-items:center;justify-content:center;margin-bottom:1.25rem">
                        <i class="{{ $icon }}" style="color:{{ $color }};font-size:1.5rem"></i>
                    </div>
                    <h3 style="font-family:'Syne',sans-serif;font-weight:700;color:var(--fg-heading);margin-bottom:0.5rem;font-size:1rem">{{ $title }}</h3>
                    <p style="color:var(--fg-text-muted);font-size:0.88rem;line-height:1.7">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

</x-layouts.frontend>
