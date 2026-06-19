import React, { useState, useEffect } from 'react';

export default function CookieConsent() {
    const [isVisible, setIsVisible] = useState(false);
    const [isExpanded, setIsExpanded] = useState(false);
    const [analyticsEnabled, setAnalyticsEnabled] = useState(true);
    const [marketingEnabled, setMarketingEnabled] = useState(true);
    const [showFab, setShowFab] = useState(false);

    const STORAGE_KEY = 'chalang_cookie_consent';
    const CONSENT_VERSION = 'v2';
    const ANALYTICS_COOKIE = 'analytics_consent';
    const MARKETING_COOKIE = 'marketing_consent';
    const COOKIE_DAYS = 365;

    useEffect(() => {
        const storedConsent = readStoredConsent();
        const analyticsCookie = getCookie(ANALYTICS_COOKIE);
        const marketingCookie = getCookie(MARKETING_COOKIE);
        const dnt = hasDnt();

        // Check Logic
        if (dnt && !storedConsent && analyticsCookie === null && marketingCookie === null) {
            persistConsent(false, false);
            return;
        }

        let effectiveConsent = storedConsent;
        if (!effectiveConsent && (analyticsCookie !== null || marketingCookie !== null)) {
            effectiveConsent = {
                version: CONSENT_VERSION,
                analytics: analyticsCookie === '1',
                marketing: marketingCookie === '1',
            };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(effectiveConsent));
        }

        const needsFreshChoice = !effectiveConsent || effectiveConsent.version !== CONSENT_VERSION;

        // Initial toggles state
        setAnalyticsEnabled(needsFreshChoice ? true : !!effectiveConsent?.analytics);
        setMarketingEnabled(needsFreshChoice ? true : !!effectiveConsent?.marketing);

        if (needsFreshChoice) {
            setTimeout(() => {
                showBar(false);
            }, 900);
        } else {
            setShowFab(true);
        }

        // Apply visual classes to body
        if (isVisible) {
            document.body.classList.add('cookie-consent-open');
        } else {
            document.body.classList.remove('cookie-consent-open');
        }

    }, []);

    // Effect for body class sync
    useEffect(() => {
        if (isVisible) {
            document.body.classList.add('cookie-consent-open');
        } else {
            document.body.classList.remove('cookie-consent-open');
        }
    }, [isVisible]);


    // Helpers
    const getCookie = (name: string) => {
        const prefix = name + '=';
        if (typeof document === 'undefined') return null;
        return document.cookie
            .split('; ')
            .find((item) => item.startsWith(prefix))
            ?.slice(prefix.length) ?? null;
    };

    const setCookie = (name: string, value: string) => {
        const maxAge = COOKIE_DAYS * 24 * 60 * 60;
        const secure = window.location.protocol === 'https:' ? '; Secure' : '';
        document.cookie = `${name}=${value}; path=/; max-age=${maxAge}; SameSite=Lax${secure}`;
    };

    const hasDnt = () => {
        if (typeof navigator === 'undefined') return false;
        // @ts-ignore
        const dnt = navigator.doNotTrack || window.doNotTrack || navigator.msDoNotTrack;
        return dnt === '1' || dnt === 'yes';
    };

    const readStoredConsent = () => {
        if (typeof localStorage === 'undefined') return null;
        const raw = localStorage.getItem(STORAGE_KEY);
        if (!raw) return null;
        if (raw === 'accepted' || raw === 'declined') {
            return {
                version: 'legacy',
                analytics: raw === 'accepted',
                marketing: false
            };
        }
        try {
            const data = JSON.parse(raw);
            if (data && typeof data === 'object') return data;
        } catch (err) {
            return null;
        }
        return null;
    };

    const persistConsent = (analytics: boolean, marketing: boolean) => {
        const payload = {
            version: CONSENT_VERSION,
            analytics: !!analytics,
            marketing: !!marketing,
            updatedAt: new Date().toISOString(),
        };
        localStorage.setItem(STORAGE_KEY, JSON.stringify(payload));
        setCookie(ANALYTICS_COOKIE, analytics ? '1' : '0');
        setCookie(MARKETING_COOKIE, marketing ? '1' : '0');
    };

    const showBar = (expanded = false) => {
        setIsVisible(true);
        if (expanded) setIsExpanded(true);
        setShowFab(false);
    };

    const hideBar = () => {
        setIsVisible(false);
        setIsExpanded(false);
        setShowFab(true);
    };

    // Handlers
    const handleAcceptAll = () => {
        setAnalyticsEnabled(true);
        setMarketingEnabled(true);
        persistConsent(true, true);
        hideBar();
        window.location.reload();
    };

    const handleDecline = () => {
        setAnalyticsEnabled(false);
        setMarketingEnabled(false);
        persistConsent(false, false);
        hideBar();
        window.location.reload();
    };

    const handleSave = () => {
        persistConsent(analyticsEnabled, marketingEnabled);
        hideBar();
        window.location.reload();
    };

    const toggleSettings = () => {
        setIsVisible(true); // Ensure visible
        setIsExpanded(!isExpanded);
        setShowFab(false);
    };

    // Listen for custom event or clicks on triggers
    useEffect(() => {
        const triggers = document.querySelectorAll('[data-cookie-settings]');
        const handler = (e: Event) => {
            e.preventDefault();
            showBar(true);
        };
        triggers.forEach(t => t.addEventListener('click', handler));
        return () => {
            triggers.forEach(t => t.removeEventListener('click', handler));
        };
    });

    return (
        <>
            <div id="cookie-consent-bar" className={`fixed bottom-4 md:bottom-8 right-4 md:right-8 w-[calc(100%-2rem)] md:w-[450px] rounded-2xl shadow-2xl backdrop-blur-xl border z-[9999] transition-all duration-500 ease-in-out transform ${isVisible ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0 pointer-events-none'}`} style={{ background: 'var(--nav-bg-glass)', borderColor: 'var(--nav-border)' }}>
                <div className="p-5 md:p-6">
                    <div className="flex flex-col gap-4">
                        <div className="flex items-center gap-4 flex-1">
                            <div className="hidden md:flex items-center justify-center w-12 h-12 rounded-full bg-brand-primary/10 text-brand-primary shrink-0">
                                <svg viewBox="0 0 24 24" fill="none" className="w-6 h-6">
                                    <path d="M21.593 7.203a2.975 2.975 0 0 0-3.692-3.692c-.14-.046-.24-.165-.254-.31a2.976 2.976 0 0 0-5.75-.436.299.299 0 0 1-.36.237 2.976 2.976 0 0 0-4.636 2.87.3.3 0 0 1-.362.296 2.976 2.976 0 0 0-2.203 4.22.3.3 0 0 1-.035.467 2.974 2.974 0 0 0 .524 5.382.3.3 0 0 1 .236.417 2.976 2.976 0 0 0 4.22 2.202.3.3 0 0 1 .468.035 2.975 2.975 0 0 0 5.38.525.3.3 0 0 1 .418.236 2.975 2.975 0 0 0 4.22-2.203.3.3 0 0 1 .467-.035 2.974 2.974 0 0 0 .525-5.38.3.3 0 0 1 .235-.418 2.974 2.974 0 0 0 .6-5.413.3.3 0 0 1-.25-.3zM12 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1-10 10zm-2-8a1 1 0 1 1-1 1 1 1 0 0 1 1-1zm6-3a1 1 0 1 1-1 1 1 1 0 0 1 1-1zm-6-3a1 1 0 1 1-1 1 1 1 0 0 1 1-1z" fill="currentColor" />
                                </svg>
                            </div>
                            <div className="text-center md:text-left">
                                <p className="text-sm md:text-base" style={{ color: 'var(--text-main)' }}>
                                    Təcrübənizi yaxşılaşdırmaq üçün kukilərdən istifadə edirik.
                                </p>
                                <button type="button" className="inline-flex items-center gap-1 mt-1 text-xs font-bold uppercase tracking-wider hover:opacity-80 transition-opacity" style={{ color: 'var(--brand-primary)' }} onClick={toggleSettings}>
                                    <span>Cookie ayarları</span>
                                    <svg className={`w-3 h-3 transition-transform ${isExpanded ? 'rotate-180' : ''}`} fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {/* Buttons */}
                        <div className="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 shrink-0 w-full mt-2">
                            <button className="px-4 py-2 rounded-lg text-sm font-bold transition-colors w-full sm:w-auto" style={{ color: 'var(--text-sub)' }} onClick={handleDecline}>Rədd et</button>
                            <button className="px-6 py-2 rounded-lg text-sm font-bold text-white transition-all duration-300 hover:-translate-y-0.5 w-full sm:w-auto whitespace-nowrap" style={{ background: 'var(--brand-gradient)', boxShadow: '0 4px 15px var(--brand-glow)' }} onClick={handleAcceptAll}>Hamısını qəbul et</button>
                        </div>
                    </div>

                    {/* Expanded Settings */}
                    {isExpanded && (
                        <div className="mt-6 pt-6 border-t border-gray-200 dark:border-white/10 animate-fade-in-up">
                            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                                {/* Options... (Simplified for brevity, can re-add full logic if needed, but keeping visual tight) */}
                                <label className="flex items-start gap-3 cursor-not-allowed opacity-70">
                                    <input type="checkbox" checked disabled className="mt-1 rounded border-gray-300 text-brand-primary focus:ring-brand-primary" />
                                    <div>
                                        <div className="font-bold text-sm" style={{ color: 'var(--text-main)' }}>Məcburi</div>
                                        <div className="text-xs" style={{ color: 'var(--text-sub)' }}>Saytın əsas funksionallığı üçün tələb olunur.</div>
                                    </div>
                                </label>
                                <label className="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" checked={analyticsEnabled} onChange={(e) => setAnalyticsEnabled(e.target.checked)} className="mt-1 rounded border-gray-300 text-brand-primary focus:ring-brand-primary" />
                                    <div>
                                        <div className="font-bold text-sm" style={{ color: 'var(--text-main)' }}>Analitika</div>
                                        <div className="text-xs" style={{ color: 'var(--text-sub)' }}>Veb saytımızı təkmilləşdirməyə kömək edir.</div>
                                    </div>
                                </label>
                                <label className="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" checked={marketingEnabled} onChange={(e) => setMarketingEnabled(e.target.checked)} className="mt-1 rounded border-gray-300 text-brand-primary focus:ring-brand-primary" />
                                    <div>
                                        <div className="font-bold text-sm" style={{ color: 'var(--text-main)' }}>Marketinq</div>
                                        <div className="text-xs" style={{ color: 'var(--text-sub)' }}>Fərdiləşdirilmiş reklamlar.</div>
                                    </div>
                                </label>
                            </div>
                            <div className="mt-6 flex justify-end">
                                <button className="px-6 py-2 rounded-lg text-sm font-bold text-white hover:opacity-90 transition-opacity" style={{ background: 'var(--brand-primary)' }} onClick={handleSave}>Seçimləri yadda saxla</button>
                            </div>
                        </div>
                    )}
                </div>
            </div>

            <button
                type="button"
                className={`cookie-fab ${showFab ? 'visible' : ''}`}
                onClick={() => showBar(true)}
                aria-label="Cookie Settings"
                title="Cookie Settings"
            >
                <svg viewBox="0 0 24 24" fill="none" className="cookie-svg">
                    <path d="M21.593 7.203a2.975 2.975 0 0 0-3.692-3.692c-.14-.046-.24-.165-.254-.31a2.976 2.976 0 0 0-5.75-.436.299.299 0 0 1-.36.237 2.976 2.976 0 0 0-4.636 2.87.3.3 0 0 1-.362.296 2.976 2.976 0 0 0-2.203 4.22.3.3 0 0 1-.035.467 2.974 2.974 0 0 0 .524 5.382.3.3 0 0 1 .236.417 2.976 2.976 0 0 0 4.22 2.202.3.3 0 0 1 .468.035 2.975 2.975 0 0 0 5.38.525.3.3 0 0 1 .418.236 2.975 2.975 0 0 0 4.22-2.203.3.3 0 0 1 .467-.035 2.974 2.974 0 0 0 .525-5.38.3.3 0 0 1 .235-.418 2.974 2.974 0 0 0 .6-5.413.3.3 0 0 1-.25-.3zM12 22a10 10 0 1 1 10-10 10.011 10.011 0 0 1-10 10zm-2-8a1 1 0 1 1-1 1 1 1 0 0 1 1-1zm6-3a1 1 0 1 1-1 1 1 1 0 0 1 1-1zm-6-3a1 1 0 1 1-1 1 1 1 0 0 1 1-1z" fill="currentColor" />
                </svg>
            </button>
        </>
    );
}
