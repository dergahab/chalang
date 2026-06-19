import { useEffect, useRef, useState, useCallback } from 'react';
import { useMotionValue, MotionValue } from 'framer-motion';

// ─────────────────────────────────────────────
// Types
// ─────────────────────────────────────────────
export interface ActiveSectionResult {
    activeSectionId: string | null;
    scrollProgress: MotionValue<number>;
}

// ─────────────────────────────────────────────
// useActiveSection — Hibrid IO + Manual Scroll
//
// DƏYIŞIKLIK: useScroll(target: ref) → useMotionValue + scroll listener
// Səbəb: Framer Motion useScroll ref-i hook çağırışında null görsə crash edir.
//        Manual approach ref null olarkən təhlükəsizdir.
//
// IntersectionObserver: makro naviqasiya
//   → hansi bölmə aktiv olduğunu müəyyən edir
//   → sıfır perf xərci, native brauzer API
//
// scroll listener (passive): mikro scroll progress
//   → aktiv bölmənin real getBoundingClientRect-inə görə 0→1 progress
//   → useMotionValue → GPU transform üçün Framer-ə verilir
//
// ResizeObserver: dinamik hündürlük
//   → FAQ accordion, dil dəyişimi, lazy load
// ─────────────────────────────────────────────
export function useActiveSection(): ActiveSectionResult {
    const [activeSectionId, setActiveSectionId] = useState<string | null>(null);

    // Bu ref yalnız scroll handler daxilində istifadə olunur
    // Framer Motion-a heç vaxt birbaşa verilmir — hydration xətası yoxdur
    const activeSectionRef = useRef<Element | null>(null);

    const debounceTimer = useRef<ReturnType<typeof setTimeout> | null>(null);

    // MotionValue — həmişə initialize olunur, null olmur
    // GuidedStar.tsx-dəki useTransform buna bağlanır
    const scrollProgress = useMotionValue(0);

    // ── Debounce ilə aktiv bölmə yenilənməsi ──
    const updateActiveSection = useCallback((id: string, element: Element) => {
        if (debounceTimer.current) {
            clearTimeout(debounceTimer.current);
        }
        debounceTimer.current = setTimeout(() => {
            setActiveSectionId(id);
            activeSectionRef.current = element;
            // Yeni bölmə aktiv olduqda progress sıfırlanır
            scrollProgress.set(0);
        }, 150);
    }, [scrollProgress]);

    // ── Manual Scroll Progress Tracker ──
    // Aktiv bölmənin getBoundingClientRect-inə görə 0→1 progress hesablayır.
    // Passive listener: main thread-i bloklamır (GPU thread üçün ideal)
    useEffect(() => {
        const handleScroll = () => {
            const section = activeSectionRef.current;
            if (!section) {
                scrollProgress.set(0);
                return;
            }

            const rect = section.getBoundingClientRect();
            const windowH = window.innerHeight;
            const sectionH = rect.height;

            // Progress: 0 = bölmə aşağıdan gəlir, 1 = yuxarıdan çıxır
            // (window + sectionH) = tam keçid məsafəsi
            const raw = 1 - (rect.bottom / (windowH + sectionH));
            scrollProgress.set(Math.max(0, Math.min(1, raw)));
        };

        window.addEventListener('scroll', handleScroll, { passive: true });
        // İlk render üçün bir dəfə manual tetik
        handleScroll();

        return () => {
            window.removeEventListener('scroll', handleScroll);
        };
    }, [scrollProgress]);

    // ── IntersectionObserver + ResizeObserver ──
    useEffect(() => {
        // prefers-reduced-motion yoxlaması
        const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReduced) return;

        const waypoints = document.querySelectorAll('[data-star-waypoint]');
        if (waypoints.length === 0) return;

        const ioOptions: IntersectionObserverInit = {
            threshold: 0.5,
            rootMargin: '0px 0px -10% 0px',
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('data-star-waypoint');
                    if (id) {
                        updateActiveSection(id, entry.target);
                    }
                }
            });
        }, ioOptions);

        waypoints.forEach((el) => observer.observe(el));

        // ResizeObserver: bölmə ölçüsü dəyişdikdə IO yenilənir
        const resizeObserver = new ResizeObserver(() => {
            setTimeout(() => {
                observer.disconnect();
                waypoints.forEach((el) => observer.observe(el));
            }, 100);
        });

        waypoints.forEach((el) => resizeObserver.observe(el));

        return () => {
            observer.disconnect();
            resizeObserver.disconnect();
            if (debounceTimer.current) {
                clearTimeout(debounceTimer.current);
            }
        };
    }, [updateActiveSection]);

    return {
        activeSectionId,
        scrollProgress,
    };
}
