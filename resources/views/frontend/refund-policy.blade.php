<x-layouts.frontend title="Refund Policy — Redis Solution">

    @php $company = setting('company_name', 'Redis Solution Pvt. Ltd.'); $email = setting('company_email', 'info@redissolution.com'); @endphp

    {{-- Hero --}}
    <section class="photo-hero">
        <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=1200&q=72&auto=format&fit=crop" alt="Refund Policy" fetchpriority="high" class="photo-hero__img">
        <div class="photo-hero__overlay"></div>
        <div class="container photo-hero__content" style="text-align:center">
            <p class="photo-hero__eye">Fair & Transparent</p>
            <h1 class="photo-hero__title" style="text-align:center">Refund <span>Policy</span></h1>
            <p class="photo-hero__sub" style="margin:0 auto">Last updated: {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        </div>
    </section>

    {{-- Content --}}
    <div style="max-width:780px;margin:0 auto;padding:3.5rem 1.5rem 5rem">

        <p style="color:var(--fg-text-muted);line-height:1.8;margin-bottom:2.5rem">
            At {{ $company }}, we are committed to delivering high-quality digital solutions.
            This Refund Policy outlines the conditions under which refunds are considered for our services.
            Please read this policy carefully before engaging our services.
        </p>

        @php
        $sections = [
            [
                'icon' => 'ri-briefcase-line',
                'title' => '1. Nature of Our Services',
                'body' => '
                    <p>We provide custom digital services including web development, mobile app development, ERP/CMS systems, digital marketing, AI applications, and software development. Because our work is custom-built to each client\'s specific requirements, refunds are handled on a case-by-case basis.</p>
                ',
            ],
            [
                'icon' => 'ri-check-double-line',
                'title' => '2. When Refunds May Be Considered',
                'body' => '
                    <p>A full or partial refund may be considered under the following conditions:</p>
                    <ul>
                        <li><strong>Project not started</strong> — If you cancel your project before any work has commenced, you are eligible for a full refund of any advance payment made.</li>
                        <li><strong>Significant delay on our end</strong> — If we fail to deliver within the agreed timeline without prior notice or valid reason, a partial refund proportional to the incomplete work may be issued.</li>
                        <li><strong>Failure to deliver agreed scope</strong> — If deliverables clearly do not match the agreed project scope and the issue cannot be resolved through revisions, a partial refund may be considered after review.</li>
                    </ul>
                ',
            ],
            [
                'icon' => 'ri-close-circle-line',
                'title' => '3. Non-Refundable Situations',
                'body' => '
                    <p>Refunds will <strong>not</strong> be issued in the following cases:</p>
                    <ul>
                        <li>Work has already been completed and delivered as per the agreed scope.</li>
                        <li>The client changes their mind or requirements after work has begun.</li>
                        <li>Delays caused by the client (e.g., late content delivery, slow feedback, unresponsiveness).</li>
                        <li>Milestone payments for completed and approved phases of a project.</li>
                        <li>Third-party costs (domain registration, hosting, software licences, API subscriptions) paid on the client\'s behalf.</li>
                        <li>Digital marketing services where campaigns have already been launched.</li>
                        <li>Maintenance or support plans once the billing period has started.</li>
                    </ul>
                ',
            ],
            [
                'icon' => 'ri-git-branch-line',
                'title' => '4. Milestone-Based Projects',
                'body' => '
                    <p>For projects divided into milestones, each milestone payment covers that specific phase of work. Once a milestone has been delivered and approved by the client, that payment is considered final and non-refundable. Refund eligibility only applies to future milestones that have not yet commenced.</p>
                ',
            ],
            [
                'icon' => 'ri-refresh-line',
                'title' => '5. Revision Policy',
                'body' => '
                    <p>Before requesting a refund, clients are encouraged to utilise the agreed revision rounds included in their project. Most concerns can be resolved through revisions. Refund requests submitted without first requesting revisions may not be considered.</p>
                ',
            ],
            [
                'icon' => 'ri-file-list-3-line',
                'title' => '6. How to Request a Refund',
                'body' => '
                    <p>To initiate a refund request, please:</p>
                    <ul>
                        <li>Email us at <strong>' . setting('company_email', 'info@redissolution.com') . '</strong> with subject line: <em>Refund Request — [Your Project Name]</em></li>
                        <li>Include your name, project details, payment reference, and reason for the request.</li>
                        <li>We will acknowledge your request within <strong>2 business days</strong> and provide a decision within <strong>7 business days</strong>.</li>
                    </ul>
                ',
            ],
            [
                'icon' => 'ri-bank-card-line',
                'title' => '7. Refund Processing',
                'body' => '
                    <p>Approved refunds will be processed to the original payment method within <strong>7–14 business days</strong>, depending on your bank or payment provider. We are not responsible for delays caused by third-party financial institutions.</p>
                ',
            ],
            [
                'icon' => 'ri-edit-line',
                'title' => '8. Changes to This Policy',
                'body' => '
                    <p>We reserve the right to update this Refund Policy at any time. Changes will be reflected on this page with a revised date. Continued use of our services after any changes constitutes acceptance of the updated policy.</p>
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
            <h3 style="font-size:1rem;font-weight:700;margin-bottom:0.5rem">Questions?</h3>
            <p style="color:var(--fg-text-muted);font-size:0.9rem;line-height:1.75">
                If you have any questions about our Refund Policy, reach out before starting a project — we believe in full transparency.<br>
                <a href="mailto:{{ $email }}" style="color:#FF6400;font-weight:600">{{ $email }}</a>
            </p>
        </div>

        <div style="margin-top:2.5rem">
            <a href="{{ route('home') }}" style="color:#FF6400;font-size:0.88rem;display:inline-flex;align-items:center;gap:0.4rem">
                <i class="ri-arrow-left-line"></i> Back to Home
            </a>
        </div>

    </div>

</x-layouts.frontend>
