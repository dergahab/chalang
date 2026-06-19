/**
 * Domain Bootstrap - Initialize domain config on app load
 * Include this in app.js before rendering
 */

import { getCurrentDomain, getDomainConfig, getLocaleFromDomain, DOMAINS } from './domains';

let domainInitialized = false;

export function bootstrapDomain(): DomainConfig {
    if (domainInitialized) return getDomainConfig();
    
    const config = getDomainConfig();
    
    // Set HTML lang attribute
    if (typeof document !== 'undefined') {
        document.documentElement.lang = config.locale;
        
        // Update canonical links
        const canonical = document.querySelector('link[rel="canonical"]');
        if (canonical) {
            canonical.setAttribute('href', `${window.location.origin}`);        }
        
        // Update alternate links
        document.querySelectorAll('link[rel="alternate"][hreflang]').forEach(link => {
            const lang = link.getAttribute('hreflang');
            if (lang === 'az') {
                link.setAttribute('href', 'https://chalang.az' + window.location.pathname);
            } else if (lang === 'en') {
                link.setAttribute('href', 'https://chalang.ai' + window.location.pathname);
            }
        });
    }
    
    domainInitialized = true;
    return config;
}

/**
 * Auto-redirect based on Accept-Language if on wrong domain
 */
export function autoRedirect(): void {
    const domain = getCurrentDomain();
    const config = getDomainConfig(domain);
    const acceptLang = typeof navigator !== 'undefined' ? navigator.language : 'az';
    
    // Only redirect from main domain
    if (domain === 'chalanggroup.com' || domain === 'www.chalanggroup.com') {
        const preferredLocale = acceptLang.startsWith('en') ? 'en' : 'az';
        
        if (preferredLocale !== config.locale) {
            // User prefers different language than current
            const redirectUrl = preferredLocale === 'az' 
                ? 'https://chalang.az' + window.location.pathname
                : 'https://chalang.ai' + window.location.pathname;
            
            // Optional: Uncomment to auto-redirect
            // window.location.href = redirectUrl;
        }
    }
}

/**
 * Get current domain info
 */
export function getDomainInfo(): {
    domain: string;
    locale: 'az' | 'en';
    localeLabel: string;
    domainUrl: string;
} {
    const domain = getCurrentDomain();
    const config = getDomainConfig(domain);
    
    return {
        domain,
        locale: config.locale,
        localeLabel: config.locale === 'az' ? 'Azərbaycan dili' : 'English',
        domainUrl: `https://${domain}`,
    };
}

/**
 * Switch between locales
 */
export function switchLocale(targetLocale: 'az' | 'en'): string {
    const targetDomain = targetLocale === 'az' ? 'chalang.az' : 'chalang.ai';
    
    if (typeof window === 'undefined') return '';
    
    return `https://www.${targetDomain}${window.location.pathname}${window.location.search}`;