<footer class="site-footer">
    <div class="footer-inner">

        {{-- Link grid --}}
        <div class="footer-grid">

            {{-- Brand col: Logo + tagline + contacts --}}
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="footer-brand__logo">
                    <img src="{{ asset('assets/brand/logo-white.png') }}" alt="Redis Solution">
                </a>
                <p class="footer-brand__tagline">Your trusted IT partner in Rawalpindi, Pakistan. We build web, mobile and enterprise solutions that scale.</p>

                <div class="footer-contact-list">
                    @if(setting('company_email'))
                    <a href="mailto:{{ setting('company_email') }}" class="footer-contact-link">
                        <i class="ri-mail-line"></i> {{ setting('company_email') }}
                    </a>
                    @endif
                    @if(setting('company_email2'))
                    <a href="mailto:{{ setting('company_email2') }}" class="footer-contact-link">
                        <i class="ri-mail-line"></i> {{ setting('company_email2') }}
                    </a>
                    @endif
                    @if(setting('company_phone'))
                    <a href="tel:{{ preg_replace('/\s+/', '', setting('company_phone')) }}" class="footer-contact-link">
                        <i class="ri-phone-line"></i> {{ setting('company_phone') }}
                    </a>
                    @endif
                </div>

                {{-- Social icons in brand col --}}
                <div class="footer-socials">
                    @foreach([
                        ['href' => setting('social_facebook'),  'icon' => 'ri-facebook-circle-fill'],
                        ['href' => setting('social_linkedin'),  'icon' => 'ri-linkedin-box-fill'],
                        ['href' => setting('social_twitter'),   'icon' => 'ri-twitter-x-fill'],
                        ['href' => setting('social_instagram'), 'icon' => 'ri-instagram-fill'],
                        ['href' => setting('social_youtube'),   'icon' => 'ri-youtube-fill'],
                    ] as $s)
                    @if($s['href'])
                    <a href="{{ $s['href'] }}" target="_blank" rel="noopener noreferrer" class="footer-social-link">
                        <i class="{{ $s['icon'] }}"></i>
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>

            {{-- Services --}}
            <div class="footer-col">
                <h5>Services</h5>
                <ul>
                    <li><a href="{{ route('services') }}">Web Development</a></li>
                    <li><a href="{{ route('services') }}">Mobile Apps</a></li>
                    <li><a href="{{ route('services') }}">Digital Marketing</a></li>
                    <li><a href="{{ route('services') }}">ERP / CMS Systems</a></li>
                    <li><a href="{{ route('services') }}">AI Applications</a></li>
                    <li><a href="{{ route('services') }}">Software Dev</a></li>
                </ul>
            </div>

            {{-- Company --}}
            <div class="footer-col">
                <h5>Company</h5>
                <ul>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('portfolio') }}">Portfolio</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li><a href="{{ route('free-audit') }}">Free SEO Audit</a></li>
                    <li><a href="{{ route('free-consultation') }}">Free Consultation</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                </ul>
            </div>

            {{-- Legal + Location --}}
            <div class="footer-col">
                <h5>Legal</h5>
                <ul>
                    <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('refund-policy') }}">Refund Policy</a></li>
                    <li><a href="{{ route('faqs') }}">FAQs</a></li>
                </ul>

                <h5 style="margin-top:1.75rem">Location</h5>
                <p style="font-size:0.82rem;color:rgba(255,255,255,0.45);line-height:1.7">
                    <i class="ri-map-pin-line" style="color:#FF6400;margin-right:0.25rem"></i>
                    {{ setting('company_address','2nd Floor, ABC Plaza, 4th Road, Rawalpindi, Pakistan') }}
                </p>
            </div>

        </div>

        {{-- Bottom bar --}}
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} Redis Solution Pvt. Ltd. All rights reserved.</span>
            <div style="display:flex;align-items:center;gap:1rem">
                <span>Built with <span style="color:#FF6400">♥</span> in Pakistan</span>
                <a href="{{ route('login') }}" class="footer-crm-link">CRM</a>
            </div>
        </div>

    </div>
</footer>
