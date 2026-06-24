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

            <div class="rg-2-gap3" data-gsap-stagger>

                @foreach($categories as $category)
                    <div>
                        {{-- Category header --}}
                        <div style="display:flex;align-items:center;gap:0.85rem;margin-bottom:1.5rem">
                            <div style="display:flex;align-items:center;justify-content:center;width:42px;height:42px;border-radius:10px;background:rgba(255,100,0,0.1);border:1px solid rgba(255,100,0,0.2);flex-shrink:0">
                                <i class="{{ $category->icon }}" style="font-size:1.2rem;color:#FF6400"></i>
                            </div>
                            <h2 style="font-family:'Syne',sans-serif;font-size:1.15rem;font-weight:700;color:var(--fg-heading)">{{ $category->name }}</h2>
                        </div>

                        {{-- FAQ items --}}
                        <div style="display:flex;flex-direction:column;gap:0.5rem">
                            @foreach($category->activeFaqs as $faq)
                                <div class="faq-item" data-open="false">
                                    <button class="faq-item__btn" type="button">
                                        <span>{{ $faq->question }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:17px;height:17px;flex-shrink:0;transition:transform 0.3s"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                                    </button>
                                    <div class="faq-item__body">
                                        <p>{{ $faq->answer }}</p>
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
