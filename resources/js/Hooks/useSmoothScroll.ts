import { useCallback } from 'react';

export default function useSmoothScroll() {
    const scrollTo = useCallback((target: string | HTMLElement, offset: number = 80) => {
        const element = typeof target === 'string' 
            ? document.querySelector(target) 
            : target;
            
        if (element) {
            const top = element.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({
                top,
                behavior: 'smooth',
            });
        }
    }, []);

    return { scrollTo };
}