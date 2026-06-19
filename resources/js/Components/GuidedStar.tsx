import React, { useEffect, useState } from 'react';
import { motion, useTransform } from 'framer-motion';
import { useActiveSection } from '@/Hooks/useActiveSection';

// ─────────────────────────────────────────────
// Waypoint Konfiqurasiyası
// ─────────────────────────────────────────────
interface WaypointConfig {
    xDesktop: number;
    yDesktop: number;
    xTablet: number;
    yTablet: number;
    scale: number;
    opacityDark: number;
    opacityLight: number;
    secondary: boolean;  // true = brand-secondary rəng
}

const WAYPOINTS: Record<string, WaypointConfig> = {
    hero: {
        xDesktop: 0.10, yDesktop: 0.48,
        xTablet:  0.08, yTablet:  0.48,
        scale: 1.0,
        opacityDark:  0.90,
        opacityLight: 0.55,
        secondary: false,
    },
    services: {
        xDesktop: 0.82, yDesktop: 0.50,
        xTablet:  0.80, yTablet:  0.50,
        scale: 0.82,
        opacityDark:  0.80,
        opacityLight: 0.40,
        secondary: true,
    },
    estimator: {
        xDesktop: 0.72, yDesktop: 0.52,
        xTablet:  0.65, yTablet:  0.52,
        scale: 0.88,
        opacityDark:  0.85,
        opacityLight: 0.45,
        secondary: false,
    },
    contact: {
        xDesktop: 0.35, yDesktop: 0.50,
        xTablet:  0.38, yTablet:  0.50,
        scale: 0.78,
        opacityDark:  0.75,
        opacityLight: 0.38,
        secondary: true,
    },
    default: {
        xDesktop: 0.50, yDesktop: 0.50,
        xTablet:  0.50, yTablet:  0.50,
        scale: 0.65,
        opacityDark:  0.40,
        opacityLight: 0.20,
        secondary: false,
    },
};

const safeguardX = (x: number): number => {
    if (x > 0.44 && x < 0.56) return x < 0.5 ? 0.43 : 0.57;
    return x;
};

type ScreenType = 'mobile' | 'tablet' | 'desktop';
const getScreenType = (w: number): ScreenType => {
    if (w < 768) return 'mobile';
    if (w < 1024) return 'tablet';
    return 'desktop';
};

// ─────────────────────────────────────────────
// GlowOrb — Pure CSS Ambient Glow & Vector Core
//
// SVG blur-dən imtina edildi. 60FPS performansı
// üçün CSS radial-gradient və sharp vektor.
// ─────────────────────────────────────────────
const GlowOrb: React.FC<{ isDark: boolean }> = ({ isDark }) => {
    return (
        <div style={{
            position: 'relative',
            width: '100%',
            height: '100%',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            // Ekstra böyük container daxilində glow
        }}>
            {/* Qat 1: Pure CSS Ambient İşıq (Heç vaxt kəsilmir, Ləkə salmır) */}
            <div style={{
                position: 'absolute',
                width: '150%',
                height: '150%',
                background: 'radial-gradient(circle at center, currentColor 0%, transparent 65%)',
                opacity: isDark ? 0.25 : 0.12,
                borderRadius: '50%',
                pointerEvents: 'none',
                // Zərif smoothing
                filter: 'blur(20px)',
            }} />

            {/* Qat 2: Təmiz, kəskin Chalang 4-guşəli ulduz (Blur YOXDUR) */}
            <svg
                width="80"
                height="80"
                viewBox="0 0 100 100"
                fill="currentColor"
                style={{
                    position: 'relative',
                    zIndex: 1,
                    opacity: isDark ? 1 : 0.85,
                    filter: 'drop-shadow(0 0 15px currentColor)',
                }}
            >
                <path d="M50,10 C53,40 60,47 90,50 C60,53 53,60 50,90 C47,60 40,53 10,50 C40,47 47,40 50,10 Z" />
            </svg>

            {/* Qat 3: Fizikiliyi artırmaq üçün kiçik ağ işıq nüvəsi */}
            <div style={{
                position: 'absolute',
                width: '8px',
                height: '8px',
                background: '#ffffff',
                borderRadius: '50%',
                boxShadow: '0 0 15px 5px rgba(255,255,255,0.8)',
                zIndex: 2,
            }} />
        </div>
    );
};

// ─────────────────────────────────────────────
// GuidedStar — Əsas Komponent
// ─────────────────────────────────────────────
const GuidedStar: React.FC = () => {
    if (typeof window !== 'undefined' &&
        window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return null;
    }
    return <GuidedStarInner />;
};

