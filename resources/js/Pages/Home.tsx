import React, { useState, lazy } from 'react';
import MainLayout from '@/Layouts/MainLayout';
import ErrorBoundary from '@/Components/ErrorBoundary';
import ThemeProvider from '@/Components/ThemeProvider';
import { Head } from '@inertiajs/react';
import type { Translations, ContentTextMap } from '@/types';
import { LazySection } from '@/Components/ui/Layout';

// Phase 2 sections — lazy loaded for code splitting
import ScrollProgress from '@/Components/Sections/ScrollProgress';
import Marquee from '@/Components/Sections/Marquee';
import MobileStickyCTA from '@/Components/Sections/MobileStickyCTA';
import Hero from '@/Components/Sections/Hero';
import SchemaData from '@/Components/SchemaData';
import { useScrollAnimation } from '@/Hooks/useScrollAnimation';
import { useSectionEnabled } from '@/Hooks/useSectionEnabled';
import { useServices, usePortfolio, useTestimonials, useBlogPosts, useMetrics } from '@/Hooks/useQueries';

// Core User Journey sections loaded eagerly for instant rendering during scroll
import WhoWeAre from '@/Components/Sections/WhoWeAre';
import Services from '@/Components/Sections/Services';
import Portfolio from '@/Components/Sections/Portfolio';
import Process from '@/Components/Sections/Process';
import Metrics from '@/Components/Sections/Metrics';
import Testimonials from '@/Components/Sections/Testimonials';
import Estimator from '@/Components/Sections/Estimator';
import Pricing from '@/Components/Sections/Pricing';
import Faq from '@/Components/Sections/Faq';
import Contact from '@/Components/Sections/Contact';

// Heavy secondary below-the-fold components loaded lazy for bundle optimization
const TechStack = lazy(() => import('@/Components/Sections/TechStack'));
const Partners = lazy(() => import('@/Components/Sections/Partners'));
const TeamGrid = lazy(() => import('@/Components/Sections/TeamGrid'));
const HallOfFame = lazy(() => import('@/Components/Sections/HallOfFame'));
const Blog = lazy(() => import('@/Components/Sections/Blog'));
const LeadMagnet = lazy(() => import('@/Components/Sections/LeadMagnet'));
const AIWidget = lazy(() => import('@/Components/Sections/AIWidget'));
const QuoteModal = lazy(() => import('@/Components/Sections/QuoteModal'));
const NewsletterPopup = lazy(() => import('@/Components/NewsletterPopup'));

// ── Prop Types ──
interface ThemeColors {
    primary: string;
    secondary: string;
    primary_rgb: string;
    secondary_rgb: string;
}

interface ThemeConfig {
    colors: {
        light: ThemeColors;
        dark: ThemeColors;
    };
    font: string;
    font_url: string;
    border_radius: string;
    radii: {
        btn: string;
        card: string;
        input: string;
    };
    smart_bg: boolean;
    glow_intensity: number;
    custom_css: string;
    custom_js: string;
}

interface HomeProps {
    theme: ThemeConfig;
    banner: {
        id: number;
        title: string;
        content: string;
        image?: string;
        video?: string;
        video_poster?: string;
        [key: string]: unknown;
    } | null;
    main_services: {
        id: number;
        name: string;
        description?: string;
        icon?: string;
        childs?: { id: number; name: string; [key: string]: unknown }[];
        [key: string]: unknown;
    }[];
    portfolio_items: {
        id: number;
        title: string;
        slug: string;
        description?: string;
        image?: string;
        pcategories?: { id: number; name: string }[];
        [key: string]: unknown;
    }[];
    case_studies: unknown[];
    testimonials: {
        id: number;
        name?: string;
        position?: string;
        content: string;
        image?: string;
        [key: string]: unknown;
    }[];
    partners: {
        id: number;
        name: string;
        logo?: string;
        [key: string]: unknown;
    }[];
    pricing_plans?: any[];
    team_members: {
        id: number;
        name: string;
        position?: string;
        image?: string;
        specialties?: string;
        [key: string]: unknown;
    }[];
    faq_items: {
        id: number;
        question: string;
        answer: string;
        [key: string]: unknown;
    }[];
    social_media: {
        id: number;
        name: string;
        icon: string;
        link: string;
    }[];
    steps: {
        id: number;
        title: string;
        description?: string;
        position: number;
        [key: string]: unknown;
    }[];
    blogs?: {
        id: number;
        title: string;
        slug: string;
        image?: string;
        created_at?: string;
        [key: string]: unknown;
    }[] | null;
    content_text_map: ContentTextMap;
    marquee_text: string;
    locale: string;
    translations: Translations;
}

