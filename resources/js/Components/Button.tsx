import React, { ButtonHTMLAttributes } from 'react';
import { Link } from '@inertiajs/react';

type Variant = 'primary' | 'secondary' | 'glass' | 'kinetic';
type Size = 'sm' | 'md' | 'lg';

interface ButtonProps extends ButtonHTMLAttributes<HTMLButtonElement> {
    variant?: Variant;
    size?: Size;
    href?: string;
    className?: string;
    children: React.ReactNode;
}

const Button: React.FC<ButtonProps> = ({
    variant = 'primary',
    size = 'md',
    href,
    className = '',
    children,
    ...props
}) => {

    // Base styles from chalang-core.css .btn class (radius-full, font-weight, transition)
    const baseStyles = "inline-flex items-center justify-center rounded-full font-bold transition-all duration-300 transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed";

    const variants = {
        primary: "bg-brand-primary text-white shadow-glow hover:-translate-y-1 hover:shadow-neon border border-transparent",
        secondary: "bg-white/1 backdrop-blur-md text-gray-800 border border-black/10 hover:border-brand-primary hover:text-brand-primary hover:-translate-y-0.5 dark:text-white dark:border-white/20",
        glass: "bg-white/10 backdrop-blur-lg border border-white/20 text-white hover:bg-white/20",
        kinetic: "bg-gradient-to-br from-white/90 to-white/50 border border-white/80 text-brand-primary shadow-sm hover:-translate-y-1 hover:shadow-glow hover:text-brand-primary hover:border-brand-primary dark:bg-white/10 dark:text-white dark:border-white/10"
    };

    const sizes = {
        sm: "px-4 py-2 text-sm h-9",
        md: "px-8 py-3 text-base h-12",
        lg: "px-10 py-4 text-lg h-14"
    };

    const combinedClasses = `${baseStyles} ${variants[variant]} ${sizes[size]} ${className}`;

    if (href) {
        return (
            <Link href={href} className={combinedClasses}>
                {children}
            </Link>
        );
    }

    return (
        <button className={combinedClasses} {...props}>
            {children}
        </button>
    );
};

export default Button;