const GuidedStarInner: React.FC = () => {
    const { activeSectionId, scrollProgress } = useActiveSection();

    // ── Tema ──
    const [isDark, setIsDark] = useState(
        typeof document !== 'undefined'
            ? document.documentElement.dataset.theme !== 'light'
            : true
    );
    useEffect(() => {
        const obs = new MutationObserver(() =>
            setIsDark(document.documentElement.dataset.theme !== 'light')
        );
        obs.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['data-theme'],
        });
        return () => obs.disconnect();
    }, []);

    // ── Ekran ──
    const [screenType, setScreenType] = useState<ScreenType>(() =>
        typeof window !== 'undefined' ? getScreenType(window.innerWidth) : 'desktop'
    );
    const [isLandscape, setIsLandscape] = useState(() =>
        typeof window !== 'undefined' ? window.innerHeight < 500 : false
    );
    useEffect(() => {
        const onResize = () => {
            setScreenType(getScreenType(window.innerWidth));
            setIsLandscape(window.innerHeight < 500);
        };
        window.addEventListener('resize', onResize, { passive: true });
        return () => window.removeEventListener('resize', onResize);
    }, []);

    const wp = WAYPOINTS[activeSectionId ?? 'default'] ?? WAYPOINTS.default;
    const isMobile = screenType === 'mobile';
    const isTablet  = screenType === 'tablet';

    // ── Ölçü ──
    // Böyük olsun — glow effekti yalnız böyük ölçüdə hiss olunur
    const containerSize = isMobile ? 300 : isTablet ? 420 : 500;

    // ── Koordinatlar ──
    const xRaw  = isTablet ? wp.xTablet : wp.xDesktop;
    const yRaw  = isTablet ? wp.yTablet : wp.yDesktop;
    const xSafe = isMobile ? 0.5 : safeguardX(xRaw);

    // UHD: max-width 1440px containerə nisbətən
    const leftValue = (() => {
        if (typeof window !== 'undefined' && window.innerWidth >= 1920) {
            const offset = (window.innerWidth - 1440) / 2;
            return offset + xSafe * 1440;
        }
        return `${xSafe * 100}%`;
    })();

    // ── Opacity ──
    const baseOpacity = isDark ? wp.opacityDark : wp.opacityLight;
    const finalOpacity = isLandscape ? baseOpacity * 0.4 : baseOpacity;

    // ── Rəng ──
    const resolvedColor = (() => {
        if (typeof document === 'undefined') return '#4b0082';
        const varName = wp.secondary ? '--brand-secondary' : '--brand-primary';
        return getComputedStyle(document.documentElement)
            .getPropertyValue(varName).trim() || '#4b0082';
    })();

    // ── Scroll mikro offset (yalnız desktop) ──
    const scrollX = useTransform(scrollProgress, [0, 1], [-30, 30]);
    const scrollY = useTransform(scrollProgress, [0, 1], [-15, 15]);

    return (
        <motion.div
            aria-hidden="true"
            style={{
                position: 'fixed',
                pointerEvents: 'none',
                // z-index 10: navbar (z:100) altında, content (z:1-5) üstündə
                // pointerEvents:none olduğu üçün interaktivliyi bloklamır
                zIndex: 10,
                width: containerSize,
                height: containerSize,
                top: isMobile ? '28%' : `${yRaw * 100}%`,
                left: leftValue,
                x: '-50%',
                y: '-50%',
                willChange: 'transform, opacity',
                color: resolvedColor,
                ...(!isMobile && {
                    translateX: scrollX,
                    translateY: scrollY,
                }),
            }}
            animate={{
                opacity: finalOpacity,
                scale: wp.scale,
                color: resolvedColor,
            }}
            transition={{
                opacity: { duration: 1.4, ease: [0.16, 1, 0.3, 1] },
                scale:   { duration: 1.4, ease: [0.16, 1, 0.3, 1] },
                color:   { duration: 1.0 },
            }}
        >
            {/* Döyünən (Nəfəs alan) Zərif Pulsasiya */}
            <motion.div
                style={{ width: '100%', height: '100%' }}
                animate={{
                    scale: [1, 1.05, 1],
                    opacity: [1, 0.85, 1],
                }}
                transition={{
                    duration: 4,
                    repeat: Infinity,
                    ease: 'easeInOut',
                }}
            >
                <GlowOrb isDark={isDark} />
            </motion.div>
        </motion.div>
    );
};

export default GuidedStar;
