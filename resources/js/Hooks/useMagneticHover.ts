import { useEffect } from 'react';

/**
 * useMagneticHover — Blade preview.blade.php L1496-1508 magnetic effect portu.
 *
 * Blade-dəki davranış:
 * ```js
 * const magneticElements = document.querySelectorAll('.progress-wrap, .kinetic-btn, .ai-trigger');
 * magneticElements.forEach((el) => {
 *     el.addEventListener('mousemove', function(e) {
 *         const pos = this.getBoundingClientRect();
 *         const x = e.clientX - pos.left - pos.width / 2;
 *         const y = e.clientY - pos.top - pos.height / 2;
 *         this.style.transform = 'translate(' + x * 0.3 + 'px, ' + y * 0.3 + 'px)';
 *     });
 *     el.addEventListener('mouseout', function() {
 *         this.style.transform = 'translate(0px, 0px)';
 *     });
 * });
 * ```
 *
 * Selectors: .kinetic-btn, .ai-trigger, .progress-wrap
 * Touch devices: disabled (hover yoxdur)
 */

const MAGNETIC_SELECTORS = '.kinetic-btn, .ai-trigger, .progress-wrap, .magnet-btn';
const MAGNETIC_STRENGTH = 0.3;

export function useMagneticHover() {
    useEffect(() => {
        // Touch cihazlarda disable et (cursorrules §5.5)
        const isTouchDevice =
            typeof window !== 'undefined' &&
            ('ontouchstart' in window || navigator.maxTouchPoints > 0);

        if (isTouchDevice) return;

        // prefers-reduced-motion yoxlaması
        const prefersReduced =
            typeof window !== 'undefined' &&
            window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (prefersReduced) return;

        const handleMouseMove = (e: MouseEvent) => {
            const target = e.currentTarget as HTMLElement;
            const pos = target.getBoundingClientRect();
            const x = e.clientX - pos.left - pos.width / 2;
            const y = e.clientY - pos.top - pos.height / 2;
            target.style.transform = `translate(${x * MAGNETIC_STRENGTH}px, ${y * MAGNETIC_STRENGTH}px)`;
        };

        const handleMouseOut = (e: MouseEvent) => {
            const target = e.currentTarget as HTMLElement;
            target.style.transform = 'translate(0px, 0px)';
        };

        // DOM elementlərini tap və listener əlavə et
        // setTimeout: React-ın render döngüsündən sonra
        const timeoutId = setTimeout(() => {
            const elements = document.querySelectorAll<HTMLElement>(MAGNETIC_SELECTORS);
            elements.forEach((el) => {
                el.addEventListener('mousemove', handleMouseMove as EventListener);
                el.addEventListener('mouseout', handleMouseOut as EventListener);
            });
        }, 200);

        return () => {
            clearTimeout(timeoutId);
            const elements = document.querySelectorAll<HTMLElement>(MAGNETIC_SELECTORS);
            elements.forEach((el) => {
                el.removeEventListener('mousemove', handleMouseMove as EventListener);
                el.removeEventListener('mouseout', handleMouseOut as EventListener);
            });
        };
    }, []);
}
