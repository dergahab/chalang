/**
 * Multi-domain configuration
 * 
 * Domain routing:
 * - chalanggroup.com → Default (redirect to .az or .ai based on Accept-Language)
 * - chalang.az → Azerbaijani version
 * - chalang.ai → English version
 */

export interface DomainConfig {
    domain: string;
    locale: 'az' | 'en';
    name: string;
    primaryColor: string;
}

export const DOMAINS: Record<string, DomainConfig> = {
    'chalanggroup.com': {
        domain: 'chalanggroup.com',
        locale: 'az', // Default
        name: 'Chalang Group',
        primaryColor: '#0D0D0D',
    },
    'chalang.az': {
        domain: 'chalang.az',
        locale: 'az',
        name: 'Chalang',
        primaryColor: '#0D0D0D',
    },
    'chalang.ai': {
        domain: 'chalang.ai',
        locale: 'en',
        name: 'Chalang AI',
        primaryColor: '#0D0D0D',
    },
};

// Get current domain from request/URL
export function getCurrentDomain(): string {
    if (typeof window === 'undefined') return 'chalanggroup.com';
    return window.location.hostname.replace(/^www\./, '');
}

// Get domain config
export function getDomainConfig(domain?: string): DomainConfig {
    const currentDomain = domain || getCurrentDomain();
    return DOMAINS[currentDomain] || DOMAINS['chalanggroup.com'];
}

// Get locale from domain
export function getLocaleFromDomain(domain?: string): 'az' | 'en' {
    const config = getDomainConfig(domain);
    return config.locale;
}

// Check if domain is Azerbaijani
export function isAzerbaijaniDomain(domain?: string): boolean {
    return getLocaleFromDomain(domain) === 'az';
}

// Check if domain is English
export function isEnglishDomain(domain?: string): boolean {
    return getLocaleFromDomain(domain) === 'en';
}

// Redirect to domain
export function redirectToDomain(targetDomain: string, path?: string): string {
    const protocol = 'https';
    const baseDomain = targetDomain.startsWith('www.') ? targetDomain : `www.${targetDomain}`;
    return `${protocol}://${baseDomain}${path || ''}`;
}

// Get alternate domains for hreflang
export function getAlternateDomains(currentDomain?: string): Record<string, string> {
    const current = currentDomain || getCurrentDomain();
    
    return {
        az: 'https://chalang.az',
        en: 'https://chalang.ai',
    };
}

// Generate hreflang tags
export function generateHreflangTags(): Array<{ href: string; hrefLang: string }> {
    return [
        { href: 'https://chalang.az', hrefLang: 'az-AZ' },
        { href: 'https://chalang.ai', hrefLang: 'en-US' },
        { href: 'https://chalanggroup.com', hrefLang: 'x-default' },
    ];
}

// Middleware-like function for domain-based locale
export function resolveLocaleFromRequest(): { locale: 'az' | 'en'; domain: string; shouldRedirect: boolean; redirectUrl?: string } {
    const domain = getCurrentDomain();
    
    // Already on correct domain
    if (DOMAINS[domain]) {
        return {
            locale: DOMAINS[domain].locale,
            domain,
            shouldRedirect: false,
        };
    }
    
    // Unknown domain - use default
    const acceptLanguage = typeof navigator !== 'undefined' ? navigator.language : 'az';
    const defaultLocale = acceptLanguage.startsWith('az') ? 'az' : 'en';
    
    return {
        locale: defaultLocale,
        domain: 'chalanggroup.com',
        shouldRedirect: true,
        redirectUrl: defaultLocale === 'az' ? 'https://chalang.az' : 'https://chalang.ai',
    };
}

export default {
    DOMAINS,
    getCurrentDomain,
    getDomainConfig,
    getLocaleFromDomain,
    isAzerbaijaniDomain,
    isEnglishDomain,
    redirectToDomain,
    getAlternateDomains,
    generateHreflangTags,
    resolveLocaleFromRequest,
};
