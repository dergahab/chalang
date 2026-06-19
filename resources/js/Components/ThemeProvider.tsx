import { useState, useEffect } from 'react';
import { ThemeContext } from '@/Hooks/useTheme';

// Cookie helpers
function getCookie(name: string): string | null {
    if (typeof document === 'undefined') return null;
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop()?.split(';').shift() || null;
    return null;
}

function setCookie(name: string, value: string, days: number = 365) {
    if (typeof document === 'undefined') return;
    const expires = new Date(Date.now() + days * 864e5).toUTCString();
    document.cookie = `${name}=${value}; expires=${expires}; path=/; SameSite=Lax`;
}

const COOKIE_NAME = 'styleCookieName';

interface ThemeColors {
    primary: string;
    secondary: string;
    tertiary: string;
    primary_rgb: string;
    secondary_rgb: string;
    tertiary_rgb: string;
}

interface ThemeConfig {
    colors: {
        light: ThemeColors;
        dark: ThemeColors;
    };
    font: string;
    font_url: string;
    border_radius: string;
    radii: {
        btn: string;
        card: string;
        input: string;
    };
    smart_bg: boolean;
    glow_intensity: number;
    custom_css: string;
    custom_js: string;
    // Gradient Studio
    gradient_angle?: number;
    gradient_ambient_intensity?: number;
    gradient_btn_start?: string;
    gradient_btn_end?: string;
    gradient_text_start?: string;
    gradient_text_end?: string;
}

interface ThemeProviderProps {
    theme: ThemeConfig;
    children: React.ReactNode;
}

