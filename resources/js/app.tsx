/// <reference types="vite/client" />
import './bootstrap';
import '../css/app.css';
import '../css/layout.css';

import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';

const queryClient = new QueryClient({
    defaultOptions: {
        queries: {
            staleTime: 5 * 60 * 1000,
            refetchOnWindowFocus: false,
            retry: 1,
        },
    },
});

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

console.log('[APP] Starting createInertiaApp...');
try {
    const el = document.getElementById('app');
    const initialPage = JSON.parse(el?.dataset.page || '{}');

    const inertiaPromise = createInertiaApp({
        page: initialPage,
        title: (title) => `${title} - ${appName}`,
        resolve: (name) => {
            console.log('[APP] Resolving:', name);
            return resolvePageComponent(`./Pages/${name}.tsx`, import.meta.glob('./Pages/**/*.tsx'))
                .catch(err => {
                    console.error('[APP] Resolve error:', err);
                    throw err;
                });
        },
        setup({ el, App, props }) {
            console.log('[APP] Setup started with el:', el);
            try {
                const root = createRoot(el);
                console.log('[APP] createRoot OK');
                root.render(
                    <QueryClientProvider client={queryClient}>
                        <App {...props} />
                    </QueryClientProvider>
                );
                console.log('[APP] Render scheduled OK');
            } catch (err) {
                console.error('[APP] Setup/Render CRASH:', err);
            }
        },
        progress: {
            color: '#4B5563',
        },
    });
    
    if (inertiaPromise && typeof inertiaPromise.then === 'function') {
        inertiaPromise
            .then(() => console.log('[APP] createInertiaApp promise RESOLVED'))
            .catch((err: unknown) => console.error('[APP] createInertiaApp promise REJECTED:', err));
    }
} catch (e) {
    console.error('[APP] createInertiaApp SYNC ERROR:', e);
}

