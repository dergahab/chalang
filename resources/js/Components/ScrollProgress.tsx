import React, { useEffect, useState } from 'react';

export default function ScrollProgress() {
    const [progress, setProgress] = useState(0);

    useEffect(() => {
        const handleScroll = () => {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPercent = scrollTop / docHeight;
            setProgress(Math.min(Math.max(scrollPercent * 100, 0), 100));
        };

        window.addEventListener('scroll', handleScroll, { passive: true });
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    return (
        <div 
            className="scroll-progress-container"
            style={{
                position: 'fixed',
                top: 0,
                left: 0,
                width: '100%',
                height: '4px',
                background: 'transparent',
                zIndex: 9999,
            }}
        >
            <div 
                className="scroll-progress-bar"
                style={{
                    height: '100%',
                    width: `${progress}%`,
                    background: 'linear-gradient(90deg, var(--brand-primary), var(--brand-secondary))',
                    transition: 'width 0.1s ease-out',
                    boxShadow: '0 0 10px var(--brand-primary)',
                }}
            />
        </div>
    );
}