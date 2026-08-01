<footer class="site-footer">
    <div class="footer-inner">

        {{-- Link grid --}}
        <div class="footer-grid">

            {{-- Brand col: Logo + tagline + contacts --}}
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="footer-brand__logo">
                    <picture>
                        <source srcset="{{ asset('assets/brand/logo-white.webp') }}" type="image/webp">
                        <img src="{{ asset('assets/brand/logo-white-sm.png') }}" alt="Redis Solution" width="97" height="36" loading="lazy">
                    </picture>
                </a>
                <p class="footer-brand__tagline">Your trusted IT partner in Rawalpindi, Pakistan. We build web, mobile and enterprise solutions that scale.</p>

                <div class="footer-contact-list">
                    @if(setting('company_email'))
                    <a href="mailto:{{ setting('company_email') }}" class="footer-contact-link">
                        <i class="ri-mail-line" aria-hidden="true"></i> {{ setting('company_email') }}
                    </a>
                    @endif
                    @if(setting('company_email2'))
                    <a href="mailto:{{ setting('company_email2') }}" class="footer-contact-link">
                        <i class="ri-mail-line" aria-hidden="true"></i> {{ setting('company_email2') }}
                    </a>
                    @endif
                    @if(setting('company_phone'))
                    <a href="tel:{{ preg_replace('/\s+/', '', setting('company_phone')) }}" class="footer-contact-link">
                        <i class="ri-phone-line" aria-hidden="true"></i> {{ setting('company_phone') }}
                    </a>
                    @endif
                </div>

                {{-- Social icons in brand col --}}
                <div class="footer-socials">
                    @foreach([
                        ['href' => setting('social_facebook'),  'icon' => 'ri-facebook-circle-fill', 'label' => 'Facebook'],
                        ['href' => setting('social_linkedin'),  'icon' => 'ri-linkedin-box-fill',    'label' => 'LinkedIn'],
                        ['href' => setting('social_twitter'),   'icon' => 'ri-twitter-x-fill',       'label' => 'X (Twitter)'],
                        ['href' => setting('social_instagram'), 'icon' => 'ri-instagram-fill',       'label' => 'Instagram'],
                        ['href' => setting('social_youtube'),   'icon' => 'ri-youtube-fill',         'label' => 'YouTube'],
                    ] as $s)
                    @if($s['href'])
                    <a href="{{ $s['href'] }}" target="_blank" rel="noopener noreferrer" class="footer-social-link" aria-label="Follow Redis Solution on {{ $s['label'] }}">
                        <i class="{{ $s['icon'] }}" aria-hidden="true"></i>
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>

            {{-- Services --}}
            <div class="footer-col">
                <h3>Services</h3>
                <ul>
                    <li><a href="{{ route('services') }}#web-development">Web Development</a></li>
                    <li><a href="{{ route('services') }}#mobile-apps">Mobile Apps</a></li>
                    <li><a href="{{ route('services') }}#digital-marketing">Digital Marketing</a></li>
                    <li><a href="{{ route('services') }}#erp-cms">ERP / CMS Systems</a></li>
                    <li><a href="{{ route('services') }}#ai-applications">AI Applications</a></li>
                    <li><a href="{{ route('services') }}#software-development">Software Dev</a></li>
                </ul>
            </div>

            {{-- Company --}}
            <div class="footer-col">
                <h3>Company</h3>
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
                <h3>Legal</h3>
                <ul>
                    <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('refund-policy') }}">Refund Policy</a></li>
                    <li><a href="{{ route('faqs') }}">FAQs</a></li>
                </ul>

                <h3 class="footer-location-heading">Location</h3>
                <address class="footer-address">
                    <i class="ri-map-pin-line footer-address__icon" aria-hidden="true"></i>
                    {{ setting('company_address','2nd Floor, ABC Plaza, 4th Road, Rawalpindi, Pakistan') }}
                </address>
            </div>

        </div>

        {{-- Bottom bar --}}
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} Redis Solution Pvt. Ltd. All rights reserved.</span>
            <div class="footer-bottom__meta">
                <span>Built with <span class="footer-heart">♥</span> in Pakistan</span>
                <a href="{{ route('login') }}" class="footer-crm-link">CRM</a>
            </div>
        </div>

    </div>
</footer>
