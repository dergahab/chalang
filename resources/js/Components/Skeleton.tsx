import React from 'react';

interface SkeletonProps {
    width?: string;
    height?: string;
    borderRadius?: string;
    className?: string;
    style?: React.CSSProperties;
}

export default function Skeleton({ 
    width = '100%', 
    height = '20px', 
    borderRadius = '8px',
    className = '',
    style
}: SkeletonProps) {
    return (
        <div
            className={`skeleton ${className}`}
            style={{
                width,
                height,
                borderRadius,
                background: 'linear-gradient(90deg, var(--brand-primary) 25%, rgba(255,255,255,0.1) 50%, var(--brand-primary) 75%)',
                backgroundSize: '200% 100%',
                animation: 'skeleton-pulse 1.5s ease-in-out infinite',
                ...style,
            }}
        >
            <style>{`
                @keyframes skeleton-pulse {
                    0% { opacity: 1; }
                    50% { opacity: 0.5; }
                    100% { opacity: 1; }
                }
            `}</style>
        </div>
    );
}

// Text skeleton variant
export function SkeletonText({ lines = 3 }: { lines?: number }) {
    return (
        <div className="skeleton-text" style={{ display: 'flex', flexDirection: 'column', gap: '8px' }}>
            {[...Array(lines)].map((_, i) => (
                <Skeleton 
                    key={i} 
                    width={i === lines - 1 ? '70%' : '100%'} 
                    height="16px" 
                />
            ))}
        </div>
    );
}

// Avatar skeleton
export function SkeletonAvatar({ size = '48px' }: { size?: string }) {
    return (
        <Skeleton 
            width={size} 
            height={size} 
            borderRadius="50%" 
        />
    );
}

// Card skeleton
export function SkeletonCard() {
    return (
        <div style={{ 
            padding: '20px', 
            borderRadius: '16px', 
            background: 'var(--card-bg)',
            border: '1px solid var(--card-border)',
        }}>
            <div style={{ display: 'flex', gap: '16px', marginBottom: '16px' }}>
                <SkeletonAvatar size="56px" />
                <div style={{ flex: 1 }}>
                    <Skeleton width="60%" height="20px" />
                    <Skeleton width="40%" height="14px" style={{ marginTop: '8px' }} />
                </div>
            </div>
            <SkeletonText lines={3} />
        </div>
    );
}
