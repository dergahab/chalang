/**
 * SchemaData — SEO Structured Data (JSON-LD)
 * 
 * Renders Organization, WebSite, FAQPage schemas for SEO
 * Uses data from props to generate dynamic structured data
 */

import React from 'react';

interface SchemaDataProps {
    locale?: string;
    siteName?: string;
    siteUrl?: string;
    logo?: string;
    description?: string;
    email?: string;
    telephone?: string;
    address?: {
        street: string;
        city: string;
        country: string;
    };
    socialLinks?: Record<string, string>;
    services?: Array<{ name: string; description: string }>;
    faqs?: Array<{ question: string; answer: string }>;
}

export default function SchemaData({
    locale = 'az',
    siteName = 'Chalang',
    siteUrl = 'https://chalang.az',
    logo = '/assets/img/logo.png',
    description = 'Chalang - Rəqəmsal agentlik və innovasiya',
    email = 'hello@chalang.az',
    telephone = '+994504000000',
    address = {
        street: 'Nizami küç. 103',
        city: 'Bakı',
        country: 'Azərbaycan'
    },
    socialLinks = {},
    services = [],
    faqs = []
}: SchemaDataProps) {
    // Organization Schema
    const organizationSchema = {
        '@context': 'https://schema.org',
        '@type': 'Organization',
        name: siteName,
        url: siteUrl,
        logo: `${siteUrl}${logo}`,
        description,
        email,
        telephone,
        address: {
            '@type': 'PostalAddress',
            streetAddress: address.street,
            addressLocality: address.city,
            addressCountry: address.country
        },
        sameAs: Object.values(socialLinks),
        areaServed: 'AZ',
        availableLanguage: ['Azerbaijani', 'English', 'Russian']
    };

    // Website Schema
    const websiteSchema = {
        '@context': 'https://schema.org',
        '@type': 'WebSite',
        name: siteName,
        url: siteUrl,
        potentialAction: {
            '@type': 'SearchAction',
            target: `${siteUrl}/search?q={search_term_string}`,
            'query-input': 'required name=search_term_string'
        }
    };

    // FAQ Schema (if faqs exist)
    const faqSchema = faqs.length > 0 ? {
        '@context': 'https://schema.org',
        '@type': 'FAQPage',
        mainEntity: faqs.map(faq => ({
            '@type': 'Question',
            name: faq.question,
            acceptedAnswer: {
                '@type': 'Answer',
                text: faq.answer
            }
        }))
    } : null;

    // LocalBusiness Schema (for local SEO)
    const localBusinessSchema = {
        '@context': 'https://schema.org',
        '@type': 'LocalBusiness',
        '@id': `${siteUrl}/#business`,
        name: siteName,
        image: `${siteUrl}${logo}`,
        url: siteUrl,
        telephone,
        email,
        address: {
            '@type': 'PostalAddress',
            streetAddress: address.street,
            addressLocality: address.city,
            addressCountry: address.country
        },
        openingHoursSpecification: {
            '@type': 'OpeningHoursSpecification',
            dayOfWeek: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            opens: '09:00',
            closes: '18:00'
        },
        priceRange: '$$'
    };

    // AggregateOffer for services (if services exist)
    const offersSchema = services.length > 0 ? {
        '@context': 'https://schema.org',
        '@type': 'ItemList',
        itemListElement: services.map((service, index) => ({
            '@type': 'ListItem',
            position: index + 1,
            item: {
                '@type': 'Service',
                name: service.name,
                description: service.description
            }
        }))
    } : null;

    return (
        <>
            <script
                type="application/ld+json"
                dangerouslySetInnerHTML={{ __html: JSON.stringify(organizationSchema) }}
            />
            <script
                type="application/ld+json"
                dangerouslySetInnerHTML={{ __html: JSON.stringify(websiteSchema) }}
            />
            <script
                type="application/ld+json"
                dangerouslySetInnerHTML={{ __html: JSON.stringify(localBusinessSchema) }}
            />
            {faqSchema && (
                <script
                    type="application/ld+json"
                    dangerouslySetInnerHTML={{ __html: JSON.stringify(faqSchema) }}
                />
            )}
            {offersSchema && (
                <script
                    type="application/ld+json"
                    dangerouslySetInnerHTML={{ __html: JSON.stringify(offersSchema) }}
                />
            )}
        </>
    );
}