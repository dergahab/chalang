import React, { HTMLAttributes } from 'react';

type Variant = 'h1' | 'h2' | 'h3' | 'h4' | 'body' | 'small' | 'section-title' | 'section-subtitle';

interface TypographyProps extends HTMLAttributes<HTMLElement> {
    variant?: Variant;
    gradient?: boolean;
    className?: string;
    as?: React.ElementType;
    children: React.ReactNode;
}

const Typography: React.FC<TypographyProps> = ({
    variant = 'body',
    gradient = false,
    className = '',
    as,
    children,
    ...props
}) => {

    // Base styles maps to chalang-core.css variables
    const styles = {
        h1: "font-display font-bold text-4xl md:text-6xl lg:text-7xl leading-tight tracking-tight",
        h2: "font-display font-bold text-3xl md:text-5xl leading-tight",
        h3: "font-display font-bold text-2xl md:text-3xl leading-snug",
        h4: "font-display font-bold text-xl md:text-2xl",
        body: "font-sans text-base md:text-lg leading-relaxed text-gray-600 dark:text-gray-300",
        small: "font-sans text-sm text-gray-500 dark:text-gray-400",
        'section-title': "font-display text-4xl md:text-5xl font-extrabold text-center mb-4 text-brand-dark dark:text-white",
        'section-subtitle': "font-sans text-lg text-center text-gray-500 dark:text-gray-400 mb-12 max-w-2xl mx-auto"
    };

    const gradientClass = gradient
        ? "bg-clip-text text-transparent bg-gradient-to-r from-brand-primary to-brand-secondary"
        : "";

    const Component = as || mapVariantToTag(variant);

    return (
        <Component className={`${styles[variant]} ${gradientClass} ${className}`} {...props}>
            {children}
        </Component>
    );
};

// Helper to determine default HTML tag
function mapVariantToTag(variant: Variant): React.ElementType {
    if (['h1', 'h2', 'h3', 'h4'].includes(variant)) return variant as React.ElementType;
    if (variant === 'section-title') return 'h2';
    if (variant === 'section-subtitle') return 'p';
    return 'p';
}

export default Typography;
