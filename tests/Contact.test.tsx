import { describe, it, expect, vi, beforeEach } from 'vitest';
import { render, screen } from '@testing-library/react';
import Contact from '../resources/js/Components/Sections/Contact';

vi.mock('framer-motion', () => ({
    motion: {
        div: ({ children, ...props }: any) => <div {...props}>{children}</div>,
        h2: ({ children, ...props }: any) => <h2 {...props}>{children}</h2>,
        p: ({ children, ...props }: any) => <p {...props}>{children}</p>,
    },
    AnimatePresence: ({ children }: any) => <>{children}</>,
}));

vi.mock('@/Components/ui/Button', () => ({
    default: ({ children, ...props }: any) => <button {...props}>{children}</button>,
}));
vi.mock('@/Components/ui/Input', () => ({
    default: (props: any) => <input {...props} />,
}));
vi.mock('@/Components/ui/Card', () => ({
    default: ({ children, ...props }: any) => <div {...props}>{children}</div>,
}));

describe('Contact Component', () => {
    beforeEach(() => {
        document.body.innerHTML = '';
    });

    it('renders nothing when enabled is false', () => {
        const { container } = render(<Contact enabled={false} />);
        expect(container.innerHTML).toBe('');
    });

    it('renders form fields', () => {
        render(<Contact translations={{}} />);
        expect(screen.getByPlaceholderText('Əli Əliyev')).toBeInTheDocument();
        expect(screen.getByPlaceholderText('example@mail.com')).toBeInTheDocument();
        expect(screen.getByPlaceholderText('+994 (__) ___ __ __')).toBeInTheDocument();
        expect(screen.getByPlaceholderText('Layihənizin məqsədi və hədəfləri...')).toBeInTheDocument();
    });

    it('renders submit button', () => {
        render(<Contact translations={{}} />);
        expect(screen.getByText('GÖNDƏR')).toBeInTheDocument();
    });
});
