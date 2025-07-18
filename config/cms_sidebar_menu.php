<?php

return [
    [
        'title' => 'Əsas',
    ],
    [
        'icon' => '<i class=" ri-home-5-fill"></i>',
        'title' => 'Əsas səhifə',
        'route' => '/',
        'can' => 'dashbord.index',
    ],
    [
        'icon' => '<i class=" ri-home-5-fill"></i>',
        'title' => 'Haqqimizda',
        'can' => 'dashbord.index',
        'inner' => [
            [
                'icon' => '<i class=" ri-home-5-fill"></i>',
                'title' => 'Haqqimizda',
                'route' => 'admin.about.index',
                'can' => 'dashbord.index',
            ],
            [
                'title' => 'Step',
                'route' => 'admin.step.index',
                'icon' => '<i class="ri-user-2-fill"></i>',
                'can' => 'step.index',
            ],
        ]
    ],
    [
        'icon' => '<i class="ri-building-2-fill"></i>',
        'title' => 'Banner',
        'route' => 'admin.banner.index',
        'can' => 'banner.index',
    ],


    [
        'icon' => '<i class="ri-building-2-fill"></i>',
        'title' => 'Xidmətlər',
        'can' => 'service.index',
        'inner' => [
            [
                'icon' => '<i class="ri-building-2-fill"></i>',
                'title' => 'Xidmətlər',
                'route' => 'admin.service.index',
                'can' => 'service.index',
            ],
            [
                'icon' => '<i class="ri-building-2-fill"></i>',
                'title' => 'Xidmətlər content',
                'route' => 'admin.service-content.index',
                'can' => 'service.index',
            ],
        ]
    ],
    [
        'icon' => '<i class="ri-building-2-fill"></i>',
        'title' => 'Şirkət',
        'route' => 'admin.company.index',
        'can' => 'company.index',
    ],
    [
        'icon' => '<i class="ri-message-2-fill "></i>',
        'title' => 'İsmarıclar',
        'route' => 'admin.message',
        'can' => 'company.index',
    ],

    [
        'icon' => '<i class="ri-building-2-fill"></i>',
        'title' => 'Tags',
        'route' => 'admin.tag.index',
        'can' => 'company.index',
    ],

    [
        'icon' => '<i class="ri-briefcase-line"></i>',
        'title' => 'Portfolio',
        'can' => 'admin.portfolio.index',
        'inner' => [
            [
                'title' => 'Kataqoriya',
                'route' => 'admin.pcategory.index',
                'icon' => '<i class="  ri-grid-fill "></i>',
                'can' => 'pcategory.index',
            ],
            [
                'title' => 'Portfolio',
                'route' => 'admin.portfolio.index',
                'icon' => '<i class=" ri-briefcase-line "></i>',
                'can' => 'customer_type.index',
            ],
        ],
    ],

    [
        'icon' => '<i class="ri-briefcase-line"></i>',
        'title' => 'Blog',
        'can' => 'admin.portfolio.index',
        'inner' => [
            [
                'title' => 'Kataqoriya',
                'route' => 'admin.bcategory.index',
                'icon' => '<i class="  ri-grid-fill "></i>',
                'can' => 'bcategory.index',
            ],
            [
                'title' => 'Bloqlar',
                'route' => 'admin.blog.index',
                'icon' => '<i class=" ri-briefcase-line "></i>',
                'can' => 'blog.index',
            ],

        ],
    ],
    [
        'icon' => '<i class="ri-briefcase-line"></i>',
        'title' => 'Əlaqə',
        'can' => 'admin.contact.index',
        'inner' => [
            [
                'title' => 'Social Media',
                'route' => 'admin.social-media.index',
                'icon' => '<i class="  ri-grid-fill "></i>',
                'can' => 'bcategory.index',
            ],
            [
                'title' => 'Əlaqə',
                'route' => 'admin.contanct.index',
                'icon' => '<i class=" ri-briefcase-line "></i>',
                'can' => 'blog.index',
            ],

        ],
    ],

      [
        'title' => 'Tənzimləmələr',
        'icon' => '<i class=" ri-settings-5-line"></i>',
        'inner' => [
            // [
            //     'title' => 'Əsas Ayarlar',
            //     'route' => '/',
            //     'icon'  => '<i class="ion ion-ios-settings "></i>',
            //     'can' => 'settings.index'
            // ],
            [
                'title' => 'İdarəçilər',
                'route' => 'admin.user.index',
                'icon' => '<i class="ri-user-2-fill"></i>',
                'can' => 'user.index',
            ],
            [
                'title' => 'İcazələr',
                'route' => 'admin.role.index',
                'icon' => '<i class=" ri-auction-fill"></i>',
                'can' => 'İzazə siyahı',
            ],
            [
                'title' => 'Əsas aşlıqlar',
                'route' => 'admin.content-text.index',
                'icon' => '<i class=" ri-auction-fill"></i>',
                'can' => 'İzazə siyahı',
            ],

        ],
    ],

];
