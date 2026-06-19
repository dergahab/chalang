import React from 'react';
import { clsx } from '@/lib/clsx';

interface StepBadgeProps {
    step: number;
    label?: string;
    isActive?: boolean;
    isCompleted?: boolean;
    className?: string;
}

export default function StepBadge({ step, label, isActive, isCompleted, className }: StepBadgeProps) {
    return (
        <div className={clsx('flex items-center gap-3', className)}>
            <div
                className={clsx(
                    'relative flex items-center justify-center w-10 h-10 rounded-full font-bold text-sm transition-all duration-500',
                    'border-2',
                    isActive && [
                        'border-[var(--brand-primary)]',
                        'bg-[var(--brand-primary)]/10',
                        'text-[var(--brand-primary)]',
                        'shadow-[0_0_20px_var(--brand-glow)]',
                        'scale-110',
                    ],
                    isCompleted && [
                        'border-[var(--brand-primary)]',
                        'bg-[var(--brand-primary)]',
                        'text-white',
                    ],
                    !isActive && !isCompleted && [
                        'border-[var(--card-border)]',
                        'bg-[var(--bg-secondary)]',
                        'text-[var(--text-muted)]',
                    ]
                )}
            >
                {isCompleted ? (
                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M5 13l4 4L19 7" />
                    </svg>
                ) : (
                    <span className="select-none">{String(step).padStart(2, '0')}</span>
                )}
            </div>
            {label && (
                <span
                    className={clsx(
                        'text-sm font-medium transition-all duration-300',
                        isActive ? 'text-[var(--text-primary)]' : 'text-[var(--text-muted)]'
                    )}
                >
                    {label}
                </span>
            )}
        </div>
    );
}
