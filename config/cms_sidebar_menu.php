<?php

return [
    // 0. Dashboard (Executive Center)
    [
        'title' => 'Dashboard',
    ],
    [
        'icon' => '<i class="ri-dashboard-fill"></i>',
        'title' => 'İdarə Paneli',
        'route' => 'admin.home',
        'can' => 'dashboard.index',
    ],

    // 1. Məzmun Hub (Content)
    [
        'title' => 'Məzmun Hub',
    ],
    [
        'icon' => '<i class="ri-pages-line"></i>',
        'title' => 'Səhifələr',
        'can' => 'about.index',
        'inner' => [
            [
                'title' => 'Page Builder',
                'route' => 'admin.pages.index',
                'icon' => '<i class="ri-layout-masonry-line"></i>',
            ],
            [
                'title' => 'Haqqımızda',
                'route' => 'admin.about.index',
                'icon' => '<i class="ri-file-info-line"></i>',
                'can' => 'about.index',
            ],
            [
                'title' => 'Addımlar',
                'route' => 'admin.step.index',
                'icon' => '<i class="ri-footprint-line"></i>',
                'can' => 'step.index',
            ],
        ],
    ],
    [
        'icon' => '<i class="ri-layout-2-line"></i>',
        'title' => 'Home Sections',
        'can' => 'content-text.index',
        'inner' => [
            [
                'title' => 'Overview',
                'route' => 'admin.home-sections.index',
                'icon' => '<i class="ri-layout-grid-line"></i>',
                'can' => 'content-text.index',
            ],
            [
                'title' => 'Smart Estimator',
                'route' => 'admin.home-sections.edit',
                'params' => ['section' => 'estimator'],
                'icon' => '<i class="ri-calculator-line"></i>',
                'can' => 'content-text.index',
            ],
            [
                'title' => 'Achievements',
                'route' => 'admin.home-sections.edit',
                'params' => ['section' => 'fame'],
                'icon' => '<i class="ri-award-line"></i>',
                'can' => 'content-text.index',
            ],
            [
                'title' => 'Lead Magnet',
                'route' => 'admin.home-sections.edit',
                'params' => ['section' => 'lead_magnet'],
                'icon' => '<i class="ri-megaphone-line"></i>',
                'can' => 'content-text.index',
            ],
            [
                'title' => 'Process',
                'route' => 'admin.home-sections.edit',
                'params' => ['section' => 'process'],
                'icon' => '<i class="ri-route-line"></i>',
                'can' => 'content-text.index',
            ],
            [
                'title' => 'Metrics',
                'route' => 'admin.home-sections.edit',
                'params' => ['section' => 'metrics'],
                'icon' => '<i class="ri-bar-chart-2-line"></i>',
                'can' => 'content-text.index',
            ],
            [
                'title' => 'Tech Stack',
                'route' => 'admin.home-sections.edit',
                'params' => ['section' => 'tech_stack'],
                'icon' => '<i class="ri-cpu-line"></i>',
                'can' => 'content-text.index',
            ],
        ],
    ],
    [
        'icon' => '<i class="ri-service-line"></i>',
        'title' => 'Xidmətlər',
        'can' => 'service.index',
        'inner' => [
            [
                'title' => 'Siyahı',
                'route' => 'admin.service.index',
                'icon' => '<i class="ri-list-check"></i>',
                'can' => 'service.index',
            ],
            [
                'title' => 'Məzmun',
                'route' => 'admin.sp-content.index',
                'icon' => '<i class="ri-file-text-line"></i>',
                'can' => 'sp-content.index',
            ],
        ],
    ],
    [
        'icon' => '<i class="ri-article-line"></i>',
        'title' => 'Bloq',
        'can' => 'blog.index',
        'inner' => [
            [
                'title' => 'Kateqoriyalar',
                'route' => 'admin.bcategory.index',
                'icon' => '<i class="ri-folder-line"></i>',
                'can' => 'bcategory.index',
            ],
            [
                'title' => 'Məqalələr',
                'route' => 'admin.blog.index',
                'icon' => '<i class="ri-file-edit-line"></i>',
                'can' => 'blog.index',
            ],
        ],
    ],
    [
        'icon' => '<i class="ri-image-2-line"></i>',
        'title' => 'Media Kitabxanası',
        'route' => 'admin.home', // Placeholder
        'can' => '*',
        'feature' => 'media_library',
    ],

    // 2. Portfel Hub
    [
        'title' => 'Portfel Hub',
    ],
    [
        'icon' => '<i class="ri-briefcase-4-line"></i>',
        'title' => 'Layihələr',
        'can' => 'portfolio.index',
        'inner' => [
            [
                'title' => 'Kateqoriyalar',
                'route' => 'admin.pcategory.index',
                'icon' => '<i class="ri-folder-line"></i>',
                'can' => 'pcategory.index',
            ],
            [
                'title' => 'Portfolio',
                'route' => 'admin.portfolio.index',
                'icon' => '<i class="ri-briefcase-line"></i>',
                'can' => 'portfolio.index',
            ],
        ],
    ],
    [
        'icon' => '<i class="ri-slideshow-line"></i>',
        'title' => 'Case Studies',
        'route' => 'admin.case-study.index',
        'can' => 'case-study.index',
    ],
    [
        'icon' => '<i class="ri-chat-quote-line"></i>',
        'title' => 'Müştəri Rəyləri',
        'route' => 'admin.testimonial.index',
        'can' => 'testimonial.index',
    ],

    // 3. Sales & CRM
    [
        'title' => 'Sales & CRM',
    ],
    [
        'icon' => '<i class="ri-customer-service-2-line"></i>',
        'title' => 'Leads / Müraciətlər',
        'route' => 'admin.submission.index',
        'can' => 'submission.index',
    ],
    [
        'icon' => '<i class="ri-search-eye-line"></i>',
        'title' => 'Audit Sorğuları',
        'route' => 'admin.subscribe.index',
        'can' => '*', // Assuming global access or check model policy if needed
    ],
    [
        'icon' => '<i class="ri-message-3-line"></i>',
        'title' => 'İsmarıclar',
        'route' => 'admin.message.index',
        'can' => 'message.index',
    ],
    [
        'icon' => '<i class="ri-shopping-cart-2-line"></i>',
        'title' => 'Sifarişlər',
        'route' => 'admin.home', // Placeholder
        'can' => '*',
        'feature' => 'crm_orders',
    ],
    [
        'icon' => '<i class="ri-package-line"></i>',
        'title' => 'Demo Paketlər',
        'route' => 'admin.home', // Placeholder
        'can' => '*',
        'feature' => 'crm_demo_packages',
    ],

    // 4. Growth & Marketing
    [
        'title' => 'Growth & Marketing',
    ],
    [
        'icon' => '<i class="ri-image-line"></i>',
        'title' => 'Bannerlər',
        'route' => 'admin.banner.index',
        'can' => 'banner.index',
    ],
    [
        'icon' => '<i class="ri-price-tag-3-line"></i>',
        'title' => 'Qiymət Planları',
        'route' => 'admin.pricing-plan.index',
        'can' => 'pricing-plan.index',
    ],
    [
        'icon' => '<i class="ri-hand-heart-line"></i>',
        'title' => 'Tərəfdaşlar',
        'route' => 'admin.partner.index',
        'can' => 'partner.index',
    ],
    [
        'icon' => '<i class="ri-earth-line"></i>',
        'title' => 'Global SEO / Sitemap',
        'route' => 'admin.analytics.edit', // Current sync
        'can' => '*',
        'feature' => 'marketing_seo_hub',
    ],

    // 5. Ops & System Health
    [
        'title' => 'Ops & Health',
    ],
    [
        'icon' => '<i class="ri-download-2-line"></i>',
        'title' => 'Data Export/Import',
        'can' => '*',
        'inner' => [
            [
                'title' => 'Eksport',
                'route' => 'admin.export.index',
                'icon' => '<i class="ri-upload-2-line"></i>',
                'can' => '*',
            ],
            [
                'title' => 'İdxal',
                'route' => 'admin.import.index',
                'icon' => '<i class="ri-download-2-line"></i>',
                'can' => '*',
            ],
            [
                'title' => 'Eksport Tarixçəsi',
                'route' => 'admin.export.history',
                'icon' => '<i class="ri-history-line"></i>',
                'can' => '*',
            ],
            [
                'title' => 'İdxal Tarixçəsi',
                'route' => 'admin.import.history',
                'icon' => '<i class="ri-history-fill"></i>',
                'can' => '*',
            ],
            [
                'title' => 'Cədvəllənmiş Eksport',
                'route' => 'admin.export.schedules',
                'icon' => '<i class="ri-calendar-schedule-line"></i>',
                'can' => '*',
            ],
        ],
    ],
    [
        'icon' => '<i class="ri-pulse-line"></i>',
        'title' => 'System Pulse',
        'route' => 'admin.home', // Placeholder
        'can' => '*',
        'feature' => 'ops_health_pulse',
    ],
    [
        'icon' => '<i class="ri-flag-line"></i>',
        'title' => 'Feature Flags UI',
        'route' => 'admin.home', // Placeholder
        'can' => '*',
        'feature' => 'ops_feature_flags_hub',
    ],
    [
        'icon' => '<i class="ri-error-warning-line"></i>',
        'title' => 'Incident Alerts',
        'route' => 'admin.home', // Placeholder
        'can' => '*',
        'feature' => 'ops_incidents',
    ],

    // 6. Bildiriş Mərkəzi
    [
        'title' => 'Bildiriş Mərkəzi',
    ],
    [
        'icon' => '<i class="ri-notification-3-line"></i>',
        'title' => 'Tarixçə',
        'route' => 'admin.notifications.index',
        'can' => '*',
    ],
    [
        'icon' => '<i class="ri-telegram-line"></i>',
        'title' => 'Telegram Bot',
        'route' => 'admin.telegram.index',
        'can' => 'telegram.index',
    ],
    [
        'icon' => '<i class="ri-webhook-line"></i>',
        'title' => 'Kanal Ayarları',
        'route' => 'admin.home', // Placeholder
        'can' => '*',
        'feature' => 'notification_channels',
    ],

    // 7. Security & Access
    [
        'title' => 'Security & Access',
    ],
    [
        'icon' => '<i class="ri-history-line"></i>',
        'title' => 'Activity Log',
        'route' => 'admin.activity-log.index',
        'can' => '*',
    ],
    [
        'icon' => '<i class="ri-shield-keyhole-line"></i>',
        'title' => 'Security Hub',
        'route' => 'admin.home', // Placeholder
        'can' => 'user.index',
        'feature' => 'security_hub_v1',
    ],

    // 8. Sistem Management
    [
        'title' => 'Sistem Management',
    ],
    [
        'icon' => '<i class="ri-user-settings-line"></i>',
        'title' => 'İdarəçilər',
        'route' => 'admin.user.index',
        'can' => 'user.index',
    ],
    [
        'icon' => '<i class="ri-shield-user-line"></i>',
        'title' => 'Rollar',
        'route' => 'admin.role.index',
        'can' => 'role.index',
    ],
    [
        'icon' => '<i class="ri-translate"></i>',
        'title' => 'Tərcümələr',
        'route' => 'admin.content-text.index',
        'can' => 'content-text.index',
    ],
    [
        'icon' => '<i class="ri-price-tag-line"></i>',
        'title' => 'Teqlər',
        'route' => 'admin.tag.index',
        'can' => 'tag.index',
    ],
    [
        'icon' => '<i class="ri-team-line"></i>',
        'title' => 'Komanda Üzvləri',
        'route' => 'admin.team-member.index',
        'can' => 'team-member.index',
    ],
    [
        'icon' => '<i class="ri-question-answer-line"></i>',
        'title' => 'FAQ',
        'route' => 'admin.faq.index',
        'can' => 'faq.index',
    ],
    [
        'icon' => '<i class="ri-contacts-book-line"></i>',
        'title' => 'Əlaqə & Şirkət',
        'can' => 'company.index',
        'inner' => [
            [
                'title' => 'Sosial Mediya',
                'route' => 'admin.social-media.index',
                'icon' => '<i class="ri-share-line"></i>',
                'can' => 'social-media.index',
            ],
            [
                'title' => 'Əlaqə Səhifəsi',
                'route' => 'admin.contact.index',
                'icon' => '<i class="ri-contacts-line"></i>',
                'can' => 'contact.index',
            ],
            [
                'title' => 'Şirkət Məlumatları',
                'route' => 'admin.company.index',
                'icon' => '<i class="ri-building-4-line"></i>',
                'can' => 'company.index',
            ],
        ],
    ],
    [
        'icon' => '<i class="ri-settings-3-line"></i>',
        'title' => 'Ümumi Ayarlar',
        'route' => 'admin.settings.index',
        'can' => 'settings.index',
    ],
];
