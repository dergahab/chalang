import { HTMLAttributes, forwardRef } from 'react';
import { clsx } from '@/lib/clsx';

export interface EmptyStateProps extends HTMLAttributes<HTMLDivElement> {
    icon?: React.ReactNode;
    title: string;
    description?: string;
    action?: React.ReactNode;
}

export const EmptyState = forwardRef<HTMLDivElement, EmptyStateProps>(({
    icon,
    title,
    description,
    action,
    className,
    ...props
}, ref) => {
    return (
        <div
            ref={ref}
            className={clsx(
                'flex flex-col items-center justify-center py-16 px-4 text-center',
                className
            )}
            {...props}
        >
            {icon && (
                <div className="mb-4 text-text-muted opacity-50">
                    {icon}
                </div>
            )}
            <h3 className="text-lg font-semibold text-text-main mb-2">
                {title}
            </h3>
            {description && (
                <p className="text-text-sub max-w-sm mb-6">
                    {description}
                </p>
            )}
            {action}
        </div>
    );
});

EmptyState.displayName = 'EmptyState';

// Preset empty states
interface EmptyStatePresetProps extends Omit<EmptyStateProps, 'title' | 'icon'> {
    type: 'no-data' | 'no-results' | 'no-connection' | 'error';
}

export function EmptyStatePreset({ type, ...props }: EmptyStatePresetProps) {
    const presets = {
        'no-data': {
            icon: (
                <svg className="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            ),
            title: 'Məlumat yoxdur',
            description: 'Hazırda göstəriləcək məlumat yoxdur. Sonra yeniden cəhd edin.',
        },
        'no-results': {
            icon: (
                <svg className="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            ),
            title: 'Nəticə tapılmadı',
            description: 'Axtarışınıza uyğun nəticə tapılmadı. Başqa axtarış sözü yoxlayın.',
        },
        'no-connection': {
            icon: (
                <svg className="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4 4 0 01-5.657-5.657l1.415 1.414a7 7 0 009.9 9.9m1.414-1.414l-3.536-3.536m0 0a5 5 0 01-7.072 0m7.072 0l3.536 3.536" />
                </svg>
            ),
            title: 'İnternet bağlantısı yoxdur',
            description: 'İnternet bağlantınızı yoxlayıb yeniden cəhd edin.',
        },
        'error': {
            icon: (
                <svg className="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            ),
            title: 'Xəta baş verdi',
            description: 'Xeta baş verdi. Yeniden cəhd edin.',
        },
    };

    const preset = presets[type];

    return (
        <EmptyState
            icon={preset.icon}
            title={preset.title}
            description={preset.description}
            {...props}
        />
    );
}

export default EmptyState;
