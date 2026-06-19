import React, { useState, useMemo, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import QuoteModal from './QuoteModal';
import type { Translations, ContentTextMap } from '@/types';

interface ServiceChild { id: number; name: string; base_price?: number; }
interface ServiceCategory { id: number; name: string; childs?: ServiceChild[]; }
interface EstimatorProps { translations: Translations; contentTextMap?: ContentTextMap; main_services?: ServiceCategory[]; }

export default function Estimator({ translations, contentTextMap = {}, main_services = [] }: EstimatorProps) {
    const [step, setStep] = useState<number>(1);
    const [currency, setCurrency] = useState<'USD' | 'AZN'>('USD');
    const [activeCatId, setActiveCatId] = useState<number | null>(null);
    const [selectedChild, setSelectedChild] = useState<ServiceChild | null>(null);
    const [scale, setScale] = useState('');
    const [timeline, setTimeline] = useState(2);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [cssCurrency, setCssCurrency] = useState('$');

    useEffect(() => {
        if (typeof window !== 'undefined') {
            const symVal = getComputedStyle(document.documentElement)
                .getPropertyValue('--currency-symbol')
                .trim()
                .replace(/['"]/g, '');
            if (symVal && symVal !== '€') {
                setCssCurrency(symVal);
            } else {
                setCssCurrency('$');
            }
        }
    }, []);

    const t = (key: string, fb: string) => {
        const keys = key.split('.'); let v: any = translations;
        for (const k of keys) v = v?.[k];
        return typeof v === 'string' ? v : fb;
    };

    const categories = main_services?.length ? main_services : [];
    const activeCategory = categories.find(c => c.id === activeCatId);
    const childServices = activeCategory?.childs || [];

    const scaleOptions = useMemo(() => {
        const raw = contentTextMap['preview.estimator.sizes'];
        if (Array.isArray(raw)) return raw.map((i: any) => ({ label: i.label || '', value: i.value || 1 }));
        return [
            { label: t('estimator.scale_small', 'Kiçik'), value: 1, desc: t('estimator.scale_small_desc', 'Startaplar və kiçik şirkətlər üçün ideal') },
            { label: t('estimator.scale_medium', 'Orta'), value: 1.5, desc: t('estimator.scale_medium_desc', 'Genişlənən bizneslər üçün hərtərəfli həll') },
            { label: t('estimator.scale_large', 'Böyük (korporativ)'), value: 2.5, desc: t('estimator.scale_large_desc', 'Böyük miqyaslı təşkilatlar və platformalar üçün') }
        ];
    }, [contentTextMap, translations]);

    useEffect(() => { if (!activeCatId && categories.length) setActiveCatId(categories[0].id); }, [categories.length]);
    useEffect(() => {
        if (activeCatId && childServices.length && (!selectedChild || !childServices.find(c => c.id === selectedChild.id)))
            setSelectedChild(childServices[0]);
    }, [activeCatId, childServices.length]);
    useEffect(() => { if (!scale && scaleOptions.length) setScale(scaleOptions[1]?.label || scaleOptions[0].label); }, [scaleOptions.length]);

    const basePrice = selectedChild?.base_price || 1500;
    const scaleMul = scaleOptions.find(s => s.label === scale)?.value || 1.5;
    const urgency = timeline === 1 ? 1.0 : (timeline === 2 ? 1.25 : 1.5);
    const rate = currency === 'AZN' ? 1.7 : 1;
    const total = basePrice * scaleMul * urgency * rate;
    const cMin = Math.round(total * 0.9), cMax = Math.round(total * 1.2);
    const sym = currency === 'USD' ? cssCurrency : '₼';
    const fmt = (n: number) => n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    const priceStr = `${sym}${fmt(cMin)} – ${sym}${fmt(cMax)}`;
    const tlLabel = timeline === 1 ? t('estimator.slow', 'Yavaş') : (timeline === 2 ? t('estimator.normal', 'Normal') : t('estimator.fast', 'Təcili'));

    const handleReset = () => {
        setStep(1);
        if (categories.length) {
            setActiveCatId(categories[0].id);
        }
        setSelectedChild(null);
        setScale(scaleOptions[1]?.label || scaleOptions[0].label);
        setTimeline(2);
    };

    // Wizard Navigation Handler
    const nextStep = () => setStep((prev) => Math.min(prev + 1, 5));
    const prevStep = () => setStep((prev) => Math.max(prev - 1, 1));

    return (
        <section id="estimator" className="py-20 md:py-28 lg:py-36 relative z-10">
            <div className="max-w-container mx-auto px-4 sm:px-6 lg:px-8">
                <h2 className="text-3xl md:text-5xl font-bold text-center text-text-main mb-4">
                    {t('estimator.title', 'Ağıllı qiymət hesablayıcı')}
                </h2>
                <p className="text-lg text-center text-text-sub mb-12 max-w-2xl mx-auto">
                    {t('estimator.subtitle', 'Layihənizin büdcəsini təxmin edin')}
                </p>

                {/* Progress Indicators */}
                <div className="max-w-xl mx-auto mb-10">
                    <div className="flex justify-between items-center relative">
                        <div className="absolute left-0 right-0 top-1/2 h-0.5 bg-[var(--card-border)] -translate-y-1/2 z-0" />
                        <div 
                            className="absolute left-0 top-1/2 h-0.5 bg-brand-gradient -translate-y-1/2 transition-all duration-300 z-0" 
                            style={{ width: `${((step - 1) / 4) * 100}%` }}
                        />
                        {[1, 2, 3, 4, 5].map((s) => (
                            <button
                                key={s}
                                onClick={() => {
                                    if (s < step || (s === 2 && activeCatId) || (s === 3 && selectedChild) || (s === 4 && scale)) {
                                        setStep(s);
                                    }
                                }}
                                className={`w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs relative z-10 transition-all duration-300 ${
                                    step >= s 
                                        ? 'bg-brand-gradient text-white shadow-md scale-110' 
                                        : 'bg-[var(--card-bg)] border-2 border-[var(--card-border)] text-text-sub'
                                }`}
                            >
                                {s}
                            </button>
                        ))}
                    </div>
                    <div className="flex justify-between text-[10px] font-bold tracking-wider uppercase text-text-sub mt-3 px-1">
                        <span>{t('estimator.step1', 'Kateqoriya')}</span>
                        <span>{t('estimator.step2', 'Xidmət')}</span>
                        <span>{t('estimator.step3', 'Həcm')}</span>
                        <span>{t('estimator.step4', 'Müddət')}</span>
                        <span>{t('estimator.step5', 'Analiz')}</span>
                    </div>
                </div>

                {/* Stepper Card Container */}
                <div className="max-w-3xl mx-auto bg-[var(--card-bg)] backdrop-blur-2xl border border-[var(--card-border)] rounded-[var(--radius-card,28px)] overflow-hidden shadow-xl min-h-[460px] flex flex-col justify-between">
                    <div className="p-8 md:p-10 flex-grow">
                        <AnimatePresence mode="wait">
                            <motion.div
                                key={step}
                                initial={{ opacity: 0, x: 20 }}
                                animate={{ opacity: 1, x: 0 }}
                                exit={{ opacity: 0, x: -20 }}
                                transition={{ duration: 0.2 }}
                                className="h-full flex flex-col justify-center"
                            >
                                {/* Step 1: Category Selection */}
                                {step === 1 && (
                                    <div>
                                        <label className="block text-[0.7rem] font-bold tracking-[1.8px] uppercase text-brand-primary mb-6">
                                            {t('estimator.step1_title', 'Addım 1: Layihənizin kateqoriyasını seçin')}
                                        </label>
                                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            {categories.map((c) => (
                                                <button
                                                    key={c.id}
                                                    type="button"
                                                    onClick={() => {
                                                        setActiveCatId(c.id);
                                                        nextStep();
                                                    }}
                                                    className={`p-6 text-left rounded-2xl border-2 transition-all duration-300 cursor-pointer min-h-[110px] flex flex-col justify-center ${
                                                        activeCatId === c.id
                                                            ? 'border-brand-primary bg-brand-primary/5 text-brand-primary shadow-lg shadow-brand-primary/5 scale-[1.02]'
                                                            : 'border-[var(--card-border)] bg-[var(--card-bg)] hover:border-brand-primary/40'
                                                    }`}
                                                >
                                                    <span className="text-base font-bold text-text-main mb-1">{c.name}</span>
                                                    <span className="text-xs text-text-sub leading-normal">
                                                        {t('estimator.select_cat_desc', 'Bu kateqoriyadakı alt xidmətləri görmək üçün klikləyin')}
                                                    </span>
                                                </button>
                                            ))}
                                        </div>
                                    </div>
                                )}

                                {/* Step 2: Service Selection */}
                                {step === 2 && (
                                    <div>
                                        <label className="block text-[0.7rem] font-bold tracking-[1.8px] uppercase text-brand-primary mb-6">
                                            {t('estimator.step2_title', 'Addım 2: İstədiyiniz xidmət növünü seçin')}
                                        </label>
                                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-[280px] overflow-y-auto pr-1">
                                            {childServices.map((child) => (
                                                <button
                                                    key={child.id}
                                                    type="button"
                                                    onClick={() => {
                                                        setSelectedChild(child);
                                                        nextStep();
                                                    }}
                                                    className={`p-4 text-left rounded-xl border-2 transition-all duration-200 cursor-pointer ${
                                                        selectedChild?.id === child.id
                                                            ? 'border-brand-primary bg-brand-primary/5 text-brand-primary shadow-md'
                                                            : 'border-[var(--card-border)] bg-[var(--card-bg)] hover:border-brand-primary/30'
                                                    }`}
                                                >
                                                    <span className="text-sm font-semibold text-text-main block">{child.name}</span>
                                                </button>
                                            ))}
                                        </div>
                                    </div>
                                )}

                                {/* Step 3: Project Scale */}
                                {step === 3 && (
                                    <div>
                                        <label className="block text-[0.7rem] font-bold tracking-[1.8px] uppercase text-brand-primary mb-6">
                                            {t('estimator.step3_title', 'Addım 3: Layihənin miqyasını/həcmini müəyyən edin')}
                                        </label>
                                        <div className="grid grid-cols-1 gap-4">
                                            {scaleOptions.map((o: any) => (
                                                <button
                                                    key={o.label}
                                                    type="button"
                                                    onClick={() => {
                                                        setScale(o.label);
                                                        nextStep();
                                                    }}
                                                    className={`p-5 text-left rounded-xl border-2 transition-all duration-200 cursor-pointer flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 ${
                                                        scale === o.label
                                                            ? 'border-brand-primary bg-brand-primary/5 text-brand-primary shadow-md'
                                                            : 'border-[var(--card-border)] bg-[var(--card-bg)] hover:border-brand-primary/30'
                                                    }`}
                                                >
                                                    <div>
                                                        <span className="text-sm font-bold text-text-main block mb-1">{o.label}</span>
                                                        <span className="text-xs text-text-sub leading-normal">{o.desc || t('estimator.scale_custom_desc', 'Fərdi tənzimlənən xidmət həcmi')}</span>
                                                    </div>
                                                    <span className="text-xs font-bold px-3 py-1.5 rounded-full bg-brand-primary/10 text-brand-primary self-start sm:self-auto">
                                                        {o.value}x {t('estimator.factor', 'Əmsal')}
                                                    </span>
                                                </button>
                                            ))}
                                        </div>
                                    </div>
                                )}

                                {/* Step 4: Timeline */}
                                {step === 4 && (
                                    <div>
                                        <label className="block text-[0.7rem] font-bold tracking-[1.8px] uppercase text-brand-primary mb-6">
                                            {t('estimator.step4_title', 'Addım 4: Layihənin təciliyinə uyğun müddət seçin')}
                                        </label>
                                        <div className="py-6">
                                            <input
                                                type="range"
                                                min="1"
                                                max="3"
                                                step="1"
                                                value={timeline}
                                                onChange={(e) => setTimeline(parseInt(e.target.value))}
                                                className="tl-slider w-full h-2 appearance-none cursor-pointer rounded-full"
                                                style={{ background: 'linear-gradient(to right, var(--brand-primary), var(--brand-secondary))' }}
                                            />
                                            <div className="flex justify-between mt-3 text-xs font-bold text-text-sub uppercase tracking-wider px-1">
                                                <span className={`${timeline === 1 ? 'text-brand-primary' : ''}`}>{t('estimator.slow', 'Yavaş')}</span>
                                                <span className={`${timeline === 2 ? 'text-brand-primary' : ''}`}>{t('estimator.normal', 'Normal')}</span>
                                                <span className={`${timeline === 3 ? 'text-brand-primary' : ''}`}>{t('estimator.fast', 'Təcili')}</span>
                                            </div>

                                            {/* Details about timeline coefficient */}
                                            <div className="mt-10 p-5 rounded-2xl bg-[var(--bg-secondary)] border border-[var(--card-border)] flex items-center justify-between">
                                                <span className="text-xs text-text-sub font-medium">
                                                    {t('estimator.urgency_multiplier', 'Təcili çatdırılma əmsalı:')}
                                                </span>
                                                <span className="text-sm font-black text-brand-primary">
                                                    {timeline === 1 ? '1.0x' : (timeline === 2 ? '1.25x' : '1.5x')}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                )}

                                {/* Step 5: Investment Analysis */}
                                {step === 5 && (
                                    <div>
                                        <label className="block text-[0.7rem] font-bold tracking-[1.8px] uppercase text-brand-primary mb-6">
                                            {t('estimator.step5_title', 'Addım 5: İnvestisiya Təhlili')}
                                        </label>

                                        <div className="grid grid-cols-1 md:grid-cols-[1fr_300px] gap-6 items-stretch">
                                            {/* Left: Summary list */}
                                            <div className="flex flex-col gap-4">
                                                <div className="p-4 rounded-xl border border-[var(--card-border)] bg-[var(--bg-secondary)]">
                                                    <span className="text-[10px] uppercase font-bold text-text-sub tracking-widest block mb-1">
                                                        {t('estimator.chosen_service', 'Seçilmiş Xidmət')}
                                                    </span>
                                                    <span className="text-sm font-bold text-text-main">{selectedChild?.name}</span>
                                                </div>
                                                <div className="grid grid-cols-2 gap-4">
                                                    <div className="p-4 rounded-xl border border-[var(--card-border)] bg-[var(--bg-secondary)]">
                                                        <span className="text-[10px] uppercase font-bold text-text-sub tracking-widest block mb-1">
                                                            {t('estimator.chosen_scale', 'Seçilmiş Həcm')}
                                                        </span>
                                                        <span className="text-sm font-bold text-text-main">{scale}</span>
                                                    </div>
                                                    <div className="p-4 rounded-xl border border-[var(--card-border)] bg-[var(--bg-secondary)]">
                                                        <span className="text-[10px] uppercase font-bold text-text-sub tracking-widest block mb-1">
                                                            {t('estimator.chosen_timeline', 'Layihə Müddəti')}
                                                        </span>
                                                        <span className="text-sm font-bold text-text-main">{tlLabel}</span>
                                                    </div>
                                                </div>

                                                {/* Currency Selector */}
                                                <div className="flex items-center justify-between border-t border-[var(--card-border)] pt-4 mt-2">
                                                    <span className="text-xs text-text-sub font-semibold">{t('estimator.choose_currency', 'Valyutanı dəyiş:')}</span>
                                                    <div className="flex rounded-lg overflow-hidden border border-[var(--card-border)] flex-shrink-0 relative z-20">
                                                        <button type="button" className={`px-3 py-1.5 border-none bg-transparent text-[10px] font-bold text-text-sub cursor-pointer transition-all ${currency === 'USD' ? 'bg-brand-primary text-white' : ''}`} onClick={(e) => { e.preventDefault(); setCurrency('USD'); }}>USD</button>
                                                        <button type="button" className={`px-3 py-1.5 border-none bg-transparent text-[10px] font-bold text-text-sub cursor-pointer transition-all ${currency === 'AZN' ? 'bg-brand-primary text-white' : ''}`} onClick={(e) => { e.preventDefault(); setCurrency('AZN'); }}>AZN</button>
                                                    </div>
                                                </div>
                                            </div>

                                            {/* Right: Calculated Price Card */}
                                            <div className="flex flex-col justify-center items-center text-center p-6 bg-brand-gradient text-white rounded-2xl shadow-lg relative overflow-hidden">
                                                <span className="text-xs font-semibold opacity-80 mb-2 tracking-wide uppercase">
                                                    {t('estimator.investment', 'Təxmini investisiya')}
                                                </span>
                                                <div className="text-2xl sm:text-3xl font-black leading-tight mb-6 [text-shadow:0_2px_10px_rgba(0,0,0,0.15)]">
                                                    {priceStr}
                                                </div>
                                                <button 
                                                    onClick={() => setIsModalOpen(true)} 
                                                    className="w-full py-3.5 rounded-xl bg-white text-[var(--brand-primary)] text-sm font-extrabold cursor-pointer transition-all duration-300 shadow-md hover:-translate-y-0.5 hover:scale-[1.02] hover:shadow-lg"
                                                >
                                                    {t('estimator.get_quote', 'Təklif alın')}
                                                </button>
                                                <p className="text-[10px] opacity-60 mt-4 leading-normal max-w-[200px]">
                                                    {t('estimator.disclaimer', '* Bu qiymətlər təxminidir. Layihənin tələblərinə görə dəyişə bilər.')}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                )}
                            </motion.div>
                        </AnimatePresence>
                    </div>

                    {/* Navigation Buttons footer */}
                    <div className="p-6 md:p-8 bg-[var(--bg-secondary)] border-t border-[var(--card-border)] flex items-center justify-between rounded-b-[var(--radius-card,28px)]">
                        <button
                            type="button"
                            onClick={step === 5 ? handleReset : prevStep}
                            disabled={step === 1}
                            className={`px-5 py-2.5 rounded-xl border text-xs font-bold flex items-center gap-1.5 transition-all duration-200 ${
                                step === 1 
                                    ? 'opacity-40 cursor-not-allowed border-[var(--card-border)] text-text-muted bg-transparent' 
                                    : 'border-[var(--card-border)] bg-[var(--card-bg)] text-[var(--text-main)] hover:border-brand-primary/40'
                            }`}
                        >
                            {step === 5 ? t('estimator.restart', 'Yenidən Başla') : (
                                <>
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3" className="stroke-current"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                                    {t('estimator.back', 'Geri')}
                                </>
                            )}
                        </button>

                        {step < 5 && (
                            <button
                                type="button"
                                onClick={nextStep}
                                disabled={
                                    (step === 1 && !activeCatId) ||
                                    (step === 2 && !selectedChild) ||
                                    (step === 3 && !scale)
                                }
                                className={`px-6 py-2.5 rounded-xl bg-brand-gradient text-white text-xs font-extrabold flex items-center gap-1.5 cursor-pointer shadow-md hover:-translate-y-0.5 transition-all duration-200 ${
                                    ((step === 1 && !activeCatId) ||
                                     (step === 2 && !selectedChild) ||
                                     (step === 3 && !scale)) 
                                        ? 'opacity-50 cursor-not-allowed' 
                                        : 'hover:shadow-lg'
                                }`}
                            >
                                <span>{t('estimator.next', 'Növbəti')}</span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3" className="stroke-current"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </button>
                        )}
                    </div>
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
                    timeline: tlLabel, 
                    priceRange: priceStr 
                }} 
            />

            <style>{`
                .tl-slider::-webkit-slider-thumb { -webkit-appearance: none; width: 22px; height: 22px; border-radius: 50%; background: var(--brand-primary, #4b0082); border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.25); cursor: pointer; transition: transform 0.15s ease; }
                .tl-slider::-webkit-slider-thumb:hover { transform: scale(1.15); }
                .tl-slider::-moz-range-thumb { width: 22px; height: 22px; border-radius: 50%; background: var(--brand-primary, #4b0082); border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.25); cursor: pointer; transition: transform 0.15s ease; }
                .tl-slider::-moz-range-thumb:hover { transform: scale(1.15); }
            `}</style>
        </section>
    );
}
