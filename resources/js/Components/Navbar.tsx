import { Link, usePage } from '@inertiajs/react';
import React, { useState, useMemo, useRef, useEffect } from 'react';
import { useTheme } from '@/Hooks/useTheme';
import { useSectionEnabled } from '@/Hooks/useSectionEnabled';
import MobileMenu from './MobileMenu';
import SearchOverlay from './SearchOverlay';

export default function Navbar() {
    const { url } = usePage();
    const props = usePage().props as any;
    const locale = (props.locale || 'az').toUpperCase();
    const translations = props.translations?.nav || {};
    const globalSettings = props.global_settings || {};
    const showClientPortal = globalSettings.nav_client_portal === '1';
    const showPartnerHub = globalSettings.nav_partner_hub === '1';
    
    const { theme, toggleTheme } = useTheme();
    const isEnabled = useSectionEnabled(props.content_text_map || {});

    // Scroll state & listener
    const [scrolled, setScrolled] = useState(false);
    useEffect(() => {
        const handleScroll = () => {
            setScrolled(window.scrollY > 50);
        };
        window.addEventListener('scroll', handleScroll, { passive: true });
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    // Translation helper
    const t = (key: string): string => translations[key] || key;

    // Unified Menu State (Mutually Exclusive)
    const [activeMenu, setActiveMenu] = useState<string | null>(null);

    const handleMouseLeave = () => {
        setActiveMenu(null);
    };

    // Mobile Menu State
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

    // Helper to check active state
    // Exact match for root items, startsWith for sections
    const isActive = (path: string, exact = false) => {
        if (exact) return url === path;
        return url.startsWith(path);
    };

    // Helper for active class string
    const activeClass = (path: string, exact = false) => isActive(path, exact) ? 'active' : '';

    // Mobile Menu - ESC Key Support
    useEffect(() => {
        const handleEsc = (event: KeyboardEvent) => {
            if (event.key === 'Escape' && mobileMenuOpen) {
                setMobileMenuOpen(false);
            }
        };
        window.addEventListener('keydown', handleEsc);
        return () => window.removeEventListener('keydown', handleEsc);
    }, [mobileMenuOpen]);

    // Search Overlay State (for ARIA)
    const [searchOpen, setSearchOpen] = useState(false);

    // Language Dropdown State
    const [langOpen, setLangOpen] = useState(false);
    const langRef = useRef<HTMLDivElement>(null);

    const toggleLang = () => {
        const newState = !langOpen;
        setLangOpen(newState);
        if (newState) {
            setActiveMenu(null); // Close main menu if opening lang
            setSearchOpen(false); // Close search if opening lang
        }
    };

    // Click Outside for Language Dropdown
    useEffect(() => {
        const handleClickOutside = (event: MouseEvent) => {
            if (langRef.current && !langRef.current.contains(event.target as Node)) {
                setLangOpen(false);
            }
        };

        if (langOpen) {
            document.addEventListener('mousedown', handleClickOutside);
        }
        return () => {
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, [langOpen]);

    // Update handlers for mutual exclusivity
    const handleMouseEnter = (menu: string) => {
        setActiveMenu(menu);
        setLangOpen(false); // Close lang when hovering main menu
    };



    // Search Toggle Handler
    const toggleSearch = () => {
        const newState = !searchOpen;
        setSearchOpen(newState);
        if (newState) {
            setLangOpen(false); // Close lang when opening search
        }
    };



    // Logo Smart Link Logic (Problem 3 - Phase 1)
    const logoHref = useMemo(() => {
        if (url === '/preview') return '/';
        if (url.startsWith('/preview/')) return '/preview';
        return '/';
    }, [url]);

    return (
        <header id="masthead" className={`fixed top-0 left-0 w-full z-[1000] pointer-events-none transition-all duration-300 ${scrolled ? 'scrolled' : ''}`}>
            <div className="flex justify-between items-center px-6 mt-6 gap-1 lg:gap-2 xl:gap-4 transition-all duration-300 text-[clamp(10px,2vw-5px,16px)] pointer-events-none" style={{ width: '100%', maxWidth: '100%', marginLeft: 0, marginRight: 0 }}>

                {/* Left Island - Logo */}
                <div className="bg-white/30 dark:bg-[#0b0f19]/90 backdrop-blur-[40px] border border-white/90 dark:border-white/5 shadow-[0_10px_40px_rgba(0,0,0,0.1),inset_0_1px_0_rgba(255,255,255,0.8)] dark:shadow-[0_10px_40px_rgba(0,0,0,0.5)] rounded-[50px] px-[1.5em] flex items-center h-[var(--navbar-height)] pointer-events-auto transition-all duration-300 shrink-0">
                    <Link href={logoHref} aria-label="Chalang" className="text-brand-primary dark:text-brand-primary transition-colors duration-300">
                        <svg className="h-7 w-auto fill-current" viewBox="0 0 81.87 15.74">
                            <g>
                                <path fill="currentColor" d="M25.7,5.95c-.49-.62-1.3-1.22-2.46-1.22-1.96,0-3.33,1.59-3.33,3.31,0,1.84,1.46,3.38,3.34,3.38.87,0,1.75-.34,2.36-1.14h2.11c-.81,1.72-2.38,2.9-4.52,2.9-3.43,0-5.1-2.89-5.1-5.14s1.66-5.07,5.13-5.07c2.03,0,3.72,1.1,4.54,2.98h-2.07Z" />
                                <path fill="currentColor" d="M28.72,3.14h1.82v3.93h3.58v-3.93h1.82v9.8h-1.82v-4.11h-3.58v4.11h-1.82V3.14Z" />
                                <path fill="currentColor" d="M40.67,3.14h1.46l4.08,9.8h-2l-1.01-2.53h-3.6l-1.01,2.53h-2l4.08-9.8ZM42.51,8.65l-1.11-2.86-1.11,2.86h2.23Z" />
                                <path fill="currentColor" d="M46.89,3.14h1.82v8.04h2.99v1.76h-4.81V3.14Z" />
                                <path fill="currentColor" d="M56.09,3.14h1.46l4.08,9.8h-2l-1.01-2.53h-3.6l-1.01,2.53h-2l4.08-9.8ZM57.93,8.65l-1.11-2.86-1.11,2.86h2.23Z" />
                                <path fill="currentColor" d="M62.3,3.14h1.82l4.37,6.62V3.14h1.82v9.8h-1.82l-4.37-6.62v6.62h-1.82V3.14Z" />
                                <path fill="currentColor" d="M81.87,7.95c-.03,2.33-1.46,5.23-5.21,5.23s-5.23-2.72-5.23-5.07,1.78-5.14,5.21-5.14c2.25,0,4.01,1.14,4.74,3.06h-2.17c-.76-1.25-2.11-1.3-2.57-1.3-2.29,0-3.39,1.78-3.39,3.31,0,1.67,1.22,3.38,3.47,3.38,1.19,0,2.33-.54,2.86-1.76h-4.09v-1.71h6.39Z" />
                                <path fill="currentColor" d="M8.88.03C3.91-.37-.27,3.73.01,8.7c.18,3.15,2.14,5.82,4.88,7.04.02,0,.04-.02.03-.03-.22-.3-.35-.68-.35-1.08,0-.87.6-1.6,1.41-1.8.02,0,.02-.03,0-.04-1.88-.92-3.1-2.96-2.8-5.26.27-2.08,2.21-4.04,4.29-4.34,3.14-.44,5.82,1.98,5.82,5.03,0,2-1.16,3.74-2.85,4.56-.02,0-.02.04,0,.04.81.2,1.41.93,1.41,1.8,0,.4-.13.77-.34, 1.08-.01.02,0,.04.03.03,2.88-1.28,4.89-4.16,4.89-7.52C16.44,3.9,13.11.36,8.88.03Z" />
                            </g>
                        </svg>
                    </Link>
                </div>

                {/* Center Island - Desktop Menu */}
                <div className="nav-island island-center nav-desktop hidden lg:flex pointer-events-auto">
                    <ul id="site-navigation" className="flex list-none m-0 p-0 gap-[5px] items-center">
                        {/* HOME */}
                        <li className={isActive('/preview', true) || isActive('/preview/home') || isActive('/', true) || isActive('/home') ? 'active' : ''}>
                            <Link href="/">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                                </svg>
                                <span>{t('home')}</span>
                            </Link>
                        </li>

                        {/* COMPANY */}
                        <li 
                            className={`nav-item-dropdown ${activeMenu === 'company' || isActive('/preview/about-us') || isActive('/about-us') || isActive('/preview/team') || isActive('/team') ? 'active' : ''}`}
                            onMouseEnter={() => handleMouseEnter('company')}
                            onMouseLeave={handleMouseLeave}
                            onFocus={() => handleMouseEnter('company')}
                            onBlur={(e) => {
                                if (!e.currentTarget.contains(e.relatedTarget)) {
                                    handleMouseLeave();
                                }
                            }}
                        >
                            <a href="#">
                                {/* Nav Swap Logic */}
                                {isActive('/preview/about-us') || isActive('/about-us') ? (
                                    <>
                                        <span className="nav-swap-default">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                                            </svg>
                                            <span className="nav-text">{t('about')}</span>
                                        </span>
                                        <span className="nav-swap-hover">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
                                            </svg>
                                            <span className="nav-text">{t('company')}</span>
                                        </span>
                                    </>
                                ) : isActive('/preview/team') || isActive('/team') ? (
                                    <>
                                        <span className="nav-swap-default">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                                            </svg>
                                            <span className="nav-text">{t('team')}</span>
                                        </span>
                                        <span className="nav-swap-hover">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
                                            </svg>
                                            <span className="nav-text">{t('company')}</span>
                                        </span>
                                    </>
                                ) : (
                                    <>
                                        <span className="nav-swap-default">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
                                            </svg>
                                            <span className="nav-text">{t('company')}</span>
                                        </span>
                                        <span className="nav-swap-hover">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
                                            </svg>
                                            <span className="nav-text">{t('company')}</span>
                                        </span>
                                    </>
                                )}
                            </a>

                            {/* Dropdown Menu */}
                            <div className={`dropdown-menu ${activeMenu === 'company' ? 'show' : ''}`}>
                                <Link href="/about-us" className={`dropdown-item ${isActive('/preview/about-us') || isActive('/about-us') ? 'active' : ''}`}>
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                                    </svg>
                                    {t('about')}
                                </Link>
                                <Link href="/team" className={`dropdown-item ${isActive('/preview/team') || isActive('/team') ? 'active' : ''}`}>
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                                    </svg>
                                    {t('team')}
                                </Link>
                                <a href="#" className="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                                    </svg>
                                    {t('partners')}
                                </a>
                                <a href="#" className="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z" />
                                    </svg>
                                    {t('legal')}
                                </a>
                            </div>
                        </li>

                        {/* SOLUTIONS */}
                        <li 
                            className={`nav-item-dropdown ${activeMenu === 'services' || isActive('/preview/services') || isActive('/services') || isActive('/preview/packages') || isActive('/packages') ? 'active' : ''}`}
                            onMouseEnter={() => handleMouseEnter('services')}
                            onMouseLeave={handleMouseLeave}
                            onFocus={() => handleMouseEnter('services')}
                            onBlur={(e) => {
                                if (!e.currentTarget.contains(e.relatedTarget)) {
                                    handleMouseLeave();
                                }
                            }}
                        >
                            <a href="#">
                                {/* Nav Swap Logic */}
                                {isActive('/preview/services') || isActive('/services') ? (
                                    <>
                                        <span className="nav-swap-default">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" />
                                            </svg>
                                            <span className="nav-text">{t('services')}</span>
                                        </span>
                                        <span className="nav-swap-hover">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2 2 7l10 5 10-5-10-5zm0 9 2.5-1.25L12 8.5 9.5 9.75 12 11zm0 2.5-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z" />
                                            </svg>
                                            <span className="nav-text">{t('solutions')}</span>
                                        </span>
                                    </>
                                ) : isActive('/preview/packages') ? (
                                    <>
                                        <span className="nav-swap-default">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M21 8V7l-9-4-9 4v1l9 4 9-4zm-9 6-9-4v7l9 4 9-4v-7l-9 4z" />
                                            </svg>
                                            <span className="nav-text">{t('products')}</span>
                                        </span>
                                        <span className="nav-swap-hover">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2 2 7l10 5 10-5-10-5zm0 9 2.5-1.25L12 8.5 9.5 9.75 12 11zm0 2.5-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z" />
                                            </svg>
                                            <span className="nav-text">{t('solutions')}</span>
                                        </span>
                                    </>
                                ) : (
                                    <>
                                        <span className="nav-swap-default">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2 2 7l10 5 10-5-10-5zm0 9 2.5-1.25L12 8.5 9.5 9.75 12 11zm0 2.5-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z" />
                                            </svg>
                                            <span className="nav-text">{t('solutions')}</span>
                                        </span>
                                        <span className="nav-swap-hover">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2 2 7l10 5 10-5-10-5zm0 9 2.5-1.25L12 8.5 9.5 9.75 12 11zm0 2.5-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z" />
                                            </svg>
                                            <span className="nav-text">{t('solutions')}</span>
                                        </span>
                                    </>
                                )}
                            </a>
                            <div className={`dropdown-menu ${activeMenu === 'services' ? 'show' : ''}`}>
                                <Link href="/preview/services" className={`dropdown-item ${isActive('/preview/services') ? 'active' : ''}`}>
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" />
                                    </svg>
                                    {t('services')}
                                </Link>
                                <Link href="/preview/packages" className={`dropdown-item ${isActive('/preview/packages') ? 'active' : ''}`}>
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M21 8V7l-9-4-9 4v1l9 4 9-4zm-9 6-9-4v7l9 4 9-4v-7l-9 4z" />
                                    </svg>
                                    {t('products')}
                                </Link>
                                <a href="#" className="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
                                    </svg>
                                    {t('industries')}
                                </a>
                            </div>
                        </li>

                        {/* WORK */}
                        <li 
                            className={`nav-item-dropdown ${activeMenu === 'work' || isActive('/preview/portfolio') || isActive('/preview/case-studies') ? 'active' : ''}`}
                            onMouseEnter={() => handleMouseEnter('work')}
                            onMouseLeave={handleMouseLeave}
                            onFocus={() => handleMouseEnter('work')}
                            onBlur={(e) => {
                                if (!e.currentTarget.contains(e.relatedTarget)) {
                                    handleMouseLeave();
                                }
                            }}
                        >
                            <a href="#">
                                {/* Nav Swap Logic */}
                                {isActive('/preview/case-studies') ? (
                                    <>
                                        <span className="nav-swap-default">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                                            </svg>
                                            <span className="nav-text">{t('case_studies')}</span>
                                        </span>
                                        <span className="nav-swap-hover">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" />
                                            </svg>
                                            <span className="nav-text">{t('work')}</span>
                                        </span>
                                    </>
                                ) : isActive('/preview/portfolio') ? (
                                    <>
                                        <span className="nav-swap-default">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                            </svg>
                                            <span className="nav-text">{t('clients')}</span>
                                        </span>
                                        <span className="nav-swap-hover">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" />
                                            </svg>
                                            <span className="nav-text">{t('work')}</span>
                                        </span>
                                    </>
                                ) : (
                                    <>
                                        <span className="nav-swap-default">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" />
                                            </svg>
                                            <span className="nav-text">{t('work')}</span>
                                        </span>
                                        <span className="nav-swap-hover">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" />
                                            </svg>
                                            <span className="nav-text">{t('work')}</span>
                                        </span>
                                    </>
                                )}
                            </a>
                            <div className={`dropdown-menu ${activeMenu === 'work' ? 'show' : ''}`}>
                                <Link href="/preview/case-studies" className={`dropdown-item ${isActive('/preview/case-studies') ? 'active' : ''}`}>
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                                    </svg>
                                    {t('case_studies')}
                                </Link>
                                <Link href="/preview/portfolio" className={`dropdown-item ${isActive('/preview/portfolio') ? 'active' : ''}`}>
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                    </svg>
                                    {t('clients')}
                                </Link>
                            </div>
                        </li>

                        {/* INSIGHTS */}
                        <li 
                            className={`nav-item-dropdown ${activeMenu === 'insights' || isActive('/preview/blogs') || isActive('/preview/blog') ? 'active' : ''}`}
                            onMouseEnter={() => handleMouseEnter('insights')}
                            onMouseLeave={handleMouseLeave}
                            onFocus={() => handleMouseEnter('insights')}
                            onBlur={(e) => {
                                if (!e.currentTarget.contains(e.relatedTarget)) {
                                    handleMouseLeave();
                                }
                            }}
                        >
                            <a href="#">
                                {/* Nav Swap Logic */}
                                {isActive('/preview/blog') ? (
                                    <>
                                        <span className="nav-swap-default">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M9 21c0 .5.5 1 1 1h4c.5 0 1-.5 1-1v-1H9v1zm3-19C8.1 2 5 5.1 5 9c0 2.4 1.2 4.5 3 5.7V17c0 .5.5 1 1 1h6c.5 0 1-.5 1-1v-2.3c1.8-1.3 3-3.4 3-5.7 0-3.9-3.1-7-7-7z" />
                                            </svg>
                                            <span className="nav-text">{t('blog')}</span>
                                        </span>
                                        <span className="nav-swap-hover">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M9 21c0 .5.5 1 1 1h4c.5 0 1-.5 1-1v-1H9v1zm3-19C8.1 2 5 5.1 5 9c0 2.4 1.2 4.5 3 5.7V17c0 .5.5 1 1 1h6c.5 0 1-.5 1-1v-2.3c1.8-1.3 3-3.4 3-5.7 0-3.9-3.1-7-7-7z" />
                                            </svg>
                                            <span className="nav-text">{t('insights')}</span>
                                        </span>
                                    </>
                                ) : (
                                    <>
                                        <span className="nav-swap-default">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M9 21c0 .5.5 1 1 1h4c.5 0 1-.5 1-1v-1H9v1zm3-19C8.1 2 5 5.1 5 9c0 2.4 1.2 4.5 3 5.7V17c0 .5.5 1 1 1h6c.5 0 1-.5 1-1v-2.3c1.8-1.3 3-3.4 3-5.7 0-3.9-3.1-7-7-7z" />
                                            </svg>
                                            <span className="nav-text">{t('insights')}</span>
                                        </span>
                                        <span className="nav-swap-hover">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M9 21c0 .5.5 1 1 1h4c.5 0 1-.5 1-1v-1H9v1zm3-19C8.1 2 5 5.1 5 9c0 2.4 1.2 4.5 3 5.7V17c0 .5.5 1 1 1h6c.5 0 1-.5 1-1v-2.3c1.8-1.3 3-3.4 3-5.7 0-3.9-3.1-7-7-7z" />
                                            </svg>
                                            <span className="nav-text">{t('insights')}</span>
                                        </span>
                                    </>
                                )}
                            </a>
                            <div className={`dropdown-menu ${activeMenu === 'insights' ? 'show' : ''}`}>
                                <Link href="/preview/blogs" className={`dropdown-item ${isActive('/preview/blogs') ? 'active' : ''}`}>
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                                    </svg>
                                    {t('blog')}
                                </Link>
                                <a href="#" className="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" />
                                    </svg>
                                    {t('events')}
                                </a>
                                <a href="#" className="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z" />
                                    </svg>
                                    {t('reports')}
                                </a>
                                <a href="#" className="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z" />
                                    </svg>
                                    {t('tools')}
                                </a>
                                <a href="#" className="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M18 4l2 4h-3l-2-4h-2l2 4h-3l-2-4H8l2 4H7L5 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4h-4z" />
                                    </svg>
                                    {t('media_kit')}
                                </a>
                            </div>
                        </li>

                        {/* CAREERS */}
                        <li 
                            className={`nav-item-dropdown ${activeMenu === 'careers' || isActive('/preview/careers') ? 'active' : ''}`}
                            onMouseEnter={() => handleMouseEnter('careers')}
                            onMouseLeave={handleMouseLeave}
                            onFocus={() => handleMouseEnter('careers')}
                            onBlur={(e) => {
                                if (!e.currentTarget.contains(e.relatedTarget)) {
                                    handleMouseLeave();
                                }
                            }}
                        >
                            <a href="#">
                                {/* Nav Swap Logic */}
                                {isActive('/preview/careers') ? (
                                    <>
                                        <span className="nav-swap-default">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                                            </svg>
                                            <span className="nav-text">{t('careers')}</span>
                                        </span>
                                        <span className="nav-swap-hover">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                                            </svg>
                                            <span className="nav-text">{t('careers')}</span>
                                        </span>
                                    </>
                                ) : (
                                    <>
                                        <span className="nav-swap-default">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                                            </svg>
                                            <span className="nav-text">{t('careers')}</span>
                                        </span>
                                        <span className="nav-swap-hover">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                                            </svg>
                                            <span className="nav-text">{t('careers')}</span>
                                        </span>
                                    </>
                                )}
                            </a>
                            <div className={`dropdown-menu ${activeMenu === 'careers' ? 'show' : ''}`}>
                                <Link href="/preview/careers" className={`dropdown-item ${isActive('/preview/careers') ? 'active' : ''}`}>
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M9 11.75c-.69 0-1.25.56-1.25 1.25s.56 1.25 1.25 1.25 1.25-.56 1.25-1.25-.56-1.25-1.25-1.25zm6 0c-.69 0-1.25.56-1.25 1.25s.56 1.25 1.25 1.25 1.25-.56 1.25-1.25-.56-1.25-1.25-1.25zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8 0-.29.02-.58.05-.86 2.36-1.05 4.23-2.98 5.21-5.37C11.07 8.33 14.05 10 17.42 10c.78 0 1.53-.09 2.25-.26.21 1.01.33 2.05.33 3.12 0 4.41-3.59 8-8 8z" />
                                    </svg>
                                    {t('join_us')}
                                </Link>
                                <a href="#" className="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72l5 2.73 5-2.73v3.72z" />
                                    </svg>
                                    {t('interns')}
                                </a>
                                <a href="#" className="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                    </svg>
                                    {t('culture')}
                                </a>
                            </div>
                        </li>

                        {/* CONTACT */}
                        <li 
                            className={`nav-item-dropdown ${activeMenu === 'contact' || isActive('/preview/contact') ? 'active' : ''}`}
                            onMouseEnter={() => handleMouseEnter('contact')}
                            onMouseLeave={handleMouseLeave}
                            onFocus={() => handleMouseEnter('contact')}
                            onBlur={(e) => {
                                if (!e.currentTarget.contains(e.relatedTarget)) {
                                    handleMouseLeave();
                                }
                            }}
                        >
                            <Link href="/preview/contact">
                                {/* Nav Swap Logic */}
                                {isActive('/preview/contact') ? (
                                    <>
                                        <span className="nav-swap-default">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                                            </svg>
                                            <span className="nav-text">{t('start_project')}</span>
                                        </span>
                                        <span className="nav-swap-hover">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                            </svg>
                                            <span className="nav-text">{t('contact')}</span>
                                        </span>
                                    </>
                                ) : (
                                    <>
                                        <span className="nav-swap-default">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                            </svg>
                                            <span className="nav-text">{t('contact')}</span>
                                        </span>
                                        <span className="nav-swap-hover">
                                            <svg viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                            </svg>
                                            <span className="nav-text">{t('contact')}</span>
                                        </span>
                                    </>
                                )}
                            </Link>
                            <div className={`dropdown-menu ${activeMenu === 'contact' ? 'show' : ''}`}>
                                <Link href="/preview/contact" className={`dropdown-item ${isActive('/preview/contact') ? 'active' : ''}`}>
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                                    </svg>
                                    {t('start_project')}
                                </Link>
                                <a href="#" className="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z" />
                                    </svg>
                                    {t('support')}
                                </a>
                                <a href="#" className="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                    </svg>
                                    {t('locations')}
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>

                {/* Right Island - Controls */}
                {/* Right Island - Utilities (Search, Lang, Theme) */}
                <div className="bg-white/30 dark:bg-[#0b0f19]/90 backdrop-blur-xl border border-white/90 dark:border-white/5 shadow-[0_10px_40px_rgba(0,0,0,0.1),inset_0_1px_0_rgba(255,255,255,0.8)] dark:shadow-[0_10px_40px_rgba(0,0,0,0.5)] rounded-[50px] px-5 flex items-center h-[var(--navbar-height)] pointer-events-auto ml-1 xl:ml-4 gap-[0.75em] transition-all duration-300 shrink-0">
                    {/* Utility Links (KP-2 Parity) */}
                    {showClientPortal && isEnabled('nav.client_portal') && (
                        <a href="/login" className="hidden lg:flex items-center justify-center w-[44px] h-[44px] rounded-full border border-transparent hover:border-brand-primary hover:bg-brand-primary/5 text-brand-primary dark:text-brand-primary transition-all duration-300" title={t('client_portal')}>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </a>
                    )}
                    {showPartnerHub && isEnabled('nav.partner_hub') && (
                        <a href="#" className="hidden lg:flex items-center justify-center w-[44px] h-[44px] rounded-full border border-transparent hover:border-brand-primary hover:bg-brand-primary/5 text-brand-primary dark:text-brand-primary transition-all duration-300" title={t('partner_hub')}>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                            </svg>
                        </a>
                    )}

                    {/* Search Toggle */}
                    <button
                        onClick={toggleSearch}
                        aria-label="Search"
                        aria-haspopup="dialog"
                        aria-expanded={searchOpen}
                        aria-controls="search-overlay"
                        className="flex items-center justify-center w-[44px] h-[44px] rounded-full border border-transparent hover:border-brand-primary hover:bg-brand-primary/5 text-brand-primary dark:text-brand-primary transition-all duration-300"
                        id="search-toggle"
                    >
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                            <path d="M19 1l-1.25 2.75L15 5l2.75 1.25L19 9l1.25-2.75L23 5l-2.75-1.25L19 1z" />
                        </svg>
                    </button>

                    {/* Language Dropdown */}
                    <div 
                        className="relative flex items-center ml-1 z-[1002]" 
                        ref={langRef}
                        onFocus={() => {
                            setLangOpen(true);
                            setActiveMenu(null);
                        }}
                        onBlur={(e) => {
                            if (!e.currentTarget.contains(e.relatedTarget)) {
                                setLangOpen(false);
                            }
                        }}
                    >
                        <button
                            className={`flex items-center justify-center w-[44px] h-[44px] rounded-full border border-transparent hover:border-brand-primary hover:bg-brand-primary/5 text-brand-primary dark:text-brand-primary transition-all duration-300 text-sm font-bold tracking-wide ${langOpen ? 'opacity-70' : ''}`}
                            id="lang-btn"
                            onClick={toggleLang}
                            aria-expanded={langOpen}
                            aria-haspopup="true"
                        >
                            {locale}
                        </button>

                        {/* Dropdown Menu */}
                        <div className={`absolute top-[calc(100%+12px)] left-1/2 -translate-x-1/2
                                      bg-white/30 dark:bg-[#121218]/90 backdrop-blur-[12px] backdrop-saturate-[180%]
                                      border border-white/50 dark:border-white/10 rounded-[24px] p-[5px] min-w-[60px]
                                      shadow-[0_20px_40px_rgba(0,0,0,0.15)]
                                      transition-all duration-300 ease-out transform origin-top flex flex-col gap-[4px]
                                      ${langOpen
                                ? 'opacity-100 visible translate-y-0 pointer-events-auto'
                                : 'opacity-0 invisible translate-y-4 pointer-events-none'
                            }`}>

                            {/* Bridge to prevent closing on gap */}
                            <div className="absolute -top-10 left-0 w-full h-12 bg-transparent"></div>

                            {['en', 'az', 'ru'].map((lang) => (
                                <a
                                    key={lang}
                                    href={`/lang/${lang}`}
                                    className={`px-2 py-2 rounded-full text-sm font-bold tracking-wide
                                               cursor-pointer text-center transition-all duration-200 border border-transparent flex items-center justify-center
                                               ${locale === lang.toUpperCase()
                                            ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/25 scale-105 hover:bg-brand-primary hover:text-white hover:scale-100 hover:shadow-none'
                                            : 'text-brand-primary dark:text-gray-300 hover:bg-transparent hover:border-brand-primary hover:text-brand-primary'}`}
                                >
                                    {lang.toUpperCase()}
                                </a>
                            ))}
                        </div>
                    </div>

                    {/* Theme Toggle */}
                    <button
                        className="flex items-center justify-center w-[44px] h-[44px] rounded-full border border-transparent hover:border-brand-primary hover:bg-brand-primary/5 text-brand-primary dark:text-brand-primary transition-all duration-300"
                        id="theme-toggle"
                        aria-label="Toggle theme"
                        onClick={toggleTheme}
                    >
                        {theme === 'light' ? (
                            <svg className="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round">
                                <circle cx="12" cy="12" r="4"></circle>
                                <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"></path>
                            </svg>
                        ) : (
                            <svg className="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round">
                                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
                            </svg>
                        )}
                    </button>

                    {/* Mobile Menu Toggle */}
                    <button
                        id="mobile-menu-toggle"
                        className="lg:hidden flex items-center justify-center text-brand-primary dark:text-brand-primary hover:opacity-70 transition-all duration-300 relative w-[44px] h-[44px]"
                        onClick={() => setMobileMenuOpen(true)}
                    >
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" />
                        </svg>
                    </button>
                </div>
            </div >

            {/* Mobile Menu Overlay */}
            <MobileMenu isOpen={mobileMenuOpen} onClose={() => setMobileMenuOpen(false)} />

            {/* Search Overlay */}
            <SearchOverlay isOpen={searchOpen} onClose={toggleSearch} />

        </header >
    );
}
