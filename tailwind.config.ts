import type { Config } from 'tailwindcss';
import defaultTheme from 'tailwindcss/defaultTheme';

const config: Config = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
        './resources/js/**/*.tsx',
    ],

    corePlugins: {
        container: true,
    },
    theme: {
        extend: {
            screens: {
                // Cursorrules Responsive Matrix
                'xs': '320px',       // XS: Critical test zone (iPhone SE)
                's': '360px',        // S: Small phones
                'm': '390px',        // M: Standard phones (iPhone 14)
                'sm': '640px',       // Mobile Landscape / Fold
                'fold': '600px',     // Foldable (Z Fold dual pane)
                'md': '768px',       // Tablet Portrait
                'tab': '768px',      // TAB: Alias for tablet (used in components)

                'lg': '1024px',      // Tablet Landscape / Small Laptop
                'ds1': '1024px',     // DS: Desktop Standard (used in Footer/components)
                'xl': '1280px',      // Desktop Standard
                '2xl': '1536px',     // Large Desktop
                'uhd': '1920px',     // UHD / 4K+
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Outfit', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    primary: 'var(--brand-primary)',     // Dynamic from admin panel
                    secondary: 'var(--brand-secondary)', // Dynamic from admin panel
                    dark: 'var(--bg-body)',              // Dynamic dark background
                    light: '#f2f4f8',                    // Static fallback (light mode default)
                    surface: '#111827',                  // Static fallback (dark surface)
                },
                text: {
                    main: 'var(--text-main)',            // Dynamic text color
                    sub: 'var(--text-sub)',              // Dynamic subtext color
                    inverse: '#e2e8f0',                   // Static fallback (dark mode text)
                },
                ui: {
                    card: 'var(--bg-card, #ffffff)',
                    border: 'var(--card-border, #eeeeee)',
                }
            },
            maxWidth: {
                container: '1440px', // --container-max (Aligned with chalang-core.css)
            },
            container: {
                center: true,
                padding: {
                    DEFAULT: '1rem',
                    sm: '1.5rem',
                    lg: '2rem',
                },
            },
            zIndex: {
                nav: '1000',
                modal: '5000',
                loader: '9999',
            },
            boxShadow: {
                neon: '0 0 20px var(--brand-secondary), 0 0 40px var(--brand-primary)', // --shadow-neon (Dynamic)
                glow: '0 10px 20px rgba(75, 0, 130, 0.35)', // --brand-glow
                glass: '0 8px 32px 0 rgba(31, 38, 135, 0.37)',
            },
            backgroundImage: {
                'brand-gradient': 'var(--brand-gradient, linear-gradient(135deg, #4b0082, #d500f9))', // --brand-gradient (Dynamic)
            },
            animation: {
                blob: "blob 7s infinite",
                'fade-in-up': "fadeInUp 0.6s ease forwards",
            },
            keyframes: {
                blob: {
                    "0%": {
                        transform: "translate(0px, 0px) scale(1)",
                    },
                    "33%": {
                        transform: "translate(30px, -50px) scale(1.1)",
                    },
                    "66%": {
                        transform: "translate(-20px, 20px) scale(0.9)",
                    },
                    "100%": {
                        transform: "translate(0px, 0px) scale(1)",
                    },
                },
                fadeInUp: {
                    "0%": {
                        opacity: "0",
                        transform: "translateY(20px)",
                    },
                    "100%": {
                        opacity: "1",
                        transform: "translateY(0)",
                    },
                },
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        function ({ addUtilities }: any) {
            const newUtilities = {
                '.pt-safe': {
                    paddingTop: 'env(safe-area-inset-top)',
                },
                '.pb-safe': {
                    paddingBottom: 'env(safe-area-inset-bottom)',
                },
                '.h-safe-screen': {
                    height: 'calc(100vh - env(safe-area-inset-top) - env(safe-area-inset-bottom))',
                },
            };
            addUtilities(newUtilities);
        }
    ],

    darkMode: 'class', // As per plan
};

export default config;
