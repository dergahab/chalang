import React, { useState, useEffect } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { useTheme } from '@/Hooks/useTheme';

interface MobileMenuProps {
    isOpen: boolean;
    onClose: () => void;
}

export default function MobileMenu({ isOpen, onClose }: MobileMenuProps) {
    const { url } = usePage();
    const props = usePage().props as any;
    const locale = (props.locale || 'az').toUpperCase();
    const { theme, toggleTheme } = useTheme();

    // Accordion States
    const [activeSection, setActiveSection] = useState<string | null>(null);

    const toggleSection = (section: string) => {
        setActiveSection(activeSection === section ? null : section);
    };

    const isActive = (path: string) => url.startsWith(path);

    // Swipe to Close Logic (Mobile Gesture)
    const [touchStart, setTouchStart] = useState<number | null>(null);
    const [touchEnd, setTouchEnd] = useState<number | null>(null);

    const minSwipeDistance = 50;

    const onTouchStart = (e: React.TouchEvent) => {
        setTouchEnd(null);
        setTouchStart(e.targetTouches[0].clientX);
    };

    const onTouchMove = (e: React.TouchEvent) => {
        setTouchEnd(e.targetTouches[0].clientX);
    };

    const onTouchEndHandler = () => {
        if (!touchStart || !touchEnd) return;
        const distance = touchStart - touchEnd;
        const isRightSwipe = distance < -minSwipeDistance;
        if (isRightSwipe) {
            onClose();
        }
    };

    // Prevent body scroll when menu is open
    useEffect(() => {
        if (isOpen) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
        }
        return () => { document.body.style.overflow = 'auto'; };
    }, [isOpen]);

    // Close on route change
    useEffect(() => {
        onClose();
    }, [url]);

    // Animation classes
    const overlayClasses = isOpen ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none delay-200';
    const contentClasses = isOpen ? 'translate-x-0' : 'translate-x-full';

    return (
        <div className={`fixed inset-0 z-[5000] flex justify-end transition-all duration-500 ${overlayClasses}`}>
            {/* Backdrop */}
            <div
                className="absolute inset-0 bg-white/60 dark:bg-brand-dark/80 backdrop-blur-xl transition-opacity duration-500"
                onClick={onClose}
            />

            {/* Menu Panel */}
            <div 
                onTouchStart={onTouchStart}
                onTouchMove={onTouchMove}
                onTouchEnd={onTouchEndHandler}
                className={`relative w-full max-w-sm h-full bg-white dark:bg-brand-surface border-l border-gray-200 dark:border-white/5 shadow-2xl flex flex-col transition-transform duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] ${contentClasses}`}
            >

                {/* Header */}
                <div className="flex items-center justify-between p-6 border-b border-gray-100 dark:border-white/5">
                    <span className="text-xl font-bold font-display text-text-main dark:text-white tracking-tight">Menu</span>
                    <button
                        onClick={onClose}
                        className="w-10 h-10 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center text-text-main dark:text-white hover:bg-brand-primary hover:text-white transition-all duration-300"
                    >
                        <svg className="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                {/* Scrollable Content */}
                <div className="flex-1 overflow-y-auto p-6 space-y-6">

                    {/* Navigation Links */}
                    <nav className="space-y-2">

                        {/* HOME */}
                        <Link
                            href="/preview"
                            className={`flex items-center gap-4 px-4 py-3 rounded-xl text-lg font-bold transition-all ${isActive('/preview') && url === '/preview' ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-text-main dark:text-white hover:bg-gray-100 dark:hover:bg-white/5'}`}
                        >
                            <svg className="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" /></svg>
                            Home
                        </Link>

                        {/* COMPANY ACCORDION */}
                        <div className="overflow-hidden rounded-xl bg-gray-50 dark:bg-white/5">
                            <button
                                onClick={() => toggleSection('company')}
                                className={`w-full flex items-center justify-between px-4 py-3 text-lg font-bold text-text-main dark:text-white transition-colors ${activeSection === 'company' ? 'text-brand-primary' : ''}`}
                            >
                                <div className="flex items-center gap-4">
                                    <svg className="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" /></svg>
                                    Company
                                </div>
                                <svg className={`w-5 h-5 transition-transform duration-300 ${activeSection === 'company' ? 'rotate-180 text-brand-primary' : ''}`} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><path d="M6 9l6 6 6-6" /></svg>
                            </button>

                            <div className={`transition-all duration-300 ease-in-out ${activeSection === 'company' ? 'max-h-96 opacity-100 pb-2' : 'max-h-0 opacity-0 overflow-hidden'}`}>
                                <Link href="/preview/about-us" className="block px-14 py-2 min-h-[44px] flex items-center text-base font-medium text-text-sub dark:text-gray-400 active:text-brand-primary">About Us</Link>
                                <Link href="/preview/team" className="block px-14 py-2 min-h-[44px] flex items-center text-base font-medium text-text-sub dark:text-gray-400 active:text-brand-primary">Team</Link>
                                <a href="#" className="block px-14 py-2 min-h-[44px] flex items-center text-base font-medium text-text-sub dark:text-gray-400 active:text-brand-primary">Partners</a>
                                <Link href="/preview/careers" className="block px-14 py-2 min-h-[44px] flex items-center text-base font-medium text-text-sub dark:text-gray-400 active:text-brand-primary">Careers</Link>
                            </div>
                        </div>

                        {/* SOLUTIONS ACCORDION */}
                        <div className="overflow-hidden rounded-xl bg-gray-50 dark:bg-white/5">
                            <button
                                onClick={() => toggleSection('solutions')}
                                className={`w-full flex items-center justify-between px-4 py-3 text-lg font-bold text-text-main dark:text-white transition-colors ${activeSection === 'solutions' ? 'text-brand-primary' : ''}`}
                            >
                                <div className="flex items-center gap-4">
                                    <svg className="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L1 21h22L12 2zm0 3.99L19.53 19H4.47L12 5.99zM13 18h-2v-2h2v2zm0-4h-2v-4h2v4z" /></svg>
                                    Solutions
                                </div>
                                <svg className={`w-5 h-5 transition-transform duration-300 ${activeSection === 'solutions' ? 'rotate-180 text-brand-primary' : ''}`} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><path d="M6 9l6 6 6-6" /></svg>
                            </button>

                            <div className={`transition-all duration-300 ease-in-out ${activeSection === 'solutions' ? 'max-h-96 opacity-100 pb-2' : 'max-h-0 opacity-0 overflow-hidden'}`}>
                                <a href="#" className="block px-14 py-2 min-h-[44px] flex items-center text-base font-medium text-text-sub dark:text-gray-400 active:text-brand-primary">Services</a>
                                <a href="#" className="block px-14 py-2 min-h-[44px] flex items-center text-base font-medium text-text-sub dark:text-gray-400 active:text-brand-primary">Products</a>
                                <a href="#" className="block px-14 py-2 min-h-[44px] flex items-center text-base font-medium text-text-sub dark:text-gray-400 active:text-brand-primary">Industries</a>
                            </div>
                        </div>

                        {/* WORK ACCORDION */}
                        <div className="overflow-hidden rounded-xl bg-gray-50 dark:bg-white/5">
                            <button
                                onClick={() => toggleSection('work')}
                                className={`w-full flex items-center justify-between px-4 py-3 text-lg font-bold text-text-main dark:text-white transition-colors ${activeSection === 'work' ? 'text-brand-primary' : ''}`}
                            >
                                <div className="flex items-center gap-4">
                                    <svg className="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z" /></svg>
                                    Work
                                </div>
                                <svg className={`w-5 h-5 transition-transform duration-300 ${activeSection === 'work' ? 'rotate-180 text-brand-primary' : ''}`} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><path d="M6 9l6 6 6-6" /></svg>
                            </button>

                            <div className={`transition-all duration-300 ease-in-out ${activeSection === 'work' ? 'max-h-96 opacity-100 pb-2' : 'max-h-0 opacity-0 overflow-hidden'}`}>
                                <Link href="/preview/portfolio" className="block px-14 py-2 min-h-[44px] flex items-center text-base font-medium text-text-sub dark:text-gray-400 active:text-brand-primary">Portfolio</Link>
                                <Link href="/preview/case-studies" className="block px-14 py-2 min-h-[44px] flex items-center text-base font-medium text-text-sub dark:text-gray-400 active:text-brand-primary">Case Studies</Link>
                            </div>
                        </div>

                        {/* INSIGHTS ACCORDION */}
                        <div className="overflow-hidden rounded-xl bg-gray-50 dark:bg-white/5">
                            <button
                                onClick={() => toggleSection('insights')}
                                className={`w-full flex items-center justify-between px-4 py-3 text-lg font-bold text-text-main dark:text-white transition-colors ${activeSection === 'insights' ? 'text-brand-primary' : ''}`}
                            >
                                <div className="flex items-center gap-4">
                                    <svg className="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z" /></svg>
                                    Insights
                                </div>
                                <svg className={`w-5 h-5 transition-transform duration-300 ${activeSection === 'insights' ? 'rotate-180 text-brand-primary' : ''}`} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><path d="M6 9l6 6 6-6" /></svg>
                            </button>

                            <div className={`transition-all duration-300 ease-in-out ${activeSection === 'insights' ? 'max-h-96 opacity-100 pb-2' : 'max-h-0 opacity-0 overflow-hidden'}`}>
                                <Link href="/preview/blogs" className="block px-14 py-2 min-h-[44px] flex items-center text-base font-medium text-text-sub dark:text-gray-400 active:text-brand-primary">Blog</Link>
                                <a href="#" className="block px-14 py-2 min-h-[44px] flex items-center text-base font-medium text-text-sub dark:text-gray-400 active:text-brand-primary">Events</a>
                            </div>
                        </div>

                        {/* CONTACT */}
                        <Link
                            href="/preview/contact"
                            className={`flex items-center gap-4 px-4 py-3 rounded-xl text-lg font-bold transition-all ${isActive('/preview/contact') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-text-main dark:text-white hover:bg-gray-100 dark:hover:bg-white/5'}`}
                        >
                            <svg className="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" /></svg>
                            Contact
                        </Link>

                    </nav>

                    <hr className="border-gray-100 dark:border-white/5" />

                    {/* Controls */}
                    <div className="space-y-4">
                        {/* Theme Toggle */}
                        <button
                            onClick={toggleTheme}
                            className="w-full flex items-center justify-between px-4 py-3 rounded-xl bg-gray-50 dark:bg-white/5 text-text-main dark:text-white font-bold"
                        >
                            <span className="flex items-center gap-4">
                                {theme === 'light' ? (
                                    <svg className="w-6 h-6 text-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><circle cx="12" cy="12" r="5" /><line x1="12" y1="1" x2="12" y2="3" /><line x1="12" y1="21" x2="12" y2="23" /><line x1="4.22" y1="4.22" x2="5.64" y2="5.64" /><line x1="18.36" y1="18.36" x2="19.78" y2="19.78" /><line x1="1" y1="12" x2="3" y2="12" /><line x1="21" y1="12" x2="23" y2="12" /><line x1="4.22" y1="19.78" x2="5.64" y2="18.36" /><line x1="18.36" y1="5.64" x2="19.78" y2="4.22" /></svg>
                                ) : (
                                    <svg className="w-6 h-6 text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                                )}
                                {theme === 'light' ? 'Light Mode' : 'Dark Mode'}
                            </span>
                        </button>

                        {/* Language */}
                        <div className="grid grid-cols-3 gap-2">
                            {['en', 'az', 'ru'].map((lang) => (
                                <button
                                    key={lang}
                                    onClick={() => window.location.href = `/lang/${lang}`}
                                    className={`py-2 min-h-[44px] flex items-center justify-center rounded-lg text-sm font-bold uppercase transition-all ${locale === lang.toUpperCase() ? 'bg-brand-primary text-white shadow-lg' : 'bg-gray-50 dark:bg-white/5 text-text-sub dark:text-gray-400'}`}
                                >
                                    {lang}
                                </button>
                            ))}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    );
}
