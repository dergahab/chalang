import { useEffect } from 'react';

/**
 * useScrollAnimation — AOS (Animate On Scroll) əvəzi.
 *
 * Blade-də AOS.js CDN-dən yüklənir və `data-aos` attributları ilə işləyir.
 * React-da IntersectionObserver ilə eyni davranış əldə edilir:
 *
 * 1. `[data-aos]` attributlu bütün elementləri tapır
 * 2. Viewport-a daxil olduqda `aos-animate` class-ını əlavə edir
 * 3. `data-aos-delay` attributunu CSS transition-delay olaraq tətbiq edir
 * 4. `once: true` (Blade konfiqurasiyası ilə eyni)
 *
 * Yenilənmə (MutationObserver): Lazy load olunan komponentlər DOM-a 
 * sonradan əlavə edildiyi üçün MutationObserver vasitəsilə yeni 
 * yaranan [data-aos] elementləri də izlənilir.
 */

interface ScrollAnimationOptions {
    threshold?: number;
    rootMargin?: string;
}

// AOS CSS qaydalarını inject edən funksiya (yalnız 1 dəfə)
function injectAosStyles() {
    if (typeof document === 'undefined') return;
    if (document.getElementById('react-aos-styles')) return;

    const style = document.createElement('style');
    style.id = 'react-aos-styles';
    style.textContent = `
        /* ── AOS Base State (gizli) ── */
        [data-aos] {
            opacity: 0;
            transition-property: opacity, transform;
            transition-duration: 0.8s;
            transition-timing-function: ease-out;
        }

        /* ── AOS Animated State (görünür) ── */
        [data-aos].aos-animate {
            opacity: 1;
            transform: translate(0, 0) scale(1) !important;
        }

        /* ── AOS Direction Variants (başlanğıc state) ── */
        [data-aos="fade-up"] {
            transform: translateY(30px);
        }
        [data-aos="fade-down"] {
            transform: translateY(-30px);
        }
        [data-aos="fade-right"] {
            transform: translateX(-30px);
        }
        [data-aos="fade-left"] {
            transform: translateX(30px);
        }
        [data-aos="zoom-in"] {
            transform: scale(0.9);
        }
        [data-aos="zoom-in-up"] {
            transform: translateY(30px) scale(0.9);
        }
        [data-aos="flip-left"] {
            transform: perspective(2500px) rotateY(-100deg);
            backface-visibility: hidden;
        }
        [data-aos="flip-left"].aos-animate {
            transform: perspective(2500px) rotateY(0) !important;
        }
        [data-aos="fade-in"] {
            transform: none;
        }

        /* ── prefers-reduced-motion: AOS disable ── */
        @media (prefers-reduced-motion: reduce) {
            [data-aos] {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
        }
    `;
    document.head.appendChild(style);
}

export function useScrollAnimation(options: ScrollAnimationOptions = {}) {
    useEffect(() => {
        // CSS qaydalarını inject et (idempotent)
        injectAosStyles();

        const defaultOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px',
            ...options,
        };

        // İzlənilən elementləri yadda saxlamaq üçün (təkrar izləməmək üçün)
        const observedElements = new WeakSet();

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const el = entry.target as HTMLElement;

                    // data-aos-delay dəstəyi
                    const delay = el.getAttribute('data-aos-delay');
                    if (delay) {
                        el.style.transitionDelay = `${delay}ms`;
                    }

                    el.classList.add('aos-animate');
                    // once: true — Blade AOS konfiqurasiyası ilə eyni
                    observer.unobserve(el);
                }
            });
        }, defaultOptions);

        // Funksiya: Yeni elementləri tapıb izləməyə başlamaq
        const observeNewElements = () => {
            const elements = document.querySelectorAll('[data-aos]');
            elements.forEach((el) => {
                if (!observedElements.has(el)) {
                    observer.observe(el);
                    observedElements.add(el);
                }
            });
        };

        // İlkin elementləri izlə
        const timeoutId = setTimeout(observeNewElements, 100);

        // Lazy-loaded komponentlər üçün MutationObserver
        const mutationObserver = new MutationObserver((mutations) => {
            let shouldCheck = false;
            for (const mutation of mutations) {
                if (mutation.addedNodes.length > 0) {
                    shouldCheck = true;
                    break;
                }
            }
            if (shouldCheck) {
                observeNewElements();
            }
        });

        // Bütün DOM dəyişikliklərini dinlə
        mutationObserver.observe(document.body, {
            childList: true,
            subtree: true,
        });

        return () => {
            clearTimeout(timeoutId);
            observer.disconnect();
            mutationObserver.disconnect();
        };
    }, []); // Yalnız 1 dəfə mount-da çalışsın
}
