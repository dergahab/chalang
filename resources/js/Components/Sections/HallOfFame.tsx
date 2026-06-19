import React from 'react';
import type { Translations } from '@/types';

interface FameItem {
    label: string;
    url: string;
}

interface HallOfFameProps {
    items: any[];
    translations: Translations;
    caseStudies?: any[];
}

export default function HallOfFame({ items, translations, caseStudies = [] }: HallOfFameProps) {
    const t = (key: string, fallback?: string): string => {
        const keys = key.split('.');
        let value: any = translations;
        for (const k of keys) {
            value = value?.[k];
        }
        return typeof value === 'string' ? value : (fallback ?? key);
    };

    const isUrl = (str: string) => {
        return str.startsWith('http://') || str.startsWith('https://') || str.startsWith('/');
    };

    const normalizeFame = (item: any): FameItem | null => {
        let label = '';
        let url = '';

        if (typeof item === 'object' && item !== null) {
            label = String(item.label || item.name || '').trim();
            url = String(item.url || item.logo || item.icon || '').trim();
        } else if (typeof item === 'string') {
            const raw = item.trim();
            if (raw !== '') {
                const parts = raw.split(/\s*\|\s*/);
                if (parts.length === 2) {
                    const first = parts[0].trim();
                    const second = parts[1].trim();
                    if (isUrl(first)) {
                        url = first;
                        label = second;
                    } else if (isUrl(second)) {
                        url = second;
                        label = first;
                    } else {
                        label = raw;
                    }
                } else {
                    if (isUrl(raw)) {
                        url = raw;
                    } else {
                        label = raw;
                    }
                }
            }
        }

        if (label !== '' || url !== '') {
            return { label, url };
        }
        return null;
    };

    let fameList = (items || [])
        .map(normalizeFame)
        .filter((item): item is FameItem => item !== null);

    const hasFameList = fameList.length > 0;
    const hasCaseStudies = caseStudies && caseStudies.length > 0;

    return (
        <section className="hall-of-fame-section" aria-labelledby="fame-heading">
            <h2 id="fame-heading" className="section-title">
                {t('fame.title', 'Hall of Fame')}
            </h2>
            <p className="section-subtitle">
                {t('fame.subtitle', 'Birlikdə böyük nailiyyətlər qazandığımız tərəfdaşlar')}
            </p>
            
            <div className="fame-grid">
                {hasFameList ? (
                    fameList.map((fame, index) => (
                        <div key={index} className="fame-item">
                            {fame.url !== '' ? (
                                <>
                                    <img 
                                        src={fame.url} 
                                        alt={fame.label || 'Logo'} 
                                        loading="lazy" 
                                        className="fame-logo"
                                        onError={(e) => (e.currentTarget.style.display = 'none')}
                                    />
                                    {fame.label !== '' && (
                                        <span className="fame-label">{fame.label}</span>
                                    )}
                                </>
                            ) : (
                                <>
                                    <svg className="fame-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style={{ opacity: 0.5 }}>
                                        <path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2zM5 8V7h2v3.82C5.84 10.4 5 9.3 5 8zm14 0c0 1.3-.84 2.4-2 2.82V7h2v1z" />
                                    </svg>
                                    <span className="fame-label">{fame.label}</span>
                                </>
                            )}
                        </div>
                    ))
                ) : hasCaseStudies ? (
                    caseStudies.slice(0, 6).map((caseStudy, index) => (
                        <div key={index} className="fame-item">
                            <svg className="fame-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style={{ opacity: 0.5 }}>
                                <path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2zM5 8V7h2v3.82C5.84 10.4 5 9.3 5 8zm14 0c0 1.3-.84 2.4-2 2.82V7h2v1z" />
                            </svg>
                            <span className="fame-label">{caseStudy.title}</span>
                        </div>
                    ))
                ) : (
                    // Fallback items matching Blade logic
                    [1, 2, 3, 4].map(num => (
                        <div key={num} className="fame-item">
                            <svg className="fame-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style={{ opacity: 0.5 }}>
                                <path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2zM5 8V7h2v3.82C5.84 10.4 5 9.3 5 8zm14 0c0 1.3-.84 2.4-2 2.82V7h2v1z" />
                            </svg>
                            <span className="fame-label">{t(`fame.item_${num}`, `Item #${num}`)}</span>
                        </div>
                    ))
                )}
            </div>
            <style>{`
                .fame-icon {
                    color: var(--brand-primary);
                    flex-shrink: 0;
                }
            `}</style>
        </section>
    );
}
