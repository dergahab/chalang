import React, { useState, useMemo, useEffect } from 'react';
import { useStore } from '@/store/useStore';
import { SectionWrapper } from '@/Components/ui/Layout';
import { Translations, ContentTextMap } from '@/types';
import { motion, AnimatePresence } from 'framer-motion';
import { createT } from '@/lib/i18n';
import QuoteModal from './QuoteModal';

interface ServiceChild { id: number; name: string; base_price?: number; }
interface ServiceCategory { id: number; name: string; childs?: ServiceChild[]; }
interface EstimatorHybridProps { translations: Translations; contentTextMap?: ContentTextMap; main_services?: ServiceCategory[]; }

export default function EstimatorHybrid({ translations, contentTextMap = {}, main_services = [] }: EstimatorHybridProps) {
    const [step, setStep] = useState(1);
    const [currency, setCurrency] = useState<'USD' | 'AZN'>('USD');
    const [activeCatId, setActiveCatId] = useState<number | null>(null);
    const [selectedChild, setSelectedChild] = useState<ServiceChild | null>(null);
    const [scale, setScale] = useState('');
    const [timeline, setTimeline] = useState(2);
    const { openQuoteModal } = useStore();
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

    const t = createT(translations);

    const categories = main_services?.length ? main_services : [];
    const activeCategory = categories.find(c => c.id === activeCatId);
    const childServices = activeCategory?.childs || [];

    const scaleOptions = useMemo(() => {
        const raw: unknown = contentTextMap['preview.estimator.sizes'];
        if (Array.isArray(raw)) return raw.map((i: unknown) => {
            const item = i as Record<string, unknown>;
            return { 
                label: String(item.label || ''), 
                value: Number(item.value) || 1,
                desc: String(item.desc || '')
            };
        });
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

    const totalSteps = 5;
    const progress = (step / totalSteps) * 100;

    const calculatePrice = () => {
        const basePrice = selectedChild?.base_price || 1500;
        const scaleMul = scaleOptions.find(s => s.label === scale)?.value || 1.5;
        const urgency = timeline === 1 ? 1.0 : (timeline === 2 ? 1.25 : 1.5);
        const rate = currency === 'AZN' ? 1.7 : 1;
        const total = basePrice * scaleMul * urgency * rate;
        const cMin = Math.round(total * 0.9), cMax = Math.round(total * 1.2);
        const sym = currency === 'USD' ? cssCurrency : '₼';
        const fmt = (n: number) => n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return `${sym}${fmt(cMin)} – ${sym}${fmt(cMax)}`;
    };

    const nextStep = () => setStep(s => Math.min(s + 1, totalSteps));
    const prevStep = () => setStep(s => Math.max(s - 1, 1));

    const priceResult = calculatePrice();
    const tlLabel = timeline === 1 ? t('estimator.slow', 'Yavaş') : (timeline === 2 ? t('estimator.normal', 'Normal') : t('estimator.fast', 'Təcili'));

    const timelineExplanations = {
        1: t('estimator.timeline_slow_desc', 'Daha geniş vaxt çərçivəsində, standart planlaşdırma ilə optimal büdcə üstünlüyü.'),
        2: t('estimator.timeline_normal_desc', 'Standart təhvil müddəti ilə balanslaşdırılmış komanda resursu və stabil sürət.'),
        3: t('estimator.timeline_fast_desc', 'Maksimum sürət: 24 saat ərzində sürətli start, komandada əlavə iş saatları və prioritet icra.')
    };

    const renderStepContent = () => {
        switch (step) {
            case 1:
                return (
                    <motion.div initial={{ opacity: 0, x: 20 }} animate={{ opacity: 1, x: 0 }} exit={{ opacity: 0, x: -20 }}>
                        <h3 className="text-xl font-bold mb-6 text-[var(--text-primary)]">{t('estimator.step1_title', 'Layihə kateqoriyasını seçin')}</h3>
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {categories.map(cat => {
                                const isActive = activeCatId === cat.id;
                                return (
                                <button 
                                    type="button" 
                                    key={cat.id} 
                                    className={`p-6 bg-[var(--bg-secondary)] border-2 rounded-2xl text-left transition-all duration-300 cursor-pointer flex items-center gap-4 hover:border-[var(--brand-primary)] ${
                                        isActive 
                                            ? 'border-brand-primary bg-brand-primary/5 text-brand-primary shadow-lg shadow-brand-primary/5 scale-[1.01]' 
                                            : 'border-[var(--card-border)] text-text-main hover:bg-[var(--bg-secondary)]/80'
                                    }`} 
                                    onClick={() => { setActiveCatId(cat.id); nextStep(); }}
                                >
                                    <div className="w-5 h-5 border-2 border-[var(--card-border)] rounded-full relative shrink-0 flex items-center justify-center">
                                        {isActive && <span className="w-2.5 h-2.5 bg-brand-primary rounded-full" />}
                                    </div>
                                    <div className="flex flex-col">
                                        <span className="text-sm font-bold text-text-main">{cat.name}</span>
                                        <span className="text-[10px] text-text-muted mt-0.5">{t('estimator.select_cat_sub', 'Seçmək üçün klikləyin')}</span>
                                    </div>
                                </button>
                                );
                            })}
                        </div>
                    </motion.div>
                );
            case 2:
                return (
                    <motion.div initial={{ opacity: 0, x: 20 }} animate={{ opacity: 1, x: 0 }} exit={{ opacity: 0, x: -20 }}>
                        <h3 className="text-xl font-bold mb-6 text-[var(--text-primary)]">{t('estimator.step2_title', 'Xidmət növünü dəqiqləşdirin')}</h3>
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-[280px] overflow-y-auto pr-1">
                            {childServices.map(child => {
                                const isActive = selectedChild?.id === child.id;
                                return (
                                <button 
                                    type="button" 
                                    key={child.id} 
                                    className={`p-4 bg-[var(--bg-secondary)] border-2 rounded-xl text-left transition-all duration-200 cursor-pointer flex items-center gap-4 hover:border-[var(--brand-primary)] ${
                                        isActive 
                                            ? 'border-brand-primary bg-brand-primary/5 text-brand-primary shadow-md' 
                                            : 'border-[var(--card-border)] text-text-main'
                                    }`} 
                                    onClick={() => { setSelectedChild(child); nextStep(); }}
                                >
                                    <div className="w-5 h-5 border-2 border-[var(--card-border)] rounded-full relative shrink-0 flex items-center justify-center">
                                        {isActive && <span className="w-2.5 h-2.5 bg-brand-primary rounded-full" />}
                                    </div>
                                    <span className="text-xs font-bold">{child.name}</span>
                                </button>
                                );
                            })}
                        </div>
                    </motion.div>
                );
            case 3:
                return (
                    <motion.div initial={{ opacity: 0, x: 20 }} animate={{ opacity: 1, x: 0 }} exit={{ opacity: 0, x: -20 }}>
                        <h3 className="text-xl font-bold mb-6 text-[var(--text-primary)]">{t('estimator.step3_title', 'Layihənin həcmini təyin edin')}</h3>
                        <div className="grid grid-cols-1 gap-3.5">
                            {scaleOptions.map(o => {
                                const isActive = scale === o.label;
                                return (
                                <button 
                                    type="button" 
                                    key={o.label} 
                                    className={`p-5 bg-[var(--bg-secondary)] border-2 rounded-2xl text-left transition-all duration-200 cursor-pointer flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 hover:border-[var(--brand-primary)] ${
                                        isActive 
                                            ? 'border-brand-primary bg-brand-primary/5 text-brand-primary shadow-md' 
                                            : 'border-[var(--card-border)] text-text-main'
                                    }`} 
                                    onClick={() => { setScale(o.label); nextStep(); }}
                                >
                                    <div className="flex items-center gap-4">
                                        <div className="w-5 h-5 border-2 border-[var(--card-border)] rounded-full relative shrink-0 flex items-center justify-center">
                                            {isActive && <span className="w-2.5 h-2.5 bg-brand-primary rounded-full" />}
                                        </div>
                                        <div className="flex flex-col">
                                            <span className="text-sm font-bold text-text-main">{o.label}</span>
                                            <span className="text-xs text-text-muted mt-1 leading-normal max-w-sm">{o.desc || t('estimator.scale_custom_desc', 'Fərdi tənzimlənən layihə miqyası')}</span>
                                        </div>
                                    </div>
                                    <span className="text-xs font-black px-3.5 py-1.5 rounded-full bg-brand-primary/10 text-brand-primary shrink-0 self-start sm:self-auto">
                                        {o.value}x {t('estimator.factor', 'Əmsal')}
                                    </span>
                                </button>
                                );
                            })}
                        </div>
                    </motion.div>
                );
            case 4:
                return (
                    <motion.div initial={{ opacity: 0, x: 20 }} animate={{ opacity: 1, x: 0 }} exit={{ opacity: 0, x: -20 }}>
                        <h3 className="text-xl font-bold mb-6 text-[var(--text-primary)]">{t('estimator.step4_title', 'Təxmini icra müddəti')}</h3>
                        <div className="max-w-xl mx-auto py-4">
                            <input 
                                type="range" 
                                min="1" 
                                max="3" 
                                step="1" 
                                value={timeline} 
                                onChange={e => setTimeline(parseInt(e.target.value))} 
                                className="tl-slider w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[var(--brand-primary)] min-h-[44px]"
                                style={{ background: 'linear-gradient(to right, var(--brand-primary), var(--brand-secondary))' }}
                            />
                            <div className="flex justify-between text-xs font-bold text-text-sub uppercase tracking-wider px-1">
                                <span className={`${timeline === 1 ? 'text-brand-primary' : ''}`}>{t('estimator.slow', 'Yavaş')}</span>
                                <span className={`${timeline === 2 ? 'text-brand-primary' : ''}`}>{t('estimator.normal', 'Normal')}</span>
                                <span className={`${timeline === 3 ? 'text-brand-primary' : ''}`}>{t('estimator.fast', 'Təcili')}</span>
                            </div>

                            {/* Informative Explanation Container (Fills the visual gap) */}
                            <motion.div 
                                key={timeline}
                                initial={{ opacity: 0, y: 10 }}
                                animate={{ opacity: 1, y: 0 }}
                                className="mt-8 p-5 rounded-2xl bg-[var(--bg-secondary)] border border-[var(--card-border)] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3"
                            >
                                <div className="flex flex-col">
                                    <span className="text-[10px] font-bold tracking-wider text-text-sub uppercase mb-1">{t('estimator.speed_priority', 'İCRA VƏ PRİORİTET STATUSU')}</span>
                                    <span className="text-xs text-text-main leading-relaxed font-medium">
                                        {timelineExplanations[timeline as 1 | 2 | 3]}
                                    </span>
                                </div>
                                <span className="text-sm font-black text-brand-primary shrink-0 self-start sm:self-auto bg-brand-primary/10 px-3 py-1.5 rounded-lg">
                                    {timeline === 1 ? '1.0x' : (timeline === 2 ? '1.25x' : '1.5x')}
                                </span>
                            </motion.div>
                        </div>
                    </motion.div>
                );
            case 5:
                return (
                    <motion.div initial={{ opacity: 0, scale: 0.96 }} animate={{ opacity: 1, scale: 1 }} className="w-full">
                        <h3 className="text-xl font-extrabold mb-8 text-center text-[var(--text-primary)]">{t('estimator.step5_title', 'Hesablamanız hazırdır!')}</h3>
                        
                        <div className="grid grid-cols-1 md:grid-cols-[1.2fr_1fr] gap-6 items-stretch">
                            {/* Left: Summary and Currency Selector (Glass Card) */}
                            <div className="p-6 rounded-2xl border border-[var(--card-border)] bg-[var(--bg-secondary)] flex flex-col justify-between gap-5">
                                <div className="flex flex-col gap-4">
                                    <div>
                                        <span className="text-[9px] uppercase font-black text-text-sub tracking-widest block mb-1">
                                            {t('estimator.chosen_service', 'Seçilmiş Xidmət')}
                                        </span>
                                        <span className="text-sm font-bold text-text-main">{selectedChild?.name}</span>
                                    </div>
                                    <div className="grid grid-cols-2 gap-4">
                                        <div>
                                            <span className="text-[9px] uppercase font-black text-text-sub tracking-widest block mb-1">
                                                {t('estimator.chosen_scale', 'Seçilmiş Həcm')}
                                            </span>
                                            <span className="text-xs font-bold text-text-main">{scale}</span>
                                        </div>
                                        <div>
                                            <span className="text-[9px] uppercase font-black text-text-sub tracking-widest block mb-1">
                                                {t('estimator.chosen_timeline', 'Müddət')}
                                            </span>
                                            <span className="text-xs font-bold text-text-main">{tlLabel}</span>
                                        </div>
                                    </div>
                                </div>

                                <div className="flex items-center justify-between border-t border-[var(--card-border)] pt-4">
                                    <span className="text-xs text-text-sub font-semibold">{t('estimator.choose_currency', 'Valyutanı dəyiş:')}</span>
                                    <div className="flex rounded-lg overflow-hidden border border-[var(--card-border)] relative z-20">
                                        <button type="button" className={`px-3 py-1.5 border-none bg-transparent text-[10px] font-bold text-text-sub cursor-pointer transition-all ${currency === 'USD' ? 'bg-brand-primary text-white' : ''}`} onClick={(e) => { e.preventDefault(); setCurrency('USD'); }}>USD</button>
                                        <button type="button" className={`px-3 py-1.5 border-none bg-transparent text-[10px] font-bold text-text-sub cursor-pointer transition-all ${currency === 'AZN' ? 'bg-brand-primary text-white' : ''}`} onClick={(e) => { e.preventDefault(); setCurrency('AZN'); }}>AZN</button>
                                    </div>
                                </div>
                            </div>

                            {/* Right: Immersive Wow Qradient Kart (Ultimate Wow effect) */}
                            <div className="p-8 bg-brand-gradient text-white rounded-2xl shadow-xl flex flex-col justify-center items-center text-center relative overflow-hidden min-h-[220px]">
                                {/* Decorative Glowing Orb inside Card */}
                                <div className="absolute -top-12 -left-12 w-28 h-28 rounded-full bg-white/10 blur-xl pointer-events-none" />
                                
                                <span className="text-[10px] font-extrabold opacity-80 mb-2 tracking-widest uppercase">
                                    {t('estimator.investment', 'Təxmini investisiya')}
                                </span>
                                <div className="text-2xl sm:text-3xl font-black leading-tight mb-6 [text-shadow:0_2px_12px_rgba(0,0,0,0.2)]">
                                    {priceResult}
                                </div>
                                <button 
                                    type="button"
                                    onClick={() => setIsModalOpen(true)} 
                                    className="w-full py-4 rounded-xl bg-white text-[var(--brand-primary)] text-sm font-extrabold cursor-pointer transition-all duration-300 shadow-md hover:-translate-y-0.5 hover:scale-[1.02] hover:shadow-lg active:scale-95 animate-pulse"
                                >
                                    {t('estimator.get_quote', 'Təklif alın')}
                                </button>
                                <p className="text-[9px] opacity-60 mt-4 leading-normal max-w-[210px] italic">
                                    {t('estimator.disclaimer', '* Bu qiymətlər təxminidir və layihənin detallarına görə dəyişə bilər.')}
                                </p>
                            </div>
                        </div>
                    </motion.div>
                );
            default:
                return null;
        }
    };

    return (
        <SectionWrapper id="estimator-hybrid" variant="primary">
            <div className="text-center mb-12">
                <span className="text-xs font-black px-3.5 py-1.5 rounded-full bg-brand-primary/10 text-brand-primary tracking-widest uppercase mb-3 inline-block">
                    PRO TOVSiYƏ
                </span>
                <h2 className="text-3xl md:text-5xl font-bold mb-4">{t('est_title_hybrid', 'Ağıllı Qiymət Hesablayıcı (Möhtəşəm Hibrid Model)')}</h2>
                <p className="text-lg text-text-sub max-w-2xl mx-auto">{t('est_sub_hybrid', 'Stəşin minimalist "Wow" qradient kartı ilə yeni interaktiv addım-addım məlumat axışının sintezi')}</p>
            </div>

            <div className="bg-[var(--card-bg)] border border-[var(--card-border)] rounded-[28px] p-8 md:p-12 min-h-[500px] flex flex-col relative overflow-hidden backdrop-blur-[20px] shadow-xl max-w-3xl mx-auto">
                {/* Visual Segmented Progress indicators */}
                <div className="mb-10">
                    <div className="flex justify-between items-center relative">
                        <div className="absolute left-0 right-0 top-1/2 h-0.5 bg-[var(--card-border)] -translate-y-1/2 z-0" />
                        <div 
                            className="absolute left-0 top-1/2 h-0.5 bg-brand-gradient -translate-y-1/2 transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] z-0" 
                            style={{ width: `${((step - 1) / (totalSteps - 1)) * 100}%` }}
                        />
                        {[1, 2, 3, 4, 5].map((s) => (
                            <button
                                key={s}
                                type="button"
                                onClick={() => {
                                    if (s < step || (s === 2 && activeCatId) || (s === 3 && selectedChild) || (s === 4 && scale)) {
                                        setStep(s);
                                    }
                                }}
                                className={`w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs relative z-10 transition-all duration-300 ${
                                    step >= s 
                                        ? 'bg-brand-gradient text-white shadow-md scale-110' 
                                        : 'bg-[var(--card-bg)] border-2 border-[var(--card-border)] text-text-sub hover:border-brand-primary/40'
                                }`}
                            >
                                {s}
                            </button>
                        ))}
                    </div>
                    <div className="flex justify-between text-[9px] font-black tracking-wider uppercase text-text-sub mt-3 px-1">
                        <span>{t('estimator.step1', 'Kateqoriya')}</span>
                        <span>{t('estimator.step2', 'Xidmət')}</span>
                        <span>{t('estimator.step3', 'Həcm')}</span>
                        <span>{t('estimator.step4', 'Müddət')}</span>
                        <span>{t('estimator.step5', 'Analiz')}</span>
                    </div>
                </div>

                {/* Step Content Area */}
                <div className="flex-1 flex flex-col justify-center">
                    <AnimatePresence mode="wait">
                        {renderStepContent()}
                    </AnimatePresence>
                </div>

                {/* Navigation Actions */}
                <div className="mt-10 flex justify-between gap-4 border-t border-[var(--card-border)] pt-6">
                    <button 
                        type="button" 
                        onClick={step === 5 ? () => setStep(1) : prevStep} 
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
                            <span>{t('estimator.next', 'İrəli')}</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3" className="stroke-current"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
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
                    timeline: tlLabel,
                    priceRange: priceResult
                }}
            />
        </SectionWrapper>
    );
}
