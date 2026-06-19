import React, { useState, useEffect, useRef, useCallback } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import type { Translations } from '@/types';

interface Message {
    role: 'user' | 'ai';
    text: string;
}

interface ConversationStep {
    question: string;
    key: 'budget' | 'timeline' | 'service_type' | 'name' | 'phone';
    options?: string[];
}

const leadFlow: ConversationStep[] = [
    { question: 'Sizi hansı xidmət növü maraqlandırır?', key: 'service_type', options: ['Veb sayt', 'Mobil tətbiq', 'AI/Həll', 'UI/UX Dizayn', 'Rəqəmsal marketinq'] },
    { question: 'Layihəniz üçün təxmini büdcəniz nədir?', key: 'budget', options: ['500-2000 ₼', '2000-5000 ₼', '5000-10000 ₼', '10000+ ₼'] },
    { question: 'Layihəni nə vaxta qədər tamamlamaq istəyirsiniz?', key: 'timeline', options: ['1-2 həftə', '1 ay', '2-3 ay', '3+ ay'] },
    { question: 'Adınızı və soyadınızı öyrənə bilərəm?', key: 'name' },
    { question: 'Əlaqə nömrənizi bildirərdiniz?', key: 'phone' },
];

export default function AIWidget({ translations }: { translations: Translations }) {
    const [isOpen, setIsOpen] = useState(false);
    const [showRocket, setShowRocket] = useState(false);
    const [messages, setMessages] = useState<Message[]>([]);
    const [inputText, setInputText] = useState('');
    const [isTyping, setIsTyping] = useState(false);
    const [leadStep, setLeadStep] = useState(-1);
    const [collected, setCollected] = useState<Record<string, string>>({});
    const [leadDone, setLeadDone] = useState(false);
    const messagesEndRef = useRef<HTMLDivElement>(null);
    const [isFirstOpen, setIsFirstOpen] = useState(true);

    const t = (key: string, fallback: string) => {
        const keys = key.split('.');
        let val: any = translations;
        for (const k of keys) val = val?.[k];
        return typeof val === 'string' ? val : fallback;
    };

    useEffect(() => {
        const handleScroll = () => {
            setShowRocket(window.scrollY > 300);
        };
        window.addEventListener('scroll', handleScroll, { passive: true });
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    useEffect(() => {
        messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
    }, [messages, isTyping]);

    const addMessage = useCallback((role: 'user' | 'ai', text: string) => {
        setMessages(prev => [...prev, { role, text }]);
    }, []);

    const startLeadFlow = useCallback(() => {
        setLeadStep(0);
        setIsTyping(true);
        setTimeout(() => {
            setIsTyping(false);
            addMessage('ai', leadFlow[0].question);
        }, 800);
    }, [addMessage]);

    const handleQuickReply = useCallback((option: string, stepKey: string) => {
        addMessage('user', option);
        setCollected(prev => ({ ...prev, [stepKey]: option }));

        const nextIdx = leadStep + 1;
        if (nextIdx < leadFlow.length) {
            setLeadStep(nextIdx);
            setIsTyping(true);
            setTimeout(() => {
                setIsTyping(false);
                addMessage('ai', leadFlow[nextIdx].question);
            }, 600);
        } else {
            setLeadStep(-1);
            setLeadDone(true);
            setIsTyping(true);
            setTimeout(() => {
                setIsTyping(false);
                addMessage('ai', `Təşəkkürlər! Məlumatlarınız qeydə alındı. Mütəxəssisimiz ən qısa zamanda sizinlə əlaqə saxlayacaq.`);
            }, 800);
        }
    }, [leadStep, addMessage]);

    const handleSendMessage = useCallback((e?: React.FormEvent) => {
        e?.preventDefault();
        if (!inputText.trim()) return;

        const text = inputText.trim();
        setInputText('');
        addMessage('user', text);

        if (leadStep >= 0 && leadStep < leadFlow.length) {
            const step = leadFlow[leadStep];
            handleQuickReply(text, step.key);
            return;
        }

        setIsTyping(true);
        setTimeout(() => {
            setIsTyping(false);
            const replies: Record<string, string[]> = {
                'qiymət': ['Qiymətlərimiz layihənin mürəkkəbliyindən asılı olaraq dəyişir. Təxmini büdcə almaq üçün "Qiymət Hesablayıcı" bölməmizdən istifadə edə bilərsiniz.', 'Daha dəqiq məlumat üçün bizimlə əlaqə saxlayın.'],
                'xidmət': ['Biz veb sayt, mobil tətbiq, AI həllər, UI/UX dizayn və rəqəmsal marketinq xidmətləri göstəririk.', 'Hansı xidmət növü sizi maraqlandırır?'],
                'əlaqə': ['Bizimlə əlaqə saxlamaq üçün əlaqə səhifəmizdəki formu doldura bilərsiniz, yaxud birbaşa zəng edə bilərsiniz.', 'Mən sizə kömək edə bilərəm?'],
                'portfolio': ['Portfoliomuzda müxtəlif sahələr üzrə layihələrimiz var. Ən son işlərimizi görmək üçün Portfolio bölməmizə baxın.'],
            };
            const lower = text.toLowerCase();
            let reply = '';
            for (const [key, vals] of Object.entries(replies)) {
                if (lower.includes(key)) {
                    reply = vals[Math.floor(Math.random() * vals.length)];
                    break;
                }
            }
            if (!reply) {
                reply = 'Məmnuniyyətlə kömək edərəm. Zəhmət olmasa sualınızı bir qədər dəqiqləşdirin və ya aşağıdakı variantlardan birini seçin.';
            }
            addMessage('ai', reply);
        }, 1000);
    }, [inputText, leadStep, leadFlow, addMessage, handleQuickReply]);

    useEffect(() => {
        if (isOpen && isFirstOpen) {
            setIsFirstOpen(false);
            setMessages([
                { role: 'ai', text: t('ai.welcome', 'Salam! Mən Chalang AI Sales Agentəm. Sizə layihəniz üçün ən uyğun həlli tapmaqda kömək edə bilərəm.') }
            ]);
            setTimeout(() => {
                addMessage('ai', 'Hansı mövzuda məlumat almaq istərdiniz? Aşağıdakı variantlardan birini seçə bilərsiniz.');
            }, 1200);
        }
    }, [isOpen, isFirstOpen, t, addMessage]);

    const scrollToTop = () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    return (
        <div className="ai-widget">
            <AnimatePresence>
                {isOpen && (
                    <motion.div
                        id="ai-modal"
                        initial={{ opacity: 0, y: 20, scale: 0.9 }}
                        animate={{ opacity: 1, y: 0, scale: 1 }}
                        exit={{ opacity: 0, y: 20, scale: 0.9 }}
                        transition={{ type: "spring", damping: 25, stiffness: 300 }}
                        className="ai-modal active"
                    >
                        <div className="ai-header">
                            <div className="flex items-center gap-2.5">
                                <div className="w-3 h-3 rounded-full bg-green-400 animate-pulse" />
                                <h4>Chalang AI</h4>
                            </div>
                            <button className="ai-close" onClick={() => setIsOpen(false)}>&times;</button>
                        </div>
                        <div className="ai-body" id="ai-body">
                            {messages.map((msg, idx) => (
                                <motion.div
                                    key={idx}
                                    initial={{ opacity: 0, y: 8 }}
                                    animate={{ opacity: 1, y: 0 }}
                                    className={`ai-message ${msg.role === 'user' ? 'user-msg' : ''}`}
                                >
                                    {msg.text}
                                </motion.div>
                            ))}

                            {!leadDone && leadStep < leadFlow.length && leadStep >= 0 && (
                                <div className="flex flex-wrap gap-1.5 mt-2.5 mb-1">
                                    {leadFlow[leadStep].options?.map((opt) => (
                                        <button
                                            key={opt}
                                            onClick={() => {
                                                const step = leadFlow[leadStep];
                                                handleQuickReply(opt, step.key);
                                            }}
                                            className="px-3 py-1.5 rounded-full text-[11px] font-bold border border-brand-primary/30 bg-brand-primary/5 text-brand-primary hover:bg-brand-primary hover:text-white transition-all duration-200 cursor-pointer"
                                        >
                                            {opt}
                                        </button>
                                    ))}
                                </div>
                            )}

                            {!leadDone && leadStep === -1 && messages.length > 1 && (
                                <div className="flex flex-wrap gap-1.5 mt-2.5 mb-1">
                                    {['Qiymət', 'Xidmətlər', 'Portfolio', 'Əlaqə', 'Təklif al'].map((opt) => (
                                        <button
                                            key={opt}
                                            onClick={() => {
                                                if (opt === 'Təklif al') {
                                                    handleQuickReply('Təklif almaq istəyirəm', 'service_type');
                                                    startLeadFlow();
                                                } else {
                                                    handleSendMessage();
                                                    const fakeInput = opt.toLowerCase();
                                                    addMessage('user', opt);
                                                    setIsTyping(true);
                                                    setTimeout(() => {
                                                        setIsTyping(false);
                                                        const replies: Record<string, string> = {
                                                            'Qiymət': 'Qiymətlərimiz layihənin mürəkkəbliyindən asılıdır. Dəqiq büdcə üçün "Qiymət Hesablayıcı"nı istifadə edin.',
                                                            'Xidmətlər': 'Veb sayt, mobil tətbiq, AI həllər, UI/UX dizayn və rəqəmsal marketinq xidmətlərimiz var.',
                                                            'Portfolio': 'Portfolio bölməmizdə son layihələrimizi görə bilərsiniz.',
                                                            'Əlaqə': 'Bizimlə əlaqə səhifəmizdəki form vasitəsilə əlaqə saxlaya bilərsiniz.',
                                                        };
                                                        addMessage('ai', replies[opt] || 'Məmnuniyyətlə kömək edərəm.');
                                                    }, 800);
                                                }
                                            }}
                                            className="px-3 py-1.5 rounded-full text-[11px] font-bold border border-brand-primary/30 bg-brand-primary/5 text-brand-primary hover:bg-brand-primary hover:text-white transition-all duration-200 cursor-pointer"
                                        >
                                            {opt}
                                        </button>
                                    ))}
                                </div>
                            )}
                        </div>

                        {isTyping && (
                            <div className="typing-indicator active" id="typing-indicator">
                                <span className="flex gap-1 items-center">
                                    <span className="w-1.5 h-1.5 rounded-full bg-brand-primary animate-bounce" style={{ animationDelay: '0ms' }} />
                                    <span className="w-1.5 h-1.5 rounded-full bg-brand-primary animate-bounce" style={{ animationDelay: '150ms' }} />
                                    <span className="w-1.5 h-1.5 rounded-full bg-brand-primary animate-bounce" style={{ animationDelay: '300ms' }} />
                                </span>
                            </div>
                        )}

                        <div className="ai-input-group">
                            <input
                                type="text"
                                className="ai-input"
                                id="ai-input"
                                value={inputText}
                                onChange={(e) => setInputText(e.target.value)}
                                onKeyPress={(e) => e.key === 'Enter' && handleSendMessage()}
                                placeholder={t('ai.placeholder', 'Sualınızı bura yazın...')}
                                disabled={leadStep >= 0}
                            />
                            <button className="ai-send" id="ai-send" onClick={() => handleSendMessage()} disabled={leadStep >= 0}>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                                    <line x1="22" y1="2" x2="11" y2="13" />
                                    <polygon points="22 2 15 22 11 13 2 9 22 2" />
                                </svg>
                            </button>
                        </div>
                    </motion.div>
                )}
            </AnimatePresence>

            <AnimatePresence>
                {showRocket && !isOpen && (
                    <motion.div
                        id="docked-rocket"
                        className="docked-rocket"
                        initial={{ opacity: 0, visibility: 'hidden' }}
                        animate={{ opacity: 1, visibility: 'visible' }}
                        exit={{ opacity: 0, visibility: 'hidden' }}
                        onClick={scrollToTop}
                        style={{ cursor: 'pointer' }}
                    >
                        <svg className="rocket-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                            <path d="M12 19V5M5 12l7-7 7 7" />
                        </svg>
                    </motion.div>
                )}
            </AnimatePresence>

            <button
                className={`ai-trigger ${isOpen ? 'active' : ''}`}
                id="ai-trigger"
                onClick={() => setIsOpen(!isOpen)}
                aria-label="AI Assistant"
            >
                <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H5.17L4 17.17V4h16v12z" />
                    <circle cx="12" cy="11" r="1.5" />
                    <circle cx="8" cy="11" r="1.5" />
                    <circle cx="16" cy="11" r="1.5" />
                </svg>
            </button>
        </div>
    );
}
