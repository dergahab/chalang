import React from 'react';
import { clsx } from '@/lib/clsx';

interface AvatarProps {
    src?: string | null;
    alt?: string;
    size?: 'sm' | 'md' | 'lg' | 'xl';
    fallback?: string;
    className?: string;
}

const sizeClasses = {
    sm: 'w-8 h-8 text-xs',
    md: 'w-10 h-10 text-sm',
    lg: 'w-14 h-14 text-lg',
    xl: 'w-20 h-20 text-2xl',
};

const getInitials = (name?: string): string => {
    if (!name) return '?';
    return name
        .split(' ')
        .map(part => part[0])
        .filter(Boolean)
        .slice(0, 2)
        .join('')
        .toUpperCase();
};

export default function Avatar({ src, alt = '', size = 'md', fallback, className }: AvatarProps) {
    const [imgError, setImgError] = React.useState(false);

    React.useEffect(() => {
        setImgError(false);
    }, [src]);

    if (src && !imgError) {
        return (
            <img
                src={src}
                alt={alt}
                className={clsx('rounded-full object-cover bg-[var(--bg-secondary)]', sizeClasses[size], className)}
                onError={() => setImgError(true)}
                loading="lazy"
                decoding="async"
            />
        );
    }

    return (
        <div
            className={clsx(
                'rounded-full flex items-center justify-center font-bold select-none',
                'bg-[var(--brand-primary)]/10 text-[var(--brand-primary)]',
                sizeClasses[size],
                className
            )}
            aria-label={alt || fallback || 'Avatar'}
        >
            {fallback || getInitials(alt)}
        </div>
    );
}
