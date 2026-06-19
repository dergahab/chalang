import React from 'react';
import { Link } from '@inertiajs/react';
import Tilt from 'react-parallax-tilt';
import type { Translations } from '@/types';

interface ServicesProps {
    services: any[];
    translations: Translations;
    loading?: boolean;
}

// Skeleton loader component
const ServicesSkeleton = () => (
    <section className="py-20 px-5 relative" id="services">
        <div className="skeleton-header">
            <div className="h-12 w-64 bg-gray-200 dark:bg-gray-700 rounded-lg mx-auto mb-4 animate-pulse" />
            <div className="h-6 w-96 bg-gray-200 dark:bg-gray-700 rounded-lg mx-auto animate-pulse" />
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-[1300px] mx-auto mt-12">
            {[1, 2, 3, 4].map((i) => (
                <div
                    key={i}
                    className="backdrop-blur-xl bg-white/60 dark:bg-brand-surface/60 border border-ui-border rounded-3xl p-8"
                    style={{ height: '320px' }}
                >
                    <div className="flex flex-col h-full">
                        <div className="w-[60px] h-[60px] rounded-2xl bg-gray-200 dark:bg-gray-700 mb-6 animate-pulse" />
                        <div className="h-8 w-48 bg-gray-200 dark:bg-gray-700 rounded-lg mb-4 animate-pulse" />
                        <div className="h-4 w-full bg-gray-200 dark:bg-gray-700 rounded mb-2 animate-pulse" />
                        <div className="h-4 w-3/4 bg-gray-200 dark:bg-gray-700 rounded mb-2 animate-pulse" />
                        <div className="h-4 w-1/2 bg-gray-200 dark:bg-gray-700 rounded animate-pulse" style={{ marginTop: 'auto' }} />
                    </div>
                </div>
            ))}
        </div>
    </section>
);

export default function Services({ services, translations, loading = false }: ServicesProps) {
    // Show skeleton when loading
    // DB-den data gelmirse skeleton goster (avtomatik)
    if (!services || services.length === 0) {
        return <ServicesSkeleton />;
    }

    const defaultServices = services;

    const t = (key: string, fallback: string) => {
        const keys = key.split('.');
        let val: any = translations;
        for (const k of keys) {
            val = val?.[k];
        }
        return typeof val === 'string' ? val : fallback;
    };

    return (
        <section className="py-20 px-5 relative" id="services">
            <h2 className="text-3xl md:text-5xl font-bold text-center text-text-main mb-4 reveal-text">{t('sec_services_title', 'Nələr edirik?')}</h2>
            <p className="text-lg text-center text-text-sub mb-12">{t('sec_services_sub', 'Biznesinizi onlayn mühitdə böyütmək üçün xidmətlər')}</p>

            <style dangerouslySetInnerHTML={{__html: `
                .ticker-horizontal-wrapper {
                    overflow: hidden;
                    width: 100%;
                    mask-image: linear-gradient(90deg, transparent 0%, #000 10%, #000 90%, transparent 100%);
                    -webkit-mask-image: linear-gradient(90deg, transparent 0%, #000 10%, #000 90%, transparent 100%);
                }
                .ticker-horizontal-track {
                    display: flex;
                    gap: 10px;
                    width: max-content;
                    animation: serviceTicker 60s linear infinite !important;
                }
                .ticker-pill {
                    white-space: nowrap;
                }
                @keyframes serviceTicker {
                    0% { transform: translateX(0); }
                    100% { transform: translateX(-50%); }
                }
            `}} />

            <div className="grid grid-cols-1 md:grid-cols-2 gap-6 crease-safe max-w-[1300px] mx-auto">
                {defaultServices.map((service, index) => {
                    
                    const childNames = service.childs ? service.childs.map((c: any) => c.name || c) : [];
                    const tickerItems = childNames.length > 0 ? childNames : [];

                    return (
                        <Tilt
                            key={service.id || index}
                            tiltMaxAngleX={1}
                            tiltMaxAngleY={1}
                            perspective={2000}
                            transitionSpeed={1000}
                            scale={1}
                            glareEnable={false}
                            className="h-full"
                            style={{ height: '100%' }}
                        >
                            <div className="flex flex-col h-full backdrop-blur-xl bg-white/60 dark:bg-brand-surface/60 border border-ui-border rounded-3xl p-8 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl group">
                                <div className="flex-grow flex flex-col">
                                    <div className="w-[60px] h-[60px] rounded-2xl bg-brand-primary/10 flex items-center justify-center mb-6 shrink-0">
                                        {typeof service.icon === 'string' ? (
                                            service.icon.startsWith('icon') ? (
                                                <img src={`/assets/media/icon/${service.icon}`} alt={service.name} className="brightness-0 invert-[0.25] dark:invert w-[30px] h-[30px]" />
                                            ) : (service.icon.includes('.') || service.icon.includes('/')) ? (
                                                <img src={service.icon.startsWith('http') ? service.icon : (service.icon.startsWith('/') ? service.icon : `/storage/${service.icon}`)} alt={service.name} className="brightness-0 invert-[0.25] dark:invert w-[30px] h-[30px]" />
                                            ) : (
                                                <span>{service.icon}</span>
                                            )
                                        ) : (
                                            <span>🚀</span>
                                        )}
                                    </div>
                                    <h3 className="text-2xl font-bold text-text-main mb-4">{service.name}</h3>
                                    <p className="text-text-sub font-medium opacity-90 leading-relaxed">
                                        {service.description && service.description.length > 5 ? (service.description.length > 110 ? service.description.substring(0, 110) + '...' : service.description) : ''}
                                    </p>

                                    {/* Decorative Ticker */}
                                    <div className="ticker-horizontal-wrapper" style={{ marginTop: 'auto' }}>
                                        <div className="ticker-horizontal-track group-hover:[animation-play-state:paused]">
                                            {tickerItems.map((item: string, i: number) => (
                                                <span key={`t1-${i}`} className="ticker-pill">{item}</span>
                                            ))}
                                            {/* Duplicates for seamless loop */}
                                            {tickerItems.map((item: string, i: number) => (
                                                <span key={`t2-${i}`} className="ticker-pill">{item}</span>
                                            ))}
                                        </div>
                                    </div>
                                </div>

                                <div className="mt-8 pt-6 border-t border-ui-border">
                                    {service.slug ? (
                                        <Link
                                            href={`/preview/service-detail/${service.slug}`}
                                            className="inline-flex items-center justify-center h-[48px] px-6 rounded-full bg-brand-primary/10 text-brand-primary font-bold hover:bg-brand-primary hover:text-white transition-all duration-300 group-hover:translate-x-2 gap-2"
                                        >
                                            {t('btn_detail', 'Ətraflı')}{' '}
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                                            </svg>
                                        </Link>
                                    ) : (
                                        <a href="#" className="inline-flex items-center justify-center h-[48px] px-6 rounded-full bg-brand-primary/10 text-brand-primary font-bold hover:bg-brand-primary hover:text-white transition-all duration-300 group-hover:translate-x-2 gap-2">
                                            {t('btn_detail', 'Ətraflı')}{' '}
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                                            </svg>
                                        </a>
                                    )}
                                </div>
                            </div>
                        </Tilt>
                    );
                })}
            </div>
        </section>
    );
}
