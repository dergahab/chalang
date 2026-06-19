import React, { useState, useEffect, useRef } from 'react';

interface LazyImageProps {
    src: string;
    alt: string;
    className?: string;
    style?: React.CSSProperties;
    placeholder?: string;
}

export default function LazyImage({ src, alt, className = '', style = {}, placeholder }: LazyImageProps) {
    const [isLoaded, setIsLoaded] = useState(false);
    const [isInView, setIsInView] = useState(false);
    const imgRef = useRef<HTMLDivElement>(null);

    // Default placeholder color
    const bgColor = placeholder || 'var(--brand-primary)';

    useEffect(() => {
        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    setIsInView(true);
                    observer.disconnect();
                }
            },
            { rootMargin: '50px', threshold: 0 }
        );

        if (imgRef.current) {
            observer.observe(imgRef.current);
        }

        return () => observer.disconnect();
    }, []);

    return (
        <div
            ref={imgRef}
            className={`lazy-image-wrapper ${className}`}
            style={{
                position: 'relative',
                overflow: 'hidden',
                background: isLoaded ? 'transparent' : bgColor,
                ...style,
            }}
        >
            {/* Skeleton pulse animation */}
            {!isLoaded && (
                <div
                    className="lazy-image-skeleton"
                    style={{
                        position: 'absolute',
                        inset: 0,
                        background: `linear-gradient(90deg, ${bgColor} 25%, rgba(255,255,255,0.1) 50%, ${bgColor} 75%)`,
                        backgroundSize: '200% 100%',
                        animation: 'shimmer 1.5s infinite',
                    }}
                />
            )}

            {/* Actual image */}
            {(isInView || isLoaded) && (
                <img
                    src={src}
                    alt={alt}
                    className="lazy-image"
                    onLoad={() => setIsLoaded(true)}
                    style={{
                        width: '100%',
                        height: '100%',
                        objectFit: 'cover',
                        opacity: isLoaded ? 1 : 0,
                        transition: 'opacity 0.3s ease-out',
                    }}
                />
            )}

            <style>{`
                @keyframes shimmer {
                    0% { background-position: -200% 0; }
                    100% { background-position: 200% 0; }
                }
            `}</style>
        </div>
    );
}