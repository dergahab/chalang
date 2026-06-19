import { describe, it, expect, vi, beforeEach } from 'vitest';
import { render, screen, waitFor } from '@testing-library/react';
import userEvent from '@testing-library/user-event';
import Modal from '../resources/js/Components/ui/Modal';

describe('Modal Component', () => {
    beforeEach(() => {
        // Clean up document before each test
        document.body.innerHTML = '';
    });

    it('renders modal when isOpen is true', () => {
        render(
            <Modal isOpen={true} onClose={() => {}}>
                <div>Modal Content</div>
            </Modal>
        );

        expect(screen.getByText('Modal Content')).toBeInTheDocument();
    });

    it('does not render when isOpen is false', () => {
        render(
            <Modal isOpen={false} onClose={() => {}}>
                <div>Modal Content</div>
            </Modal>
        );

        expect(screen.queryByText('Modal Content')).not.toBeInTheDocument();
    });

it('renders with close button when showCloseButton is true', () => {
        render(
            <Modal isOpen={true} onClose={() => {}} showCloseButton={true}>
                <div>Modal Content</div>
            </Modal>
        );

        expect(screen.getByRole('button', { name: /bağla/i })).toBeInTheDocument();
    });

    it('calls onClose when close button is clicked', async () => {
        const onClose = vi.fn();
        
        render(
            <Modal isOpen={true} onClose={onClose} showCloseButton={true}>
                <div>Modal Content</div>
            </Modal>
        );

        await userEvent.click(screen.getByRole('button', { name: /bağla/i }));
        
        expect(onClose).toHaveBeenCalledTimes(1);
    });

    it('applies custom className', () => {
        render(
            <Modal isOpen={true} onClose={() => {}} className="custom-modal">
                <div>Modal Content</div>
            </Modal>
        );

        const modal = screen.getByText('Modal Content').closest('[role="dialog"]');
        expect(modal).toHaveClass('custom-modal');
    });
});

describe('Accessibility', () => {
    it('has proper role attribute', () => {
        render(
            <Modal isOpen={true} onClose={() => {}}>
                <div>Modal Content</div>
            </Modal>
        );

        expect(screen.getByRole('dialog')).toBeInTheDocument();
    });

    it('has aria-modal set to true', () => {
        render(
            <Modal isOpen={true} onClose={() => {}}>
                <div>Modal Content</div>
            </Modal>
        );

        const modal = screen.getByRole('dialog');
        expect(modal).toHaveAttribute('aria-modal', 'true');
    });
});
