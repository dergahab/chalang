import React from 'react';
import Tilt from 'react-parallax-tilt';
import { Link } from '@inertiajs/react';
import { Translations } from '@/types';

interface WhoWeAreProps {
    about: {
        title: string;
        description: string;
        image?: string;
    };
    translations: Translations;
}

function sanitizeHtml(html: string): string {
    return html
        .replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, '')
        .replace(/\bon\w+\s*=\s*"[^"]*"/gi, '')
        .replace(/\bon\w+\s*=\s*'[^']*'/gi, '')
        .replace(/javascript\s*:/gi, '');
}

const WhoWeAre: React.FC<WhoWeAreProps> = ({ about, translations }) => {
    const t = (key: string, fallback: string): string => {
        const keys = key.split('.');
        let value: any = translations;
        for (const k of keys) {
            value = value?.[k];
        }
        return typeof value === 'string' ? value : fallback;
    };

    return (
        <section className="relative py-24 overflow-hidden bg-white/30 dark:bg-transparent" aria-labelledby="who-we-are-heading">
            {/* Background Orbs */}
            <div className="absolute top-0 left-0 w-[500px] h-[500px] bg-brand-primary/5 rounded-full blur-[120px] -z-10 pointer-events-none"></div>
            <div className="absolute bottom-0 right-0 w-[400px] h-[400px] bg-brand-secondary/5 rounded-full blur-[100px] -z-10 pointer-events-none"></div>

            <div className="max-w-7xl mx-auto px-6 relative z-10">
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    {/* Visual Column */}
                    <div className="order-2 lg:order-1 relative" data-aos="fade-right">
                        <Tilt className="glass-card-premium" perspective={1000} scale={1.02} transitionSpeed={2000}>
                            <div className="bg-white/60 dark:bg-[#0b0f19]/50 backdrop-blur-2xl border border-white/50 dark:border-white/10 p-4 rounded-[40px] shadow-2xl relative overflow-hidden group">
                                <div className="absolute inset-0 bg-gradient-to-br from-brand-primary/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div className="relative aspect-[4/3] rounded-[30px] overflow-hidden shadow-inner">
                                    <img 
                                        src={about?.image || '/assets/media/about/about-1.png'} 
                                        alt="Who We Are" loading="lazy" decoding="async"
                                        className="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-1000" 
                                    />
                                </div>
                                
                                {/* Floating Badge */}
                                <div className="absolute bottom-10 right-10 bg-white/80 dark:bg-[#111827]/80 backdrop-blur-md border border-white/20 p-6 rounded-2xl shadow-xl transform translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-500 hidden md:block">
                                    <span className="block text-2xl font-bold text-brand-primary">100%</span>
                                    <span className="text-xs font-semibold text-text-sub uppercase tracking-widest">{t('who_we_are.badge_title', 'Quality Focus')}</span>
                                </div>
                            </div>
                        </Tilt>
                    </div>

                    {/* Content Column */}
                    <div className="order-1 lg:order-2" data-aos="fade-left">
                        <div className="mb-8">
                            <div className="inline-flex items-center gap-3 px-4 py-1.5 rounded-full bg-brand-primary/10 border border-brand-primary/20 mb-6 group cursor-default">
                                <span className="w-2 h-2 rounded-full bg-brand-primary animate-pulse"></span>
                                <span className="text-xs font-bold text-brand-primary tracking-widest uppercase">
                                    {t('who_we_are.label', 'BİZ KİMİK')}
                                </span>
                            </div>
                            
                            <h2 id="who-we-are-heading" className="text-h2 mb-8">
                                {about?.title || t('who_we_are.title', 'Gələcəyi Yaradanlar')}
                            </h2>
                            
                            <div 
                                className="text-text-sub text-lg leading-relaxed mb-10 opacity-90"
                                dangerouslySetInnerHTML={{__html: sanitizeHtml(about?.description || '<p>Chalang, brendlərin rəqəmsal dünyada parlamasına kömək edən yaradıcı agentlikdir.</p>')}}
                            />
                            
                            <div className="flex flex-col sm:flex-row items-center gap-6">
                                <Link 
                                    href="/preview/about-us" 
                                    className="magnet-btn px-8 py-4 bg-brand-primary text-white font-bold rounded-full hover:bg-brand-secondary hover:shadow-lg hover:shadow-brand-secondary/30 transition-all duration-300 w-full sm:w-auto text-center flex items-center justify-center group"
                                >
                                    {t('who_we_are.btn_more', 'Daha ətraflı')}
                                    <svg className="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </Link>
                                
                                <div className="flex items-center gap-4">
                                    <div className="flex -space-x-3">
                                        {[1, 2, 3].map(i => (
                                            <div key={i} className="w-10 h-10 rounded-full border-2 border-white dark:border-[#0b0f19] overflow-hidden bg-brand-primary/20">
                                                <img src={`/assets/media/team/team-${i}.png`} alt="Member" loading="lazy" decoding="async" className="w-full h-full object-cover" />
                                            </div>
                                        ))}
                                    </div>
                                    <div className="text-sm font-medium text-text-sub">
                                        <span className="text-text-main font-bold block">{t('who_we_are.client_count', '50+ Müştəri')}</span>
                                        {t('who_we_are.client_text', 'Bəyənisi qazandıq')}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Quick Stats Grid */}
                        <div className="grid grid-cols-2 gap-4 mt-12 pt-8 border-t border-black/5 dark:border-white/5">
                            <div className="flex flex-col">
                                <span className="text-3xl font-bold text-text-main">5+</span>
                                <span className="text-sm text-text-sub">{t('who_we_are.stats_years', 'İllik Təcrübə')}</span>
                            </div>
                            <div className="flex flex-col">
                                <span className="text-3xl font-bold text-text-main">200+</span>
                                <span className="text-sm text-text-sub">{t('who_we_are.stats_projects', 'Uğurlu Layihə')}</span>
                            </div>
                        </div>

                        {/* Core Values */}
                        <div className="grid grid-cols-2 gap-4 mt-8">
                            <div className="p-4 rounded-2xl bg-brand-primary/5 border border-brand-primary/10 hover:border-brand-primary/30 transition-colors">
                                <h4 className="text-sm font-bold text-text-main mb-1">{t('who_we_are.val_innovative', 'İnnovasiya')}</h4>
                                <p className="text-xs text-text-sub">{t('who_we_are.val_innovative_desc', 'Həmişə bir addım öndə.')}</p>
                            </div>
                            <div className="p-4 rounded-2xl bg-brand-secondary/5 border border-brand-secondary/10 hover:border-brand-secondary/30 transition-colors">
                                <h4 className="text-sm font-bold text-text-main mb-1">{t('who_we_are.val_trusted', 'Etibar')}</h4>
                                <p className="text-xs text-text-sub">{t('who_we_are.val_trusted_desc', 'Şəffaf əməkdaşlıq.')}</p>
                            </div>
                        </div>


                    </div>
                </div>

                {/* Founder Mini Section */}
                <div className="mt-24 p-8 md:p-12 rounded-[40px] bg-gradient-to-br from-brand-primary/5 via-transparent to-brand-secondary/5 border border-white/20 relative overflow-hidden group">
                    <div className="absolute -right-20 -top-20 w-64 h-64 bg-brand-primary/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                    <div className="flex flex-col md:flex-row items-center gap-10 relative z-10">
                        <div className="w-24 h-24 rounded-full border-4 border-brand-primary/30 overflow-hidden shrink-0 shadow-xl">
                            <img src="/assets/media/team/team-1.png" alt="CEO" loading="lazy" decoding="async" className="w-full h-full object-cover" />
                        </div>
                        <div className="flex-grow text-center md:text-left">
                            <blockquote className="text-xl md:text-2xl font-medium text-text-main italic mb-4 leading-relaxed">
                                {t('who_we_are.quote', '"Biz sadəcə kod yazmırıq, biz gələcəyin rəqəmsal ekosistemini dizayn edirik."')}
                            </blockquote>
                            <div className="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
                                <span className="text-brand-primary font-bold">{t('who_we_are.quote_author', 'Cavidan Dadaşov')}</span>
                                <span className="hidden md:block w-1 h-1 rounded-full bg-text-sub opacity-50"></span>
                                <span className="text-text-sub text-sm uppercase tracking-widest font-semibold">{t('who_we_are.quote_role', 'Founder & Lead Architect')}</span>
                            </div>
                        </div>
                        <Link 
                            href="#contact" 
                            className="magnet-btn px-6 py-3 bg-white dark:bg-white/5 border border-brand-primary/20 text-text-main rounded-xl hover:bg-brand-primary hover:text-white transition-all duration-300 font-bold text-sm whitespace-nowrap"
                        >
                            {t('who_we_are.quote_cta', 'Məsləhət al')}
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    );
};

export default WhoWeAre;
