import { useState } from 'react';
import type { Translations } from '@/types';

/**
 * FAQ — Accordion section.
 * 1:1 match with Blade .faq-section (chalang-preview.css)
 *
 * Legacy CSS classes used:
 *   .faq-section, .section-title, .reveal-text,
 *   .faq-item, .faq-question, .faq-icon, .faq-answer
 */

interface FaqItem {
    id: number;
    question: string;
    answer: string;
}

interface FaqProps {
    items: FaqItem[];
    title?: string;
    translations?: Translations;
}

const ChevronIcon = () => (
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
        <polyline points="6 9 12 15 18 9" />
    </svg>
);

export default function Faq({ items, title, translations }: FaqProps) {
    const [openIndex, setOpenIndex] = useState<number | null>(null);

    const faqTitle = title || translations?.faq?.title || 'FAQ';
    // Filter out items with null/empty question (DB-dəki corrupt entries)
    const validItems = items.filter(faq => faq.question && faq.question.trim() !== '');

    if (validItems.length === 0) return null;

    const faqItems = validItems;

    const stripHtml = (text: string) => {
        if (typeof document !== 'undefined') {
            const div = document.createElement('div');
            div.innerHTML = text;
            return div.textContent || div.innerText || '';
        }
        return text.replace(/<[^>]*>/g, '');
    };

    const toggle = (index: number) => {
        setOpenIndex(openIndex === index ? null : index);
    };

    return (
        <section className="py-20 md:py-28 lg:py-36 max-w-container mx-auto px-4 sm:px-6 lg:px-8" id="faq">
            <h2 className="text-3xl md:text-5xl font-bold text-center text-text-main mb-12">
                <span>{faqTitle}</span>
            </h2>

            <div className="max-w-3xl mx-auto space-y-4">
                {faqItems.map((faq, index) => {
                    const isOpen = openIndex === index;
                    const question = stripHtml(faq.question);
                    const answer = stripHtml(faq.answer).substring(0, 300);

                    return (
                        <div
                            key={faq.id || index}
                            className={`bg-[var(--card-bg)] border border-[var(--card-border)] rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-lg ${isOpen ? 'border-brand-primary shadow-md' : ''}`}
                            data-aos="fade-up"
                            data-aos-delay={`${50 * (index + 1)}`}
                        >
                            <div
                                className="flex items-center justify-between w-full p-4 md:p-6 text-left font-semibold text-text-main cursor-pointer select-none"
                                onClick={() => toggle(index)}
                                role="button"
                                tabIndex={0}
                                aria-expanded={isOpen}
                                onKeyDown={(e) => {
                                    if (e.key === 'Enter' || e.key === ' ') {
                                        e.preventDefault();
                                        toggle(index);
                                    }
                                }}
                            >
                                {question}
                                <span className={`inline-flex items-center justify-center transition-transform duration-300 ${isOpen ? 'rotate-180' : ''}`}>
                                    <ChevronIcon />
                                </span>
                            </div>
                            <div
                                className="px-4 md:px-6 text-text-sub"
                                style={{
                                    maxHeight: isOpen ? '300px' : '0',
                                    overflow: 'hidden',
                                    transition: 'max-height 0.3s ease, opacity 0.3s ease',
                                    opacity: isOpen ? 1 : 0,
                                }}
                            >
                                {answer}
                            </div>
                        </div>
                    );
                })}
            </div>
        </section>
    );
}
