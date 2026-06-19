import React from 'react';
import { motion } from 'framer-motion';

interface Milestone {
    year: string;
    title: string;
    description: string;
}

interface TimelineSectionProps {
    milestones?: Milestone[];
    title?: string;
    subtitle?: string;
}

const DEFAULT_MILESTONES: Milestone[] = [
    { year: '2014', title: 'Təsis', description: 'Chalang-ın əsası qoyuldu. Kiçik bir komanda ilə rəqəmsal dizayn sahəsində ilk addımlar.' },
    { year: '2018', title: 'Beynəlxalq Genişlənmə', description: 'Beynəlxalq bazarlara açılış, ilk xarici müştərilər və böyük miqyaslı layihələr.' },
    { year: '2021', title: 'AI İnteqrasiyası', description: 'Süni intellekt alətlərinin iş axınına inteqrasiyası, Chalang AI-nin əsasının qoyulması.' },
    { year: '2024', title: 'Yeni Era', description: 'Tam miqyaslı AI agentliyə çevrilmə, 50+ komanda üzvü, 200+ uğurlu layihə.' },
];

const TimelineSection: React.FC<TimelineSectionProps> = ({
    milestones = DEFAULT_MILESTONES,
    title = 'Bizim Yolumuz',
    subtitle = '10 illik inkişaf hekayəmiz',
}) => {
    return (
        <section className="py-20 relative overflow-hidden" aria-labelledby="timeline-heading">
            <div className="max-w-7xl mx-auto px-6">
                <div className="text-center mb-16">
                    <span className="text-brand-primary font-semibold tracking-wider uppercase text-sm mb-2 block">
                        {subtitle}
                    </span>
                    <h2 id="timeline-heading" className="text-3xl md:text-5xl font-bold font-display text-text-main">
                        {title}
                    </h2>
                </div>

                <div className="relative">
                    <div className="absolute left-1/2 top-0 bottom-0 w-px bg-gradient-to-b from-brand-primary/40 via-brand-secondary/40 to-transparent hidden md:block" />

                    <div className="space-y-12 md:space-y-16">
                        {milestones.map((milestone, index) => {
                            const isLeft = index % 2 === 0;
                            return (
                                <motion.div
                                    key={milestone.year}
                                    initial={{ opacity: 0, x: isLeft ? -40 : 40 }}
                                    whileInView={{ opacity: 1, x: 0 }}
                                    viewport={{ once: true, margin: '-100px' }}
                                    transition={{ duration: 0.6, ease: 'easeOut' }}
                                    className={`relative flex flex-col md:flex-row items-center gap-6 md:gap-0 ${
                                        isLeft ? 'md:flex-row' : 'md:flex-row-reverse'
                                    }`}
                                >
                                    <div className={`w-full md:w-1/2 ${isLeft ? 'md:text-right md:pr-12' : 'md:text-left md:pl-12'}`}>
                                        <div className="inline-block p-6 md:p-8 bg-white/60 dark:bg-[#111827]/60 backdrop-blur-xl border border-white/40 dark:border-white/5 rounded-2xl shadow-lg hover:shadow-brand-primary/10 transition-all duration-300 max-w-lg">
                                            <span className="text-3xl md:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-brand-primary to-brand-secondary">
                                                {milestone.year}
                                            </span>
                                            <h3 className="text-xl font-bold text-text-main mt-2 mb-2">
                                                {milestone.title}
                                            </h3>
                                            <p className="text-text-sub text-sm leading-relaxed">
                                                {milestone.description}
                                            </p>
                                        </div>
                                    </div>

                                    <div className="hidden md:flex absolute left-1/2 -translate-x-1/2 w-4 h-4 rounded-full bg-brand-primary border-4 border-white dark:border-[#0b0f19] z-10" />

                                    <div className="w-full md:w-1/2" />
                                </motion.div>
                            );
                        })}
                    </div>
                </div>
            </div>
        </section>
    );
};

export default TimelineSection;
