import React from 'react';
import { motion } from 'framer-motion';
import type { Translations } from '@/types';

export default function CTASection({ translations }: { translations: Translations }) {
    const t = (key: string, fallback: string) => {
        const keys = key.split('.');
        let val: any = translations;
        for (const k of keys) {
            val = val?.[k];
        }
        return typeof val === 'string' ? val : fallback;
    };

    return (
        <section className="py-20 px-5 max-w-[1200px] mx-auto relative overflow-hidden">
            <motion.div
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ duration: 0.6 }}
                className="p-10 md:p-16 rounded-3xl text-center relative z-10"
                style={{
                    background: 'var(--brand-gradient, linear-gradient(135deg, var(--brand-primary), var(--brand-secondary)))',
                    color: '#ffffff',
                }}
            >
                <h2 className="text-3xl md:text-5xl font-bold mb-6">
                    {t('cta.title', 'Hədəflərinizə nail olmağa hazırsınız?')}
                </h2>
                <p className="text-lg md:text-xl max-w-2xl mx-auto mb-10 opacity-90">
                    {t('cta.subtitle', 'Bizimlə əlaqə saxlayın və layihənizi necə reallaşdıra biləcəyimizi müzakirə edək.')}
                </p>
                <button
                    onClick={() => {
                        const contactEl = document.getElementById('contact');
                        if (contactEl) {
                            contactEl.scrollIntoView({ behavior: 'smooth' });
                        }
                    }}
                    className="inline-block px-8 py-4 rounded-full font-bold text-lg transition-transform hover:scale-105 active:scale-95 cursor-pointer border-0"
                    style={{
                        background: '#ffffff',
                        color: 'var(--brand-primary)',
                    }}
                >
                    {t('cta.button', 'İndi Başla')}
                </button>

                {/* Dekorativ arxa fon effektləri */}
                <div className="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none" />
                <div className="absolute bottom-0 left-0 w-48 h-48 bg-black opacity-10 rounded-full blur-2xl translate-y-1/2 -translate-x-1/2 pointer-events-none" />
            </motion.div>
        </section>
    );
}
