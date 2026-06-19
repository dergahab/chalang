import { ReactNode, Suspense } from 'react';
import { motion } from 'framer-motion';
import { Skeleton } from './Skeleton';

interface LazySectionProps {
    children: ReactNode;
    fallback?: 'card' | 'text' | 'image';
    height?: string;
}

export function LazySection({ children, fallback = 'card', height }: LazySectionProps) {
    const fallbackHeights = {
        card: 'h-96',
        text: 'h-32',
        image: 'h-64',
    };

    return (
        <Suspense
            fallback={
                <div className={fallbackHeights[fallback] || height} style={{ minHeight: height }}>
                    <Skeleton variant="rect" className="w-full h-full" />
                </div>
            }
        >
            <motion.div
                initial={{ opacity: 1, y: 0 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true, margin: '-100px' }}
                transition={{ duration: 0.35, ease: 'easeOut' }}
            >
                {children}
            </motion.div>
        </Suspense>
    );
}

/**
 * Section wrapper with global spacing tokens, alternating backgrounds, and container system.
 * Phase 3.7: py-20 md:py-28 lg:py-36, var(--bg-primary) / var(--bg-section-alt) alternation.
 */
interface SectionWrapperProps {
    children: ReactNode;
    id?: string;
    className?: string;
    as?: 'section' | 'div' | 'main';
    variant?: 'primary' | 'alt';
    containerClass?: string;
    noContainer?: boolean;
    'aria-labelledby'?: string;
}

const variantClasses: Record<string, string> = {
    primary: 'bg-transparent',
    alt: 'bg-black/10', // Alt versiya üçün çox xəfif kölgə, gradienti örtmür
};

export function SectionWrapper({
    children,
    id,
    className = '',
    as: Tag = 'section',
    variant = 'primary',
    containerClass = '',
    noContainer = false,
    'aria-labelledby': ariaLabelledby,
}: SectionWrapperProps) {
    return (
        <Tag
            id={id}
            aria-labelledby={ariaLabelledby}
            className={`py-20 md:py-28 lg:py-36 ${variantClasses[variant] || variantClasses.primary} ${className}`}
        >
            {noContainer ? children : (
                <div className={`max-w-container mx-auto px-4 sm:px-6 lg:px-8 ${containerClass}`}>
                    {children}
                </div>
            )}
        </Tag>
    );
}

/**
 * Container for grid layouts
 */
interface GridContainerProps {
    children: ReactNode;
    columns?: 1 | 2 | 3 | 4 | 5 | 6;
    gap?: 'sm' | 'md' | 'lg' | 'xl';
    className?: string;
}

export function GridContainer({
    children,
    columns = 3,
    gap = 'lg',
    className = ''
}: GridContainerProps) {
    const columnMap = {
        1: 'grid-cols-1',
        2: 'grid-cols-1 sm:grid-cols-2',
        3: 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
        4: 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
        5: 'grid-cols-1 sm:grid-cols-3 lg:grid-cols-5',
        6: 'grid-cols-1 sm:grid-cols-3 lg:grid-cols-6',
    };

    const gapMap = {
        sm: 'gap-4',
        md: 'gap-6',
        lg: 'gap-8',
        xl: 'gap-10',
    };

    return (
        <div className={`grid ${columnMap[columns]} ${gapMap[gap]} ${className}`}>
            {children}
        </div>
    );
}

/**
 * Container for flex layouts
 */
interface FlexContainerProps {
    children: ReactNode;
    direction?: 'row' | 'col';
    justify?: 'start' | 'center' | 'end' | 'between' | 'around';
    align?: 'start' | 'center' | 'end' | 'stretch';
    gap?: 'sm' | 'md' | 'lg' | 'xl';
    wrap?: boolean;
    className?: string;
}

export function FlexContainer({
    children,
    direction = 'row',
    justify = 'start',
    align = 'start',
    gap = 'md',
    wrap = false,
    className = ''
}: FlexContainerProps) {
    const directionMap = {
        row: 'flex-row',
        col: 'flex-col',
    };

    const justifyMap = {
        start: 'justify-start',
        center: 'justify-center',
        end: 'justify-end',
        between: 'justify-between',
        around: 'justify-around',
    };

    const alignMap = {
        start: 'items-start',
        center: 'items-center',
        end: 'items-end',
        stretch: 'items-stretch',
    };

    const gapMap = {
        sm: 'gap-2',
        md: 'gap-4',
        lg: 'gap-6',
        xl: 'gap-8',
    };

    return (
        <div className={`flex ${directionMap[direction]} ${justifyMap[justify]} ${alignMap[align]} ${gapMap[gap]} ${wrap ? 'flex-wrap' : ''} ${className}`}>
            {children}
        </div>
    );
}

/**
 * Centered content wrapper
 */
interface CenterProps {
    children: ReactNode;
    className?: string;
}

export function Center({ children, className = '' }: CenterProps) {
    return (
        <div className={`flex items-center justify-center ${className}`}>
            {children}
        </div>
    );
}

/**
 * Text alignment wrapper
 */
interface TextAlignProps {
    children: ReactNode;
    align?: 'left' | 'center' | 'right';
    className?: string;
}

export function TextAlign({ children, align = 'center', className = '' }: TextAlignProps) {
    const alignMap = {
        left: 'text-left',
        center: 'text-center',
        right: 'text-right',
    };

    return (
        <div className={alignMap[align] + ' ' + className}>
            {children}
        </div>
    );
}

/**
 * Two column layout
 */
interface TwoColumnProps {
    children: [ReactNode, ReactNode];
    reverseOnMobile?: boolean;
    gap?: 'md' | 'lg' | 'xl';
    className?: string;
}

export function TwoColumn({
    children,
    reverseOnMobile = false,
    gap = 'lg',
    className = ''
}: TwoColumnProps) {
    const gapMap = {
        md: 'gap-6',
        lg: 'gap-10',
        xl: 'gap-14',
    };

    return (
        <div className={`grid grid-cols-1 lg:grid-cols-2 ${gapMap[gap]} ${className}`}>
            <div className={reverseOnMobile ? 'order-2 lg:order-1' : 'order-1'}>
                {children[0]}
            </div>
            <div className={reverseOnMobile ? 'order-1 lg:order-2' : 'order-2'}>
                {children[1]}
            </div>
        </div>
    );
}

export default LazySection;