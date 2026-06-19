import React, { useState } from 'react';
import type { Translations } from '@/types';

interface PricingPlan {
    id: number;
    name: string;
    description: string;
    price_monthly: string | number;
    price_yearly: string | number;
    is_popular: boolean;
    features: string[];
    cta_text?: string;
    cta_link?: string;
}

interface PricingProps {
    plans?: PricingPlan[];
    translations: Translations;
}

export default function Pricing({ plans = [], translations }: PricingProps) {
    const [isYearly, setIsYearly] = useState(false);

    const t = (key: string, fallback?: string): string => {
        const keys = key.split('.');
        let value: any = translations;
        for (const k of keys) {
            value = value?.[k];
        }
        return typeof value === 'string' ? value : (fallback ?? key);
    };

    const defaultPlans: PricingPlan[] = [
        {
            id: 1,
            name: 'Start',
            description: 'Yeni başlayanlar üçün sürətli başlanğıc paketi.',
            price_monthly: 499,
            price_yearly: 399,
            is_popular: false,
            features: ['Əsas səhifə + 3 daxili səhifə', 'Basic SEO setup', 'Kontakt formu'],
        },
        {
            id: 2,
            name: 'Growth',
            description: 'Böyümək istəyən bizneslər üçün balanslı paket.',
            price_monthly: 999,
            price_yearly: 799,
            is_popular: true,
            features: ['8-12 səhifə', 'Konversiya blokları', 'Blog və analitika', 'Prioritetli dəstək'],
        },
        {
            id: 3,
            name: 'Enterprise',
            description: 'Böyük miqyaslı layihələr üçün fərdi korporativ həll.',
            price_monthly: 'Əlaqə',
            price_yearly: 'Əlaqə',
            is_popular: false,
            features: ['Limitsiz səhifə', 'Fərdi inteqrasiyalar', 'SLA zəmanəti', 'Dedicated menecer', '24/7 prioritet dəstək'],
            cta_text: 'Əlaqə saxlayın',
            cta_link: '#contact',
        }
    ];

    const displayPlans = (plans && plans.length > 0) ? plans : defaultPlans;

    return (
        <section className="py-20 md:py-28 lg:py-36 text-center bg-transparent border-t border-[var(--card-border)]" id="pricing">
            <div className="max-w-container mx-auto px-4 sm:px-6 lg:px-8">
                <h2 className="text-3xl md:text-5xl font-bold text-center text-text-main mb-4">
                    {t('pricing.title', 'Sizə Uyğun Paketi Seçin')}
                </h2>
                <p className="text-lg text-center text-text-sub mb-12 max-w-2xl mx-auto">
                    {t('pricing.subtitle', 'Şəffaf və çevik qiymət planları')}
                </p>

                <div className="flex justify-center items-center gap-5 mb-12 text-lg">
                    <span className="font-semibold" style={{ opacity: isYearly ? 0.5 : 1 }}>{t('pricing.monthly', 'Aylıq')}</span>
                    <label className="relative inline-block w-[56px] h-[28px] cursor-pointer">
                        <input type="checkbox" className="sr-only" checked={isYearly} onChange={() => setIsYearly(!isYearly)} />
                        <span className={`absolute inset-0 rounded-full transition-colors duration-300 border ${isYearly ? 'bg-brand-primary border-brand-primary' : 'bg-black/10 dark:bg-white/10 border-black/10 dark:border-white/10'}`}>
                            <span className={`absolute top-[3px] left-[3px] w-[22px] h-[22px] bg-white rounded-full shadow-md transition-transform duration-300 ${isYearly ? 'translate-x-[28px]' : ''}`}></span>
                        </span>
                    </label>
                    <span className="font-semibold" style={{ opacity: isYearly ? 1 : 0.5 }}>
                        {t('pricing.yearly', 'İllik')} 
                        <span className="bg-green-500 text-white px-2 py-0.5 rounded-full text-xs ml-2 font-bold">-{t('pricing.discount', '20%')}</span>
                    </span>
                </div>

                <div className="flex flex-wrap justify-center gap-8">
                    {displayPlans.map((plan) => (
                        <div key={plan.id} className={`p-10 rounded-[var(--radius-card,24px)] relative flex flex-col transition-all duration-300 bg-[var(--card-bg)] border border-[var(--card-border)] max-w-sm w-full ${plan.is_popular ? 'md:scale-105 shadow-2xl border-2 border-brand-primary shadow-brand-primary/15' : ''} ${plan.name === 'Enterprise' ? 'border-2 border-dashed border-brand-secondary/50 hover:border-brand-secondary' : ''}`}>
                            {plan.is_popular && (
                                <div className="absolute -top-4 left-1/2 -translate-x-1/2 bg-brand-gradient text-white px-6 py-2 rounded-full text-sm font-extrabold tracking-[1.5px] whitespace-nowrap shadow-lg border-2 border-white dark:border-[var(--card-bg)]">
                                    {t('pricing.best_seller', 'ƏN ÇOX SEÇİLƏN')}
                                </div>
                            )}
                            <h3 className="text-2xl mb-5 text-text-main">{plan.name}</h3>
                            <div className="mb-6">
                                {typeof (isYearly ? plan.price_yearly : plan.price_monthly) === 'string' ? (
                                    <span className="text-[2rem] font-extrabold text-text-main">{t('pricing.custom', 'Fərdi')}</span>
                                ) : (
                                    <>
                                        <span className="text-2xl text-brand-primary font-bold align-top mr-0.5">{t('pricing.currency', '₼')}</span>
                                        <span className="text-[3.5rem] font-extrabold text-text-main">{isYearly ? plan.price_yearly : plan.price_monthly}</span>
                                        <span className="text-text-sub text-base">/{isYearly ? t('pricing.year_short', 'il') : t('pricing.month_short', 'ay')}</span>
                                    </>
                                )}
                            </div>
                            <p className="text-text-sub mb-8 leading-relaxed min-h-[50px]">{plan.description}</p>
                            <ul className="list-none p-0 m-0 text-left flex-grow mb-10">
                                {plan.features.map((feature, i) => (
                                    <li key={i} className="flex items-center gap-3 py-3 text-text-main border-b border-[var(--card-border)]">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3" strokeLinecap="round" strokeLinejoin="round" className="text-brand-secondary flex-shrink-0">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        {feature}
                                    </li>
                                ))}
                            </ul>
                            <a href={plan.cta_link || '#contact'} className={`block py-4 rounded-[var(--radius-btn,12px)] font-bold no-underline transition-all duration-300 text-center ${plan.is_popular ? 'bg-brand-gradient text-white shadow-lg hover:-translate-y-0.5' : 'bg-[var(--card-bg)] border-2 border-[var(--card-border)] text-text-main hover:border-brand-primary'}`}>
                                {plan.cta_text || t('pricing.cta', 'Başla')}
                            </a>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
