import React, { useRef, useState } from 'react';
import type { Translations } from '@/types';

/**
 * Testimonials — Grid layout (Blade 1:1).
 * Blade .testimonials-section, .testimonial-slider (grid, not Swiper)
 *
 * CSS classes: .testimonials-section, .testimonial-slider,
 *   .testimonial-card, .testimonial-text, .testimonial-author,
 *   .author-avatar, .author-info
 */

interface Testimonial {
    id: number;
    name?: string;
    position?: string;
    content?: string;
    image?: string | null;
}

interface TestimonialsProps {
    testimonials: Testimonial[];
    translations: Translations;
}

export default function Testimonials({ testimonials, translations }: TestimonialsProps) {
    const t = (key: string, fallback?: string): string => {
        const keys = key.split('.');
        let value: any = translations;
        for (const k of keys) {
            value = value?.[k];
        }
        return typeof value === 'string' ? value : (fallback ?? key);
    };

    const displayTestimonials = testimonials && testimonials.length > 0 ? testimonials.slice(0, 6) : [];

    const getImageUrl = (imagePath?: string | null) => {
        if (!imagePath) return '';
        if (imagePath.startsWith('http')) return imagePath;
        return `/storage/${imagePath}`;
    };

    // Testimonials data yoxdursa skeleton goster
    if (!displayTestimonials || displayTestimonials.length === 0) {
        return (
            <section className="py-20 md:py-28 lg:py-36" id="testimonials">
                <div className="max-w-container mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 className="text-3xl md:text-5xl font-bold text-center text-text-main mb-4">Musherilrimiz ne deyir</h2>
                </div>
                <div className="flex gap-6 px-10 overflow-hidden">
                    {[0,1,2].map(i => (
                        <div key={i} className="flex-shrink-0 w-[calc(100%-20px)] md:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] min-w-[320px] bg-[var(--card-bg)] border border-[var(--card-border)] rounded-2xl p-8">
                            <div className="flex gap-0.5 mb-4 text-[var(--brand-secondary)] opacity-30">{[...Array(5)].map((_,j)=><span key={j}>★</span>)}</div>
                            <div className="h-20 rounded-lg mb-5" style={{background:'var(--brand-primary)/10'}} />
                            <div className="flex items-center gap-3">
                                <div className="w-12 h-12 rounded-full" style={{background:'var(--brand-primary)/10'}} />
                                <div><div className="h-4 w-24 rounded mb-1" style={{background:'var(--brand-primary)/10'}} /><div className="h-3 w-16 rounded opacity-50" style={{background:'var(--brand-primary)/10'}} /></div>
                            </div>
                        </div>
                    ))}
                </div>
            </section>
        );
    }

    const scrollRef = useRef<HTMLDivElement>(null);
    const [activeIndex, setActiveIndex] = useState(0);

    const handleScroll = () => {
        if (!scrollRef.current) return;
        const scrollLeft = scrollRef.current.scrollLeft;
        const cardWidth = scrollRef.current.children[0]?.clientWidth || 320;
        const gap = window.innerWidth <= 768 ? 20 : 24;
        const newIndex = Math.round(scrollLeft / (cardWidth + gap));
        setActiveIndex(newIndex);
    };

    const scrollTo = (index: number) => {
        if (!scrollRef.current) return;
        const cardWidth = scrollRef.current.children[0]?.clientWidth || 320;
        const gap = window.innerWidth <= 768 ? 20 : 24;
        scrollRef.current.scrollTo({ left: index * (cardWidth + gap), behavior: 'smooth' });
    };

    return (
        <section className="py-20 md:py-28 lg:py-36" id="testimonials">
            <div className="max-w-container mx-auto px-4 sm:px-6 lg:px-8">
                <h2 className="text-3xl md:text-5xl font-bold text-center text-text-main mb-4">
                    {t('testimonials.title', 'Müştərilərimiz nə deyir')}
                </h2>
            </div>

            <div className="w-full overflow-hidden py-5">
                <div 
                    className="testimonial-slider flex overflow-x-auto snap-x snap-mandatory gap-6 px-10 py-5 pb-10" 
                    id="testimonial-slider"
                    ref={scrollRef}
                    onScroll={handleScroll}
                >
                    {displayTestimonials.map((testimonial, index) => {
                        const imgUrl = getImageUrl(testimonial.image);
                        const name = testimonial.name || 'Client';
                        const position = testimonial.position || '';
                        const content = String(testimonial.content || '').replace(/<[^>]*>?/gm, '').substring(0, 160);

                        return (
                            <div key={testimonial.id || index} className="flex-shrink-0 w-[calc(100%-20px)] md:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] min-w-[320px] snap-center transition-all duration-300 hover:-translate-y-1.5 hover:shadow-lg bg-[var(--card-bg)] border border-[var(--card-border)] rounded-2xl p-8 relative">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor" className="absolute top-5 right-5 opacity-10">
                                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                </svg>
                                <div className="flex gap-0.5 mb-4 text-amber-400">
                                    {[...Array(5)].map((_, i) => (
                                        <svg key={i} width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                        </svg>
                                    ))}
                                </div>
                                <div className="text-text-sub leading-relaxed mb-6 italic">"{content}"</div>
                                <div className="flex items-center gap-3 pt-4 border-t border-[var(--card-border)]">
                                    {imgUrl ? (
                                        <div
                                            className="w-12 h-12 rounded-full flex-shrink-0"
                                            style={{
                                                backgroundImage: `url('${imgUrl}')`,
                                                backgroundSize: 'cover',
                                                backgroundPosition: 'center',
                                            }}
                                        />
                                    ) : (
                                        <div className="w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center bg-[var(--brand-gradient)]">
                                            <span className="text-lg font-bold text-white">
                                                {name.split(' ').map((n: string) => n[0]).join('').substring(0, 2) || 'CL'}
                                            </span>
                                        </div>
                                    )}
                                    <div className="min-w-0">
                                        <h5 className="font-semibold text-text-main text-sm">{name}</h5>
                                        <span className="text-xs text-text-sub block truncate">{position}</span>
                                    </div>
                                </div>
                            </div>
                        );
                    })}
                </div>

                <div className="flex justify-center gap-2 mt-2.5">
                    {displayTestimonials.map((_, index) => (
                        <button
                            key={index}
                            className={`w-2.5 h-2.5 rounded-full border-0 p-0 cursor-pointer transition-all duration-300 ${activeIndex === index ? 'bg-brand-primary scale-125' : 'bg-black/10 dark:bg-white/10'}`}
                            onClick={() => scrollTo(index)}
                            aria-label={`Go to slide ${index + 1}`}
                        />
                    ))}
                </div>
            </div>
            <style>{`
                .testimonial-slider {
                    scrollbar-width: none;
                    -ms-overflow-style: none;
                }
                .testimonial-slider::-webkit-scrollbar {
                    display: none;
                }
            `}</style>
        </section>
    );
}
