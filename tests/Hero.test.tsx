import { describe, it, expect, vi, beforeEach } from 'vitest';
import { render, screen } from '@testing-library/react';
import Hero from '../resources/js/Components/Sections/Hero';

vi.mock('@inertiajs/react', () => ({
    Link: ({ href, children, ...props }: any) => (
        <a href={href} {...props}>{children}</a>
    ),
    usePage: () => ({
        props: {
            locale: 'az',
            translations: { hero: { showreel_url: '#showreel' } },
            global_settings: {},
            content_text_map: {},
        },
        url: '/',
    }),
}));

vi.mock('@/store/useStore', () => ({
    useStore: () => ({ openQuoteModal: vi.fn() }),
}));

beforeEach(() => {
    document.body.innerHTML = '';
    window.matchMedia = vi.fn().mockImplementation((query: string) => ({
        matches: false,
        media: query,
        onchange: null,
        addListener: vi.fn(),
        removeListener: vi.fn(),
        addEventListener: vi.fn(),
        removeEventListener: vi.fn(),
        dispatchEvent: vi.fn(),
    }));
});

describe('Hero Component', () => {

    it('renders banner title and content', () => {
        render(<Hero banner={{ id: 1, title: 'Test Title', content: 'Test Content' }} translations={{}} />);
        expect(screen.getByText('Test Title')).toBeInTheDocument();
        expect(screen.getByText('Test Content')).toBeInTheDocument();
    });

    it('renders fallback when banner is null', () => {
        render(<Hero banner={null} translations={{}} />);
        const sections = document.querySelectorAll('section');
        expect(sections.length).toBeGreaterThan(0);
    });

    it('renders canvas element for animation', () => {
        render(<Hero banner={null} translations={{}} />);
        const canvas = document.querySelector('canvas');
        expect(canvas).toBeInTheDocument();
    });

    it('renders CTA buttons', () => {
        render(<Hero banner={{ id: 1, title: 'T', content: 'C' }} translations={{}} />);
        expect(screen.getByText('Start')).toBeInTheDocument();
        expect(screen.getByText('Our Work')).toBeInTheDocument();
        expect(screen.getByText('Showreel')).toBeInTheDocument();
    });
});
