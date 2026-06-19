import { useState, useEffect } from 'react';

/**
 * Media query hook for responsive design
 */
export function useMediaQuery(query: string): boolean {
    const [matches, setMatches] = useState(false);

    useEffect(() => {
        if (typeof window === 'undefined') return;
        
        const media = window.matchMedia(query);
        
        // Set initial value
        setMatches(media.matches);

        // Listen for changes
        const listener = (e: MediaQueryListEvent) => setMatches(e.matches);
        
        if (media.addEventListener) {
            media.addEventListener('change', listener);
        } else {
            // Deprecated but needed for Safari < 14
            media.addListener(listener);
        }

        return () => {
            if (media.removeEventListener) {
                media.removeEventListener('change', listener);
            } else {
                media.removeListener(listener);
            }
        };
    }, [query]);

    return matches;
}

/**
 * Shorthand hooks for common breakpoints
 */
export function useIsMobile() {
    return useMediaQuery('(max-width: 639px)');
}

export function useIsTablet() {
    return useMediaQuery('(min-width: 640px) and (max-width: 1023px)');
}

export function useIsDesktop() {
    return useMediaQuery('(min-width: 1024px)');
}

export function useIsDarkMode() {
    return useMediaQuery('(prefers-color-scheme: dark)');
}

export function usePrefersReducedMotion() {
    return useMediaQuery('(prefers-reduced-motion: reduce)');
}

export default useMediaQuery;