export default function ThemeProvider({ theme, children }: ThemeProviderProps) {
    const [mode, setMode] = useState<'dark' | 'light'>(() => {
        if (typeof window !== 'undefined') {
            const stored = getCookie(COOKIE_NAME);
            if (stored === 'dark' || stored === 'light') return stored;
            // Dark mode default — .cursorrules §4.3: "Dark mode default."
            // Blade preview.blade.php: data-theme="dark" default-dur.
            return 'dark';
        }
        return 'dark';
    });

    const toggleTheme = () => {
        setMode((prev) => (prev === 'dark' ? 'light' : 'dark'));
    };

    const [mounted, setMounted] = useState(false);

    useEffect(() => {
        setMounted(true);
    }, []);

    // Update global classes, data attributes, and cookie
    useEffect(() => {
        if (typeof window === 'undefined') return;
        const root = document.documentElement;
        
        // Only add transition class after first mount to avoid FOUC
        if (mounted) {
            root.classList.add('theme-transition-enabled');
        }

        root.classList.toggle('dark', mode === 'dark');
        root.setAttribute('data-theme', mode);
        setCookie(COOKIE_NAME, mode);
    }, [mode, mounted]);

    // Update CSS variables
    useEffect(() => {
        if (!theme?.colors) return;

        const root = document.documentElement;
        const isDark = mode === 'dark';
        const colors = isDark ? theme.colors.dark : theme.colors.light;
        const glowAlpha = (theme.glow_intensity ?? 15) / 100;

        // ── TYPOGRAPHY ──
        root.style.setProperty('--font-main', `'${theme.font}', sans-serif`);
        root.style.setProperty('--font-display', `'${theme.font}', sans-serif`);
        root.style.setProperty('--font-heading', `'${theme.font}', sans-serif`);
        root.style.setProperty('--font-body', `'${theme.font}', sans-serif`);

        // ── SHAPES (Semantic) ──
        root.style.setProperty('--radius-btn', theme.radii.btn);
        root.style.setProperty('--radius-card', theme.radii.card);
        root.style.setProperty('--radius-input', theme.radii.input);
        
        root.style.setProperty('--radius-sm', theme.radii.input);
        root.style.setProperty('--radius-md', theme.radii.card);
        root.style.setProperty('--radius-lg', theme.radii.card);
        root.style.setProperty('--radius-full', theme.radii.btn);

        // ── BRAND COLORS ──
        root.style.setProperty('--brand-primary', colors.primary);
        root.style.setProperty('--brand-primary-rgb', colors.primary_rgb);
        root.style.setProperty('--brand-secondary', colors.secondary);
        root.style.setProperty('--brand-secondary-rgb', colors.secondary_rgb);
        root.style.setProperty('--brand-tertiary', colors.tertiary ?? (isDark ? '#8b00ff' : '#9333ea'));
        root.style.setProperty('--brand-tertiary-rgb', colors.tertiary_rgb ?? (isDark ? '139, 0, 255' : '147, 51, 234'));

        // ── GRADIENT STUDIO ──
        const angle = theme.gradient_angle ?? 135;
        const btnStart = theme.gradient_btn_start || colors.primary;
        const btnEnd   = theme.gradient_btn_end   || colors.secondary;
        const txtStart = theme.gradient_text_start || colors.primary;
        const txtEnd   = theme.gradient_text_end   || colors.secondary;
        const ambientI = (theme.gradient_ambient_intensity ?? 60) / 100;

        root.style.setProperty('--gradient-angle',     `${angle}deg`);
        root.style.setProperty('--ambient-intensity',  String(ambientI));
        root.style.setProperty('--gradient-btn-start', btnStart);
        root.style.setProperty('--gradient-btn-end',   btnEnd);
        root.style.setProperty('--gradient-text-start', txtStart);
        root.style.setProperty('--gradient-text-end',   txtEnd);
        root.style.setProperty('--brand-gradient', `linear-gradient(${angle}deg, ${btnStart}, ${btnEnd})`);
        root.style.setProperty('--brand-glow', `rgba(${colors.primary_rgb}, ${glowAlpha})`);

        // ── SURFACE COLORS ──
        if (isDark) {
            let bgBody = '#0b0f19';
            let navBgGlass = 'rgba(11, 15, 25, 0.9)';

            if (theme.smart_bg) {
                bgBody = `color-mix(in srgb, ${colors.primary} 5%, #0b0f19)`;
                navBgGlass = `color-mix(in srgb, ${colors.primary} 5%, rgba(11, 15, 25, 0.9))`;
            }

            root.style.setProperty('--bg-body', bgBody);
            root.style.setProperty('--bg-primary', bgBody);
            root.style.setProperty('--bg-secondary', '#141424');
            root.style.setProperty('--card-bg', 'rgba(28, 28, 45, 0.8)');
            root.style.setProperty('--bg-card', 'rgba(28, 28, 45, 0.8)');
            root.style.setProperty('--bg-card-hover', 'rgba(35, 35, 55, 0.95)');
            root.style.setProperty('--nav-bg-glass', navBgGlass);
            root.style.setProperty('--card-border', 'rgba(255, 255, 255, 0.12)');
            root.style.setProperty('--border-color', 'rgba(255, 255, 255, 0.12)');
            root.style.setProperty('--nav-border', 'rgba(255, 255, 255, 0.05)');
            root.style.setProperty('--nav-shadow', '0 10px 40px rgba(0, 0, 0, 0.5)');
            root.style.setProperty('--btn-glass', 'rgba(255, 255, 255, 0.05)');
            
            root.style.setProperty('--text-main', '#e2e8f0');
            root.style.setProperty('--text-sub', '#CCCCCC');
            
            // Legacy aliases
            root.style.setProperty('--color-bg', bgBody);
            root.style.setProperty('--color-bg-secondary', '#141424');
            root.style.setProperty('--color-text-main', '#e2e8f0');
            root.style.setProperty('--color-text-sub', '#CCCCCC');
        } else {
            let bgBody = '#f2f4f8';

            if (theme.smart_bg) {
                bgBody = `color-mix(in srgb, ${colors.primary} 3%, #f2f4f8)`;
            }

            root.style.setProperty('--bg-body', bgBody);
            root.style.setProperty('--bg-primary', bgBody);
            root.style.setProperty('--bg-secondary', '#ebedf2');
            root.style.setProperty('--card-bg', 'rgba(255, 255, 255, 0.6)');
            root.style.setProperty('--bg-card', 'rgba(255, 255, 255, 0.6)');
            root.style.setProperty('--bg-card-hover', 'rgba(255, 255, 255, 0.85)');
            root.style.setProperty('--nav-bg-glass', 'rgba(255, 255, 255, 0.3)');
            root.style.setProperty('--card-border', 'rgba(0, 0, 0, 0.08)');
            root.style.setProperty('--border-color', 'rgba(0, 0, 0, 0.08)');
            root.style.setProperty('--nav-border', 'rgba(255, 255, 255, 0.9)');
            root.style.setProperty('--nav-shadow', '0 10px 40px rgba(0, 0, 0, 0.1)');
            root.style.setProperty('--btn-glass', 'rgba(255, 255, 255, 0.2)');
            
            root.style.setProperty('--text-main', '#1a1a2e');
            root.style.setProperty('--text-sub', '#555555');
            
            // Legacy aliases
            root.style.setProperty('--color-bg', bgBody);
            root.style.setProperty('--color-bg-secondary', '#ebedf2');
            root.style.setProperty('--color-text-main', '#1a1a2e');
            root.style.setProperty('--color-text-sub', '#555555');
        }

        // ── CUSTOM CSS ──
        const existingCustomStyle = document.getElementById('theme-custom-css');
        if (existingCustomStyle) existingCustomStyle.remove();

        if (theme.custom_css) {
            const styleEl = document.createElement('style');
            styleEl.id = 'theme-custom-css';
            styleEl.textContent = theme.custom_css;
            document.head.appendChild(styleEl);
        }

        // ── CUSTOM JS ──
        const existingCustomScript = document.getElementById('theme-custom-js');
        if (existingCustomScript) existingCustomScript.remove();

        if (theme.custom_js) {
            const scriptEl = document.createElement('script');
            scriptEl.id = 'theme-custom-js';
            scriptEl.textContent = theme.custom_js;
            document.body.appendChild(scriptEl);
        }

        document.body.style.fontFamily = `var(--font-main)`;

    }, [theme, mode]);

    // Dynamic font loading
    useEffect(() => {
        if (!theme?.font_url) return;

        const fontLinkId = 'dynamic-font-link';
        const existing = document.getElementById(fontLinkId);
        if (existing) existing.remove();

        const link = document.createElement('link');
        link.id = fontLinkId;
        link.rel = 'stylesheet';
        link.href = `https://fonts.googleapis.com/css2?family=${theme.font_url}&display=swap`;
        document.head.appendChild(link);
    }, [theme?.font_url]);

    return (
        <ThemeContext.Provider value={{ theme: mode, toggleTheme }}>
            {children}
        </ThemeContext.Provider>
    );
}
