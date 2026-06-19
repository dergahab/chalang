import { describe, it, expect, vi, beforeEach } from 'vitest';
import { render, screen, fireEvent } from '@testing-library/react';
import Portfolio from '../resources/js/Components/Sections/Portfolio';

vi.mock('@inertiajs/react', () => ({
    Link: ({ href, children, ...props }: any) => (
        <a href={href} {...props}>{children}</a>
    ),
    usePage: () => ({
        props: { locale: 'az', translations: {}, global_settings: {}, content_text_map: {} },
        url: '/',
    }),
}));

vi.mock('react-parallax-tilt', () => ({
    default: ({ children }: any) => <div>{children}</div>,
}));

vi.mock('@/Components/ui/Card', () => ({
    default: ({ children, ...props }: any) => <div {...props}>{children}</div>,
}));
vi.mock('@/Components/ui/Button', () => ({
    default: ({ children, ...props }: any) => <button {...props}>{children}</button>,
}));

const mockItems = [
    { id: 1, title: 'E-comm App', slug: 'ecomm', pcategories: [{ id: 1, name: 'Web' }] },
    { id: 2, title: 'Game App', slug: 'game', pcategories: [{ id: 2, name: 'Mobile' }] },
];

describe('Portfolio Component', () => {
    beforeEach(() => {
        document.body.innerHTML = '';
    });

    it('renders portfolio items', () => {
        render(<Portfolio items={mockItems} translations={{}} />);
        expect(screen.getByText('E-comm App')).toBeInTheDocument();
        expect(screen.getByText('Game App')).toBeInTheDocument();
    });

    it('renders filter buttons from categories', () => {
        render(<Portfolio items={mockItems} translations={{}} />);
        expect(screen.getByRole('button', { name: 'Hamısı' })).toBeInTheDocument();
        expect(screen.getByRole('button', { name: 'Web' })).toBeInTheDocument();
        expect(screen.getByRole('button', { name: 'Mobile' })).toBeInTheDocument();
    });

    it('filters items when category button clicked', () => {
        render(<Portfolio items={mockItems} translations={{}} />);
        expect(screen.getByText('E-comm App')).toBeInTheDocument();
        expect(screen.getByText('Game App')).toBeInTheDocument();

        fireEvent.click(screen.getByRole('button', { name: 'Mobile' }));
        expect(screen.queryByText('E-comm App')).not.toBeInTheDocument();
        expect(screen.getByText('Game App')).toBeInTheDocument();
    });

    it('renders empty state when no items', () => {
        const { container } = render(<Portfolio items={[]} translations={{}} />);
        const section = container.querySelector('section');
        expect(section).toBeInTheDocument();
    });
});
