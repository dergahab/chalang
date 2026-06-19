import React from 'react';

interface SkeletonProps {
    className?: string;
    width?: string | number;
    height?: string | number;
    variant?: 'text' | 'rect' | 'circle';
}

export const Skeleton: React.FC<SkeletonProps> = ({ 
    className = '', 
    width, 
    height, 
    variant = 'rect' 
}) => {
    const baseClasses = "animate-pulse bg-gray-200 dark:bg-white/10";
    const variantClasses = {
        text: "rounded h-4 w-full mb-2",
        rect: "rounded-lg",
        circle: "rounded-full"
    };

    const style: React.CSSProperties = {
        width: width || '100%',
        height: height || (variant === 'text' ? undefined : '100%'),
    };

    return (
        <div 
            className={`${baseClasses} ${variantClasses[variant]} ${className}`}
            style={style}
            aria-hidden="true"
        />
    );
};

// Named exports for specific cases (fixing ui/index.ts issues)
export const CardSkeleton = ({ className = "" }) => <Skeleton height={300} className={`w-full ${className}`} />;
export const ImageSkeleton = ({ className = "" }) => <Skeleton height={400} className={`w-full ${className}`} />;
export const AvatarSkeleton = ({ className = "" }) => <Skeleton variant="circle" width={60} height={60} className={className} />;
export const ButtonSkeleton = ({ className = "" }) => <Skeleton height={48} width={160} className={`rounded-full ${className}`} />;
export const TextSkeleton = ({ className = "" }) => (
    <div className={`space-y-2 ${className}`}>
        <Skeleton variant="text" width="100%" />
        <Skeleton variant="text" width="90%" />
        <Skeleton variant="text" width="40%" />
    </div>
);

export default Skeleton;
