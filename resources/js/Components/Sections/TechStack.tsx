import React from 'react';

interface TechItem {
    icon: string;
    label: string;
}

interface TechStackProps {
    items: any[];
}

export default function TechStack({ items }: TechStackProps) {
    const normalizeTech = (item: any): TechItem => {
        if (typeof item === 'object' && item !== null) {
            const icon = item.icon || item.emoji || '';
            const label = item.label || item.name || '';
            return { icon: String(icon).trim(), label: String(label).trim() };
        }
        return { icon: '', label: String(item).trim() };
    };

    const techItems = items.map(normalizeTech).filter(t => t.label !== '');

    const isUrl = (str: string) => {
        return str.startsWith('http://') || str.startsWith('https://') || str.startsWith('/');
    };

    if (techItems.length === 0) {
        return null;
    }

    // Duplicate array multiple times for smooth infinite scroll
    const displayItems = [...techItems, ...techItems, ...techItems];

    return (
        <section className="tech-stack-section">
            <div className="tech-marquee">
                <div className="tech-track">
                    {displayItems.map((tech, index) => {
                        const iconIsUrl = isUrl(tech.icon);
                        
                        return (
                            <div key={index} className="tech-item">
                                <span className="tech-icon">
                                    {tech.icon ? (
                                        iconIsUrl ? (
                                            <img src={tech.icon} alt={tech.label} loading="lazy" />
                                        ) : (
                                            <>{tech.icon}</>
                                        )
                                    ) : (
                                        <>*</>
                                    )}
                                </span>
                                {tech.label}
                            </div>
                        );
                    })}
                </div>
            </div>
        </section>
    );
}
