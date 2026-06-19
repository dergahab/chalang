import { Link, useForm, usePage } from '@inertiajs/react';
import React, { useState } from 'react';
import type { Translations } from '@/types';

type AnyObj = Record<string, unknown>;

export default function Footer() {
    const { props } = usePage<any>();
    const main_services = props.main_services || [];
    const socialmedia = props.social_media || props.socialmedia || [];
    const translations = props.translations || {};

    // footer source-of-truth key (preview route)
    const t = (suffix: string, fallback: string): string => {
        const previewPath = `preview.footer.${suffix}`;
        const frontPath = `front.footer.${suffix}`;

        const get = (path: string) => {
            const keys = path.split('.');
            let value: any = translations;
            for (const k of keys) value = value?.[k];
            return typeof value === 'string' ? value : undefined;
        };

        return get(previewPath) ?? get(frontPath) ?? fallback;
    };

    const slugify = (value: string) =>
        String(value || '')
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\u00C0-\u024f\u0400-\u04FF\s-]/gi, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');

    const { data, setData, post, processing, reset } = useForm({
        mail: '',
    });

    const [subscribeError, setSubscribeError] = useState('');

    const handleSubscribe = (e: React.FormEvent) => {
        e.preventDefault();
        setSubscribeError('');

        post('/subscribe', {
            preserveScroll: true,
            onSuccess: () => {
                reset('mail');
            },
            onError: (errors: AnyObj) => {
                const firstError = Object.values(errors || {})[0];
                setSubscribeError(typeof firstError === 'string' ? firstError : '');
            },
        });
    };

    const currentYear = new Date().getFullYear();

    return (
        <footer className="relative border-t border-[var(--card-border)] overflow-hidden" style={{ backgroundColor: 'var(--footer-bg)' }}>
            <div className="max-w-container mx-auto px-4 sm:px-6 lg:px-8">
                <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 py-16 md:py-20">
                    {/* Column 1: Logo + About + Social */}
                    <div data-sal="slide-up" data-sal-duration="800" data-sal-delay="100" className="flex flex-col gap-6">
                        <Link href="/" aria-label="Chalang" className="text-brand-primary dark:text-brand-primary inline-block">
                            <svg className="h-8 w-auto fill-current" viewBox="0 0 81.87 15.74">
                                <g>
                                    <path fill="currentColor" d="M25.7,5.95c-.49-.62-1.3-1.22-2.46-1.22-1.96,0-3.33,1.59-3.33,3.31,0,1.84,1.46,3.38,3.34,3.38.87,0,1.75-.34,2.36-1.14h2.11c-.81,1.72-2.38,2.9-4.52,2.9-3.43,0-5.1-2.89-5.1-5.14s1.66-5.07,5.13-5.07c2.03,0,3.72,1.1,4.54,2.98h-2.07Z" />
                                    <path fill="currentColor" d="M28.72,3.14h1.82v3.93h3.58v-3.93h1.82v9.8h-1.82v-4.11h-3.58v4.11h-1.82V3.14Z" />
                                    <path fill="currentColor" d="M40.67,3.14h1.46l4.08,9.8h-2l-1.01-2.53h-3.6l-1.01,2.53h-2l4.08-9.8ZM42.51,8.65l-1.11-2.86-1.11,2.86h2.23Z" />
                                    <path fill="currentColor" d="M46.89,3.14h1.82v8.04h2.99v1.76h-4.81V3.14Z" />
                                    <path fill="currentColor" d="M56.09,3.14h1.46l4.08,9.8h-2l-1.01-2.53h-3.6l-1.01,2.53h-2l4.08-9.8ZM57.93,8.65l-1.11-2.86-1.11,2.86h2.23Z" />
                                    <path fill="currentColor" d="M62.3,3.14h1.82l4.37,6.62V3.14h1.82v9.8h-1.82l-4.37-6.62v6.62h-1.82V3.14Z" />
                                    <path fill="currentColor" d="M81.87,7.95c-.03,2.33-1.46,5.23-5.21,5.23s-5.23-2.72-5.23-5.07,1.78-5.14,5.21-5.14c2.25,0,4.01,1.14,4.74,3.06h-2.17c-.76-1.25-2.11-1.3-2.57-1.3-2.29,0-3.39,1.78-3.39,3.31,0,1.67,1.22,3.38,3.47,3.38,1.19,0,2.33-.54,2.86-1.76h-4.09v-1.71h6.39Z" />
                                    <path fill="currentColor" d="M8.88.03C3.91-.37-.27,3.73.01,8.7c.18,3.15,2.14,5.82,4.88,7.04.02,0,.04-.02.03-.03-.22-.3-.35-.68-.35-1.08,0-.87.6-1.6,1.41-1.8.02,0,.02-.03,0-.04-1.88-.92-3.1-2.96-2.8-5.26.27-2.08,2.21-4.04,4.29-4.34,3.14-.44,5.82,1.98,5.82,5.03,0,2-1.16,3.74-2.85,4.56-.02,0-.02.04,0,.04.81.2,1.41.93,1.41,1.8,0-.4-.13.77-.34, 1.08-.01.02,0,.04.03.03,2.88-1.28,4.89-4.16,4.89-7.52C16.44,3.9,13.11.36,8.88.03Z" />
                                </g>
                            </svg>
                        </Link>
                        <p className="text-text-sub text-sm leading-relaxed max-w-[280px]">
                            {t('company_desc', 'Biznesinizi gələcəyə daşımaq üçün strategiya, dizayn və texnologiyanı birləşdiririk.')}
                        </p>
                        {/* Desktop Socials */}
                        <ul className="flex gap-3 list-none p-0 m-0 mt-2 hidden sm:flex">
                            {socialmedia.map((media: any) => (
                                <li key={media?.id ?? media?.link}>
                                    <a
                                        href={media?.link}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="w-10 h-10 flex items-center justify-center rounded-full bg-[var(--bg-primary)] border border-[var(--card-border)] text-text-sub hover:text-white hover:bg-brand-primary hover:border-brand-primary transition-all duration-300"
                                    >
                                        <i className={media?.icon}></i>
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </div>

                    {/* Column 2: Services */}
                    <div data-sal="slide-up" data-sal-duration="800" data-sal-delay="200">
                        <h6 className="text-sm font-bold uppercase tracking-widest text-text-main mb-6">{t('services', 'Xidmətlər')}</h6>
                        <ul className="list-none p-0 m-0 space-y-3">
                            {main_services.map((service: any) => {
                                const name = service?.name || '';
                                const anchor = `${slugify(name)}-${service?.id}`;
                                return (
                                    <li key={service?.id}>
                                        <Link href={`/preview/services#${anchor}`} className="text-text-sub hover:text-brand-primary transition-colors text-sm">{name}</Link>
                                    </li>
                                );
                            })}
                        </ul>
                    </div>

                    {/* Column 3: Company */}
                    <div data-sal="slide-up" data-sal-duration="800" data-sal-delay="300">
                        <h6 className="text-sm font-bold uppercase tracking-widest text-text-main mb-6">{t('company', 'Şirkət')}</h6>
                        <ul className="list-none p-0 m-0 space-y-3">
                            <li><Link href="/preview/about-us" className="text-text-sub hover:text-brand-primary transition-colors text-sm">{t('about_us', 'Haqqımızda')}</Link></li>
                            <li><Link href="/preview/team" className="text-text-sub hover:text-brand-primary transition-colors text-sm">{t('team', 'Komanda')}</Link></li>
                            <li><Link href="/preview/blogs" className="text-text-sub hover:text-brand-primary transition-colors text-sm">{t('blog', 'Bloq')}</Link></li>
                            <li><Link href="/preview/careers" className="text-text-sub hover:text-brand-primary transition-colors text-sm">{t('careers', 'Karyera')}</Link></li>
                            <li><Link href="/preview/portfolio" className="text-text-sub hover:text-brand-primary transition-colors text-sm">{t('portfolio', 'İşlərimiz')}</Link></li>
                        </ul>
                    </div>

                    {/* Column 4: Newsletter & Contact */}
                    <div data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                        <h6 className="text-sm font-bold uppercase tracking-widest text-text-main mb-6">{t('newsletter', 'Yeniliklər')}</h6>
                        <p className="text-text-sub text-sm mb-4">{t('get_in_touch_desc', 'Yeniliklər və təkliflər üçün abunə olun.')}</p>
                        <form onSubmit={handleSubscribe} className="mb-6">
                            <div className="flex flex-col gap-2">
                                <input
                                    type="email"
                                    className="w-full px-4 py-3 rounded-xl bg-[var(--bg-primary)] border border-[var(--card-border)] text-[var(--text-main)] placeholder:text-[var(--text-sub)] focus:outline-none focus:ring-2 focus:ring-brand-primary/30 focus:border-brand-primary transition-all disabled:opacity-60 text-sm"
                                    name="mail"
                                    value={data.mail}
                                    onChange={(e) => setData('mail', e.target.value)}
                                    placeholder={t('subscribe_placeholder', 'E-poçt ünvanınız')}
                                    required
                                    disabled={processing}
                                />
                                <button className="w-full px-4 py-3 rounded-xl font-bold text-white bg-brand-gradient hover:-translate-y-1 transition-all duration-300 shadow-lg disabled:opacity-60 text-sm" type="submit" disabled={processing}>
                                    {t('subscribe_button', 'Abunə ol')}
                                </button>
                            </div>
                            {subscribeError && (
                                <div className="mt-2.5 text-red-400 text-xs" role="alert">✕ {subscribeError}</div>
                            )}
                        </form>
                        
                        <div className="mt-6 pt-6 border-t border-[var(--card-border)]">
                            <Link href="/preview/contact" className="inline-flex items-center gap-2 text-brand-primary font-bold hover:text-brand-secondary transition-colors group">
                                {t('discuss_project', 'Layihənizi müzakirə edək')}
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" className="group-hover:translate-x-1 transition-transform">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M5 12h14m-7-7l7 7-7 7" />
                                </svg>
                            </Link>
                        </div>
                    </div>
                </div>

                <div className="border-t border-[var(--card-border)] py-8 flex flex-col items-center gap-5" data-sal="slide-up" data-sal-duration="500" data-sal-delay="100" style={{ paddingBottom: '80px' }}>
                    <ul className="flex justify-center gap-4 list-none p-0 m-0">
                        {socialmedia.map((media: any) => (
                            <li key={media?.id ?? media?.link}>
                                <a
                                    href={media?.link}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="w-10 h-10 flex items-center justify-center rounded-full bg-[var(--card-bg)] border border-[var(--card-border)] text-text-sub hover:text-brand-primary hover:border-brand-primary transition-all duration-200"
                                    data-sal="slide-up"
                                    data-sal-duration="500"
                                    data-sal-delay="100"
                                >
                                    <i className={media?.icon}></i>
                                </a>
                            </li>
                        ))}
                    </ul>
                    <div className="flex items-center gap-2">
                        <div className="flex items-center gap-2 text-text-sub text-sm">
                            <span className="w-2 h-2 rounded-full bg-green-500 animate-pulse" aria-hidden="true"></span>
                            <span>{t('live_status', 'Canlı status')}</span>
                        </div>
                    </div>
                    <span className="text-text-sub text-sm">
                        &copy; {currentYear}. {t('all_rights_reserved', 'Bütün hüquqlar qorunur')}.
                    </span>
                </div>
            </div>
        </footer>
    );
}
