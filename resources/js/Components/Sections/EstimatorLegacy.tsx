import React, { useState, useMemo, useEffect } from 'react';
import { useStore } from '@/store/useStore';
import { SectionWrapper } from '@/Components/ui/Layout';
import { Translations, ContentTextMap } from '@/types';
import { motion, AnimatePresence } from 'framer-motion';
import { createT } from '@/lib/i18n';
import QuoteModal from './QuoteModal';

interface ServiceChild { id: number; name: string; base_price?: number; }
interface ServiceCategory { id: number; name: string; childs?: ServiceChild[]; }
interface EstimatorLegacyProps { translations: Translations; contentTextMap?: ContentTextMap; main_services?: ServiceCategory[]; }

export default function EstimatorLegacy({ translations, contentTextMap = {}, main_services = [] }: EstimatorLegacyProps) {
    const [step, setStep] = useState(1);
    const [currency, setCurrency] = useState<'USD' | 'AZN'>('USD');
    const [activeCatId, setActiveCatId] = useState<number | null>(null);
    const [selectedChild, setSelectedChild] = useState<ServiceChild | null>(null);
    const [scale, setScale] = useState('');
    const [timeline, setTimeline] = useState(2);
    const { openQuoteModal } = useStore();
    const [isModalOpen, setIsModalOpen] = useState(false);

    const t = createT(translations);

    const categories = main_services?.length ? main_services : [];
    const activeCategory = categories.find(c => c.id === activeCatId);
    const childServices = activeCategory?.childs || [];

    const scaleOptions = useMemo(() => {
        const raw: unknown = contentTextMap['preview.estimator.sizes'];
        if (Array.isArray(raw)) return raw.map((i: unknown) => {
            const item = i as Record<string, unknown>;
            return { label: String(item.label || ''), value: Number(item.value) || 1 };
        });
        return [
            { label: t('estimator.scale_small', 'Kiçik'), value: 1 }, 
            { label: t('estimator.scale_medium', 'Orta'), value: 1.5 }, 
            { label: t('estimator.scale_large', 'Böyük'), value: 2.5 }
        ];
    }, [contentTextMap, translations]);

    useEffect(() => { if (!activeCatId && categories.length) setActiveCatId(categories[0].id); }, [categories.length]);
    useEffect(() => {
        if (activeCatId && childServices.length && (!selectedChild || !childServices.find(c => c.id === selectedChild.id)))
            setSelectedChild(childServices[0]);
    }, [activeCatId, childServices.length]);
    useEffect(() => { if (!scale && scaleOptions.length) setScale(scaleOptions[1]?.label || scaleOptions[0].label); }, [scaleOptions.length]);

    const totalSteps = 5;
    const progress = (step / totalSteps) * 100;

    const calculatePrice = () => {
        const basePrice = selectedChild?.base_price || 1500;
        const scaleMul = scaleOptions.find(s => s.label === scale)?.value || 1.5;
        const urgency = timeline === 1 ? 1.0 : (timeline === 2 ? 1.25 : 1.5);
        const rate = currency === 'AZN' ? 1.7 : 1;
        const total = basePrice * scaleMul * urgency * rate;
        const cMin = Math.round(total * 0.9), cMax = Math.round(total * 1.2);
        const sym = currency === 'USD' ? '$' : '₼';
        const fmt = (n: number) => n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return `${sym}${fmt(cMin)} – ${sym}${fmt(cMax)}`;
    };

    const nextStep = () => setStep(s => Math.min(s + 1, totalSteps));
    const prevStep = () => setStep(s => Math.max(s - 1, 1));

    const renderStepContent = () => {
        switch (step) {
            case 1:
                return (
                    <motion.div initial={{ opacity: 0, x: 20 }} animate={{ opacity: 1, x: 0 }} exit={{ opacity: 0, x: -20 }}>
                        <h3 className="text-xl font-bold mb-8 text-[var(--text-primary)]">{t('estimator.step1_title', 'Layihə kateqoriyasını seçin')}</h3>
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {categories.map(cat => {
                                const isActive = activeCatId === cat.id;
                                return (
                                <button type="button" key={cat.id} className={`p-5 bg-[var(--bg-secondary)] border rounded-xl text-left transition-all duration-300 cursor-pointer flex items-center gap-4 hover:border-[var(--brand-primary)] ${isActive ? 'border-brand-primary bg-brand-primary/5 text-brand-primary' : 'border-[var(--card-border)] text-text-main'}`} onClick={() => { setActiveCatId(cat.id); nextStep(); }}>
                                    <div className="w-5 h-5 border-2 rounded-full relative shrink-0">
                                        {isActive && <span className="absolute inset-[3px] bg-brand-primary rounded-full" />}
                                    </div>
                                    <span>{cat.name}</span>
                                </button>
                                );
                            })}
                        </div>
                    </motion.div>
                );
            case 2:
                return (
                    <motion.div initial={{ opacity: 0, x: 20 }} animate={{ opacity: 1, x: 0 }} exit={{ opacity: 0, x: -20 }}>
                        <h3 className="text-xl font-bold mb-8 text-[var(--text-primary)]">{t('estimator.step2_title', 'Xidmət növünü dəqiqləşdirin')}</h3>
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {childServices.map(child => {
                                const isActive = selectedChild?.id === child.id;
                                return (
                                <button type="button" key={child.id} className={`p-5 bg-[var(--bg-secondary)] border rounded-xl text-left transition-all duration-300 cursor-pointer flex items-center gap-4 hover:border-[var(--brand-primary)] ${isActive ? 'border-brand-primary bg-brand-primary/5 text-brand-primary' : 'border-[var(--card-border)] text-text-main'}`} onClick={() => { setSelectedChild(child); nextStep(); }}>
                                    <div className="w-5 h-5 border-2 rounded-full relative shrink-0">
                                        {isActive && <span className="absolute inset-[3px] bg-brand-primary rounded-full" />}
                                    </div>
                                    <span>{child.name}</span>
                                </button>
                                );
                            })}
                        </div>
                    </motion.div>
                );
            case 3:
                return (
                    <motion.div initial={{ opacity: 0, x: 20 }} animate={{ opacity: 1, x: 0 }} exit={{ opacity: 0, x: -20 }}>
                        <h3 className="text-xl font-bold mb-8 text-[var(--text-primary)]">{t('estimator.step3_title', 'Layihənin həcmini təyin edin')}</h3>
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {scaleOptions.map(o => {
                                const isActive = scale === o.label;
                                return (
                                <button type="button" key={o.label} className={`p-5 bg-[var(--bg-secondary)] border rounded-xl text-left transition-all duration-300 cursor-pointer flex items-center gap-4 hover:border-[var(--brand-primary)] ${isActive ? 'border-brand-primary bg-brand-primary/5 text-brand-primary' : 'border-[var(--card-border)] text-text-main'}`} onClick={() => { setScale(o.label); nextStep(); }}>
                                    <div className="w-5 h-5 border-2 rounded-full relative shrink-0">
                                        {isActive && <span className="absolute inset-[3px] bg-brand-primary rounded-full" />}
                                    </div>
                                    <span>{o.label}</span>
                                </button>
                                );
                            })}
                        </div>
                    </motion.div>
                );
            case 4:
                return (
                    <motion.div initial={{ opacity: 0, x: 20 }} animate={{ opacity: 1, x: 0 }} exit={{ opacity: 0, x: -20 }}>
                        <h3 className="text-xl font-bold mb-8 text-[var(--text-primary)]">{t('estimator.step4_title', 'Təxmini icra müddəti')}</h3>
                        <div className="max-w-md mx-auto">
                            <input type="range" min="1" max="3" step="1" value={timeline} onChange={e => setTimeline(parseInt(e.target.value))} className="w-full my-8 accent-[var(--brand-primary)] min-h-[44px]" />
                            <div className="flex justify-between text-xs font-bold text-text-sub uppercase">
                                <span>{t('estimator.slow', 'Yavaş')}</span>
                                <span>{t('estimator.normal', 'Normal')}</span>
                                <span>{t('estimator.fast', 'Təcili')}</span>
                            </div>
                        </div>
                    </motion.div>
                );
            case 5:
                const priceResult = calculatePrice();
                const tlLabel = timeline === 1 ? t('estimator.slow', 'Yavaş') : (timeline === 2 ? t('estimator.normal', 'Normal') : t('estimator.fast', 'Təcili'));
                return (
                    <motion.div initial={{ opacity: 0, scale: 0.95 }} animate={{ opacity: 1, scale: 1 }} className="text-center flex flex-col items-center justify-center">
                        <h3 className="text-xl font-extrabold mb-8 text-[var(--text-primary)]">{t('estimator.step5_title', 'Hesablamanız hazırdır!')}</h3>
                        <div className="text-center p-8 bg-brand-gradient rounded-2xl text-white mb-8 shadow-lg max-w-sm w-full">
                            <p className="text-xs uppercase font-bold tracking-widest opacity-80">{t('estimator.investment', 'Təxmini investisiya')}</p>
                            <div className="text-3xl font-black my-4">{priceResult}</div>
                            <div className="flex justify-center gap-4 mt-4 relative z-20">
                                <button type="button" className={`px-4 py-1.5 rounded-full text-xs font-bold border transition-all ${currency === 'USD' ? 'bg-white text-[var(--brand-primary)] border-white' : 'border-white/30 text-white'}`} onClick={() => setCurrency('USD')}>USD</button>
                                <button type="button" className={`px-4 py-1.5 rounded-full text-xs font-bold border transition-all ${currency === 'AZN' ? 'bg-white text-[var(--brand-primary)] border-white' : 'border-white/30 text-white'}`} onClick={() => setCurrency('AZN')}>AZN</button>
                            </div>
                        </div>
                        <button 
                            type="button"
                            onClick={() => setIsModalOpen(true)}
                            className="px-10 py-4 rounded-full font-black text-lg bg-brand-gradient text-white shadow-xl hover:scale-105 transition-transform"
                        >
                            {t('estimator.get_quote', 'Təklif alın')}
                        </button>
                        <p className="text-xs text-text-sub mt-8 opacity-60 italic">{t('estimator.disclaimer', '* Bu qiymətlər təxminidir və layihənin detallarına görə dəyişə bilər.')}</p>
                    </motion.div>
                );
            default:
                return null;
        }
    };

    return (
        <SectionWrapper id="estimator-legacy" variant="primary">
            <div className="text-center mb-12">
                <h2 className="text-3xl md:text-5xl font-bold mb-4">{t('est_title', 'Ağıllı qiymət hesablayıcı (Orijinal Stəş Modeli)')}</h2>
                <p className="text-lg text-text-sub">{t('est_sub', 'Köhnə minimalist 5 addımlı axış')}</p>
            </div>

            <div className="bg-[var(--card-bg)] border border-[var(--card-border)] rounded-[28px] p-8 md:p-12 min-h-[480px] flex flex-col relative overflow-hidden backdrop-blur-[20px] shadow-xl max-w-3xl mx-auto">
                {/* Progress Indicator */}
                <div className="mb-10">
                    <div className="h-1.5 bg-[var(--card-border)] rounded-full overflow-hidden relative">
                        <div className="h-full bg-brand-gradient transition-all duration-500" style={{ width: `${progress}%` }} />
                    </div>
                    <div className="flex justify-between mt-3 text-xs text-text-sub font-bold">
                        <span>Step {step} / {totalSteps}</span>
                        <span>{Math.round(progress)}% Complete</span>
                    </div>
                </div>

                {/* Step Content Area */}
                <div className="flex-1 flex flex-col justify-center">
                    <AnimatePresence mode="wait">
                        {renderStepContent()}
                    </AnimatePresence>
                </div>

                {/* Navigation Actions */}
                <div className="mt-10 flex justify-between gap-4">
                    {step > 1 && step < 5 && (
                        <button type="button" onClick={prevStep} className="px-6 py-2.5 rounded-xl border border-[var(--card-border)] bg-[var(--card-bg)] text-[var(--text-main)] text-xs font-bold transition-all hover:border-brand-primary/40">
                            Geri
                        </button>
                    )}
                    {step < 5 && (
                        <button type="button" onClick={nextStep} className="px-6 py-2.5 rounded-xl bg-brand-gradient text-white text-xs font-bold ml-auto hover:shadow-lg transition-all">
                            İrəli
                        </button>
                    )}
                    {step === 5 && (
                        <button type="button" onClick={() => setStep(1)} className="px-6 py-2.5 rounded-xl border border-[var(--card-border)] bg-[var(--card-bg)] text-[var(--text-main)] text-xs font-bold mx-auto transition-all hover:border-brand-primary/40">
                            Yenidən başla
                        </button>
                    )}
                </div>
            </div>

            <QuoteModal 
                isOpen={isModalOpen} 
                onClose={() => setIsModalOpen(false)}
                translations={translations}
                summaryData={{
                    platform: selectedChild?.name || '',
                    service_id: selectedChild?.id || null,
                    scale,
                    timeline: timeline === 1 ? t('estimator.slow', 'Yavaş') : (timeline === 2 ? t('estimator.normal', 'Normal') : t('estimator.fast', 'Təcili')),
                    priceRange: calculatePrice()
                }}
            />
        </SectionWrapper>
    );
}
