import React, { HTMLAttributes } from 'react';

type Variant = 'default' | 'glass' | 'kinetic';

interface CardProps extends HTMLAttributes<HTMLDivElement> {
    variant?: Variant;
    hoverEffect?: boolean;
    className?: string;
    children: React.ReactNode;
}

const Card: React.FC<CardProps> = ({
    variant = 'default',
    hoverEffect = false,
    className = '',
    children,
    ...props
}) => {

    // Base styles from chalang-core.css (.card, .card-glass)
    const baseStyles = "rounded-2xl p-6 transition-all duration-400 ease-out";

    const variants = {
        default: "bg-white border border-gray-100 shadow-sm dark:bg-brand-dark dark:border-white/10",
        glass: "bg-white/60 backdrop-blur-xl border border-white/80 shadow-md dark:bg-black/40 dark:border-white/10",
        kinetic: "bg-white/80 backdrop-blur-md border border-white/90 shadow-lg dark:bg-white/5 dark:border-white/5"
    };

    const hoverStyles = hoverEffect
        ? "hover:-translate-y-1 hover:shadow-lg hover:border-brand-secondary/50 hover:z-10 relative"
        : "";

    const combinedClasses = `${baseStyles} ${variants[variant]} ${hoverStyles} ${className}`;

    return (
        <div className={combinedClasses} {...props}>
            {children}
        </div>
    );
};

export default Card;
