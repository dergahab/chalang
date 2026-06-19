// Base SEO config interface
export interface SEOConfig {
    title?: string;
    description?: string;
    keywords?: string[];
    image?: string;
    url?: string;
    type?: 'website' | 'article' | 'product' | 'profile';
    author?: string;
    publishedTime?: string;
    modifiedTime?: string;
    section?: string;
    tag?: string[];
    price?: {
        currency: string;
        amount: number;
    };
    locale?: string;
    localeAlternate?: string[];
}

export interface SEOHeadProps {
    title?: string;
    defaultTitle?: string;
    meta?: Array<Record<string, string | undefined>>;
}

// Open Graph metadata
export interface OpenGraph extends SEOConfig {
    ogTitle?: string;
    ogDescription?: string;
    ogImage?: string;
    ogUrl?: string;
    ogType?: string;
    ogLocale?: string;
    ogSiteName?: string;
    articlePublishedTime?: string;
    articleModifiedTime?: string;
    articleAuthor?: string[];
    articleSection?: string;
    articleTag?: string[];
}

// Twitter Card metadata
export interface TwitterCard extends SEOConfig {
    twitterCard?: 'summary' | 'summary_large_image' | 'app' | 'player';
    twitterSite?: string;
    twitterCreator?: string;
    twitterImage?: string;
}

// Generate complete SEO props
export function generateSEOProps(config: SEOConfig): SEOHeadProps {
    const {
        title,
        description,
        image,
        url,
        type = 'website',
        locale = 'az_AZ',
    } = config;

    const siteName = 'Chalang';

    return {
        title,
        defaultTitle: siteName,
        meta: [
            { name: 'description', content: description || '' },
            { name: 'keywords', content: config.keywords?.join(', ') || '' },
            // Open Graph
            { property: 'og:title', content: title },
            { property: 'og:description', content: description },
            { property: 'og:image', content: image },
            { property: 'og:url', content: url },
            { property: 'og:type', content: type },
            { property: 'og:locale', content: locale },
            { property: 'og:site_name', content: siteName },
            // Twitter Card
            { name: 'twitter:card', content: 'summary_large_image' },
            { name: 'twitter:title', content: title },
            { name: 'twitter:description', content: description },
            { name: 'twitter:image', content: image },
        ],
    };
}

// Generate JSON-LD for structured data
export interface SchemaOrgItem {
    '@context': 'https://schema.org';
    '@type': string;
    [key: string]: unknown;
}

export function generateOrganizationSchema(name: string, url: string, logo?: string, contactPoint?: string): SchemaOrgItem {
    return {
        '@context': 'https://schema.org',
        '@type': 'Organization',
        name,
        url,
        logo,
        contactPoint: contactPoint ? {
            '@type': 'ContactPoint',
            telephone: contactPoint,
            contactType: 'customer service',
        } : undefined,
    } as SchemaOrgItem;
}

export function generateLocalBusinessSchema(
    name: string,
    address: {
        streetAddress: string;
        addressLocality: string;
        addressRegion: string;
        postalCode: string;
        addressCountry: string;
    },
    geo?: {
        latitude: number;
        longitude: number;
    },
    openingHours?: string[],
    priceRange?: string
): SchemaOrgItem {
    return {
        '@context': 'https://schema.org',
        '@type': 'LocalBusiness',
        name,
        address: {
            '@type': 'PostalAddress',
            ...address,
        },
        geo: geo ? {
            '@type': 'GeoCoordinates',
            latitude: geo.latitude,
            longitude: geo.longitude,
        } : undefined,
        openingHoursSpecification: openingHours?.map(hours => ({
            '@type': 'OpeningHoursSpecification',
            dayOfWeek: hours,
        })),
        priceRange,
    } as SchemaOrgItem;
}

export function generateProductSchema(
    name: string,
    description: string,
    brand: string,
    sku: string,
    price?: {
        currency: string;
        amount: number;
    },
    image?: string[],
    review?: {
        ratingValue: number;
        reviewCount: number;
    }
): SchemaOrgItem {
    return {
        '@context': 'https://schema.org',
        '@type': 'Product',
        name,
        description,
        brand: {
            '@type': 'Brand',
            name: brand,
        },
        sku,
        offers: price ? {
            '@type': 'Offer',
            price: price.amount,
            priceCurrency: price.currency,
        } : undefined,
        image: image?.[0],
        aggregateRating: review ? {
            '@type': 'AggregateRating',
            ratingValue: review.ratingValue,
            reviewCount: review.reviewCount,
        } : undefined,
    } as SchemaOrgItem;
}

export function generateFAQSchema(
    questions: Array<{ question: string; answer: string }>
): SchemaOrgItem {
    return {
        '@context': 'https://schema.org',
        '@type': 'FAQPage',
        mainEntity: questions.map(q => ({
            '@type': 'Question',
            name: q.question,
            acceptedAnswer: {
                '@type': 'Answer',
                text: q.answer,
            },
        })),
    } as SchemaOrgItem;
}

// Generate breadcrumb structured data
export interface BreadcrumbItem {
    name: string;
    url: string;
}

export function generateBreadcrumbSchema(items: BreadcrumbItem[]): SchemaOrgItem {
    return {
        '@context': 'https://schema.org',
        '@type': 'BreadcrumbList',
        itemListElement: items.map((item, index) => ({
            '@type': 'ListItem',
            position: index + 1,
            name: item.name,
            item: item.url,
        })),
    } as SchemaOrgItem;
}

export default {
    generateSEOProps,
    generateOrganizationSchema,
    generateLocalBusinessSchema,
    generateProductSchema,
    generateFAQSchema,
    generateBreadcrumbSchema,
};
