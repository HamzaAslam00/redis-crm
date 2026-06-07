<section class="cta-banner-gradient">
    <div class="cta-banner-gradient__noise"></div>
    <div class="container" style="position:relative;z-index:1" data-gsap-fade>

        <div class="cta-banner-gradient__eyebrow">
            <i class="ri-rocket-2-line"></i> Let's Build Something Great
        </div>

        <h2 class="cta-banner-gradient__title">
            Ready to Build<br>Something <span>Amazing?</span>
        </h2>

        <p class="cta-banner-gradient__sub">
            Whether you have a full brief or just an idea on a napkin — let's talk.
            Free consultation, no commitment, no pressure.
        </p>

        <div class="cta-banner-gradient__actions">
            <a href="{{ route('contact') }}" class="cta-banner-gradient__btn cta-banner-gradient__btn--primary">
                Start Your Project
                <i class="ri-arrow-right-line"></i>
            </a>
            <a href="mailto:{{ setting('company_email','info@redissolution.com') }}" class="cta-banner-gradient__btn cta-banner-gradient__btn--ghost">
                <i class="ri-mail-line"></i>
                {{ setting('company_email','info@redissolution.com') }}
            </a>
        </div>

        <div class="cta-banner-gradient__trust">
            <span><i class="ri-shield-check-line"></i> NDA on request</span>
            <span class="cta-banner-gradient__dot"></span>
            <span><i class="ri-lock-line"></i> 100% IP ownership</span>
            <span class="cta-banner-gradient__dot"></span>
            <span><i class="ri-time-line"></i> Response within 24h</span>
        </div>

    </div>
</section>
