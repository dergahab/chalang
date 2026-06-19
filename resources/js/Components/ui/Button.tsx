import { ButtonHTMLAttributes, forwardRef } from 'react';
import { clsx } from '@/lib/clsx';

import { Link } from '@inertiajs/react';

export interface ButtonProps extends ButtonHTMLAttributes<HTMLButtonElement> {
    variant?: 'primary' | 'secondary' | 'ghost' | 'danger' | 'outline';
    size?: 'sm' | 'md' | 'lg';
    isLoading?: boolean;
    glow?: boolean;
    leftIcon?: React.ReactNode;
    rightIcon?: React.ReactNode;
    href?: string;
}

const Button = forwardRef<HTMLButtonElement | HTMLAnchorElement, ButtonProps>(({
    children,
    variant = 'primary',
    size = 'md',
    isLoading = false,
    glow = false,
    leftIcon,
    rightIcon,
    className,
    disabled,
    href,
    ...props
}, ref) => {
    const buttonClass = clsx(
        'magnet-btn inline-flex items-center justify-center font-semibold rounded-[var(--radius-btn,12px)] transition-all duration-300 ease-out cursor-pointer border border-transparent outline-none gap-2 whitespace-nowrap select-none relative overflow-hidden',
        variant === 'primary' && 'bg-brand-gradient text-white shadow-lg hover:-translate-y-0.5 hover:shadow-xl',
        variant === 'secondary' && 'bg-[var(--card-bg)] text-[var(--text-main)] border-[var(--card-border)] backdrop-blur-md hover:bg-[var(--bg-secondary)] hover:border-brand-primary',
        variant === 'outline' && 'bg-transparent text-brand-primary border-brand-primary hover:bg-brand-primary/10',
        variant === 'ghost' && 'bg-transparent text-[var(--text-main)] hover:bg-white/5',
        variant === 'danger' && 'bg-gradient-to-r from-red-500 to-red-700 text-white',
        size === 'sm' && 'px-4 py-2 text-sm min-h-[44px]',
        size === 'md' && 'px-6 py-3 text-base min-h-[44px]',
        size === 'lg' && 'px-8 py-4 text-lg min-h-[52px]',
        (disabled || isLoading) && 'opacity-50 cursor-not-allowed grayscale',
        className
    );

    const innerContent = isLoading ? (
        <span className="block w-[18px] h-[18px] border-2 border-white/30 rounded-full border-t-white animate-spin" />
    ) : (
        <>
            {leftIcon && <span className="flex items-center">{leftIcon}</span>}
            {children}
            {rightIcon && <span className="flex items-center">{rightIcon}</span>}
        </>
    );

    if (href) {
        if (href.startsWith('http')) {
            return (
                <a href={href} className={buttonClass} ref={ref as React.Ref<HTMLAnchorElement>} {...(props as Record<string, unknown>)}>
                    {innerContent}
                </a>
            );
        }

        return (
            <Link href={href} className={buttonClass} {...(props as Record<string, unknown>)}>
                {innerContent}
            </Link>
        );
    }

    return (
        <button
            ref={ref as React.Ref<HTMLButtonElement>}
            className={buttonClass}
            disabled={disabled || isLoading}
            {...props}
        >
            {innerContent}
            {glow && (
                <div className="absolute -inset-[2px] bg-brand-gradient blur-[15px] opacity-30 -z-10 rounded-[calc(var(--radius-btn,12px)+2px)] animate-glow-pulse" />
            )}
        </button>
    );
});

Button.displayName = 'Button';

export default Button;
