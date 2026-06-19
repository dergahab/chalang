<?php

namespace App\Helpers;

class SchemaHelper
{
    public static function organization()
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Chalang',
            'url' => url('/'),
            'logo' => asset('assets/images/logo/logo.png'), // Adjust path if needed
            'sameAs' => [
                'https://www.facebook.com/chalang', // Example, replace with real if available
                'https://www.instagram.com/chalang',
                'https://www.linkedin.com/company/chalang'
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+994501234567', // Replace with real config
                'contactType' => 'customer service',
                'areaServed' => ['AZ', 'US', 'GB'],
                'availableLanguage' => ['Azerbaijani', 'English', 'Russian']
            ]
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }

    public static function website()
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'Chalang',
            'url' => url('/'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => url('/search?q={search_term_string}'),
                'query-input' => 'required name=search_term_string'
            ]
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }

    public static function breadcrumb($items)
    {
        // $items format: ['Title' => 'URL', 'Page' => '']
        $itemListElement = [];
        $position = 1;

        foreach ($items as $name => $url) {
            $item = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $name
            ];

            if (!empty($url)) {
                $item['item'] = $url;
            }

            $itemListElement[] = $item;
            $position++;
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $itemListElement
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }

    public static function article($blog)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => route('blog.single', $blog->slug ?? '') // Adjust route name if needed
            ],
            'headline' => $blog->title,
            'description' => \Illuminate\Support\Str::limit(strip_tags($blog->body), 160),
            'image' => $blog->image ? asset('storage/' . $blog->image) : null,
            'author' => [
                '@type' => 'Organization', // Or Person
                'name' => 'Chalang Team'
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Chalang',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('assets/images/logo/logo.png')
                ]
            ],
            'datePublished' => $blog->created_at->toIso8601String(),
            'dateModified' => $blog->updated_at->toIso8601String()
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }

    public static function service($service)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $service->name,
            'description' => $service->description,
            'provider' => [
                '@type' => 'Organization',
                'name' => 'Chalang'
            ],
            'areaServed' => [
                '@type' => 'Country',
                'name' => 'Azerbaijan'
            ],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => $service->name . ' Services',
                'itemListElement' => [] 
            ]
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }
    
    public static function faq($faqs)
    {
        if ($faqs->isEmpty()) return '';

        $mainEntity = [];
        foreach ($faqs as $faq) {
            $mainEntity[] = [
                '@type' => 'Question',
                'name' => $faq->question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq->answer
                ]
            ];
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $mainEntity
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
    }
}
