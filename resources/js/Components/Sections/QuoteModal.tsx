import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import type { Translations } from '@/types';

interface QuoteModalProps {
    isOpen: boolean;
    onClose: () => void;
    summaryData: {
        platform: string;
        service_id: number | null;
        scale: string;
        timeline: string;
        priceRange: string;
    };
    translations: Translations;
}

export default function QuoteModal({ isOpen, onClose, summaryData, translations }: QuoteModalProps) {
    const [step, setStep] = useState(1);
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [isSuccess, setIsSuccess] = useState(false);
    const [error, setError] = useState('');
    const [honeypot, setHoneypot] = useState('');
    const [formData, setFormData] = useState({ name: '', phone: '', email: '' });

    useEffect(() => {
        if (isOpen) setStep(1);
    }, [isOpen]);

    const t = (key: string, fb: string) => {
        const keys = key.split('.');
        let v: any = translations;
        for (const k of keys) v = v?.[k];
        return typeof v === 'string' ? v : fb;
    };

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        if (honeypot) return;
        setError('');
        setIsSubmitting(true);
        try {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const res = await fetch('/contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    full_name: formData.name,
                    phone: formData.phone,
                    email: formData.email,
                    service_id: summaryData.service_id,
                    message: `[Estimator] Xidmət: ${summaryData.platform}, Həcm: ${summaryData.scale}, Sürət: ${summaryData.timeline}, Qiymət: ${summaryData.priceRange}`,
                    type: 'preview_estimator',
                    hp: honeypot,
                }),
            });
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            setIsSuccess(true);
            setFormData({ name: '', phone: '', email: '' });
            setTimeout(() => {
                setIsSuccess(false);
                onClose();
            }, 3000);
        } catch (err: unknown) {
            setError(err instanceof Error ? err.message : 'Xəta baş verdi.');
        } finally {
            setIsSubmitting(false);
        }
    };

    const steps = [
        { label: t('modal.step1', 'Xülasə'), icon: '📋' },
        { label: t('modal.step2', 'Məlumat'), icon: '✉️' },
        { label: t('modal.step3', 'Təsdiq'), icon: '✓' },
    ];

    return (
        <AnimatePresence>
            {isOpen && (
                <>
                    <motion.div
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        exit={{ opacity: 0 }}
                        onClick={onClose}
                        className="fixed inset-0 z-50 bg-black/70 backdrop-blur-md cursor-pointer"
                    />

                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">
                        <motion.div
                            initial={{ opacity: 0, scale: 0.95, y: 20 }}
                            animate={{ opacity: 1, scale: 1, y: 0 }}
                            exit={{ opacity: 0, scale: 0.95, y: 20 }}
                            transition={{ type: "spring", duration: 0.4 }}
                            className="relative w-full max-w-4xl bg-white dark:bg-[#12121e] border border-black/5 dark:border-[var(--card-border)] rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row max-h-[90vh] md:max-h-[85vh] overflow-y-auto outline-none"
                        >
                            <button
                                onClick={onClose}
                                className="absolute top-4 right-4 sm:top-6 sm:right-6 w-8 h-8 rounded-full border border-white/20 md:border-black/5 dark:border-[var(--card-border)] flex items-center justify-center text-white md:text-text-sub hover:text-white/80 md:hover:text-text-main hover:bg-white/10 md:hover:bg-black/5 dark:hover:bg-white/5 transition-all duration-200 cursor-pointer focus:outline-none z-50"
                                aria-label="Close"
                                type="button"
                            >
                                ✕
                            </button>

                            {/* Step Indicator */}
                            <div className="absolute top-4 left-4 sm:top-6 sm:left-6 flex gap-1.5 z-50">
                                {steps.map((s, i) => (
                                    <div key={i} className="flex items-center gap-1.5">
                                        <div className={`w-7 h-7 rounded-full flex items-center justify-center text-[10px] font-extrabold transition-all duration-300 ${
                                            step === i + 1
                                                ? 'bg-brand-primary text-white scale-110 shadow-lg'
                                                : step > i + 1
                                                    ? 'bg-green-500 text-white'
                                                    : 'bg-black/5 dark:bg-white/10 text-text-muted'
                                        }`}>
                                            {step > i + 1 ? '✓' : i + 1}
                                        </div>
                                        <span className={`hidden sm:block text-[10px] font-bold tracking-wide ${
                                            step === i + 1 ? 'text-brand-primary' : 'text-text-muted'
                                        }`}>
                                            {s.label}
                                        </span>
                                    </div>
                                ))}
                            </div>

                            {/* Left: Summary Panel */}
                            <div className="w-full md:w-[360px] bg-gradient-to-br from-brand-primary via-[var(--brand-secondary)] to-indigo-600 p-6 sm:p-10 text-white flex flex-col justify-between relative overflow-hidden flex-shrink-0">
                                <div className="absolute -top-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none" />
                                <div className="absolute -bottom-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-2xl pointer-events-none" />

                                <div className="relative z-10">
                                    <h3 className="text-xl sm:text-2xl font-black mb-6 tracking-wide [text-shadow:0_2px_8px_rgba(0,0,0,0.15)]">
                                        {t('modal.summary_title', 'Sifariş Xülasəsi')}
                                    </h3>
                                    <div className="space-y-4">
                                        <motion.div
                                            key={`${summaryData.platform}-${step}`}
                                            initial={{ opacity: 0, x: -10 }}
                                            animate={{ opacity: 1, x: 0 }}
                                            className="flex justify-between items-center py-2.5 border-b border-white/10 text-sm"
                                        >
                                            <span className="opacity-75 font-medium">{t('estimator.platform', 'Xidmət')}</span>
                                            <strong className="font-bold text-right ml-2">{summaryData.platform}</strong>
                                        </motion.div>
                                        <motion.div
                                            key={`${summaryData.scale}-${step}`}
                                            initial={{ opacity: 0, x: -10 }}
                                            animate={{ opacity: 1, x: 0 }}
                                            transition={{ delay: 0.05 }}
                                            className="flex justify-between items-center py-2.5 border-b border-white/10 text-sm"
                                        >
                                            <span className="opacity-75 font-medium">{t('estimator.scale', 'Həcm')}</span>
                                            <strong className="font-bold">{summaryData.scale}</strong>
                                        </motion.div>
                                        <motion.div
                                            key={`${summaryData.timeline}-${step}`}
                                            initial={{ opacity: 0, x: -10 }}
                                            animate={{ opacity: 1, x: 0 }}
                                            transition={{ delay: 0.1 }}
                                            className="flex justify-between items-center py-2.5 border-b border-white/10 text-sm"
                                        >
                                            <span className="opacity-75 font-medium">{t('estimator.timeline', 'Sürət')}</span>
                                            <strong className="font-bold">{summaryData.timeline}</strong>
                                        </motion.div>
                                    </div>

                                    <motion.div
                                        key={`price-${summaryData.priceRange}-${step}`}
                                        initial={{ opacity: 0, scale: 0.9 }}
                                        animate={{ opacity: 1, scale: 1 }}
                                        transition={{ type: "spring", stiffness: 200, damping: 15 }}
                                        className="mt-8 p-4 bg-white/10 rounded-2xl border border-white/10 backdrop-blur-md"
                                    >
                                        <span className="text-[10px] uppercase tracking-[1.5px] opacity-75 block mb-1 font-bold">
                                            {t('estimator.estimated_price', 'Təxmini Qiymət')}
                                        </span>
                                        <span className="text-xl sm:text-2xl font-black [text-shadow:0_2px_8px_rgba(0,0,0,0.15)]">
                                            {summaryData.priceRange}
                                        </span>
                                    </motion.div>
                                </div>
                                <p className="text-[10px] opacity-70 mt-6 leading-normal relative z-10">
                                    {t('modal.note', '* Bu qiymət təxminidir və texniki şərtlər dəqiqləşdikdən sonra dəyişə bilər.')}
                                </p>
                            </div>

                            {/* Right: Multi-Step Content */}
                            <div className="flex-1 p-6 sm:p-10 relative flex flex-col justify-center bg-white dark:bg-[#12121e]">
                                {isSuccess ? (
                                    <div className="flex flex-col items-center justify-center text-center py-10 animate-fadeIn">
                                        <motion.div
                                            initial={{ scale: 0 }}
                                            animate={{ scale: 1 }}
                                            className="w-16 h-16 rounded-full bg-green-500 text-white flex items-center justify-center text-2xl font-bold mb-4 shadow-lg shadow-green-500/20"
                                        >
                                            ✓
                                        </motion.div>
                                        <h3 className="text-xl font-bold text-text-main mb-2">
                                            {t('modal.success_title', 'Təşəkkürlər!')}
                                        </h3>
                                        <p className="text-sm text-text-sub max-w-sm">
                                            {t('modal.success_desc', 'Sorğunuz uğurla qəbul edildi. Ən qısa zamanda sizinlə əlaqə saxlayacağıq.')}
                                        </p>
                                    </div>
                                ) : (
                                    <AnimatePresence mode="wait">
                                        {/* Step 1: Summary Review */}
                                        {step === 1 && (
                                            <motion.div
                                                key="step1"
                                                initial={{ opacity: 0, x: 20 }}
                                                animate={{ opacity: 1, x: 0 }}
                                                exit={{ opacity: 0, x: -20 }}
                                                transition={{ duration: 0.25 }}
                                                className="flex flex-col h-full"
                                            >
                                                <h3 className="text-xl sm:text-2xl font-bold text-text-main mb-1">
                                                    {t('modal.review_title', 'Layihəni Nəzərdən Keçirin')}
                                                </h3>
                                                <p className="text-xs sm:text-sm text-text-sub mb-8 leading-relaxed">
                                                    {t('modal.review_desc', 'Seçilmiş parametrləri təsdiqləyin. Doğru deyilsə, geri qayıdıb düzəldə bilərsiniz.')}
                                                </p>

                                                <div className="flex-1 flex flex-col justify-center">
                                                    <div className="bg-[var(--bg-secondary)] rounded-2xl p-5 border border-[var(--card-border)] space-y-3">
                                                        <div className="flex items-center gap-3">
                                                            <div className="w-8 h-8 rounded-lg bg-brand-primary/10 flex items-center justify-center text-brand-primary font-bold text-xs">1</div>
                                                            <div className="flex-1">
                                                                <div className="text-[10px] uppercase tracking-wide text-text-muted font-semibold">{t('estimator.platform', 'Xidmət')}</div>
                                                                <div className="font-bold text-text-main text-sm">{summaryData.platform}</div>
                                                            </div>
                                                        </div>
                                                        <div className="flex items-center gap-3">
                                                            <div className="w-8 h-8 rounded-lg bg-brand-secondary/10 flex items-center justify-center text-brand-secondary font-bold text-xs">2</div>
                                                            <div className="flex-1">
                                                                <div className="text-[10px] uppercase tracking-wide text-text-muted font-semibold">{t('estimator.scale', 'Həcm')}</div>
                                                                <div className="font-bold text-text-main text-sm">{summaryData.scale}</div>
                                                            </div>
                                                        </div>
                                                        <div className="flex items-center gap-3">
                                                            <div className="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-500 font-bold text-xs">3</div>
                                                            <div className="flex-1">
                                                                <div className="text-[10px] uppercase tracking-wide text-text-muted font-semibold">{t('estimator.timeline', 'Sürət')}</div>
                                                                <div className="font-bold text-text-main text-sm">{summaryData.timeline}</div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div className="mt-4 p-4 bg-gradient-to-r from-brand-primary/5 to-brand-secondary/5 rounded-2xl border border-brand-primary/10 text-center">
                                                        <span className="text-[10px] uppercase tracking-[1.5px] text-text-muted font-bold block mb-1">{t('estimator.estimated_price', 'Təxmini Qiymət')}</span>
                                                        <span className="text-xl font-black text-text-main">{summaryData.priceRange}</span>
                                                    </div>
                                                </div>

                                                <button
                                                    type="button"
                                                    onClick={() => setStep(2)}
                                                    className="mt-6 w-full py-3.5 rounded-xl bg-brand-primary text-white text-sm font-extrabold hover:bg-brand-primary/95 transition-all duration-300 shadow-lg shadow-brand-primary/10 hover:shadow-xl hover:-translate-y-0.5 active:scale-95 min-h-[44px] cursor-pointer focus:outline-none"
                                                >
                                                    {t('modal.continue', 'Davam Et →')}
                                                </button>
                                            </motion.div>
                                        )}

                                        {/* Step 2: Contact Form */}
                                        {step === 2 && (
                                            <motion.div
                                                key="step2"
                                                initial={{ opacity: 0, x: 20 }}
                                                animate={{ opacity: 1, x: 0 }}
                                                exit={{ opacity: 0, x: -20 }}
                                                transition={{ duration: 0.25 }}
                                            >
                                                <h3 className="text-xl sm:text-2xl font-bold text-text-main mb-1">
                                                    {t('modal.form_title', 'Əlaqə Məlumatları')}
                                                </h3>
                                                <p className="text-xs sm:text-sm text-text-sub mb-6 leading-relaxed">
                                                    {t('modal.form_desc', 'Zəhmət olmasa əlaqə məlumatlarınızı daxil edin. Mütəxəssisimiz sizinlə əlaqə saxlayacaq.')}
                                                </p>

                                                {error && (
                                                    <div className="p-3 bg-red-500/10 border border-red-500/20 text-red-500 rounded-xl text-xs font-semibold mb-4 text-center">
                                                        {error}
                                                    </div>
                                                )}

                                                <form onSubmit={handleSubmit} className="space-y-4">
                                                    <input
                                                        type="text"
                                                        name="hp"
                                                        style={{ display: 'none' }}
                                                        value={honeypot}
                                                        onChange={e => setHoneypot(e.target.value)}
                                                        tabIndex={-1}
                                                        autoComplete="off"
                                                    />

                                                    <div>
                                                        <input
                                                            type="text"
                                                            required
                                                            value={formData.name}
                                                            onChange={e => setFormData({ ...formData, name: e.target.value })}
                                                            disabled={isSubmitting}
                                                            placeholder={t('modal.name', 'Ad, Soyad')}
                                                            className="w-full px-4 py-3 rounded-xl border-2 border-black/5 dark:border-[var(--card-border)] bg-transparent text-text-main text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary focus:shadow-[0_0_20px_var(--brand-glow)] transition-all duration-300 placeholder:text-text-muted"
                                                        />
                                                    </div>

                                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                        <div>
                                                            <input
                                                                type="tel"
                                                                required
                                                                value={formData.phone}
                                                                onChange={e => setFormData({ ...formData, phone: e.target.value })}
                                                                disabled={isSubmitting}
                                                                placeholder={t('modal.phone', 'Telefon nömrəsi')}
                                                                className="w-full px-4 py-3 rounded-xl border-2 border-black/5 dark:border-[var(--card-border)] bg-transparent text-text-main text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary focus:shadow-[0_0_20px_var(--brand-glow)] transition-all duration-300 placeholder:text-text-muted"
                                                            />
                                                        </div>
                                                        <div>
                                                            <input
                                                                type="email"
                                                                required
                                                                value={formData.email}
                                                                onChange={e => setFormData({ ...formData, email: e.target.value })}
                                                                disabled={isSubmitting}
                                                                placeholder={t('modal.email', 'E-poçt ünvanı')}
                                                                className="w-full px-4 py-3 rounded-xl border-2 border-black/5 dark:border-[var(--card-border)] bg-transparent text-text-main text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary focus:shadow-[0_0_20px_var(--brand-glow)] transition-all duration-300 placeholder:text-text-muted"
                                                            />
                                                        </div>
                                                    </div>

                                                    <div className="flex gap-3 pt-2">
                                                        <button
                                                            type="button"
                                                            onClick={() => setStep(1)}
                                                            className="px-6 py-3.5 rounded-xl border-2 border-[var(--card-border)] text-text-sub font-bold text-sm hover:border-brand-primary/40 hover:text-brand-primary transition-all duration-300 cursor-pointer min-h-[44px] focus:outline-none"
                                                        >
                                                            ← {t('modal.back', 'Geri')}
                                                        </button>
                                                        <button
                                                            type="submit"
                                                            disabled={isSubmitting}
                                                            className="flex-1 py-3.5 rounded-xl bg-brand-primary text-white text-sm font-extrabold hover:bg-brand-primary/95 transition-all duration-300 shadow-lg shadow-brand-primary/10 hover:shadow-xl hover:-translate-y-0.5 active:scale-95 min-h-[44px] cursor-pointer focus:outline-none disabled:opacity-60"
                                                        >
                                                            {isSubmitting ? t('modal.sending', 'Göndərilir...') : t('modal.submit', 'Təklif Al')}
                                                        </button>
                                                    </div>
                                                </form>
                                            </motion.div>
                                        )}
                                    </AnimatePresence>
                                )}
                            </div>
                        </motion.div>
                    </div>
                </>
            )}
        </AnimatePresence>
    );
}
