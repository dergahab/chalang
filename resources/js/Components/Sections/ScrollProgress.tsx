import { useEffect, useState } from 'react';

/**
 * ScrollProgress — Fixed gradient bar at the top of viewport.
 * 1:1 match with Blade #scroll-progress
 */
export default function ScrollProgress() {
    const [width, setWidth] = useState(0);

    useEffect(() => {
        const handleScroll = () => {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
            setWidth(progress);
        };

        window.addEventListener('scroll', handleScroll, { passive: true });
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    return (
        <div
            id="scroll-progress"
            className="fixed top-0 left-0 h-1 z-[200001] transition-[width] duration-100 ease-out"
            style={{
                width: `${width}%`,
                background: 'var(--brand-gradient, linear-gradient(135deg, #4b0082, #d500f9))',
                boxShadow: '0 0 10px var(--brand-secondary, #d500f9)',
            }}
        />
    );
}
