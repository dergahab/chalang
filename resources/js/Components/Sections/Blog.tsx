import React, { useEffect } from 'react';
import type { Translations } from '@/types';

interface BlogItem {
    id: number;
    title: string;
    slug: string;
    image?: string;
    created_at?: string;
    [key: string]: unknown;
}

interface BlogProps {
    blogs?: BlogItem[] | null;
    translations?: Translations;
    locale?: string;
    siteUrl?: string;
}

function formatBlogDate(raw?: string, locale: string = 'az'): string {
    if (!raw) return '';
    const d = new Date(raw);
    if (isNaN(d.getTime())) return raw;
    const localeMap: Record<string, string> = { az: 'az-AZ', en: 'en-US', ru: 'ru-RU' };
    const intlLocale = localeMap[locale] ?? 'en-US';
    try {
        return new Intl.DateTimeFormat(intlLocale, { day: 'numeric', month: 'short', year: 'numeric' }).format(d);
    } catch {
        return d.toISOString().slice(0, 10);
    }
}

function getImageUrl(blog: BlogItem): string {
    if (!blog.image) return '';
    if (blog.image.startsWith('http')) return blog.image;
    return `/storage/${blog.image}`;
}

export default function Blog({ blogs, translations, locale = 'az', siteUrl }: BlogProps) {
    // ── Null / undefined guard ──────────────────────────────────────
    const safeBlogs: BlogItem[] = Array.isArray(blogs) ? blogs : [];
    const items = safeBlogs.slice(0, 3);

    const blogTitle   = translations?.blog?.title     || 'Blog';
    const readMore    = translations?.blog?.read_more || 'Ətraflı oxu';

    // JSON-LD structured data
    useEffect(() => {
        if (items.length === 0) return;
        const scriptId = 'blog-itemlist-schema';
        const existing = document.getElementById(scriptId);
        if (existing) existing.remove();
        const url = siteUrl || (typeof window !== 'undefined' ? window.location.origin : 'https://chalang.az');
        const schema = {
            '@context': 'https://schema.org',
            '@type': 'ItemList',
            numberOfItems: items.length,
            itemListElement: items.map((blog, index) => ({
                '@type': 'ListItem',
                position: index + 1,
                item: {
                    '@type': 'BlogPosting',
                    headline: blog.title,
                    image: blog.image ? (blog.image.startsWith('http') ? blog.image : `${url}/storage/${blog.image}`) : undefined,
                    datePublished: blog.created_at,
                    url: `${url}/preview/blog/${blog.slug}`,
                },
            })),
        };
        const script = document.createElement('script');
        script.id = scriptId;
        script.type = 'application/ld+json';
        script.text = JSON.stringify(schema);
        document.head.appendChild(script);
        return () => { const el = document.getElementById(scriptId); if (el) el.remove(); };
    }, [items, siteUrl]);

    // ── Skeleton (no data) ──────────────────────────────────────────
    if (items.length === 0) {
        return (
            <section className="py-20 md:py-28 lg:py-36" id="blog" aria-labelledby="blog-heading">
                <h2 id="blog-heading" className="text-3xl md:text-5xl font-bold text-center text-text-main mb-4">{blogTitle}</h2>
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-container mx-auto px-4 sm:px-6 lg:px-8 mt-10">
                    {[0, 1, 2].map(i => (
                        <div key={i} className="bg-[var(--card-bg)] border border-[var(--card-border)] rounded-2xl p-5 animate-pulse">
                            <div className="h-[180px] rounded-2xl mb-4 bg-brand-primary/10" />
                            <div className="h-4 w-20 rounded-lg mb-2 bg-brand-primary/10" />
                            <div className="h-6 w-[90%] rounded-lg bg-brand-primary/10" />
                        </div>
                    ))}
                </div>
            </section>
        );
    }

    const featured   = items[0];
    const secondary  = items.slice(1);

    return (
        <section className="py-20 md:py-28 lg:py-36" id="blog" aria-labelledby="blog-heading">
            <div className="max-w-container mx-auto px-4 sm:px-6 lg:px-8">
                <h2 id="blog-heading" className="text-3xl md:text-5xl font-bold text-center text-text-main mb-4">
                    {blogTitle}
                </h2>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-10">
                    {/* ── Featured post (left) ── */}
                    {featured && (
                        <article
                            className="bg-[var(--card-bg)] border border-[var(--card-border)] rounded-3xl overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl flex flex-col h-full"
                            data-aos="fade-right"
                            itemScope
                            itemType="https://schema.org/Article"
                        >
                            <div className="relative h-64 md:h-80 lg:h-96 w-full overflow-hidden group">
                                {getImageUrl(featured) ? (
                                    <img
                                        src={getImageUrl(featured)}
                                        alt={featured.title}
                                        className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                        loading="lazy"
                                        itemProp="image"
                                    />
                                ) : (
                                    <div className="w-full h-full flex items-center justify-center bg-brand-gradient opacity-80">
                                        <span className="text-3xl text-white font-bold tracking-wider uppercase">{blogTitle}</span>
                                    </div>
                                )}
                                <div className="absolute top-4 left-4">
                                    <span className="px-3 py-1 bg-[var(--brand-primary)] text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-lg">
                                        Featured
                                    </span>
                                </div>
                            </div>
                            <div className="p-8 flex flex-col flex-grow justify-between">
                                <div>
                                    <div className="flex items-center gap-4 mb-3">
                                        <span
                                            className="text-sm text-text-sub uppercase tracking-wider font-semibold"
                                            itemProp="datePublished"
                                            content={featured.created_at}
                                        >
                                            {formatBlogDate(featured.created_at, locale)}
                                        </span>
                                    </div>
                                    <h3
                                        className="text-2xl md:text-3xl font-bold text-text-main mt-2 mb-4 hover:underline decoration-[var(--brand-primary)] decoration-2 underline-offset-4"
                                        itemProp="headline"
                                    >
                                        <a href={featured.slug ? `/preview/blog/${featured.slug}` : '#'}>{featured.title}</a>
                                    </h3>
                                </div>
                                <a
                                    href={featured.slug ? `/preview/blog/${featured.slug}` : '#'}
                                    className="inline-flex items-center gap-2 text-[var(--brand-primary)] font-bold hover:text-[var(--brand-secondary)] transition-colors uppercase text-sm tracking-wider mt-6"
                                    itemProp="url"
                                >
                                    {readMore}
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3" strokeLinecap="round">
                                        <path d="M5 12h14"/><path d="M12 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    )}

                    {/* ── Secondary posts (right column) ── */}
                    <div className="flex flex-col gap-8 h-full">
                        {secondary.map((blog, index) => (
                            <article
                                key={blog.id}
                                className="bg-[var(--card-bg)] border border-[var(--card-border)] rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1.5 hover:shadow-lg flex flex-col sm:flex-row flex-1"
                                data-aos="fade-up"
                                data-aos-delay={(index + 1) * 150}
                                itemScope
                                itemType="https://schema.org/Article"
                            >
                                <div className="sm:w-2/5 h-48 sm:h-auto relative overflow-hidden group flex-shrink-0">
                                    {getImageUrl(blog) ? (
                                        <img
                                            src={getImageUrl(blog)}
                                            alt={blog.title}
                                            className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                            loading="lazy"
                                            itemProp="image"
                                        />
                                    ) : (
                                        <div className="w-full h-full flex items-center justify-center bg-brand-gradient opacity-80">
                                            <span className="text-xl text-white font-bold tracking-wider uppercase">{blogTitle}</span>
                                        </div>
                                    )}
                                </div>
                                <div className="p-6 flex flex-col justify-center w-full">
                                    <span
                                        className="text-xs text-text-sub uppercase tracking-wider font-semibold"
                                        itemProp="datePublished"
                                        content={blog.created_at}
                                    >
                                        {formatBlogDate(blog.created_at, locale)}
                                    </span>
                                    <h3
                                        className="text-lg md:text-xl font-bold text-text-main mt-1 mb-3"
                                        itemProp="headline"
                                    >
                                        <a href={blog.slug ? `/preview/blog/${blog.slug}` : '#'}>{blog.title}</a>
                                    </h3>
                                    <a
                                        href={blog.slug ? `/preview/blog/${blog.slug}` : '#'}
                                        className="inline-flex items-center text-[var(--brand-primary)] font-semibold hover:text-[var(--brand-secondary)] transition-colors text-sm mt-auto"
                                        itemProp="url"
                                    >
                                        {readMore} &gt;
                                    </a>
                                </div>
                            </article>
                        ))}
                    </div>
                </div>

                <div className="mt-12 text-center" data-aos="fade-up">
                    <a
                        href="/preview/blogs"
                        className="inline-block px-8 py-3 rounded-full font-bold text-white bg-[var(--brand-primary)] hover:bg-[var(--brand-secondary)] transition-colors shadow-lg"
                    >
                        {translations?.blog?.read_all || 'Bütün məqalələr'}
                    </a>
                </div>
            </div>
        </section>
    );
}