export default function Home({
    theme,
    banner,
    main_services,
    portfolio_items,
    case_studies,
    testimonials,
    partners,
    pricing_plans,
    team_members,
    faq_items,
    social_media,
    steps,
    blogs,
    content_text_map,
    marquee_text,
    locale,
    translations,
}: HomeProps) {

    // Initialize custom scroll animations (AOS simulator)
    useScrollAnimation();

    // TanStack Decoupled Queries (Faza 5 - API-Ready Integration)
    // Using Inertia props as initialData for 100% SEO/SSR parity and dynamic client fetching
    const { data: servicesData } = useServices() as { data?: typeof main_services };
    const { data: portfolioData } = usePortfolio() as { data?: typeof portfolio_items };
    const { data: testimonialsData } = useTestimonials() as { data?: typeof testimonials };
    const { data: blogsData } = useBlogPosts() as { data?: typeof blogs };
    const { data: metricsData } = useMetrics() as any;

    // QuoteModal global state (E1 — Hero CTA-dan açılma)
    const [quoteOpen, setQuoteOpen] = useState(false);
    const [quoteSummary] = useState({
        platform: '—',
        service_id: null as number | null,
        scale: '—',
        timeline: '—',
        priceRange: '—',
    });
    const openQuote = () => setQuoteOpen(true);

    // Admin-controlled section visibility — 1:1 parity with Blade $sectionEnabled()
    const isEnabled = useSectionEnabled(content_text_map);

    // Translation helper
    const t = (key: string, fallback?: string): string => {
        const keys = key.split('.');
        let value: any = translations;
        for (const k of keys) {
            value = value?.[k];
        }
        return typeof value === 'string' ? value : (fallback ?? key);
    };

    const safeContentMap = content_text_map || {};
    const ct = (key: string, fallback?: string): string => {
        const val = safeContentMap[key];
        return typeof val === 'string' ? val : (fallback ?? key);
    };

    return (
        <ErrorBoundary>
        <ThemeProvider theme={theme}>
            <MainLayout title={t('meta_title', 'Chalang')}>
                <Head>
                    <title>{t('meta_title', 'Chalang - Qlobal İnnovasiya Agentliyi')}</title>
                    <meta name="description" content={t('meta_description', 'Chalang - Rəqəmsal həllər və innovasiya agentliyi')} />
                    <meta name="keywords" content={t('meta_keywords', 'chalang, veb sayt, mobil tətbiq, AI, süni intellekt, rəqəmsal marketinq, UI UX dizayn, Bakı, Azərbaycan')} />
                    <meta property="og:type" content="website" />
                    <meta property="og:title" content={t('meta_title', 'Chalang')} />
                    <meta property="og:description" content={t('meta_description', 'Chalang - Rəqəmsal həllər və innovasiya agentliyi')} />
                    {/* og:image — use SSR-safe relative path; server will resolve with APP_URL */}
                    <meta property="og:image" content="/assets/img/og-preview.jpg" />
                    <meta property="og:locale" content={locale} />
                    <meta property="twitter:card" content="summary_large_image" />
                    <meta property="twitter:title" content={t('meta_title', 'Chalang')} />
                    <meta property="twitter:description" content={t('meta_description', 'Chalang - Rəqəmsal həllər və innovasiya agentliyi')} />
                    <meta property="twitter:image" content="/assets/img/og-preview.jpg" />
                    <link rel="alternate" hrefLang="az" href="/lang/az" />
                    <link rel="alternate" hrefLang="en" href="/lang/en" />
                    <link rel="alternate" hrefLang="ru" href="/lang/ru" />
                    <link rel="alternate" hrefLang="x-default" href="/lang/az" />
                </Head>
                
                {/* SEO Structured Data */}
                <SchemaData 
                    locale={locale}
                    siteName={t('meta_title', 'Chalang')}
                    siteUrl={typeof window !== 'undefined' ? window.location.origin : 'https://chalang.az'}
                    description={t('meta_description', 'Chalang - Rəqəmsal həllər və innovasiya agentliyi')}
                    faqs={faq_items.map(faq => ({
                        question: faq.question || '',
                        answer: (faq.answer || '').replace(/<[^>]*>/g, '')
                    }))}
                    services={main_services.map(s => ({
                        name: s.name || '',
                        description: s.description || ''
                    }))}
                />
                
                <ScrollProgress />

                {/* ── 1. HERO ── */}
                <div data-star-waypoint="hero">
                    <Hero banner={banner} translations={translations} onOpenQuote={openQuote} partners={partners} />
                </div>
                <Marquee text={marquee_text} />
                <LazySection><Partners partners={partners} title={ct('preview.partners_title', 'Güvənilən tərəfdaşlarımız')} /></LazySection>

                {/* ── 2. ABOUT / WhoWeAre ── */}
                <LazySection><WhoWeAre about={{
                    title: ct('preview.about_title', 'Gələcəyi Yaradanlar'),
                    description: ct('preview.about_description', '<p>Chalang, brendlərin rəqəmsal dünyada parlamasına kömək edən yaradıcı agentlikdir.</p>'),
                    image: ct('preview.about_image', '/assets/media/about/about-1.png'),
                }} translations={translations} /></LazySection>

                {/* ── 2. ABOUT / WhoWeAre ── */}

                {/* ── 4. SERVICES ── */}
                <div data-star-waypoint="services">
                    <LazySection><Services services={servicesData || main_services} translations={translations} /></LazySection>
                </div>

                {/* ── 5. PORTFOLIO ── */}
                <LazySection><Portfolio items={portfolioData || portfolio_items} translations={translations} /></LazySection>

                {/* ── 6. PROCESS (admin-toggleable) ── */}
                {isEnabled('process') && (
                    <LazySection><Process steps={steps} translations={translations} contentTextMap={safeContentMap} /></LazySection>
                )}

                {/* ── 7. METRICS (admin-toggleable) ── */}
                {isEnabled('metrics') && (
                    <LazySection><Metrics
                        years={{ 
                            value: metricsData?.years?.value ?? ct('preview.metrics.years_value', '10'), 
                            label: metricsData?.years?.label ?? ct('preview.metrics.years', t('metrics.years', 'İllik Təcrübə')) 
                        }}
                        projects={{ 
                            value: metricsData?.projects?.value ?? ct('preview.metrics.projects_value', (portfolio_items?.length || 0).toString()), 
                            label: metricsData?.projects?.label ?? ct('preview.metrics.projects', t('metrics.projects', 'Uğurlu Layihələr')) 
                        }}
                        satisfaction={{ 
                            value: metricsData?.satisfaction?.value ?? ct('preview.metrics.satisfaction_value', '100'), 
                            label: metricsData?.satisfaction?.label ?? ct('preview.metrics.satisfaction', t('metrics.satisfaction', 'Müştəri Məmnuniyyəti')) 
                        }}
                        awards={{ 
                            value: metricsData?.awards?.value ?? ct('preview.metrics.awards_value', '5'), 
                            label: metricsData?.awards?.label ?? ct('preview.metrics.awards', t('metrics.awards', 'Beynəlxalq Mükafatlar')) 
                        }}
                    /></LazySection>
                )}

                {/* ── 8. TESTIMONIALS ── */}
                <LazySection><Testimonials testimonials={testimonialsData || testimonials} translations={translations} /></LazySection>

                {/* ── 9. ESTIMATOR (admin-toggleable) ── */}
                {isEnabled('estimator') && (
                    <div data-star-waypoint="estimator">
                        <LazySection><Estimator translations={translations} contentTextMap={safeContentMap} main_services={servicesData || main_services} /></LazySection>
                    </div>
                )}

                {/* ── 10. PRICING (admin-toggleable) ── */}
                {isEnabled('pricing') && (
                    <LazySection><Pricing plans={pricing_plans} translations={translations} /></LazySection>
                )}

                {/* ── FAQ ── */}
                <LazySection><Faq items={faq_items} translations={translations} /></LazySection>

                {/* ── BLOG ── */}
                <LazySection><Blog blogs={blogsData || blogs} translations={translations} locale={locale} siteUrl={typeof window !== 'undefined' ? window.location.origin : 'https://chalang.az'} /></LazySection>

                {/* ── CONTACT ── */}
                <div data-star-waypoint="contact">
                    <LazySection><Contact translations={translations} /></LazySection>
                </div>

                {/* ── TEAM ── */}
                <LazySection><TeamGrid members={team_members} translations={translations} /></LazySection>

                {/* ── HALL OF FAME ── */}
                <LazySection><HallOfFame items={(safeContentMap['preview.fame.items'] as any[]) || []} caseStudies={case_studies} translations={translations} /></LazySection>

                {/* ── TECH STACK (admin-toggleable) ── */}
                {isEnabled('tech_stack') && (
                    <LazySection><TechStack items={(safeContentMap['preview.tech_stack.items'] as any[]) || []} /></LazySection>
                )}

                {/* ── LEAD MAGNET (admin-toggleable) ── */}
                {isEnabled('lead_magnet') && (
                    <LazySection><LeadMagnet translations={translations} /></LazySection>
                )}

                {/* ── MOBILE STICKY CTA ── */}
                <MobileStickyCTA label={t('btn_start', 'Start Project')} href="#contact" />

                {/* ── AI WIDGET ── */}
                <LazySection><AIWidget translations={translations} /></LazySection>

                {/* ── NEWSLETTER POPUP ── */}
                {isEnabled('newsletter_popup') && (
                    <LazySection><NewsletterPopup translations={translations} /></LazySection>
                )}

                {/* ── QUOTE MODAL — Global (E1: Hero CTA-dan açılır) ── */}
                <QuoteModal
                    isOpen={quoteOpen}
                    onClose={() => setQuoteOpen(false)}
                    summaryData={quoteSummary}
                    translations={translations}
                />
            </MainLayout>
        </ThemeProvider>
        </ErrorBoundary>
    );
}
