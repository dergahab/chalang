import React, { useState, useEffect, useMemo } from 'react';
import { Link } from '@inertiajs/react';
import Tilt from 'react-parallax-tilt';
import type { Translations } from '@/types';

interface PortfolioCategory {
    id: number;
    name: string;
}

interface PortfolioItem {
    id: number;
    title: string;
    slug: string;
    image?: string;
    gif?: string; // Animated GIF on hover (requires DB field)
    short_description?: string;
    description?: string;
    pcategories?: PortfolioCategory[];
}

interface PortfolioProps {
    items: PortfolioItem[];
    translations: Translations;
}

export default function Portfolio({ items, translations }: PortfolioProps) {
    const [selectedItem, setSelectedItem] = useState<PortfolioItem | null>(null);
    const [activeFilter, setActiveFilter] = useState<string>('all');

    const t = (key: string, fallback?: string): string => {
        const keys = key.split('.');
        let value: any = translations;
        for (const k of keys) {
            value = value?.[k];
        }
        return typeof value === 'string' ? value : (fallback ?? key);
    };

    const getImageUrl = (imagePath?: string | null) => {
        if (!imagePath) return '';
        if (imagePath.startsWith('http') || imagePath.startsWith('/')) return imagePath;
        return `/storage/${imagePath}`;
    };

    const [hoveredItem, setHoveredItem] = useState<number | null>(null);

    const openModal = (item: PortfolioItem) => setSelectedItem(item);
    const closeModal = () => setSelectedItem(null);

    // Prevent body scroll when modal is open
    useEffect(() => {
        if (selectedItem) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
        return () => {
            document.body.style.overflow = '';
        };
    }, [selectedItem]);

    // Extract unique categories from items
    const categories = useMemo(() => {
        const allCats = new Map<string, number>();
        items?.forEach((item) => {
            item.pcategories?.forEach((cat) => {
                if (cat.id && cat.name) {
                    allCats.set(cat.name, cat.id);
                }
            });
        });
        return Array.from(allCats.entries()).map(([name, id]) => ({ id, name }));
    }, [items]);

    // Filter items by active category
    const filteredItems = useMemo(() => {
        if (!items || activeFilter === 'all') return items;
        return items.filter((item) =>
            item.pcategories?.some((cat) => cat.name === activeFilter)
        );
    }, [items, activeFilter]);

    const displayItems = filteredItems && filteredItems.length > 0 ? filteredItems.slice(0, 6) : [];

    const getDesc = (item: PortfolioItem) => {
        const src = item.short_description || item.description || item.title || '';
        const stripped = src.replace(/<[^>]*>/g, '');
        return stripped.length > 120 ? stripped.substring(0, 120) + '...' : stripped;
    };

    const getCategorySlug = (name: string) => name.toLowerCase().replace(/[^a-z0-9]+/g, '-');
    
    // Skeleton loading state
    if (!items || items.length === 0) {
        return (
            <section className="py-20 md:py-28 lg:py-36" id="portfolio">
                <h2 className="text-3xl md:text-5xl font-bold text-center text-text-main mb-4">{t('portfolio.title', 'Seçilmiş İşlər')}</h2>
                <p className="text-lg text-center text-text-sub mb-12 max-w-2xl mx-auto">
                    {t('portfolio.subtitle', 'Son tamamlanmış rəqəmsal layihələrimizə baxın.')}
                </p>
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-container mx-auto px-4 sm:px-6 lg:px-8 mt-10">
                    {[0, 1, 2, 3, 4, 5].map((i) => (
                        <div 
                            key={i} 
                            className="bg-[var(--card-bg)] border border-[var(--card-border)] rounded-[var(--radius-card,24px)] min-h-[380px] animate-pulse"
                        />
                    ))}
                </div>
            </section>
        );
    }


    return (
        <section className="py-20 md:py-28 lg:py-36" id="portfolio" aria-labelledby="portfolio-heading">
            <h2 id="portfolio-heading" className="text-3xl md:text-5xl font-bold text-center text-text-main mb-4">{t('portfolio.title', 'Seçilmiş İşlər')}</h2>
            <p className="text-lg text-center text-text-sub mb-12 max-w-2xl mx-auto">
                {t('portfolio.subtitle', 'Son tamamlanmış rəqəmsal layihələrimizə baxın.')}
            </p>

            {/* Category Filters */}
            {categories.length > 0 && (
                <div className="flex flex-wrap justify-center gap-3 mt-8 mb-6">
                    <button
                        className={`px-6 py-2.5 border-2 border-[var(--card-border)] bg-transparent text-text-sub text-sm font-semibold rounded-full cursor-pointer transition-all duration-300 hover:border-brand-primary hover:text-brand-primary ${activeFilter === 'all' ? 'bg-brand-gradient border-transparent text-white' : ''}`}
                        onClick={() => setActiveFilter('all')}
                    >
                        {t('filter_all', 'Hamısı')}
                    </button>
                    {categories.map((cat) => (
                        <button
                            key={cat.id}
                            className={`px-6 py-2.5 border-2 border-[var(--card-border)] bg-transparent text-text-sub text-sm font-semibold rounded-full cursor-pointer transition-all duration-300 hover:border-brand-primary hover:text-brand-primary ${activeFilter === cat.name ? 'bg-brand-gradient border-transparent text-white' : ''}`}
                            onClick={() => setActiveFilter(cat.name)}
                        >
                            {cat.name}
                        </button>
                    ))}
                </div>
            )}

            {displayItems.length > 0 ? (
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-container mx-auto px-4 sm:px-6 lg:px-8">
                    {displayItems.map((item, index) => {
                        const imgUrl = getImageUrl(item.image);
                        const portfolioTags = item.pcategories && item.pcategories.length > 0 
                            ? item.pcategories.slice(0, 2) 
                            : [];
                        const portfolioSlug = item.slug || null;
                        const desc = getDesc(item);

                        return (
                            <Tilt
                                key={item.id}
                                tiltMaxAngleX={5}
                                tiltMaxAngleY={5}
                                perspective={2000}
                                transitionSpeed={1500}
                                scale={1}
                                className="h-full"
                            >
                                <article 
                                    className="h-full flex flex-col bg-[var(--card-bg)] rounded-[var(--radius-card,24px)] overflow-hidden border border-[var(--card-border)] transition-all duration-300 hover:-translate-y-2 hover:shadow-xl relative cursor-pointer group"
                                    onClick={() => openModal(item)}
                                    onMouseEnter={() => setHoveredItem(item.id)}
                                    onMouseLeave={() => setHoveredItem(null)}
                                >
                                    <div className="overflow-hidden relative">
                                        {/* GIF on hover (if available), otherwise static image */}
                                        {item.gif && hoveredItem === item.id ? (
                                            <img 
                                                src={getImageUrl(item.gif)} 
                                                alt={item.title} 
                                                className="w-full h-[250px] object-cover rounded-t-[var(--radius-card,24px)] transition-transform duration-500 group-hover:scale-105"
                                                loading="lazy"
                                            />
                                        ) : (
                                            imgUrl && (
                                                <img src={imgUrl} alt={item.title} className="w-full h-[250px] object-cover rounded-t-[var(--radius-card,24px)] transition-transform duration-500 group-hover:scale-105" loading="lazy" />
                                            )
                                        )}
                                    </div>
                                    <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-60 transition-opacity duration-300"></div>
                                    <div className="p-6 z-[2] relative flex flex-col flex-grow">
                                        <div className="flex gap-2 mb-3 flex-wrap">
                                            {portfolioTags.length > 0 ? (
                                                portfolioTags.map(tag => (
                                                    <span key={tag.id} className="text-xs px-3 py-1.5 bg-brand-primary/15 border border-brand-primary/30 rounded-full text-brand-secondary uppercase tracking-wider font-semibold">{tag.name}</span>
                                                ))
                                            ) : (
                                                <span className="text-xs px-3 py-1.5 bg-brand-primary/15 border border-brand-primary/30 rounded-full text-brand-secondary uppercase tracking-wider font-semibold">{t('portfolio.tag', 'Layihə')}</span>
                                            )}
                                        </div>
                                        <h3 className="text-xl font-extrabold mb-3 leading-tight text-text-main">{item.title}</h3>
                                        <p className="text-sm leading-relaxed opacity-80 mb-5 flex-grow text-text-sub">{desc}</p>
                                        {portfolioSlug ? (
                                            <Link
                                                href={`/preview/portfolio-detail/${portfolioSlug}`}
                                                className="inline-flex items-center gap-2 font-bold uppercase text-sm tracking-wider text-brand-secondary transition-all duration-300 hover:gap-3"
                                                onClick={(e) => e.stopPropagation()}
                                            >
                                                {t('portfolio.view', 'Ətraflı')}{' '}
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                                                </svg>
                                            </Link>
                                        ) : (
                                            <a
                                                href="#"
                                                className="inline-flex items-center gap-2 font-bold uppercase text-sm tracking-wider text-brand-secondary transition-all duration-300 hover:gap-3"
                                                onClick={(e) => e.stopPropagation()}
                                            >
                                                {t('portfolio.view', 'Ətraflı')}{' '}
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                                                </svg>
                                            </a>
                                        )}
                                    </div>
                                </article>
                            </Tilt>
                        );
                    })}
                </div>
            ) : (
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-container mx-auto px-4 sm:px-6 lg:px-8">
                    {[0, 1, 2].map(i => (
                        <article 
                            key={i} 
                            className="h-full flex flex-col bg-[var(--card-bg)] rounded-[var(--radius-card,24px)] overflow-hidden border border-[var(--card-border)] transition-all duration-300 hover:-translate-y-2 hover:shadow-xl relative cursor-pointer group" 
                            style={{ 
                                background: 'linear-gradient(135deg, rgba(var(--brand-primary-rgb), 0.2), rgba(var(--brand-secondary-rgb), 0.15))',
                                minHeight: '200px'
                            }}
                        >
                            <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-60 transition-opacity duration-300"></div>
                            <div className="p-6 z-[2] relative flex flex-col flex-grow absolute">
                                <div className="flex gap-2 mb-3 flex-wrap">
                                    <span className="text-xs px-3 py-1.5 bg-brand-primary/15 border border-brand-primary/30 rounded-full text-brand-secondary uppercase tracking-wider font-semibold">{t('portfolio.placeholder_tag', 'Nümunə')}</span>
                                </div>
                                <h3 className="text-xl font-extrabold mb-3 leading-tight text-text-main">{t('portfolio.placeholder_title', 'Yeni Layihə')}</h3>
                                <p className="text-sm leading-relaxed opacity-80 mb-5 flex-grow text-text-sub">{t('portfolio.placeholder_desc', 'Tezliklə buraya əlavə olunacaq.')}</p>
                            </div>
                        </article>
                    ))}
                </div>
            )}

            <div className="text-center mt-10">
                <Link href="/preview/portfolio" className="inline-flex items-center gap-2 px-8 py-3 rounded-full font-bold text-white bg-brand-gradient hover:-translate-y-1 transition-all duration-300 shadow-lg magnet-btn">
                    {t('portfolio.btn_view_all', 'Bütün işlərə bax')}{' '}
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                    </svg>
                </Link>
            </div>

            {/* Modal — Blade parity: project-modal-overlay */}
            {selectedItem && (
                <div 
                    className="fixed inset-0 bg-black/90 z-[9999] flex items-center justify-center p-5 backdrop-blur-md" 
                    onClick={closeModal}
                >
                    <div className="bg-[var(--card-bg)] rounded-3xl max-w-[900px] w-full max-h-[90vh] overflow-y-auto relative" onClick={(e) => e.stopPropagation()}>
                        <div className="absolute top-5 right-5 w-10 h-10 rounded-full bg-white/10 text-white flex items-center justify-center cursor-pointer z-10 text-lg transition-all duration-300 hover:bg-brand-primary" onClick={closeModal}>✕</div>
                        {selectedItem.image && (
                            <div>
                                {/* Show GIF in modal if available */}
                                {selectedItem.gif ? (
                                    <img 
                                        src={getImageUrl(selectedItem.gif)} 
                                        className="w-full h-[400px] object-cover rounded-t-3xl" 
                                        alt={selectedItem.title}
                                        loading="lazy"
                                    />
                                ) : (
                                    <img 
                                        src={getImageUrl(selectedItem.image)} 
                                        className="w-full h-[400px] object-cover rounded-t-3xl" 
                                        alt={selectedItem.title}
                                        loading="lazy"
                                    />
                                )}
                            </div>
                        )}
                        <div className="p-8">
                            <div className="flex gap-2 mb-3 flex-wrap">
                                {(selectedItem.pcategories || []).map(tag => (
                                    <span key={tag.id} className="text-xs px-3 py-1.5 bg-brand-primary/15 border border-brand-primary/30 rounded-full text-brand-secondary uppercase tracking-wider font-semibold">{tag.name}</span>
                                ))}
                            </div>
                            <h2 className="text-3xl font-extrabold mb-4 text-text-main">{selectedItem.title}</h2>
                            <p className="text-lg leading-relaxed opacity-90 text-text-sub">
                                {selectedItem.description || selectedItem.short_description || ''}
                            </p>
                            {selectedItem.slug ? (
                                <Link
                                    href={`/preview/portfolio-detail/${selectedItem.slug}`}
                                    className="inline-flex items-center gap-2 px-8 py-3 rounded-full font-bold text-white bg-brand-gradient hover:-translate-y-1 transition-all duration-300 shadow-lg mt-5"
                                >
                                    {t('modal.view_project', 'Layihəni gör')}{' '}
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                                    </svg>
                                </Link>
                            ) : (
                                <a
                                    href="#"
                                    className="inline-flex items-center gap-2 px-8 py-3 rounded-full font-bold text-white bg-brand-gradient hover:-translate-y-1 transition-all duration-300 shadow-lg mt-5"
                                >
                                    {t('modal.view_project', 'Layihəni gör')}{' '}
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                                    </svg>
                                </a>
                            )}
                        </div>
                    </div>
                </div>
            )}
            <style>{`
                @keyframes fadeInUp {
                    from { 
                        opacity: 0; 
                        transform: translateY(20px); 
                    }
                    to { 
                        opacity: 1; 
                        transform: translateY(0); 
                    }
                }
            `}</style>
        </section>
    );
}
