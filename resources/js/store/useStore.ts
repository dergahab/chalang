import { create } from 'zustand';
import { persist } from 'zustand/middleware';

interface AppState {
    // Theme State
    theme: 'light' | 'dark';
    setTheme: (theme: 'light' | 'dark') => void;
    toggleTheme: () => void;

    // Language State
    language: 'az' | 'en' | 'ru';
    setLanguage: (lang: 'az' | 'en' | 'ru') => void;

    // Modal States
    isQuoteModalOpen: boolean;
    quoteSummaryData: {
        platform: string;
        service_id: number | null;
        scale: string;
        timeline: string;
        priceRange: string;
    } | null;
    openQuoteModal: (data?: Record<string, unknown>) => void;
    closeQuoteModal: () => void;
    
    // Newsletter State
    isNewsletterOpen: boolean;
    setNewsletterOpen: (open: boolean) => void;
}

export const useStore = create<AppState>()(
    persist(
        (set) => ({
            // Theme Defaults
            theme: 'dark',
            setTheme: (theme) => {
                document.documentElement.setAttribute('data-theme', theme);
                set({ theme });
            },
            toggleTheme: () => set((state) => {
                const newTheme = state.theme === 'light' ? 'dark' : 'light';
                document.documentElement.setAttribute('data-theme', newTheme);
                return { theme: newTheme };
            }),

            // Language Defaults
            language: 'az',
            setLanguage: (language) => set({ language }),

            // Quote Modal
            isQuoteModalOpen: false,
            quoteSummaryData: null,
            openQuoteModal: (data?: Record<string, unknown>) => set({ isQuoteModalOpen: true, quoteSummaryData: data || null }),
            closeQuoteModal: () => set({ isQuoteModalOpen: false }),

            // Newsletter
            isNewsletterOpen: false,
            setNewsletterOpen: (isNewsletterOpen) => set({ isNewsletterOpen }),
        }),
        {
            name: 'chalang-app-storage',
            partialize: (state) => ({ theme: state.theme, language: state.language }),
        }
    )
);
