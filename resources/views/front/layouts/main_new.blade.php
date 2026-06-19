<!DOCTYPE html>
<html class="no-js" lang="{{ app()->getLocale() }}" data-theme="{{ request()->cookie('styleCookieName', 'light') }}">

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Chalang</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/media/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/sal.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/green-audio-player.min.css') }}">

    <!-- Site Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/chalang-core.css?v=' . time()) }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/chalang-preview.css?v=' . time() . '99') }}">
    <!-- Dynamic Styles & Global Customization -->
    @include('front.layouts.partials.dynamic-styles')
    @include('front.layouts.partials.analytics')
    @stack('styles')


    <!-- SEO Structured Data -->
    {!! App\Helpers\SchemaHelper::organization() !!}
    @if(request()->path() == '/')
    {!! App\Helpers\SchemaHelper::website() !!}
    @endif
    @stack('schema_json')

</head>

<body class="sticky-header {{ request()->cookie('styleCookieName', 'light') === 'dark' ? 'active-dark-mode' : 'active-light-mode' }}">
    @php
    $isPreview = request()->is('preview*');
    @endphp
    <div id="scroll-progress"></div>
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>
    <div class="bg-shape shape-4"></div>
    <div class="bg-shape shape-5"></div>
    <div class="noise-overlay"></div>
    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>


    <div class="mobile-nav" id="mobile-nav">
        <button class="close-btn" id="close-menu" aria-label="{{ __('Close menu') }}">
            <svg width="32" height="32" viewBox="0 0 24 24">
                <path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" fill="currentColor" />
            </svg>
        </button>

        <style>
            /* Mobile Nested Menu Styles */
            .mobile-menu-list {
                list-style: none;
                padding: 0;
                margin: 40px 0 0;
            }

            .mobile-menu-item {
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }

            .menu-head {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .mobile-menu-link {
                display: block;
                padding: 15px 0;
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--text-main);
                text-decoration: none;
                flex-grow: 1;
            }

            .mobile-toggle-btn {
                background: none;
                border: none;
                color: var(--text-main);
                padding: 15px;
                cursor: pointer;
                transition: transform 0.3s;
            }

            .mobile-toggle-btn.active {
                transform: rotate(180deg);
                color: var(--brand-primary);
            }

            .mobile-sub-menu {
                display: none;
                list-style: none;
                padding: 0 0 15px 20px;
                background: rgba(255, 255, 255, 0.02);
            }

            .mobile-sub-menu.open {
                display: block;
            }

            .mobile-sub-link {
                display: block;
                padding: 10px 0;
                font-size: 1.1rem;
                color: var(--text-sub);
                text-decoration: none;
            }

            .mobile-utility-bar {
                margin-top: 30px;
                display: flex;
                gap: 15px;
                flex-wrap: wrap;
            }

            .mobile-util-btn {
                font-size: 0.9rem;
                padding: 8px 16px;
                border: 1px solid var(--card-border);
                border-radius: 20px;
                text-decoration: none;
                color: var(--text-sub);
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }
        </style>

        <ul class="mobile-menu-list">
            <!-- HOME -->
            <li class="mobile-menu-item">
                <a href="{{ route(request()->is('preview*') && !request()->is('preview') ? 'preview' : '/') }}" class="mobile-menu-link">
                    {{ __('preview.nav.home') }}
                </a>
            </li>

            <!-- COMPANY -->
            <li class="mobile-menu-item">
                <div class="menu-head">
                    <a href="#" onclick="return false;" class="mobile-menu-link">{{ __('preview.nav.company') }}</a>
                    <button class="mobile-toggle-btn" aria-label="Toggle Submenu"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 10l5 5 5-5z" />
                        </svg></button>
                </div>
                <ul class="mobile-sub-menu">
                    <li><a href="{{ route('preview.about-us') }}" class="mobile-sub-link">{{ __('preview.nav.about') }}</a></li>
                    <li><a href="{{ route('preview.team.index') }}" class="mobile-sub-link">{{ __('preview.nav.team') }}</a></li>
                    <li><a href="#" class="mobile-sub-link">{{ __('preview.nav.partners') }}</a></li>
                    <li><a href="#" class="mobile-sub-link">{{ __('preview.nav.legal') }}</a></li>
                </ul>
            </li>

            <!-- SOLUTIONS -->
            <li class="mobile-menu-item">
                <div class="menu-head">
                    <a href="#" onclick="return false;" class="mobile-menu-link">{{ __('preview.nav.solutions') }}</a>
                    <button class="mobile-toggle-btn"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 10l5 5 5-5z" />
                        </svg></button>
                </div>
                <ul class="mobile-sub-menu">
                    <li><a href="{{ route('preview.services') }}" class="mobile-sub-link">{{ __('preview.nav.services') }}</a></li>
                    <li><a href="{{ route('preview.packages') }}" class="mobile-sub-link">{{ __('preview.nav.products') }}</a></li>
                    <li><a href="#" class="mobile-sub-link">{{ __('preview.nav.industries') }}</a></li>
                </ul>
            </li>

            <!-- WORK -->
            <li class="mobile-menu-item">
                <div class="menu-head">
                    <a href="#" onclick="return false;" class="mobile-menu-link">{{ __('preview.nav.work') }}</a>
                    <button class="mobile-toggle-btn"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 10l5 5 5-5z" />
                        </svg></button>
                </div>
                <ul class="mobile-sub-menu">
                    <li><a href="{{ route('preview.case-study.index') }}" class="mobile-sub-link">{{ __('preview.nav.case_studies') }}</a></li>
                    <li><a href="{{ route('preview.portfolio') }}" class="mobile-sub-link">{{ __('preview.nav.clients') }}</a></li>
                </ul>
            </li>

            <!-- INSIGHTS -->
            <li class="mobile-menu-item">
                <div class="menu-head">
                    <a href="#" onclick="return false;" class="mobile-menu-link">{{ __('preview.nav.insights') }}</a>
                    <button class="mobile-toggle-btn"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 10l5 5 5-5z" />
                        </svg></button>
                </div>
                <ul class="mobile-sub-menu">
                    <li><a href="{{ route('preview.blogs') }}" class="mobile-sub-link">{{ __('preview.nav.blog') }}</a></li>
                    <li><a href="#" class="mobile-sub-link">{{ __('preview.nav.events') }}</a></li>
                    <li><a href="#" class="mobile-sub-link">{{ __('preview.nav.reports') }}</a></li>
                </ul>
            </li>

            <!-- CAREERS -->
            <li class="mobile-menu-item">
                <div class="menu-head">
                    <a href="#" onclick="return false;" class="mobile-menu-link">{{ __('preview.nav.careers') }}</a>
                    <button class="mobile-toggle-btn"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 10l5 5 5-5z" />
                        </svg></button>
                </div>
                <ul class="mobile-sub-menu">
                    <li><a href="#" class="mobile-sub-link">{{ __('preview.nav.join_us') }}</a></li>
                    <li><a href="#" class="mobile-sub-link">{{ __('preview.nav.culture') }}</a></li>
                </ul>
            </li>

            <!-- CONTACT -->
            <li class="mobile-menu-item">
                <a href="{{ route('preview.contact') }}" class="mobile-menu-link">{{ __('preview.nav.contact') }}</a>
            </li>
        </ul>

        <div class="mobile-utility-bar">
            <a href="{{ route('login') }}" class="mobile-util-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
                {{ __('preview.nav.client_portal') }}
            </a>
            <a href="#" class="mobile-util-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                </svg>
                {{ __('preview.nav.partner_hub') }}
            </a>
        </div>

        <script>
            document.querySelectorAll('.mobile-toggle-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    const subMenu = btn.closest('.mobile-menu-item').querySelector('.mobile-sub-menu');
                    if (subMenu) {
                        const isOpen = subMenu.classList.contains('open');
                        // Close all others
                        document.querySelectorAll('.mobile-sub-menu').forEach(el => el.classList.remove('open'));
                        document.querySelectorAll('.mobile-toggle-btn').forEach(el => el.classList.remove('active'));

                        if (!isOpen) {
                            subMenu.classList.add('open');
                            btn.classList.add('active');
                        }
                    }
                });
            });
        </script>

        <div class="mobile-controls">
            <button class="mobile-control-btn" id="mobile-lang-toggle" data-current-lang="{{ strtoupper(app()->getLocale()) }}" data-lang-change-url="{{ route('lang.change', ['lang' => ':lang']) }}">{{ strtoupper(app()->getLocale()) }}</button>
            <button class="mobile-control-btn" id="mobile-theme-toggle">
                <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="4"></circle>
                    <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"></path>
                </svg>
                <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
                </svg>
                Tema
            </button>
        </div>
    </div>

    <div class="search-overlay" id="search-overlay">
        <div class="search-container">
            <div class="search-header">
                <svg class="search-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                    <path d="M19 1 17.75 3.75 15 5l2.75 1.25L19 9l1.25-2.75L23 5l-2.75-1.25L19 1z" />
                </svg>
                <input type="text" class="search-input" id="search-input" placeholder="{{ __('preview.search.placeholder') }}" data-lang-placeholder="search_placeholder">
                <button class="search-close" id="search-close">{{ __('preview.search.close') }}</button>
            </div>
            <div class="search-results" id="search-results"></div>
        </div>
    </div>


    <div id="main-wrapper" class="main-wrapper">

        <!--=====================================-->
        <!--=        Header Area Start       	=-->
        <!--=====================================-->
        @include('front.layouts.partials.header-preview')
        @yield('content')
        <!--=====================================-->
        <!--=====================================-->
        <!--=        Footer Area Start       	=-->
        <!--=====================================-->
        <div class="ai-widget">
            <div class="ai-modal" id="ai-modal" role="dialog" aria-label="Chalang AI">
                <div class="ai-header">
                    <h4>✨ Chalang AI</h4>
                    <button class="ai-close" id="ai-close" aria-label="{{ __('Close') }}">&times;</button>
                </div>
                <div class="ai-body" id="ai-body">
                    <div class="ai-message">Salam! Mən Chalang AI strateji köməkçisiyəm.</div>
                </div>
                <div class="typing-indicator" id="typing-indicator">Chalang AI düşünür...</div>
                <div class="ai-input-group">
                    <input type="text" class="ai-input" id="ai-input" placeholder="Sual verin..." aria-label="AI sualı">
                    <button class="ai-send" id="ai-send" aria-label="{{ __('Send') }}" type="button"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M2.01 21 23 12 2.01 3 2 10l15 2-15 2z" />
                        </svg></button>
                </div>
            </div>

            <!-- Docked Logic: Rocket is part of the Widget now -->
            <div class="docked-rocket" id="docked-rocket">
                <svg class="rocket-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 19V5M5 12l7-7 7 7" />
                </svg>
            </div>

            <button class="ai-trigger" id="ai-trigger" aria-label="Chalang AI"><svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 9.3V4h-3v2.6L12 3 2 12h3v8h5v-6h4v6h5v-8h3l-3-2.7zm-9 .7c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2z" />
                </svg></button>
        </div>

        @include('front.layouts.partials.footer-modern')
        @include('front.layouts.partials.cookie-consent')
    </div>

    <!-- Jquery Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.4/imagesloaded.pkgd.min.js"></script>

    <script src="{{ asset('assets/js/vendor/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/counterup.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/sal.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/js.cookie.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/tilt.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/green-audio-player.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.nav.js') }}"></script>
    <script>
        function changeLang(lang) {
            var url = "{{ route('lang.change', ['lang' => ':lang']) }}";
            url = url.replace(':lang', lang);
            window.location.href = url;
        }
    </script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <!-- Site Scripts -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/chalang-preview.js?v=' . time()) }}"></script>

    @stack('scripts')
    @stack('js_script')
    <script>
        const hidePreloader = () => {
            const preloader = document.getElementById("preloader-wrapper");
            if (!preloader) return;
            preloader.style.opacity = "0";
            preloader.style.visibility = "hidden";
            preloader.style.transition = "opacity 0.5s ease-out";
            setTimeout(() => preloader.remove(), 700);
        };
        window.addEventListener("load", hidePreloader);
        document.addEventListener("DOMContentLoaded", () => setTimeout(hidePreloader, 1200));
        setTimeout(hidePreloader, 4000);
    </script>
    {{-- Moved to ai-widget --}}
</body>

</html>