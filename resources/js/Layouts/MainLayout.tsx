import React, { ReactNode } from 'react';
import { Head } from '@inertiajs/react';
import Navbar from '@/Components/Navbar';
import Footer from '@/Components/Footer';
import CookieConsent from '@/Components/CookieConsent';
import Preloader from '@/Components/Sections/Preloader';
import CustomCursor from '@/Components/Sections/CustomCursor';
import ToastContainer from '@/Components/ui/Toast';
import { useMagneticHover } from '@/Hooks/useMagneticHover';
import GuidedStar from '@/Components/GuidedStar';

interface MainLayoutProps {
    children: ReactNode;
    title?: string;
}

/**
 * MainLayout — 1:1 match with Blade abstrak.blade.php
 *
 * Background: Uses CSS var(--bg-body) from ThemeProvider (not Tailwind classes)
 * Shapes: 3 shapes matching Blade (shape-1, shape-2, shape-3)
 * Noise: opacity 0.04 matching Blade
 */
const MainLayout: React.FC<MainLayoutProps> = ({ children, title }) => {
    useMagneticHover();

    return (
        <div
            className="min-h-screen relative transition-colors duration-300 selection:bg-brand-secondary selection:text-white"
            style={{
                color: 'var(--text-main)',
            }}
        >
            {/* Global Design System utilities — Glassmorphism & radius tokens (Design System §4) */}
            <style>{`
                .glass-card,
                .kinetic-card,
                .project-card,
                .team-card,
                .faq-item {
                    backdrop-filter: blur(12px);
                    -webkit-backdrop-filter: blur(12px);
                }
                .glass-card {
                    background: rgba(255, 255, 255, 0.03);
                    border: 1px solid rgba(255, 255, 255, 0.05);
                }

                /* ── Background Shapes (Blade parity) ── */
                .bg-shape {
                    position: fixed;
                    width: 100%;
                    height: 100%;
                    left: 0;
                    top: 0;
                    pointer-events: none;
                    z-index: 0;
                }
                .bg-shape.shape-1 {
                    background: radial-gradient(circle at 20% 30%, var(--brand-primary) 0%, transparent 50%);
                    opacity: calc(0.6 * var(--ambient-intensity, 0.6));
                    filter: blur(100px);
                }
                .bg-shape.shape-2 {
                    background: radial-gradient(circle at 80% 55%, var(--brand-secondary) 0%, transparent 40%);
                    opacity: calc(0.45 * var(--ambient-intensity, 0.6));
                    filter: blur(85px);
                }
                .bg-shape.shape-3 {
                    /* tertiary (violet family) — footer ambient */
                    background: radial-gradient(circle at 50% 92%, var(--brand-tertiary, #8b00ff) 0%, transparent 35%);
                    opacity: calc(0.25 * var(--ambient-intensity, 0.6));
                    filter: blur(90px);
                }
                .bg-shape.shape-4 {
                    /* primary+secondary blend — left-bottom warmth */
                    background: radial-gradient(circle at 8% 75%, color-mix(in srgb, var(--brand-primary) 60%, var(--brand-secondary) 40%) 0%, transparent 45%);
                    opacity: calc(0.18 * var(--ambient-intensity, 0.6));
                    filter: blur(120px);
                }
                .bg-shape.shape-5 {
                    /* secondary+primary blend — top-right accent */
                    background: radial-gradient(circle at 88% 12%, color-mix(in srgb, var(--brand-secondary) 70%, var(--brand-primary) 30%) 0%, transparent 40%);
                    opacity: calc(0.15 * var(--ambient-intensity, 0.6));
                    filter: blur(130px);
                }

                /* ── Noise Overlay (Blade parity) ── */
                .noise-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: 9999;
                    pointer-events: none;
                    opacity: 0.04;
                    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
                }

                /* ── Custom Cursor (Blade parity) ── */
                .cursor-dot,
                .cursor-outline {
                    position: fixed;
                    top: 0;
                    left: 0;
                    transform: translate(-50%, -50%);
                    border-radius: 50%;
                    z-index: 10000;
                    pointer-events: none;
                    mix-blend-mode: difference;
                }
                .cursor-dot {
                    width: 8px;
                    height: 8px;
                    background: #fff;
                }
                .cursor-outline {
                    width: 40px;
                    height: 40px;
                    border: 1px solid rgba(255, 255, 255, 0.5);
                }

                [data-theme="light"] .glass-card {
                    background: rgba(255, 255, 255, 0.7);
                    border: 1px solid rgba(0, 0, 0, 0.05);
                }
                [data-theme="light"] .service-desc,
                [data-theme="light"] .step-desc {
                    color: rgba(0, 0, 0, 0.75) !important;
                }
                .process-line {
                    background: linear-gradient(90deg, transparent, var(--brand-primary), transparent) !important;
                    opacity: 0.5;
                    height: 2px;
                }
                .magnet-input, .magnet-btn {
                    height: 50px;
                    box-sizing: border-box;
                }
                .kinetic-card,
                .project-card,
                .team-card,
                .faq-item {
                    border-radius: var(--radius-card, 24px);
                }
                .magnet-btn,
                .subscribe-btn {
                    border-radius: var(--radius-btn, 12px);
                    transition: transform 0.25s ease, box-shadow 0.25s ease;
                }
                .kinetic-btn:hover,
                .magnet-btn:hover,
                .subscribe-btn:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 10px 30px var(--brand-glow, rgba(75, 0, 130, 0.35));
                }

                /* ── Q-13: 320px iPhone SE (cursorrules §5.1) ── */
                @media (max-width: 359px) {
                    .hero h1 { font-size: 1.5rem !important; }
                    .hero p { font-size: 0.85rem !important; }
                    .section-title { font-size: 1.4rem !important; }
                    .section-subtitle { font-size: 0.8rem !important; }
                    .counter-card { min-width: 130px !important; max-width: 150px !important; padding: 15px !important; }
                    .count-number { font-size: 2rem !important; }
                    .kinetic-card { padding: 16px !important; }
                    .team-card { min-width: 250px !important; }
                    .faq-question { font-size: 0.85rem !important; padding: 12px !important; }
                    .blog-card .blog-content { padding: 12px !important; }
                    .contact-form .form-input { padding: 10px 12px !important; font-size: 0.85rem !important; }
                    .footer-main { padding: 30px 15px !important; }
                    .mobile-sticky-cta .btn { font-size: 0.85rem !important; padding: 10px 16px !important; }
                }

                /* ── Q-14: Landscape mode (cursorrules §5.3) ── */
                @media (max-height: 500px) and (orientation: landscape) {
                    .hero { height: auto !important; min-height: auto !important; }
                    .hero .hero-decor,
                    .hero .bg-shape { opacity: 0.3 !important; }
                    .section { padding-top: 30px !important; padding-bottom: 30px !important; }
                    .sticky, [class*="sticky"] { position: relative !important; }
                    .mobile-sticky-cta { display: none !important; }
                    .navbar, #masthead { position: relative !important; }
                }

                /* ── Q-15: Foldable crease-safe (cursorrules §5.3) ── */
                .crease-safe {
                    padding-left: env(viewport-segment-left, 0px);
                    padding-right: env(viewport-segment-right, 0px);
                }
                @media (min-width: 600px) and (max-width: 800px) and (min-aspect-ratio: 3/4) and (max-aspect-ratio: 5/4) {
                    .counter-grid { grid-template-columns: repeat(2, 1fr) !important; }
                    .services-grid { grid-template-columns: repeat(2, 1fr) !important; }
                    .team-grid { grid-template-columns: repeat(2, 1fr) !important; }
                    .blog-slider { grid-template-columns: repeat(2, 1fr) !important; }
                }

                /* ── Q-16: 8K/UHD cap (cursorrules §5.4) ── */
                @media (min-width: 1920px) {
                    .section,
                    .services-section,
                    .process-section,
                    .team-section,
                    .portfolio-section,
                    .blog-section,
                    .faq-section,
                    .contact-section,
                    .estimator-section { max-width: 1440px; margin-left: auto; margin-right: auto; }
                    html { font-size: min(18px, 1.1vw); }
                }

                /* ── Q-17: prefers-reduced-motion (cursorrules §5.5) ── */
                @media (prefers-reduced-motion: reduce) {
                    .infinite-text, .tech-track, .partners-track { animation: none !important; }
                    .hero canvas { display: none !important; }
                    [data-aos] { opacity: 1 !important; transform: none !important; transition: none !important; }
                    .bg-shape, [class*="float"] { animation: none !important; }
                }

                /* ── Q-18: Touch devices hover → :active (cursorrules §5.5) ── */
                @media (hover: none) and (pointer: coarse) {
                    .kinetic-btn:hover,
                    .magnet-btn:hover,
                    .kinetic-card:hover,
                    .project-card:hover,
                    .team-card:hover,
                    .blog-card:hover { transform: none !important; box-shadow: none !important; }
                    .kinetic-btn:active,
                    .magnet-btn:active { transform: scale(0.97) !important; }
                    .kinetic-card:active,
                    .project-card:active { transform: scale(0.98) !important; }
                }

                /* ── Q-19: Notch / Dynamic Island (env safe-area) ── */
                @supports (padding: env(safe-area-inset-top)) {
                    #masthead { padding-top: env(safe-area-inset-top); }
                    .mobile-sticky-cta { padding-bottom: env(safe-area-inset-bottom); }
                    .footer-bottom { padding-bottom: calc(20px + env(safe-area-inset-bottom)); }
                }

                /* ── Q-20: Focus-visible for keyboard navigation ── */
                *:focus-visible {
                    outline: 2px solid var(--brand-primary);
                    outline-offset: 2px;
                    border-radius: 4px;
                }
                .kinetic-btn:focus-visible,
                .magnet-btn:focus-visible {
                    outline-offset: 4px;
                    box-shadow: 0 0 0 4px var(--brand-glow, rgba(75, 0, 130, 0.25));
                }

                /* ── Q-21: Custom Cursor Mobil/Tablet Guard (id: 806_cursor) ── */
                @media (pointer: coarse) {
                    html, body, a, button, [role="button"], .cursor-pointer {
                        cursor: auto !important;
                    }
                    #cursor, #cursor-follower {
                        display: none !important;
                    }
                }
            `}</style>

            <Preloader />
            <CustomCursor />

            {/* NOISE OVERLAY — 1:1 with Blade (override z-index so it doesn't fall behind root) */}
            <div className="noise-overlay" style={{ zIndex: 1, pointerEvents: 'none' }}></div>

            {/* BG SHAPES — 1:1 with Blade (override z-index: -1 from chalang-core.css) */}
            <div className="bg-shape shape-1" data-speed="2" style={{ zIndex: 1, pointerEvents: 'none' }}></div>
            <div className="bg-shape shape-2" data-speed="4" style={{ zIndex: 1, pointerEvents: 'none' }}></div>
            <div className="bg-shape shape-3" data-speed="1.5" style={{ zIndex: 1, pointerEvents: 'none' }}></div>
            <div className="bg-shape shape-4" data-speed="3" style={{ zIndex: 1, pointerEvents: 'none' }}></div>
            <div className="bg-shape shape-5" data-speed="2.5" style={{ zIndex: 1, pointerEvents: 'none' }}></div>

            {/* GUIDED STAR — Scroll-reactive ambient glow (✦ logo element) */}
            <GuidedStar />

            {title && <Head title={title} />}

            <Navbar />

            {/* Main Content with subtle hydration fade-in */}
            <main className="relative z-10 animate-fade-in-up" style={{ animationDuration: '0.6s' }}>
                {children}
            </main>

            <Footer />
            
            {/* Wrapper for CookieConsent to prevent layout shifting */}
            <div className="fixed bottom-0 left-0 w-full z-[9999] pointer-events-none">
                <div className="pointer-events-auto">
                    <CookieConsent />
                </div>
            </div>
            <ToastContainer />
        </div>
    );
};

export default MainLayout;
