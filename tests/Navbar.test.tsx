import { describe, it, expect, vi, beforeEach } from 'vitest';
import { render, screen } from '@testing-library/react';
import Navbar from '../resources/js/Components/Navbar';

// Mock @inertiajs/react
vi.mock('@inertiajs/react', () => ({
    Link: ({ href, children, ...props }: any) => (
        <a href={href} {...props}>{children}</a>
    ),
    usePage: () => ({
        props: {
            locale: 'az',
            translations: {
                nav: {
                    home: 'Ana Səhifə',
                    about: 'Haqqımızda',
                    team: 'Komanda',
                    company: 'Şirkət',
                    services: 'Xidmətlər',
                    solutions: 'Həllər',
                    products: 'Məhsullar',
                    work: 'İşlər',
                    clients: 'Müştərilər',
                    case_studies: 'Case Studies',
                    insights: 'İdeyalar',
                    blog: 'Blog',
                    careers: 'Karyera',
                    contact: 'Əlaqə',
                    start_project: 'Layihə Başlat',
                }
            },
            global_settings: {},
            content_text_map: {},
        },
        url: '/',
    }),
}));

// Mock zustand store
vi.mock('@/store/useStore', () => ({
    useStore: () => ({
        theme: 'light',
        toggleTheme: vi.fn(),
        openQuoteModal: false,
    }),
}));

// Mock useSectionEnabled hook
vi.mock('@/Hooks/useSectionEnabled', () => ({
    useSectionEnabled: () => (key: string) => true,
}));

describe('Navbar Component', () => {
    beforeEach(() => {
        document.body.innerHTML = '';
    });

    it('renders logo link', () => {
        render(<Navbar />);
        
        const logo = screen.getByLabelText('Chalang');
        expect(logo).toBeInTheDocument();
        expect(logo.closest('a')).toHaveAttribute('href', '/');
    });

    it('renders home link', () => {
        render(<Navbar />);
        
        const homeLink = screen.getByText('Ana Səhifə');
        expect(homeLink).toBeInTheDocument();
    });

    it('renders navigation items', () => {
        render(<Navbar />);
        
        // Check for navigation
        expect(screen.getByText('Komanda')).toBeInTheDocument();
        expect(screen.getByText('Xidmətlər')).toBeInTheDocument();
    });

    it('renders theme toggle button', () => {
        render(<Navbar />);
        
        const themeToggle = screen.getByLabelText('Toggle theme');
        expect(themeToggle).toBeInTheDocument();
    });

it('renders language button with locale', () => {
        render(<Navbar />);
        
        // Use getAllByText as there are multiple AZ elements (button and dropdown item)
        const langBtns = screen.getAllByText('AZ');
        expect(langBtns.length).toBeGreaterThan(0);
        // Main button should be a button element
        expect(langBtns[0].closest('button')).toBeInTheDocument();
    });

    it('renders search button', () => {
        render(<Navbar />);
        
        const searchBtn = screen.getByLabelText('Search');
        expect(searchBtn).toBeInTheDocument();
    });

    it('renders skip link for accessibility', () => {
        render(<Navbar />);
        
        const skipLink = screen.getByText('Əsas məzmuna keç');
        expect(skipLink).toBeInTheDocument();
    });
});

describe('ThemeToggle Button', () => {
    beforeEach(() => {
        document.body.innerHTML = '';
    });

    it('renders sun icon when light theme', () => {
        render(<Navbar />);
        
        const themeBtn = screen.getByLabelText('Toggle theme');
        // Should have svg with sun/light icon
        expect(themeBtn.querySelector('svg')).toBeInTheDocument();
    });
});

describe('Accessibility', () => {
    beforeEach(() => {
        document.body.innerHTML = '';
    });

    it('has skip link with proper href', () => {
        render(<Navbar />);
        
        const skipLink = screen.getByText('Əsas məzmuna keç');
        expect(skipLink).toHaveAttribute('href', '#main-content');
    });

    it('has search button with proper aria attributes', () => {
        render(<Navbar />);
        
        const searchBtn = screen.getByLabelText('Search');
        expect(searchBtn).toHaveAttribute('aria-label', 'Search');
    });

    it('has theme toggle with aria-label', () => {
        render(<Navbar />);
        
        const themeBtn = screen.getByLabelText('Toggle theme');
        expect(themeBtn).toHaveAttribute('aria-label', 'Toggle theme');
    });
});
