import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import VanillaTilt from 'vanilla-tilt';
import Alpine from 'alpinejs';

gsap.registerPlugin(ScrollTrigger);

window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
window.VanillaTilt = VanillaTilt;
window.Alpine = Alpine;

// ─── Alpine Store ─────────────────────────────────────────────────────────────
Alpine.store('nav', { scrolled: false });

// ─── Init ─────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {

    Alpine.start();

    // Nav scroll detection
    const updateNav = () => { Alpine.store('nav').scrolled = window.scrollY > 60; };
    window.addEventListener('scroll', updateNav, { passive: true });
    updateNav();

    // ── Custom cursor (desktop only) ──────────────────────────────────────
    const cursor = document.querySelector('.custom-cursor');
    if (cursor && !window.matchMedia('(hover: none)').matches) {
        let cx = 0, cy = 0;
        document.addEventListener('mousemove', e => {
            cx = e.clientX; cy = e.clientY;
            gsap.to(cursor, { x: cx, y: cy, duration: 0.08, ease: 'none' });
        });
        document.querySelectorAll('a, button, [data-cursor-hover]').forEach(el => {
            el.addEventListener('mouseenter', () => cursor.classList.add('hovering'));
            el.addEventListener('mouseleave', () => cursor.classList.remove('hovering'));
        });
    }

    // ── Hero V2 entrance (light homepage) ────────────────────────────────
    const heroV2 = document.querySelector('.hero-v2');
    if (heroV2) {
        const tl = gsap.timeline({ delay: 0.15 });

        tl.from('.hero-v2__badge',   { y: 20, opacity: 0, duration: 0.6,  ease: 'power3.out' });
        tl.from('.hero-v2__title',   { y: 36, opacity: 0, duration: 0.75, ease: 'power3.out' }, '-=0.3');
        tl.from('.hero-v2__sub',     { y: 22, opacity: 0, duration: 0.65, ease: 'power3.out' }, '-=0.45');
        tl.from('.hero-v2__actions', { y: 18, opacity: 0, duration: 0.6,  ease: 'power3.out' }, '-=0.4');
        tl.from('.hero-v2__trust',   { y: 14, opacity: 0, duration: 0.5,  ease: 'power3.out' }, '-=0.35');

        // Pipeline card entrance
        tl.from('.dev-pipeline', {
            x: 50, opacity: 0, duration: 0.8, ease: 'power3.out',
        }, '-=0.4');

        tl.from(['.hero-v2__stat--1', '.hero-v2__stat--2'], {
            scale: 0.75, opacity: 0, duration: 0.5, ease: 'back.out(1.7)', stagger: 0.15,
        }, '-=0.3');

        // ── Pipeline cycling animation ────────────────────────────────
        const pipeline = document.getElementById('devPipeline');
        if (pipeline) {
            const rows       = pipeline.querySelectorAll('.dp-row');
            const connectors = pipeline.querySelectorAll('.dp-connector');
            const lastRow    = rows[rows.length - 1];
            const lastStatus = lastRow ? lastRow.querySelector('.dp-row__status') : null;

            function runCycle() {
                // Reset: hide all rows & connectors
                rows.forEach(r => {
                    r.style.opacity = '0';
                    r.style.transform = 'translateX(-8px)';
                    r.classList.remove('dp-row--active');
                    if (r !== lastRow) {
                        r.classList.add('dp-row--done');
                    }
                });
                connectors.forEach(c => { c.style.opacity = '0'; c.style.transform = 'scaleY(0)'; });

                // Restore last row to active/spinner state
                if (lastRow) {
                    lastRow.classList.remove('dp-row--done');
                    lastRow.classList.add('dp-row--active');
                }
                if (lastStatus) {
                    lastStatus.innerHTML = '<span class="dp-row__spinner" style="border-top-color:#FF6400"></span>';
                }

                // Animate each row in sequentially
                rows.forEach((row, i) => {
                    const delay = 600 + i * 500;
                    setTimeout(() => {
                        row.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                        row.style.opacity = '1';
                        row.style.transform = 'translateX(0)';
                        if (connectors[i]) {
                            connectors[i].style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                            connectors[i].style.opacity = '1';
                            connectors[i].style.transform = 'scaleY(1)';
                            connectors[i].style.transformOrigin = 'top';
                        }
                    }, delay);
                });

                // Complete the deployment stage after all rows appear
                setTimeout(() => {
                    if (lastRow && lastStatus) {
                        lastRow.classList.remove('dp-row--active');
                        lastRow.classList.add('dp-row--done');
                        lastStatus.innerHTML = '<i class="ri-checkbox-circle-fill dp-row__check"></i>';
                    }
                }, 600 + rows.length * 500 + 1800);

                // Schedule next cycle
                setTimeout(runCycle, 600 + rows.length * 500 + 4000);
            }

            // Start first cycle after initial GSAP entrance
            setTimeout(runCycle, 2800);
        }
    }

    // ── Legacy dark hero entrance ─────────────────────────────────────────
    const hero = document.querySelector('.hero');
    if (hero) {
        const tl = gsap.timeline({ delay: 0.1 });
        tl.from('.hero__badge',   { y: 24, opacity: 0, duration: 0.7, ease: 'power3.out' });
        tl.from('.hero__title',   { y: 36, opacity: 0, duration: 0.8, ease: 'power3.out' }, '-=0.35');
        tl.from('.hero__sub',     { y: 20, opacity: 0, duration: 0.7, ease: 'power3.out' }, '-=0.4');
        tl.from('.hero__actions', { y: 20, opacity: 0, duration: 0.6, ease: 'power3.out' }, '-=0.45');
        tl.from('.hero__proof',   { y: 16, opacity: 0, duration: 0.5, ease: 'power3.out' }, '-=0.4');
        tl.from('.hero__scroll',  { opacity: 0, duration: 0.6, ease: 'power2.out' }, '-=0.2');

        ScrollTrigger.create({
            trigger: hero,
            start: 'top top',
            end: 'bottom top',
            scrub: true,
            onUpdate: (self) => {
                const p = self.progress;
                gsap.set('.hero__orb--1', { y: p * -80 });
                gsap.set('.hero__orb--2', { y: p * 60 });
            },
        });
    }

    // ── GSAP scroll-fade [data-gsap-fade] ────────────────────────────────
    gsap.utils.toArray('[data-gsap-fade]').forEach(el => {
        gsap.from(el, {
            y: 32,
            opacity: 0,
            duration: 0.85,
            ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 88%', once: true },
        });
    });

    // ── Staggered children [data-gsap-stagger] ───────────────────────────
    gsap.utils.toArray('[data-gsap-stagger]').forEach(parent => {
        gsap.from(Array.from(parent.children), {
            y: 40,
            opacity: 0,
            duration: 0.7,
            ease: 'power3.out',
            stagger: 0.09,
            scrollTrigger: { trigger: parent, start: 'top 84%', once: true },
        });
    });

    // ── Stats strip parallax text ─────────────────────────────────────────
    gsap.utils.toArray('.stat-item').forEach((el, i) => {
        gsap.from(el, {
            y: 30,
            opacity: 0,
            duration: 0.6,
            ease: 'power3.out',
            delay: i * 0.1,
            scrollTrigger: { trigger: el, start: 'top 90%', once: true },
        });
    });

    // ── Counter animation ─────────────────────────────────────────────────
    const counters = document.querySelectorAll('[data-count]');
    if (counters.length) {
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) { return; }
                observer.unobserve(entry.target);
                const el = entry.target;
                const target = parseInt(el.dataset.count, 10);
                const suffix = el.dataset.suffix ?? '';
                const prefix = el.dataset.prefix ?? '';
                const duration = 1800;
                const start = performance.now();

                const step = now => {
                    const progress = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    el.textContent = prefix + Math.floor(eased * target) + suffix;
                    if (progress < 1) { requestAnimationFrame(step); }
                };
                requestAnimationFrame(step);
            });
        }, { threshold: 0.3 });

        counters.forEach(el => observer.observe(el));
    }

    // ── VanillaTilt ───────────────────────────────────────────────────────
    const tiltEls = document.querySelectorAll('[data-tilt]');
    if (tiltEls.length && !window.matchMedia('(hover: none)').matches) {
        VanillaTilt.init(tiltEls, { max: 6, speed: 400, glare: true, 'max-glare': 0.07 });
    }

    // ── Marquee pause on hidden tab ───────────────────────────────────────
    document.addEventListener('visibilitychange', () => {
        document.querySelectorAll('.marquee-track').forEach(el => {
            el.style.animationPlayState = document.hidden ? 'paused' : 'running';
        });
    });

    // ── FAQ accordion ─────────────────────────────────────────────────────
    document.querySelectorAll('.faq-item__body').forEach(body => {
        body.style.maxHeight = '0';
        body.style.overflow = 'hidden';
        body.style.transition = 'max-height 0.38s cubic-bezier(0.4,0,0.2,1)';
    });

    document.querySelectorAll('.faq-item__btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const item = btn.closest('.faq-item');
            const body = item.querySelector('.faq-item__body');
            const isOpen = item.dataset.open === 'true';

            document.querySelectorAll('.faq-item').forEach(other => {
                if (other !== item) {
                    other.dataset.open = 'false';
                    other.querySelector('.faq-item__body').style.maxHeight = '0';
                }
            });

            item.dataset.open = isOpen ? 'false' : 'true';
            body.style.maxHeight = isOpen ? '0' : body.scrollHeight + 'px';
        });
    });

    // ── Portfolio filter tabs ─────────────────────────────────────────────
    const tabs = document.querySelectorAll('.filter-tab');
    const items = document.querySelectorAll('.portfolio-card');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            const filter = tab.dataset.filter;

            items.forEach(card => {
                const show = filter === 'all' || card.dataset.category === filter;
                gsap.to(card, {
                    opacity: show ? 1 : 0.2,
                    scale: show ? 1 : 0.95,
                    duration: 0.28,
                    ease: 'power2.out',
                    pointerEvents: show ? 'all' : 'none',
                });
            });
        });
    });

    // ── Smooth scroll anchors ─────────────────────────────────────────────
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ── Service card icon hover glow ──────────────────────────────────────
    document.querySelectorAll('.service-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            gsap.to(card.querySelector('.service-card__icon'), {
                boxShadow: '0 0 20px rgba(255,100,0,0.25)',
                duration: 0.25,
            });
        });
        card.addEventListener('mouseleave', () => {
            gsap.to(card.querySelector('.service-card__icon'), {
                boxShadow: '0 0 0px rgba(255,100,0,0)',
                duration: 0.25,
            });
        });
    });

    // ── Scroll-reveal section dividers ────────────────────────────────────
    gsap.utils.toArray('.section, .audit-cta, .cta-banner, .stats-strip').forEach(el => {
        ScrollTrigger.create({
            trigger: el,
            start: 'top 92%',
            once: true,
            onEnter: () => el.classList.add('section--visible'),
        });
    });
});
