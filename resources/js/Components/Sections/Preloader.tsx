import React, { useEffect, useState } from 'react';

export default function Preloader() {
    const [progress, setProgress] = useState(0);
    const [hidden, setHidden] = useState(false);

    useEffect(() => {
        let currentProgress = 0;
        const targetProgress = 100;
        
        // Simulating the loading effect
        const interval = setInterval(() => {
            currentProgress += Math.floor(Math.random() * 20) + 5;
            if (currentProgress > targetProgress) {
                currentProgress = targetProgress;
            }
            
            setProgress(currentProgress);
            
            if (currentProgress === targetProgress) {
                clearInterval(interval);
                setTimeout(() => {
                    setHidden(true);
                }, 500); // Wait 0.5s after 100% then hide
            }
        }, 150);

        return () => clearInterval(interval);
    }, []);

    if (hidden) return null;

    return (
        <div id="preloader-wrapper" className={progress === 100 ? 'loaded' : ''} style={{ zIndex: 999999 }}>
            <div className="curtain-layer" style={{ transform: progress === 100 ? 'translateY(-100%)' : 'translateY(0)', transition: 'transform 0.8s cubic-bezier(0.77, 0, 0.175, 1)' }}></div>
            <div className="loader-content" style={{ opacity: progress === 100 ? 0 : 1, transition: 'opacity 0.4s ease' }}>
                <svg className="loader-logo" viewBox="0 0 81.87 15.74" style={{ width: '120px', height: 'auto', marginBottom: '20px', color: 'var(--brand-primary)' }}>
                    <path fill="currentColor" d="M25.7,5.95c-.49-.62-1.3-1.22-2.46-1.22-1.96,0-3.33,1.59-3.33,3.31,0,1.84,1.46,3.38,3.34,3.38.87,0,1.75-.34,2.36-1.14h2.11c-.81,1.72-2.38,2.9-4.52,2.9-3.43,0-5.1-2.89-5.1-5.14s1.66-5.07,5.13-5.07c2.03,0,3.72,1.1,4.54,2.98h-2.07Z" />
                    <path fill="currentColor" d="M8.88.03C3.91-.37-.27,3.73.01,8.7c.18,3.15,2.14,5.82,4.88,7.04.02,0,.04-.02.03-.03-.22-.3-.35-.68-.35-1.08,0-.87.6-1.6,1.41-1.8.02,0,.02-.03,0-.04-1.88-.92-3.1-2.96-2.8-5.26.27-2.08,2.21-4.04,4.29-4.34,3.14-.44,5.82,1.98,5.82,5.03,0,2-1.16,3.74-2.85,4.56-.02,0-.02.04,0,.04.81.2,1.41.93,1.41,1.8,0,.4-.13.77-.34, 1.08-.01.02,0,.04.03.03,2.88-1.28,4.89-4.16,4.89-7.52C16.44,3.9,13.11.36,8.88.03Z" />
                </svg>
                <div className="loader-progress" style={{ fontSize: '24px', fontWeight: 700, color: 'var(--brand-primary)' }}>{progress}%</div>
            </div>
        </div>
    );
}
