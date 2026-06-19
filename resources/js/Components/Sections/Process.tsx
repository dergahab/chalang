import React, { useEffect, useRef, useState, useMemo } from 'react';
import type { Translations, ContentTextMap } from '@/types';

interface MapPoint {
    label: string;
    top: number;
    left: number;
}

interface Step {
    id: number;
    title?: string;
    step?: string;
    description?: string;
    [key: string]: unknown;
}

interface ProcessProps {
    steps: Step[];
    translations: Translations;
    contentTextMap?: ContentTextMap;
}

const MAX_STEPS = 4;
const ROTATION_INTERVAL = 8000; // 8s — 1:1 with Blade
const DEFAULT_MAP_URL = '/assets/images/world-map-borders.svg';

const DEFAULT_MAP_POINTS: MapPoint[] = [
    { label: 'New York', top: 27.4, left: 29.4 },
    { label: 'Switzerland', top: 24.0, left: 52.3 },
    { label: 'Baku', top: 27.6, left: 63.9 },
    { label: 'Dubai', top: 36.0, left: 65.4 },
];

/**
 * Process Section — 1:1 port of Blade preview.blade.php lines 456-724
 *
 * Features:
 * - World map with locked aspect-ratio hotspots (fitMap logic)
 * - 4 step circles (01-04) with auto-rotation (8s interval)
 * - 2-column dual-pane layout (step navigation + detail cards)
 * - Checklist items with SVG checkmarks
 * - CTA button on step 4
 * - Pause on hover, manual click resets interval
 * - prefers-reduced-motion support
 */
