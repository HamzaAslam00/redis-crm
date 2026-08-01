<x-layouts.frontend title="Privacy Policy — Redis Solution">

    @php $company = setting('company_name', 'Redis Solution Pvt. Ltd.'); $email = setting('company_email', 'info@redissolution.com'); @endphp

    {{-- Hero --}}
    <section class="photo-hero">
        <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=1200&q=72&auto=format&fit=crop" alt="Privacy Policy" fetchpriority="high" class="photo-hero__img">
        <div class="photo-hero__overlay"></div>
        <div class="container photo-hero__content" style="text-align:center">
            <p class="photo-hero__eye">Your Data, Our Responsibility</p>
            <h1 class="photo-hero__title" style="text-align:center">Privacy <span>Policy</span></h1>
            <p class="photo-hero__sub" style="margin:0 auto">Last updated: {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        </div>
    </section>

    {{-- Content --}}
    <div style="max-width:780px;margin:0 auto;padding:3.5rem 1.5rem 5rem">

        <p style="color:var(--fg-text-muted);line-height:1.8;margin-bottom:2.5rem">
            {{ $company }} ("we", "us", or "our") is committed to protecting your personal information.
            This Privacy Policy explains what data we collect, how we use it, and your rights regarding that data
            when you visit our website or engage our services.
        </p>

        @php
        $sections = [
            [
                'icon' => 'ri-database-2-line',
                'title' => '1. Information We Collect',
                'body' => '
                    <p>We may collect the following types of information:</p>
                    <ul>
                        <li><strong>Contact information</strong> — name, email address, phone number, company name submitted through our contact, consultation, or audit forms.</li>
                        <li><strong>Project details</strong> — descriptions, requirements, or files you share with us during a project inquiry or engagement.</li>
                        <li><strong>Usage data</strong> — IP address, browser type, pages visited, and time spent on our website (collected automatically via analytics tools).</li>
                        <li><strong>SEO audit data</strong> — if you use our Free SEO Audit tool, we record the URL submitted, your IP address, approximate location, and ISP for internal tracking purposes.</li>
                    </ul>
                ',
            ],
            [
                'icon' => 'ri-settings-3-line',
                'title' => '2. How We Use Your Information',
                'body' => '
                    <p>We use the information collected to:</p>
                    <ul>
                        <li>Respond to your inquiries and provide requested services.</li>
                        <li>Send project updates, proposals, and invoices.</li>
                        <li>Improve our website and service quality.</li>
                        <li>Analyse usage patterns for internal reporting.</li>
                        <li>Comply with legal obligations.</li>
                    </ul>
                    <p>We do <strong>not</strong> sell, rent, or trade your personal information to third parties.</p>
                ',
            ],
            [
                'icon' => 'ri-global-line',
                'title' => '3. Cookies',
                'body' => '
                    <p>Our website may use cookies to enhance your browsing experience. Cookies are small text files stored on your device. We use:</p>
                    <ul>
                        <li><strong>Essential cookies</strong> — required for the website to function correctly.</li>
                        <li><strong>Analytics cookies</strong> — to understand how visitors interact with our site (e.g., Google Analytics).</li>
                    </ul>
                    <p>You can disable cookies through your browser settings; however, some parts of the website may not function as intended.</p>
                ',
            ],
            [
                'icon' => 'ri-links-line',
                'title' => '4. Third-Party Services',
                'body' => '
                    <p>We may use trusted third-party tools including:</p>
                    <ul>
                        <li>Google Analytics — for website traffic analysis.</li>
                        <li>Payment gateways — for invoice processing (where applicable).</li>
                        <li>Email service providers — to send transactional emails.</li>
                    </ul>
                    <p>These services have their own privacy policies and we encourage you to review them.</p>
                ',
            ],
            [
                'icon' => 'ri-lock-2-line',
                'title' => '5. Data Security',
                'body' => '
                    <p>We take reasonable technical and organisational measures to protect your data against unauthorised access, loss, or misuse. However, no method of transmission over the internet is 100% secure, and we cannot guarantee absolute security.</p>
                ',
            ],
            [
                'icon' => 'ri-time-line',
                'title' => '6. Data Retention',
                'body' => '
                    <p>We retain your personal data only for as long as necessary to fulfil the purposes outlined in this policy, or as required by law. Project-related data may be retained for up to 3 years for record-keeping purposes.</p>
                ',
            ],
            [
                'icon' => 'ri-user-settings-line',
                'title' => '7. Your Rights',
                'body' => '
                    <p>You have the right to:</p>
                    <ul>
                        <li>Request access to the personal data we hold about you.</li>
                        <li>Request correction of inaccurate data.</li>
                        <li>Request deletion of your data (subject to legal obligations).</li>
                        <li>Withdraw consent at any time where processing is based on consent.</li>
                    </ul>
                    <p>To exercise any of these rights, please contact us at the email below.</p>
                ',
            ],
            [
                'icon' => 'ri-edit-line',
                'title' => '8. Changes to This Policy',
                'body' => '
                    <p>We may update this Privacy Policy from time to time. Changes will be posted on this page with a revised date. Continued use of our website after any changes constitutes acceptance of the updated policy.</p>
                ',
            ],
        ];
        @endphp

        @foreach($sections as $s)
        <div style="margin-bottom:2.5rem">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.9rem">
                <div style="width:36px;height:36px;border-radius:8px;background:rgba(255,100,0,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="{{ $s['icon'] }}" style="color:#FF6400;font-size:1rem"></i>
                </div>
                <h2 style="font-size:1.1rem;font-weight:700;color:var(--fg-heading)">{{ $s['title'] }}</h2>
            </div>
            <div style="padding-left:0.25rem;color:var(--fg-text-muted);line-height:1.85;font-size:0.92rem">
                {!! $s['body'] !!}
            </div>
        </div>
        @endforeach

        {{-- Contact box --}}
        <div style="border:1px solid rgba(255,100,0,0.25);border-radius:12px;padding:1.5rem 1.75rem;background:rgba(255,100,0,0.04);margin-top:1rem">
            <h3 style="font-size:1rem;font-weight:700;margin-bottom:0.5rem">Contact Us</h3>
            <p style="color:var(--fg-text-muted);font-size:0.9rem;line-height:1.75">
                If you have any questions about this Privacy Policy, please contact us at:<br>
                <a href="mailto:{{ $email }}" style="color:#FF6400;font-weight:600">{{ $email }}</a>
            </p>
        </div>

        <style>
            .privacy-content ul { padding-left: 1.25rem; margin: 0.6rem 0 0.9rem; }
            .privacy-content ul li { margin-bottom: 0.4rem; }
            .privacy-content p { margin-bottom: 0.75rem; }
        </style>

        <div style="margin-top:2.5rem">
            <a href="{{ route('home') }}" style="color:#FF6400;font-size:0.88rem;display:inline-flex;align-items:center;gap:0.4rem">
                <i class="ri-arrow-left-line"></i> Back to Home
            </a>
        </div>

    </div>

</x-layouts.frontend>
