import '@testing-library/jest-dom';

// Mocklar
vi.mock('react', async () => {
    const actual = await vi.importActual('react');
    return {
        ...actual,
        useEffect: actual.useEffect,
        useState: actual.useState,
    };
});

// Inertia mock
vi.mock('@inertiajs/react', () => ({
    Link: ({ href, children, ...props }: any) => 
        vi.fn(() => h('a', { href, ...props }, children))(),
    usePage: () => ({
        props: {
            locale: 'az',
            translations: {},
            global_settings: {},
            content_text_map: {},
        },
        url: '/',
    }),
}));

// Zustand mock
vi.mock('zustand', () => ({
    create: (fn: any) => {
        const store = fn((set: any) => ({ 
            theme: 'light', 
            toggleTheme: () => {},
            openQuoteModal: false,
        }));
        return () => {};
    },
    useStore: () => ({
        theme: 'light',
        toggleTheme: () => {},
    }),
}));
