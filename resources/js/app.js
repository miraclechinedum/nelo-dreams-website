import './bootstrap';

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import collapse from '@alpinejs/collapse';

Alpine.plugin(intersect);
Alpine.plugin(collapse);

/**
 * Animated counter — eases a number from 0 → target the first time it
 * scrolls into view. Respects prefers-reduced-motion.
 */
Alpine.data('counter', (target, { duration = 2000, decimals = 0 } = {}) => ({
    target,
    duration,
    decimals,
    current: 0,
    started: false,
    init() {
        // Safety net: even if the viewport trigger never fires, show the number.
        setTimeout(() => this.start(), 3500);
    },
    get display() {
        return Number(this.current).toLocaleString(undefined, {
            minimumFractionDigits: this.decimals,
            maximumFractionDigits: this.decimals,
        });
    },
    start() {
        if (this.started) return;
        this.started = true;

        const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (reduce || this.target === 0) {
            this.current = this.target;
            return;
        }

        const t0 = performance.now();
        const easeOutExpo = (x) => (x === 1 ? 1 : 1 - Math.pow(2, -10 * x));

        const tick = (now) => {
            const p = Math.min((now - t0) / this.duration, 1);
            this.current = this.target * easeOutExpo(p);
            if (p < 1) {
                requestAnimationFrame(tick);
            } else {
                this.current = this.target;
            }
        };
        requestAnimationFrame(tick);
    },
}));

/**
 * Site header — gains a backdrop once the page is scrolled, owns mobile nav state.
 */
Alpine.data('siteHeader', () => ({
    scrolled: false,
    mobileOpen: false,
    init() {
        const onScroll = () => (this.scrolled = window.scrollY > 24);
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    },
}));

window.Alpine = Alpine;
Alpine.start();

/**
 * Scroll reveal — a single, robust IntersectionObserver drives every
 * `.reveal` / `.img-reveal` element. This is intentionally independent of
 * Alpine so content can never stay permanently hidden: if the API is missing
 * or motion is reduced, everything is shown immediately.
 */
(function initReveals() {
    const els = () => document.querySelectorAll('.reveal:not(.is-shown), .img-reveal:not(.is-shown)');
    const showAll = () => els().forEach((el) => el.classList.add('is-shown'));

    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduce || !('IntersectionObserver' in window)) {
        showAll();
        return;
    }

    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-shown');
                    obs.unobserve(entry.target);
                }
            });
        },
        { root: null, rootMargin: '0px 0px -8% 0px', threshold: 0.05 }
    );

    const observe = () => els().forEach((el) => observer.observe(el));
    document.addEventListener('DOMContentLoaded', observe);
    if (document.readyState !== 'loading') observe();

    // Final safety net: reveal anything still hidden shortly after load.
    window.addEventListener('load', () => setTimeout(showAll, 2500));
})();
