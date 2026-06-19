/**
 * Partners — Horizontal auto-scrolling logo marquee.
 * 1:1 match with Blade .partners-section
 */

import React, { useEffect, useState, useRef } from 'react';

interface Partner {
    id: number;
    name: string;
    logo?: string;
}

interface PartnersProps {
    partners: Partner[];
    title?: string;
}

export default function Partners({ partners, title = 'Güvənilən tərəfdaşlarımız' }: PartnersProps) {
    const [isPaused, setIsPaused] = useState(false);
    
    if (!partners || partners.length === 0) return null;

    // Create duplicate array for seamless infinite scroll
    const displayPartners = [...partners, ...partners, ...partners];

    return (
        <section 
            className="py-12 md:py-20 lg:py-24 overflow-hidden relative"
            style={{ '--fade-color': 'var(--bg-body, #0b0f19)' } as React.CSSProperties}
            onMouseEnter={() => setIsPaused(true)}
            onMouseLeave={() => setIsPaused(false)}
        >
            <div className="w-full max-w-container mx-auto px-4 mb-8 text-center" style={{ zIndex: 20, position: 'relative' }}>
                <h6 className="text-sm font-bold uppercase tracking-[0.2em] text-text-sub opacity-70">{title}</h6>
            </div>
            <div className="w-full overflow-hidden">
                <div 
                    className="flex w-max"
                    data-track=""
                    style={{ 
                        animationPlayState: isPaused ? 'paused' : 'running',
                        '--partner-count': partners.length,
                    } as React.CSSProperties}
                >
                    {displayPartners.map((partner, i) => {
                        const hasLogo = !!partner.logo;
                        const fallbackName = partner.name || 'Partner';
                        const key = `${partner.id}-${i}`;

                        return (
                            <div key={key} className="group flex-shrink-0 flex justify-center items-center w-[140px] p-[15px_20px] md:w-[180px] md:p-5 mx-[5px] rounded-xl bg-[rgba(255,255,255,0.02)] transition-all duration-300 hover:bg-[rgba(255,255,255,0.05)] hover:-translate-y-0.5">
                                {hasLogo ? (
                                    <img 
                                        src={partner.logo.startsWith('http') ? partner.logo : (partner.logo.startsWith('/') ? partner.logo : `/storage/${partner.logo}`)} 
                                        alt={fallbackName} 
                                        className="max-h-[35px] max-w-[100px] md:max-h-[50px] md:max-w-[140px] grayscale opacity-50 transition-all duration-300 object-contain group-hover:grayscale-0 group-hover:opacity-100"
                                        loading="lazy"
                                    />
                                ) : (
                                    <span className="text-lg font-extrabold uppercase opacity-40 tracking-wider text-text-main transition-all duration-300 group-hover:opacity-80">{fallbackName}</span>
                                )}
                            </div>
                        );
                    })}
                </div>
            </div>
            <style>{`
                @keyframes scrollLeft {
                    0% { transform: translateX(0); }
                    100% { transform: translateX(calc(-33.333% - 10px)); }
                }
                [data-track] {
                    animation: scrollLeft 40s linear infinite;
                }
                @media (max-width: 768px) {
                    [data-track] {
                        animation-duration: 25s;
                    }
                }
            `}</style>
        </section>
    );
}
