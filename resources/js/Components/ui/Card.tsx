import { HTMLAttributes, forwardRef } from 'react';
import { clsx } from '@/lib/clsx';

export interface CardProps extends HTMLAttributes<HTMLDivElement> {
    variant?: 'default' | 'glass' | 'elevated' | 'outline';
    hover?: boolean;
    padding?: 'none' | 'sm' | 'md' | 'lg';
}

const Card = forwardRef<HTMLDivElement, CardProps>(({
    children,
    variant = 'default',
    hover = false,
    padding = 'md',
    className,
    ...props
}, ref) => {
    const cardClass = clsx(
        'rounded-[var(--radius-card,24px)] border border-[var(--card-border)] transition-all duration-300 ease-out relative overflow-hidden',
        variant === 'default' && 'bg-[var(--bg-card,var(--bg-primary))]',
        variant === 'glass' && 'bg-[var(--nav-bg-glass,rgba(255,255,255,0.05))] backdrop-blur-xl',
        variant === 'elevated' && 'bg-[var(--bg-card,var(--bg-primary))] shadow-[0_10px_30px_rgba(0,0,0,0.05)]',
        variant === 'outline' && 'bg-transparent border-2',
        hover && 'hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(0,0,0,0.12)] hover:border-brand-primary',
        padding === 'none' && 'p-0',
        padding === 'sm' && 'p-4',
        padding === 'md' && 'p-6',
        padding === 'lg' && 'p-10 max-md:p-6',
        className
    );

    return (
        <div ref={ref} className={cardClass} {...props}>
            {children}
        </div>
    );
});

Card.displayName = 'Card';

export const CardHeader = ({ children, className, ...props }: HTMLAttributes<HTMLDivElement>) => (
    <div className={clsx('mb-5', className)} {...props}>
        {children}
    </div>
);

export const CardTitle = ({ children, className, as: Tag = 'h3', ...props }: Record<string, unknown> & { children?: React.ReactNode; className?: string; as?: React.ElementType }) => (
    <Tag className={clsx('text-xl font-bold text-[var(--text-main)] m-0', className)} {...props}>
        {children}
    </Tag>
);

export const CardDescription = ({ children, className, ...props }: HTMLAttributes<HTMLParagraphElement>) => (
    <p className={clsx('text-[0.95rem] text-[var(--text-sub)] mt-1.5 leading-relaxed', className)} {...props}>
        {children}
    </p>
);

export const CardFooter = ({ children, className, ...props }: HTMLAttributes<HTMLDivElement>) => (
    <div className={clsx('mt-6 pt-5 border-t border-[var(--card-border)] flex items-center gap-3', className)} {...props}>
        {children}
    </div>
);

export default Card;
