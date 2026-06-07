<x-layouts.frontend title="FAQs — Redis Solution">

    {{-- ═══════════════════════════════════════════════
         PAGE HERO
    ═══════════════════════════════════════════════ --}}
    <section class="photo-hero">
        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1600&q=80&auto=format&fit=crop" alt="FAQs" class="photo-hero__img">
        <div class="photo-hero__overlay"></div>
        <div class="container photo-hero__content" style="text-align:center">
            <p class="photo-hero__eye">Help Centre</p>
            <h1 class="photo-hero__title" style="text-align:center">Frequently Asked<br><span>Questions</span></h1>
            <p class="photo-hero__sub" style="margin:0 auto">Everything you need to know before working with us. Can't find your answer? Just reach out.</p>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         FAQ CONTENT
    ═══════════════════════════════════════════════ --}}
    <section class="section">
        <div class="container">

            @php
                $categories = [
                    [
                        'title' => 'Working with Us',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />',
                        'faqs'  => [
                            [
                                'q' => 'How long does a typical project take?',
                                'a' => 'Project timelines vary based on scope and complexity. A simple landing page can be delivered in 1–2 weeks. A standard business website takes 3–5 weeks. Complex web applications or mobile apps typically run 6–16 weeks. We always share a detailed timeline with milestones before any work begins so you know exactly what to expect.',
                            ],
                            [
                                'q' => 'What information do you need to start?',
                                'a' => 'To provide an accurate quote we need a rough description of what you want built, your target launch date and an approximate budget range. Any existing designs, brand guidelines or references you have are helpful but not required at this stage. We\'ll schedule a discovery call to fill in the gaps before anything is formalised.',
                            ],
                            [
                                'q' => 'Do you work with international clients?',
                                'a' => 'Yes — we regularly work with clients in the UK, UAE, USA, Canada and Australia. All our project communication is in English and we use industry-standard collaboration tools (Notion, Linear, Slack, Figma) to keep remote teams fully aligned. Time zone differences are manageable and we\'re flexible with overlap hours.',
                            ],
                            [
                                'q' => 'How do you handle project communication?',
                                'a' => 'Every project has a dedicated project manager who is your single point of contact. We hold weekly status calls (or bi-weekly for smaller projects), share updates via Slack or WhatsApp and use Linear or Jira for task tracking. You have full visibility into progress at all times — no chasing required.',
                            ],
                            [
                                'q' => 'Do you sign NDAs?',
                                'a' => 'Absolutely. We sign non-disclosure agreements before any sensitive business information is shared. Our standard NDA is mutual, covers all information exchanged during both pre-sales and active project phases and is drafted to be fair to both parties. We can also review and sign your company\'s NDA if you prefer.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Pricing & Payment',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />',
                        'faqs'  => [
                            [
                                'q' => 'How much does a website cost?',
                                'a' => 'Pricing depends heavily on scope. A simple brochure website typically starts at around $500–$1,500. A full e-commerce store or custom web application can range from $2,000 to $15,000+. We don\'t believe in one-size-fits-all pricing — we\'ll give you a detailed, itemised quote after understanding your specific requirements. There\'s no cost for the initial consultation or quote.',
                            ],
                            [
                                'q' => 'What payment methods do you accept?',
                                'a' => 'We accept bank transfers (local and international SWIFT/IBAN), Payoneer, Wise and cryptocurrency (USDT/BTC). For Pakistani clients we also accept Easypaisa, JazzCash and direct bank transfer. Invoices are issued in USD, GBP or PKR depending on your preference.',
                            ],
                            [
                                'q' => 'Do you offer payment plans?',
                                'a' => 'Yes. Our standard payment structure is 40% upfront to begin work, 30% at the mid-project milestone and the final 30% on delivery. For larger projects ($5,000+) we can arrange custom milestone-based payment schedules. We don\'t require full payment before starting — we understand that building trust is a two-way process.',
                            ],
                            [
                                'q' => 'Are there any hidden costs?',
                                'a' => 'No. Our quotes are fully itemised and include all development, design and project management costs. Any third-party costs (domain, hosting, premium fonts, paid APIs or stock images) are clearly listed separately before you commit. If scope changes during the project we discuss it openly and agree on any additional cost before proceeding.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Technical',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />',
                        'faqs'  => [
                            [
                                'q' => 'Who owns the code after project completion?',
                                'a' => 'You do — 100%. On final payment we transfer full ownership of all source code, design assets and associated intellectual property to you. We\'ll push the complete codebase to a Git repository of your choice and hand over all credentials. We retain no rights over your software.',
                            ],
                            [
                                'q' => 'Do you offer hosting?',
                                'a' => 'We can set up and configure hosting on your preferred provider (AWS, DigitalOcean, Laravel Cloud, Hostinger, etc.) as part of the project, or we can manage hosting and server maintenance on an ongoing monthly basis. We recommend you own the hosting account directly so you\'re never dependent on us for access.',
                            ],
                            [
                                'q' => 'Can you maintain and update our existing website?',
                                'a' => 'Yes. We offer monthly maintenance retainers that include security updates, plugin/dependency upgrades, uptime monitoring, regular backups and a set number of content or minor feature change hours per month. We\'re also happy to perform one-off audits, performance improvements or security hardening on existing sites we didn\'t build.',
                            ],
                            [
                                'q' => 'What happens after launch?',
                                'a' => 'All projects include a 30-day post-launch support period during which we fix any bugs that arise at no additional cost. After that you can choose a maintenance retainer for ongoing support or engage us ad-hoc for future improvements. We don\'t disappear after handover — most of our clients come back to us for additional projects.',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Services',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />',
                        'faqs'  => [
                            [
                                'q' => 'Do you do design only, without development?',
                                'a' => 'Yes. We offer standalone UI/UX design services including wireframing, high-fidelity mockups in Figma and clickable prototypes. Many clients come to us for design work and then hand the Figma files to their in-house developers. We can also review and improve existing designs.',
                            ],
                            [
                                'q' => 'Can you help with an existing project someone else started?',
                                'a' => 'Absolutely. We\'re comfortable taking over partially-built projects. We\'ll start with a thorough code review to understand what exists, identify any technical debt and propose a clear path forward. We don\'t charge for the initial code review on projects above $1,000.',
                            ],
                            [
                                'q' => 'Do you offer SEO with every website?',
                                'a' => 'Every website we build is technically SEO-ready out of the box — that means semantic HTML, fast load times, proper meta tags, schema markup and a clean URL structure. Full ongoing SEO (keyword research, link building, content strategy) is a separate service. We\'ll always recommend whether you need it based on your goals.',
                            ],
                        ],
                    ],
                ];
            @endphp

            <div class="rg-2-gap3" data-gsap-stagger>

                @foreach($categories as $catIndex => $category)
                    <div>
                        {{-- Category header --}}
                        <div style="display:flex;align-items:center;gap:0.85rem;margin-bottom:1.5rem">
                            <div style="display:flex;align-items:center;justify-content:center;width:42px;height:42px;border-radius:10px;background:rgba(255,100,0,0.1);border:1px solid rgba(255,100,0,0.2);flex-shrink:0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FF6400" style="width:20px;height:20px">{!! $category['icon'] !!}</svg>
                            </div>
                            <h2 style="font-family:'Syne',sans-serif;font-size:1.15rem;font-weight:700;color:var(--fg-heading)">{{ $category['title'] }}</h2>
                        </div>

                        {{-- FAQ items --}}
                        <div style="display:flex;flex-direction:column;gap:0.5rem">
                            @foreach($category['faqs'] as $faqIndex => $faq)
                                <div class="faq-item" data-open="false">
                                    <button class="faq-item__btn" type="button">
                                        <span>{{ $faq['q'] }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:17px;height:17px;flex-shrink:0;transition:transform 0.3s"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                                    </button>
                                    <div class="faq-item__body">
                                        <p>{{ $faq['a'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         BOTTOM CTA
    ═══════════════════════════════════════════════ --}}
    <section class="section" style="background:var(--fg-surface)">
        <div class="container">
            <div style="max-width:600px;margin:0 auto;text-align:center" data-gsap-fade>
                <div style="display:inline-flex;width:64px;height:64px;border-radius:16px;background:rgba(255,100,0,0.1);border:1px solid rgba(255,100,0,0.25);align-items:center;justify-content:center;margin-bottom:1.5rem">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FF6400" style="width:30px;height:30px"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" /></svg>
                </div>
                <h2 style="font-family:'Syne',sans-serif;font-size:1.75rem;font-weight:700;color:var(--fg-heading);margin-bottom:0.75rem">Still Have Questions?</h2>
                <p style="color:var(--fg-text-muted);line-height:1.75;margin-bottom:2rem">
                    Our team is happy to answer anything that isn't covered here. Drop us a message and we'll get back to you within a few hours.
                </p>
                <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
                    <a href="{{ route('contact') }}" class="btn-primary">Contact Us</a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('company_whatsapp', '+923001234567')) }}" target="_blank" rel="noopener" class="btn-outline">
                        Chat on WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>


</x-layouts.frontend>