export default function Process({ steps, translations, contentTextMap = {} }: ProcessProps) {
    const [currentStep, setCurrentStep] = useState(1);
    const intervalRef = useRef<ReturnType<typeof setInterval> | null>(null);
    const sectionRef = useRef<HTMLElement>(null);
    const wrapperRef = useRef<HTMLDivElement>(null);
    const containerRef = useRef<HTMLDivElement>(null);
    const imgRef = useRef<HTMLImageElement>(null);

    // ── Translation helper (dot-notation) ──
    const t = (key: string, fallback?: string): string => {
        const keys = key.split('.');
        let value: any = translations;
        for (const k of keys) {
            value = value?.[k];
        }
        return typeof value === 'string' ? value : (fallback ?? key);
    };

    // ── Content text helper (CMS override) ──
    const ct = (key: string, fallback?: string): string => {
        const v = contentTextMap[key];
        if (typeof v === 'string' && v.trim() !== '' && v !== key) return v.trim();
        return fallback ?? '';
    };

    // ── tArray: translations may return array (for list items) ──
    const tArray = (key: string): string[] => {
        const keys = key.split('.');
        let value: any = translations;
        for (const k of keys) {
            value = value?.[k];
        }
        return Array.isArray(value) ? value : [];
    };

    // ── Parse map URL from CMS (with cache buster) ──
    const mapUrl = useMemo(() => {
        const raw = ct('preview.process.map_url', DEFAULT_MAP_URL);
        let url = DEFAULT_MAP_URL;
        if (raw) {
            url = /^https?:\/\//i.test(raw) ? raw : (raw.startsWith('/') ? raw : '/' + raw.replace(/^\/+/, ''));
        }
        // Cache buster to ensure the newest, accurately aligned map is always loaded
        return url + '?v=' + Date.now();
    }, [contentTextMap]);

    // ── Parse map styles from CMS ──
    const mapStyles = useMemo(() => {
        const raw = contentTextMap['preview.process.map_styles'];
        try {
            if (typeof raw === 'string' && raw.trim() !== '') {
                return JSON.parse(raw);
            }
        } catch (e) {
            console.warn('Process section: Invalid map_styles JSON', e);
        }
        return {
            ocean: 'transparent',
            land: '#111625',
            stroke: 'rgba(124, 58, 237, 0.16)',
            strokeWidth: 0.6,
            opacity: 75,
            glow: false
        };
    }, [contentTextMap]);

    // ── Fetch inline SVG for CSS Variable injection ──
    const [svgContent, setSvgContent] = useState<string>('');
    useEffect(() => {
        if (mapUrl) {
            fetch(mapUrl)
                .then(r => r.text())
                .then(svg => setSvgContent(svg))
                .catch(e => console.error('Failed to load map SVG', e));
        }
    }, [mapUrl]);

    // ── Parse map points from CMS (array | JSON string | pipe-delimited) ──
    const mapPoints = useMemo<MapPoint[]>(() => {
        const clamp = (val: any) => {
            const n = parseFloat(val);
            if (isNaN(n)) return 0;
            return Math.max(0, Math.min(100, n));
        };
        const normalize = (item: any): MapPoint => ({
            label: String(item?.label ?? ''),
            top: clamp(item?.top ?? item?.y ?? 0),
            left: clamp(item?.left ?? item?.x ?? 0),
        });

        const raw = contentTextMap['preview.process.map_points'];
        const out: MapPoint[] = [];

        if (Array.isArray(raw)) {
            raw.forEach((item) => out.push(normalize(item)));
        } else if (typeof raw === 'string' && raw.trim() !== '') {
            try {
                const decoded = JSON.parse(raw);
                if (Array.isArray(decoded)) {
                    decoded.forEach((item) => out.push(normalize(item)));
                }
            } catch {
                // Pipe-delimited: "Label|top|left"
                if (raw.includes('|')) {
                    raw.split(/\r?\n/).forEach((line) => {
                        const parts = line.split('|').map((p) => p.trim());
                        if (parts.length >= 3) {
                            out.push(normalize({ label: parts[0], top: parts[1], left: parts[2] }));
                        }
                    });
                }
            }
        }

        return out.length > 0 ? out : DEFAULT_MAP_POINTS;
    }, [contentTextMap]);

    // ── Build 4 step items with fallback chain: DB > CMS override > translations ──
    const stepData = useMemo(() => {
        const items: Array<{
            index: number;
            circle: string;
            navTitle: string;
            navDesc: string;
            detailTitle: string;
            detailText: string;
            detailItems: string[];
            isLast: boolean;
        }> = [];

        const toText = (val: any): string => {
            if (typeof val === 'string') return val.trim();
            if (val && typeof val === 'object') {
                // Translatable fallback: pick first non-empty string
                const vals: string[] = Object.values(val).filter(
                    (v): v is string => typeof v === 'string' && v.trim() !== ''
                );
                return vals[0]?.trim() ?? '';
            }
            return '';
        };

        for (let i = 0; i < MAX_STEPS; i++) {
            const stepIndex = i + 1;
            const step = steps?.[i];
            const navTitleRaw = step ? toText((step as any).title) : '';
            const navDescRaw = step ? toText((step as any).step) : '';

            const detailTitleOverride = ct(`preview.process.details.step_${stepIndex}.title`, '');
            const detailTextOverride = ct(`preview.process.details.step_${stepIndex}.text`, '');
            const detailItemsFromTrans = tArray(`process.details.step_${stepIndex}.items`);

            let detailTitle = detailTitleOverride || navTitleRaw;
            if (!detailTitle) detailTitle = t(`process.details.step_${stepIndex}.title`, `Step ${stepIndex}`);

            let detailText = detailTextOverride || (step ? toText((step as any).description) : '');
            if (!detailText) detailText = t(`process.details.step_${stepIndex}.text`, '');

            // For step 4: exclude last detail item (used as CTA button)
            const isLast = stepIndex === MAX_STEPS;
            const itemsFiltered = isLast && detailItemsFromTrans.length > 0
                ? detailItemsFromTrans.slice(0, -1)
                : detailItemsFromTrans;

            items.push({
                index: stepIndex,
                circle: String(stepIndex).padStart(2, '0'),
                navTitle: navTitleRaw || t(
                    `process.steps.step_${stepIndex}.title`,
                    // P1-01: Standart Azərbaycan label-ları (Kəşf → Strategiya → İcra → Ölçmə)
                    ['Kəşf', 'Strategiya', 'İcra', 'Ölçmə'][i] ?? `Step ${stepIndex}`
                ),
                navDesc: navDescRaw || t(`process.steps.step_${stepIndex}.desc`, ''),
                detailTitle,
                detailText,
                detailItems: itemsFiltered,
                isLast,
            });
        }
        return items;
    }, [steps, translations, contentTextMap]);

    // ── Map aspect-ratio preservation (fitMap from Blade lines 548-594) ──
    useEffect(() => {
        const fitMap = () => {
            const wrapper = wrapperRef.current;
            const container = containerRef.current;
            if (!wrapper || !container) return;

            const wrapW = wrapper.clientWidth;
            const wrapH = wrapper.clientHeight;
            if (wrapW === 0 || wrapH === 0) return;
            const wrapRatio = wrapW / wrapH;

            const natW = 1600;
            const natH = 800;
            const imgRatio = natW / natH;

            if (wrapRatio > imgRatio) {
                container.style.width = wrapW + 'px';
                container.style.height = (wrapW / imgRatio) + 'px';
            } else {
                container.style.width = (wrapH * imgRatio) + 'px';
                container.style.height = wrapH + 'px';
            }
        };

        fitMap();
        window.addEventListener('resize', fitMap);
        
        // Observe wrapper size changes (layout shift)
        const ro = typeof ResizeObserver !== 'undefined' ? new ResizeObserver(fitMap) : null;
        if (ro && wrapperRef.current) ro.observe(wrapperRef.current);

        return () => {
            window.removeEventListener('resize', fitMap);
            if (ro) ro.disconnect();
        };
    }, [mapUrl]);

    // ── Auto-rotation (8s) + pause on hover ──
    useEffect(() => {
        const prefersReduced = typeof window !== 'undefined'
            && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReduced) return;

        const start = () => {
            if (intervalRef.current) clearInterval(intervalRef.current);
            intervalRef.current = setInterval(() => {
                setCurrentStep((prev) => (prev >= MAX_STEPS ? 1 : prev + 1));
            }, ROTATION_INTERVAL);
        };

        const stop = () => {
            if (intervalRef.current) {
                clearInterval(intervalRef.current);
                intervalRef.current = null;
            }
        };

        start();

        const section = sectionRef.current;
        if (section) {
            section.addEventListener('mouseenter', stop);
            section.addEventListener('mouseleave', start);
        }

        return () => {
            stop();
            if (section) {
                section.removeEventListener('mouseenter', stop);
                section.removeEventListener('mouseleave', start);
            }
        };
    }, []);

    // ── Manual switch: reset rotation timer ──
    const handleSwitch = (id: number) => {
        setCurrentStep(id);
        if (intervalRef.current) {
            clearInterval(intervalRef.current);
            intervalRef.current = setInterval(() => {
                setCurrentStep((prev) => (prev >= MAX_STEPS ? 1 : prev + 1));
            }, ROTATION_INTERVAL);
        }
    };

    const sectionTitle = t('sec_process_title', 'İş prosesimiz');
    const sectionSubtitle = t('sec_process_sub', 'Layihənizi necə həyata keçiririk');
    const ctaLabel = t('btn_start', 'Başla');

    return (
        <section ref={sectionRef} className="py-20 md:py-28 lg:py-36 px-5 relative overflow-hidden" id="about" aria-labelledby="process-heading">
            {/* World Map with Hotspots in Background — locked aspect-ratio */}
            <div ref={wrapperRef} className="absolute inset-0 z-0 overflow-hidden pointer-events-none select-none flex items-center justify-center">
                <div 
                    ref={containerRef} 
                    className="relative" 
                    id="processMapContainer"
                    style={{
                        backgroundColor: mapStyles.ocean !== 'transparent' ? mapStyles.ocean : 'transparent',
                        '--map-land': mapStyles.land,
                        '--map-stroke': mapStyles.stroke,
                        '--map-stroke-width': `${mapStyles.strokeWidth}px`,
                    } as React.CSSProperties}
                >
                    <div
                        className={`w-full h-auto block max-w-none transition-all duration-500 ${mapStyles.glow ? 'drop-shadow-[0_0_8px_var(--map-stroke)]' : ''}`}
                        style={{ opacity: mapStyles.opacity / 100 }}
                        dangerouslySetInnerHTML={{ __html: svgContent }}
                    />
                    {mapPoints.map((point, idx) => (
                        <div
                            key={`${point.label}-${idx}`}
                            className="absolute z-10 flex items-center justify-center -translate-x-1/2 -translate-y-1/2"
                            style={{ top: `${point.top}%`, left: `${point.left}%` }}
                            title={point.label}
                            aria-label={point.label}
                        >
                            {/* Outer pulsating ripple ring (Smaller, subtle) */}
                            <span 
                                className="absolute inline-flex h-4 w-4 rounded-full opacity-60 animate-ping" 
                                style={{ backgroundColor: 'var(--brand-secondary)' }}
                            ></span>
                            {/* Inner solid glowing core (Smaller, sharper) */}
                            <span 
                                className="relative inline-flex rounded-full h-2 w-2 border border-white/40 shadow-lg" 
                                style={{ 
                                    backgroundColor: 'var(--brand-secondary)', 
                                    boxShadow: '0 0 8px var(--brand-secondary)' 
                                }}
                            ></span>
                            {/* Floating text label beside dot */}
                            <span className="absolute left-4 text-[11px] font-semibold text-white/85 whitespace-nowrap tracking-wider pointer-events-none select-none drop-shadow-[0_2px_5px_rgba(0,0,0,0.95)]">
                                {point.label}
                            </span>
                        </div>
                    ))}
                </div>
            </div>

            <h2 id="process-heading" className="text-3xl md:text-5xl font-bold text-center text-text-main mb-4 reveal-text">
                <span>{sectionTitle}</span>
            </h2>
            <p className="text-lg text-center text-text-sub mb-12 max-w-2xl mx-auto">
                {sectionSubtitle}
            </p>

            {/* Navigation Steps (left column in dual-pane) */}
            <div
                className="max-w-[1200px] mx-auto relative flex justify-between items-start mb-10 px-5 crease-safe dual-pane stats-two-col"
            >
                {/* Connecting Line */}
                <div className="absolute top-[44px] left-[12%] right-[12%] h-[2px] z-0 hidden md:block overflow-hidden pointer-events-none">
                    <div className="w-full h-full border-t-2 border-dashed border-white/20 absolute top-0 left-0"></div>
                    <div className="absolute top-[-5px] left-0 text-brand-primary animate-connector-move">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="4" strokeLinecap="round" strokeLinejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </div>
                </div>
                <style>{`
                    @keyframes connector-move {
                        0% { left: 0%; opacity: 0; }
                        5% { opacity: 1; }
                        95% { opacity: 1; }
                        100% { left: 100%; opacity: 0; }
                    }
                    .animate-connector-move {
                        animation: connector-move 3s linear infinite;
                    }
                `}</style>
                
                {stepData.map((item) => (
                    <div
                        key={`step-${item.index}`}
                        className={`relative z-10 flex flex-col items-center text-center cursor-pointer transition-all duration-500 flex-1 ${
                            currentStep === item.index 
                            ? 'opacity-100 scale-105' 
                            : 'opacity-70 hover:opacity-100 hover:-translate-y-1'
                        }`}
                        id={`p-step-${item.index}`}
                        onClick={() => handleSwitch(item.index)}
                        role="button"
                        tabIndex={0}
                        onKeyDown={(e) => {
                            if (e.key === 'Enter' || e.key === ' ') {
                                e.preventDefault();
                                handleSwitch(item.index);
                            }
                        }}
                    >
                        <div className={`w-[88px] h-[88px] rounded-full flex items-center justify-center text-3xl font-bold mb-4 backdrop-blur-md transition-all duration-300 relative shadow-lg ${
                            currentStep === item.index 
                            ? 'bg-brand-primary border-brand-primary text-white shadow-brand-primary/40' 
                            : 'bg-white/5 border border-white/10 text-white hover:bg-white/10'
                        }`}>
                            {item.circle}
                        </div>
                        <div className="text-lg font-bold mb-2 px-2 text-text-main">{item.navTitle}</div>
                        <div className="text-sm max-w-[200px] leading-relaxed text-text-sub">{item.navDesc}</div>
                    </div>
                ))}
            </div>

            {/* Detail Cards (right column in dual-pane) */}
            <div className="max-w-[1100px] mx-auto mt-10 relative min-h-[400px] z-[2] bg-brand-primary/5 border border-white/5 rounded-3xl p-8 backdrop-blur-sm crease-safe dual-pane stats-two-col">
                {stepData.map((item) => (
                    <div
                        key={`detail-${item.index}`}
                        className={`transition-all duration-500 absolute inset-0 p-8 ${
                            currentStep === item.index 
                            ? 'opacity-100 pointer-events-auto translate-y-0 relative' 
                            : 'opacity-0 pointer-events-none translate-y-4 absolute'
                        }`}
                        id={`p-detail-${item.index}`}
                    >
                        <h4 className="text-2xl font-bold mb-4 text-text-main">{item.detailTitle}</h4>
                        <p className="text-lg text-text-sub mb-8" dangerouslySetInnerHTML={{ __html: item.detailText }} />

                        {item.detailItems.length > 0 && (
                            <ul className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                                {item.detailItems.map((listItem, i) => (
                                    <li key={`item-${item.index}-${i}`} className="flex items-center gap-3 p-4 rounded-xl bg-white/5 border border-white/5 text-text-main hover:bg-white/10 hover:border-white/20 transition-all hover:translate-x-1">
                                        <svg
                                            width="20"
                                            height="20"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#00ff88"
                                            strokeWidth="2.5"
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            className="shrink-0"
                                        >
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        {listItem}
                                    </li>
                                ))}
                            </ul>
                        )}

                        {item.isLast && (
                            <a href="#contact" className="inline-flex items-center gap-2 px-8 py-3 rounded-full font-bold text-white transition-all bg-brand-gradient hover:-translate-y-1 shadow-lg shadow-brand-primary/40 mt-4">
                                {ctaLabel}{' '}
                                <svg
                                    width="20"
                                    height="20"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    className="ms-1"
                                >
                                    <path
                                        d="M5 12h14M12 5l7 7-7 7"
                                        stroke="currentColor"
                                        strokeWidth="2"
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                    />
                                </svg>
                            </a>
                        )}
                    </div>
                ))}
            </div>
        </section>
    );
}
