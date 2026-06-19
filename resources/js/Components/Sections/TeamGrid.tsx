import React from 'react';
import type { Translations } from '@/types';

interface TeamMember {
    id: number;
    name?: string;
    position?: string;
    image?: string | null;
    specialties?: string | string[];
}

interface TeamGridProps {
    members: TeamMember[];
    translations: Translations;
}

export default function TeamGrid({ members, translations }: TeamGridProps) {
    const t = (key: string, fallback?: string): string => {
        const keys = key.split('.');
        let value: any = translations;
        for (const k of keys) {
            value = value?.[k];
        }
        return typeof value === 'string' ? value : (fallback ?? key);
    };

    const parseSpecialties = (specs?: string | string[]): string[] => {
        if (!specs) return [];
        if (Array.isArray(specs)) return specs.slice(0, 3);
        
        return specs.split(',')
            .map(s => s.trim())
            .filter(s => s.length > 0)
            .slice(0, 3);
    };

    const displayMembers = members && members.length > 0 ? members.slice(0, 4) : [];

    // DB-dən data gəlmirsə section gizlənir — hardcode QADAĞANDIR
    if (displayMembers.length === 0) return null;

    return (
        <section className="py-20 md:py-28 lg:py-36 px-5">
            <h2 className="text-3xl md:text-5xl font-bold text-center text-text-main mb-4 reveal-text">
                <span>{t('sec_team_title', 'Digital Architects')}</span>
            </h2>
            <p className="text-lg text-center text-text-sub mb-12 max-w-2xl mx-auto">
                {t('sec_team_sub', 'The brilliant minds powering your next breakthrough.')}
            </p>
            
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-container mx-auto px-4 sm:px-6 lg:px-8 mt-10">
                {displayMembers.length > 0 ? (
                    displayMembers.map((member, index) => {
                        const memberImage = member.image ? (member.image.startsWith('http') ? member.image : (member.image.startsWith('/') ? member.image : `/storage/${member.image}`)) : null;
                        const memberName = member.name || t('team.fallback.member', 'Team Member');
                        const memberPosition = member.position || '';
                        const specialties = parseSpecialties(member.specialties);

                        return (
                            <div key={member.id || index} className="bg-white dark:bg-[var(--card-bg)] border border-black/5 dark:border-[var(--card-border)] rounded-2xl p-6 text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-lg dark:hover:shadow-[0_15px_35px_rgba(var(--brand-secondary-rgb,213,0,249),0.15)] hover:border-brand-secondary/30 group relative overflow-hidden shadow-sm dark:shadow-none">
                                <div className="w-[120px] h-[120px] mx-auto mb-5 rounded-full overflow-hidden relative p-[4px] bg-[var(--brand-gradient)]">
                                    {memberImage ? (
                                        <>
                                            <img src={memberImage} alt={memberName} className="w-full h-full object-cover rounded-full border-4 border-white dark:border-[var(--card-bg)] transition-transform duration-500 group-hover:scale-110" loading="lazy" />
                                            <img src={memberImage} alt={memberName} className="w-full h-full object-cover rounded-full border-4 border-white dark:border-[var(--card-bg)] absolute inset-0 opacity-0 saturate-150 hue-rotate-[15deg] group-hover:opacity-50 transition-all duration-500" loading="lazy" />
                                        </>
                                    ) : (
                                        <div className="bg-[var(--brand-gradient)] flex items-center justify-center w-full h-full rounded-[inherit]">
                                            <span className="text-lg font-bold text-white uppercase">
                                                {memberName.split(' ').map((n: string) => n[0]).join('').substring(0, 2) || 'TM'}
                                            </span>
                                        </div>
                                    )}
                                </div>
                                <div>
                                    <h3 className="text-xl font-bold mb-1 text-[#1e293b] dark:text-text-main">{memberName}</h3>
                                    <span className="text-sm text-brand-secondary font-semibold uppercase tracking-wider block mb-4">{memberPosition}</span>
                                    {specialties.length > 0 && (
                                        <div className="flex flex-wrap justify-center gap-2">
                                            {specialties.map((spec, i) => (
                                                <span key={i} className="text-xs px-2.5 py-1 bg-[#f1f5f9] dark:bg-white/5 border border-[#e2e8f0] dark:border-white/10 rounded-full text-[#475569] dark:text-text-sub transition-all duration-300 group-hover:bg-brand-secondary/10 group-hover:border-brand-secondary/20 group-hover:text-text-main">{spec}</span>
                                            ))}
                                        </div>
                                    )}
                                </div>
                            </div>
                        );
                    })
                ) : null}
            </div>

        </section>
    );
}
