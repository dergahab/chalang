import { InputHTMLAttributes, forwardRef, useState } from 'react';
import { clsx } from '@/lib/clsx';

export interface InputProps extends InputHTMLAttributes<HTMLInputElement> {
    label?: string;
    error?: string;
    helperText?: string;
    leftIcon?: React.ReactNode;
    rightIcon?: React.ReactNode;
}

const Input = forwardRef<HTMLInputElement, InputProps>(({
    label,
    error,
    helperText,
    leftIcon,
    rightIcon,
    className,
    type = 'text',
    ...props
}, ref) => {
    const [showPassword, setShowPassword] = useState(false);
    const isPassword = type === 'password';

    const inputClass = clsx(
        'w-full bg-[var(--card-bg)] border rounded-[var(--radius-input,12px)] px-4 py-3 text-[var(--text-main)] text-base transition-all duration-300 ease-out outline-none backdrop-blur-sm',
        error
            ? 'border-red-500 focus:border-red-500 focus:shadow-[0_0_0_4px_rgba(239,68,68,0.1)]'
            : 'border-[var(--card-border)] focus:border-brand-primary focus:shadow-[0_0_0_4px_rgba(var(--brand-primary-rgb),0.1)] focus:bg-[var(--bg-body)]',
        leftIcon && 'pl-[45px]',
        (rightIcon || isPassword) && 'pr-[45px]'
    );

    const iconBase = 'absolute top-1/2 -translate-y-1/2 flex items-center justify-center w-10 h-full bg-transparent border-none cursor-pointer transition-colors duration-300 text-[var(--text-sub)]';

    return (
        <div className={clsx('w-full mb-5', className)}>
            {label && (
                <label className="block text-sm font-semibold text-[var(--text-main)] mb-2 opacity-90">
                    {label}
                </label>
            )}
            <div className="relative w-full">
                {leftIcon && (
                    <div className={clsx(iconBase, 'left-[5px]')}>
                        {leftIcon}
                    </div>
                )}
                <input
                    ref={ref}
                    type={isPassword && showPassword ? 'text' : type}
                    className={inputClass}
                    {...props}
                />
                {isPassword && (
                    <button
                        type="button"
                        onClick={() => setShowPassword(!showPassword)}
                        className={clsx(iconBase, 'right-[5px] hover:text-brand-primary')}
                    >
                        {showPassword ? (
                            <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        ) : (
                            <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        )}
                    </button>
                )}
                {rightIcon && !isPassword && (
                    <div className={clsx(iconBase, 'right-[5px]')}>
                        {rightIcon}
                    </div>
                )}
            </div>
            {(error || helperText) && (
                <p className={clsx('text-xs mt-1.5', error ? 'text-red-500' : 'text-[var(--text-sub)]')}>
                    {error || helperText}
                </p>
            )}
        </div>
    );
});

Input.displayName = 'Input';

export default Input;
