import { describe, it, expect, vi, beforeEach } from 'vitest';
import { render, screen } from '@testing-library/react';
import Services from '../resources/js/Components/Sections/Services';

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

describe('Services Component', () => {
    beforeEach(() => {
        document.body.innerHTML = '';
    });

    it('renders skeleton when services array is empty', () => {
        render(<Services services={[]} translations={{}} />);
        const skeletonHeaders = document.querySelectorAll('.animate-pulse');
        expect(skeletonHeaders.length).toBeGreaterThan(0);
    });

    it('renders skeleton when services is null/undefined', () => {
        render(<Services services={undefined as any} translations={{}} />);
        const skeletonHeaders = document.querySelectorAll('.animate-pulse');
        expect(skeletonHeaders.length).toBeGreaterThan(0);
    });

    it('renders service titles from props', () => {
        const mockServices = [
            { id: 1, name: 'Web Development', childs: [] },
            { id: 2, name: 'Mobile Apps', childs: [] },
        ];
        render(<Services services={mockServices} translations={{ sec_services_title: 'Nələr edirik?' }} />);

        expect(screen.getByText('Nələr edirik?')).toBeInTheDocument();
        expect(screen.getByText('Web Development')).toBeInTheDocument();
        expect(screen.getByText('Mobile Apps')).toBeInTheDocument();
    });

    it('renders child service names', () => {
        const mockServices = [
            {
                id: 1,
                name: 'Web',
                childs: [{ name: 'React' }, { name: 'Laravel' }],
            },
        ];
        render(<Services services={mockServices} translations={{}} />);
        const reacts = screen.getAllByText('React');
        expect(reacts.length).toBeGreaterThanOrEqual(1);
        const laravels = screen.getAllByText('Laravel');
        expect(laravels.length).toBeGreaterThanOrEqual(1);
    });
});
