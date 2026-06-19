<!DOCTYPE html>
<html class="no-js" lang="en" data-theme="{{ request()->cookie('styleCookieName', 'light') }}">

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ \App\Models\Setting::getValue('site_title') ?? 'Chalang' }}</title>
    <meta name="description" content="{{ \App\Models\Setting::getValue('seo_meta_description') ?? '' }}">
    <meta name="keywords" content="{{ \App\Models\Setting::getValue('seo_meta_keywords') ?? '' }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ \App\Models\Setting::getValue('site_favicon') ?? asset('assets/media/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/sal.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/green-audio-player.min.css') }}">

    <!-- Site Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('front.layouts.partials.analytics')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/chalang-preview.css?v=') . time() }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/chalang-core.css?v=') . time() }}">
    <!-- Dynamic Styles & Global Customization -->
    @include('front.layouts.partials.dynamic-styles')
</head>


<body class="sticky-header {{ request()->cookie('styleCookieName', 'light') === 'dark' ? 'active-dark-mode' : 'active-light-mode' }}">
    @php
    $isPreview = request()->is('preview*');
    @endphp
    <div id="scroll-progress"></div>

    <div class="mobile-nav" id="mobile-nav">
        <button class="close-btn" id="close-menu" aria-label="{{ __('Close menu') }}">
            <svg width="32" height="32" viewBox="0 0 24 24">
                <path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" fill="currentColor" />
            </svg>
        </button>
        <ul>
            <li><a href="{{ route($isPreview ? 'preview' : '/') }}">{{ __('front.home') }}</a></li>
            <li><a href="{{ route($isPreview ? 'preview.services' : 'services') }}">{{ __('services') }}</a></li>
            <li><a href="{{ route($isPreview ? 'preview.packages' : 'packages') }}">Paketl?r</a></li>
            <li><a href="{{ route($isPreview ? 'preview.portfolio' : 'portfolio') }}">{{ __('portfolio') }}</a></li>
            <li><a href="{{ route($isPreview ? 'preview.case-study.index' : 'case-study.index') }}">Nmun? Layih?l?r</a></li>
            <li><a href="{{ route(request()->is('preview*') ? 'preview.team.index' : 'team.index') }}">Komanda</a></li>
            <li><a href="{{ route($isPreview ? 'preview.about-us' : 'about-us') }}">{{ __('about') }}</a></li>
            <li><a href="{{ route($isPreview ? 'preview.blogs' : 'blogs') }}">{{ __('blog') }}</a></li>
            <li><a href="{{ route($isPreview ? 'preview.contact' : 'contact') }}">{{ __('contact') }}</a></li>
        </ul>
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
        <div class="navbar-container">
            <div class="nav-island island-left">
                <a href="{{ route($isPreview ? 'preview' : '/') }}" aria-label="Chalang">
                    <svg class="logo-svg" viewBox="0 0 81.87 15.74">
                        <g>
                            <path fill="currentColor" d="M25.7,5.95c-.49-.62-1.3-1.22-2.46-1.22-1.96,0-3.33,1.59-3.33,3.31,0,1.84,1.46,3.38,3.34,3.38.87,0,1.75-.34,2.36-1.14h2.11c-.81,1.72-2.38,2.9-4.52,2.9-3.43,0-5.1-2.89-5.1-5.14s1.66-5.07,5.13-5.07c2.03,0,3.72,1.1,4.54,2.98h-2.07Z" />
                            <path fill="currentColor" d="M28.72,3.14h1.82v3.93h3.58v-3.93h1.82v9.8h-1.82v-4.11h-3.58v4.11h-1.82V3.14Z" />
                            <path fill="currentColor" d="M40.67,3.14h1.46l4.08,9.8h-2l-1.01-2.53h-3.6l-1.01,2.53h-2l4.08-9.8ZM42.51,8.65l-1.11-2.86-1.11,2.86h2.23Z" />
                            <path fill="currentColor" d="M46.89,3.14h1.82v8.04h2.99v1.76h-4.81V3.14Z" />
                            <path fill="currentColor" d="M56.09,3.14h1.46l4.08,9.8h-2l-1.01-2.53h-3.6l-1.01,2.53h-2l4.08-9.8ZM57.93,8.65l-1.11-2.86-1.11,2.86h2.23Z" />
                            <path fill="currentColor" d="M62.3,3.14h1.82l4.37,6.62V3.14h1.82v9.8h-1.82l-4.37-6.62v6.62h-1.82V3.14Z" />
                            <path fill="currentColor" d="M81.87,7.95c-.03,2.33-1.46,5.23-5.21,5.23s-5.23-2.72-5.23-5.07,1.78-5.14,5.21-5.14c2.25,0,4.01,1.14,4.74,3.06h-2.17c-.76-1.25-2.11-1.3-2.57-1.3-2.29,0-3.39,1.78-3.39,3.31,0,1.67,1.22,3.38,3.47,3.38,1.19,0,2.33-.54,2.86-1.76h-4.09v-1.71h6.39Z" />
                            <path fill="currentColor" d="M8.88.03C3.91-.37-.27,3.73.01,8.7c.18,3.15,2.14,5.82,4.88,7.04.02,0,.04-.02.03-.03-.22-.3-.35-.68-.35-1.08,0-.87.6-1.6,1.41-1.8.02,0,.02-.03,0-.04-1.88-.92-3.1-2.96-2.8-5.26.27-2.08,2.21-4.04,4.29-4.34,3.14-.44,5.82,1.98,5.82,5.03,0,2-1.16,3.74-2.85,4.56-.02,0-.02.04,0,.04.81.2,1.41.93,1.41,1.8,0,.4-.13.77-.34,1.08-.01.02,0,.04.03.03,2.88-1.28,4.89-4.16,4.89-7.52C16.44,3.9,13.11.36,8.88.03Z" />
                            <path fill="currentColor" d="M8.23,13.3l.19.37c.14.28.36.5.64.64l.37.19s.01.02,0,.03l-.37.19c-.28.14-.5.36-.64.64l-.19.37s-.02.01-.03,0l-.19-.37c-.14-.28-.36-.5-.64-.64l-.37-.19s-.01-.02,0-.03l.37-.19c.28-.14.5-.36.64-.64l.19-.37s.02-.01.03,0Z" />
                        </g>
                    </svg>
                </a>
            </div>
            <div class="nav-island island-center nav-desktop">
                <ul>
                    <li class="{{ request()->is('preview') ? 'active' : '' }}"><a href="{{ route($isPreview ? 'preview' : '/') }}" data-lang="nav_home"><svg viewBox="0 0 24 24">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg><span>{{ __('front.home') }}</span></a></li>
                    <li class="{{ request()->is('preview/services*') ? 'active' : '' }}"><a href="{{ route($isPreview ? 'preview.services' : 'services') }}" data-lang="nav_services"><svg viewBox="0 0 24 24">
                                <path d="M12 2 2 7l10 5 10-5-10-5zm0 9 2.5-1.25L12 8.5 9.5 9.75 12 11zm0 2.5-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z" />
                            </svg><span>{{ __('services') }}</span></a></li>
                    <li class="{{ request()->is('preview/packages*') ? 'active' : '' }}"><a href="{{ route($isPreview ? 'preview.packages' : 'packages') }}"><svg viewBox="0 0 24 24">
                                <path d="M21 8V7l-9-4-9 4v1l9 4 9-4zm-9 6-9-4v7l9 4 9-4v-7l-9 4z" />
                            </svg><span>Paketl?r</span></a></li>
                    <li class="{{ request()->is('preview/portfolio*') ? 'active' : '' }}"><a href="{{ route($isPreview ? 'preview.portfolio' : 'portfolio') }}" data-lang="nav_portfolio"><svg viewBox="0 0 24 24">
                                <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" />
                            </svg><span>{{ __('portfolio') }}</span></a></li>

                    <li class="nav-item-dropdown">
                        <a href="#" onclick="return false;"><svg viewBox="0 0 24 24">
                                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z" />
                            </svg><span>S?hif?l?r</span></a>
                        <div class="dropdown-menu">
                            <a href="{{ route($isPreview ? 'preview.case-study.index' : 'case-study.index') }}" class="dropdown-item">
                                <svg viewBox="0 0 24 24">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                                </svg>
                                Nmun? Layih?l?r
                            </a>
                            <a href="{{ route(request()->is('preview*') ? 'preview.team.index' : 'team.index') }}" class="dropdown-item">
                                <svg viewBox="0 0 24 24">
                                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                                </svg>
                                Komanda
                            </a>
                        </div>
                    </li>
                    <li class="{{ request()->is('preview/about-us') ? 'active' : '' }}"><a href="{{ route($isPreview ? 'preview.about-us' : 'about-us') }}" data-lang="nav_about"><svg viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg><span>{{ __('about') }}</span></a></li>
                    <li class="{{ request()->is('preview/blogs*') || request()->is('preview/blog/*') ? 'active' : '' }}"><a href="{{ route($isPreview ? 'preview.blogs' : 'blogs') }}" data-lang="nav_blog"><svg viewBox="0 0 24 24">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                            </svg><span>{{ __('blog') }}</span></a></li>
                    <li class="{{ request()->is('preview/contact') ? 'active' : '' }}"><a href="{{ route($isPreview ? 'preview.contact' : 'contact') }}" data-lang="nav_contact"><svg viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z" />
                            </svg><span>{{ __('contact') }}</span></a></li>
                </ul>
            </div>
            <div class="nav-island island-right controls">
                <button class="control-btn" id="search-toggle" aria-label="{{ __('Search') }}" aria-expanded="false">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                        <path d="M19 1 17.75 3.75 15 5l2.75 1.25L19 9l1.25-2.75L23 5l-2.75-1.25L19 1z" />
                    </svg>
                </button>
                <div class="lang-dropdown-wrapper" id="lang-dropdown-wrapper">
                    <button class="control-btn lang-btn" id="lang-btn" aria-label="{{ __('Change language') }}" data-current-lang="{{ strtoupper(app()->getLocale()) }}" data-lang-change-url="{{ route('lang.change', ['lang' => ':lang']) }}">{{ strtoupper(app()->getLocale()) }}</button>
                    <div class="lang-dropdown-menu">
                        @foreach($languages as $language)
                        <div class="lang-item{{ strtoupper(app()->getLocale()) === strtoupper($language->lang) ? ' active' : '' }}" data-lang="{{ $language->lang }}">{{ strtoupper($language->lang) }}</div>
                        @endforeach
                    </div>
                </div>
                <button class="control-btn theme-toggle" id="theme-toggle" aria-label="{{ __('Toggle theme') }}">
                    <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="4"></circle>
                        <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"></path>
                    </svg>
                    <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
                    </svg>
                </button>
            </div>
            <button id="mobile-menu-toggle" aria-label="{{ __('Open menu') }}" aria-expanded="false"><svg viewBox="0 0 24 24">
                    <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" />
                </svg></button>
        </div>
        {{--
        <header class="header axil-header header-style-1">
            <div id="axil-sticky-placeholder"></div>
            <div class="axil-mainmenu">
                <div class="container">
                    <div class="header-navbar">
                        <div class="header-logo" style="width: 10% !important;">
                            <a href="{{ route('/') }}">
        <img class="light-version-logo" style="width: 85% !important;"
            src="{{ \App\Models\Setting::getValue('site_logo') ?? asset('assets/media/logo.svg') }}" alt="logo">
        </a>
        <a href="{{ route('/') }}">
            <img class="dark-version-logo" style="width: 85% !important;"
                src="{{ \App\Models\Setting::getValue('site_logo_dark') ?? asset('assets/media/logo.svg') }}" alt="logo">
        </a>
        <a href="{{ route('/') }}">
            <img class="sticky-logo" style="width: 85% !important;"
                src="{{ \App\Models\Setting::getValue('site_logo') ?? asset('assets/media/logo.svg') }}" alt="logo">
        </a>
    </div>
    <div class="header-main-nav">
        <!-- Start Mainmanu Nav -->
        <nav class="mainmenu-nav" id="mobilemenu-popup">
            <div class="d-block d-lg-none">
                <div class="mobile-nav-header">
                    <div class="mobile-nav-logo">
                        <a href="index-1.html">
                            <img class="light-mode" width="85%"
                                src="{{ \App\Models\Setting::getValue('site_logo') ?? asset('assets/media/logo-2.svg') }}" alt="Site Logo">
                            <img class="dark-mode" width="85%"
                                src="{{ \App\Models\Setting::getValue('site_logo_dark') ?? asset('assets/media/logo-3.svg') }}" alt="Site Logo">
                        </a>
                    </div>
                    <button class="mobile-menu-close" data-bs-dismiss="offcanvas"><i
                            class="fas fa-times"></i></button>
                </div>
            </div>
            <ul class="mainmenu justify-content-center">
                <li>
                    <a href="{{ route('/') }}" class="{{ request()->segment(1) == '' ? 'active' : '' }}">
                        <i class="fas fa-home"></i> {{ __('front.home') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('services') }}" class="{{ request()->segment(1) == 'services' ? 'active' : '' }}">
                        <i class="fa fa-swatchbook"></i> {{ __('services') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('packages') }}" class="{{ request()->segment(1) == 'packages' ? 'active' : '' }}">
                        <i class="fa fa-box"></i> Paketlər
                    </a>
                </li>
                <li>
                    <a href="{{ route('portfolio') }}" class="{{ request()->segment(1) == 'portfolio' ? 'active' : '' }}">
                        <i class="fa fa-suitcase"></i> {{ __('portfolio') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('about-us') }}" class="{{ request()->segment(1) == 'about-us' ? 'active' : '' }}">
                        <i class="fa fa-users"></i> {{ __('about') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('blogs') }}" class="{{ request()->segment(1) == 'blogs' ? 'active' : '' }}">
                        <i class="fas fa-pen-nib"></i> {{ __('blog') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="{{ request()->segment(1) == 'contact' ? 'active' : '' }}">
                        <i class="fas fa-phone"></i> {{ __('contact') }}
                    </a>
                </li>
            </ul>

        </nav>
        <!-- End Mainmanu Nav -->
    </div>
    <div class="header-action">
        <ul class="list-unstyled">

            <li class="lang-select-container d-lg-block d-none" style="position: relative; width: 50px;">
                <div class="selected-lang" onclick="toggleLangDropdown()" style="cursor: pointer;">
                    {{ strtoupper(app()->getLocale()) }}
                </div>
                <ul class="lang-list" id="langDropdown" style="display: none;">
                    @foreach($languages as $language)
                    @if(app()->getLocale() != $language->lang)
                    <li onclick="changeLang('{{ $language->lang }}')">
                        {{ strtoupper($language->lang) }}
                    </li>
                    @endif
                    @endforeach
                </ul>
            </li>


            <li class="my_switcher d-lg-block d-none">
                <ul>
                    <li title="Light Mode">
                        <a href="javascript:void(0)" class="setColor light" data-theme="light">
                            <i class="fal fa-lightbulb-on"></i>
                        </a>
                    </li>
                    <li title="Dark Mode">
                        <a href="javascript:void(0)" class="setColor dark" data-theme="dark">
                            <i class="fas fa-moon"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidemenu-btn d-lg-block d-none">
                <button class="btn-wrap" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasMenuRight">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </li>
            <li class="mobile-menu-btn sidemenu-btn d-lg-none d-block">
                <button class="btn-wrap" data-bs-toggle="offcanvas"
                    data-bs-target="#mobilemenu-popup">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </li>
            <li class="my_switcher d-lg-none d-block">
                <ul>
                    <li title="Light Mode">
                        <a href="javascript:void(0)" class="setColor light" data-theme="light">
                            <i class="fal fa-lightbulb-on"></i>
                        </a>
                    </li>
                    <li title="Dark Mode">
                        <a href="javascript:void(0)" class="setColor dark" data-theme="dark">
                            <i class="fas fa-moon"></i>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    </div>
    </div>
    </div>
    </header>
    --}}
    @yield('content')
    <!--=====================================-->
    <!--=        Footer Area Start       	=-->
    <!--=====================================-->
    <footer class="footer-area">
        <div class="container">
            <div class="footer-top">
                <div class="footer-social-link">
                    <ul class="list-unstyled">
                        @foreach ($socialmedia as $media)
                        <li><a href="{{ $media->link }}" target="_blnck" data-sal="slide-up"
                                data-sal-duration="500" data-sal-delay="100">
                                <i class="{{ $media->icon }}"></i></a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="footer-main">
                <div class="row">
                    <div class="col-xl-6 col-lg-5" data-sal="slide-right" data-sal-duration="800"
                        data-sal-delay="100">
                        <div class="footer-widget border-end">
                            <div class="footer-newsletter">
                                <h2 class="title">{{ __('front.footer.get_in_touch') }}</h2>
                                <p>Fusce varius, dolor tempor interdum tristique, dui urna bib
                                    endum magna, ut ullamcorper purus</p>
                                <form>
                                    <div class="input-group">
                                        <input type="email" class="form-control" placeholder="Email address">
                                        <button class="subscribe-btn" type="submit">{{__('subscribe')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-7" data-sal="slide-left" data-sal-duration="800"
                        data-sal-delay="100">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="footer-widget">
                                    <h6 class="widget-title">{{__('services')}}</h6>
                                    <div class="footer-menu-link">
                                        <ul class="list-unstyled">
                                            @foreach ($main_services as $service)
                                            <li><a
                                                    href="{{ route('services') }}#{{ $service->name }}">{{ $service?->name }}</a>
                                            </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="footer-widget">
                                    <h6 class="widget-title">Resourses</h6>
                                    <div class="footer-menu-link">
                                        <ul class="list-unstyled">
                                            <li><a href="{{ route('blogs') }}">{{__('blog')}}</a></li>
                                            <li><a href="{{ route('portfolio') }}">{{__('portfolio')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="footer-widget">
                                    <h6 class="widget-title">{{__("Suport")}}</h6>
                                    <div class="footer-menu-link">
                                        <ul class="list-unstyled">
                                            <li><a href="{{ route('contact') }}">{{__("contact")}}</a></li>
                                            <li><a href="privacy-policy.html">Privacy Policy</a></li>
                                            <li><a href="terms-of-use.html">Terms of Use</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom" data-sal="slide-up" data-sal-duration="500" data-sal-delay="100">
                <div class="row">
                    <div class="col-md-6">
                        <div class="footer-copyright">
                            <div class="live-status">
                                <span class="live-dot" aria-hidden="true"></span>
                                <span>Live Status</span>
                            </div>
                            <span class="copyright-text">&copy; <?= date('Y') ?>. All rights reserved .</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="footer-bottom-link">
                            <ul class="list-unstyled">
                                <li><a href="privacy-policy.html">Privacy Policy</a></li>
                                <li><a href="terms-of-use.html">Terms of Use</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="offcanvas offcanvas-end header-offcanvasmenu" tabindex="-1" id="offcanvasMenuRight">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row ">
                <div class="col-lg-5 col-xl-6">
                    <ul class="main-navigation list-unstyled">
                        <li><a href="index-1.html">Digital Agency</a></li>
                        <li><a href="index-2.html">Creative Agency</a></li>
                        <li><a href="index-3.html">Personal Portfolio</a></li>
                        <li><a href="index-4.html">Home Startup</a></li>
                        <li><a href="index-5.html">Corporate Agency</a></li>
                    </ul>
                </div>
                <div class="col-lg-7 col-xl-6">
                    <div class="contact-info-wrap">
                        <div class="contact-inner">
                            <address class="address">
                                <span class="title">Contact Information</span>
                                <p>{{ \App\Models\Setting::getValue('contact_address') ?? 'Address not set' }}</p>
                            </address>
                            <address class="address">
                                <span class="title">We're Available 24/7. Call Now.</span>
                                <a class="tel" href="tel:{{ \App\Models\Setting::getValue('contact_phone') }}"><i class="fas fa-phone"></i>{{ \App\Models\Setting::getValue('contact_phone') ?? '+000 000 00 00' }}</a>
                                <a class="tel" href="mailto:{{ \App\Models\Setting::getValue('contact_email') }}"><i class="fas fa-envelope"></i>{{ \App\Models\Setting::getValue('contact_email') ?? 'info@example.com' }}</a>
                            </address>
                        </div>
                        <div class="contact-inner">
                            <h5 class="title">{{ __('front.footer.find_us') }}</h5>
                            <div class="contact-social-share">
                                <ul class="social-share list-unstyled">
                                    @if(\App\Models\Setting::getValue('social_facebook'))
                                    <li><a href="{{ \App\Models\Setting::getValue('social_facebook') }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                    @endif
                                    @if(\App\Models\Setting::getValue('social_twitter'))
                                    <li><a href="{{ \App\Models\Setting::getValue('social_twitter') }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                    @endif
                                    @if(\App\Models\Setting::getValue('social_linkedin'))
                                    <li><a href="{{ \App\Models\Setting::getValue('social_linkedin') }}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                    @endif
                                    @if(\App\Models\Setting::getValue('social_instagram'))
                                    <li><a href="{{ \App\Models\Setting::getValue('social_instagram') }}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                    @endif
                                    @if(\App\Models\Setting::getValue('social_youtube'))
                                    <li><a href="{{ \App\Models\Setting::getValue('social_youtube') }}" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @include('front.layouts.partials.cookie-consent')

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
    <script src="{{ asset('assets/js/vendor/jquery.style.switcher.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/tilt.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/green-audio-player.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.nav.js') }}"></script>
    <script>
        function changeLang(lang) {
            var langToggle = document.getElementById('mobile-lang-toggle') || document.getElementById('lang-btn');
            if(langToggle) {
                langToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    var current = this.getAttribute('data-current-lang');
                    var lang = current === 'AZ' ? 'en' : (current === 'EN' ? 'ru' : 'az');
                    var urls = {
                        'az': "{!! LaravelLocalization::getLocalizedURL('az') !!}",
                        'en': "{!! LaravelLocalization::getLocalizedURL('en') !!}",
                        'ru': "{!! LaravelLocalization::getLocalizedURL('ru') !!}"
                    };
                    window.location.href = urls[lang];
                });
            }   
        }
    </script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <!-- Site Scripts -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

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
        // Native lazy-loading fallback: tag all images (except logo variants) with loading=lazy if not set
        (function() {
            const imgs = document.querySelectorAll('img');
            imgs.forEach((img) => {
                const isLogo = img.classList.contains('light-version-logo') || img.classList.contains('dark-version-logo') || img.classList.contains('sticky-logo');
                if (!img.hasAttribute('loading') && !isLogo) {
                    img.setAttribute('loading', 'lazy');
                }
                if (!img.hasAttribute('decoding')) {
                    img.setAttribute('decoding', 'async');
                }
            });
        })();
    </script>
    <script>
        (function() {
            const bar = document.getElementById('scroll-progress');
            const updateScrollProgress = () => {
                if (!bar) return;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = height > 0 ? (window.pageYOffset / height) * 100 : 0;
                bar.style.width = scrolled + '%';
            };
            if (bar) {
                updateScrollProgress();
                window.addEventListener('scroll', updateScrollProgress, {
                    passive: true
                });
                window.addEventListener('resize', updateScrollProgress);
            }

            const html = document.documentElement;
            const body = document.body;
            const readCookieTheme = () => (window.Cookies ? Cookies.get('styleCookieName') : null);
            const applyTheme = (theme, persist = true) => {
                const next = theme === 'dark' ? 'dark' : 'light';
                html.setAttribute('data-theme', next);
                body.classList.toggle('active-dark-mode', next === 'dark');
                body.classList.toggle('active-light-mode', next === 'light');
                if (persist && window.Cookies) {
                    Cookies.set('styleCookieName', next, {
                        expires: 7
                    });
                }
            };
            const current = readCookieTheme() ||
                (body.classList.contains('active-dark-mode') ? 'dark' : body.classList.contains('active-light-mode') ? 'light' : null) ||
                html.getAttribute('data-theme') ||
                'light';
            applyTheme(current, false);
            document.addEventListener('click', (event) => {
                const toggle = event.target.closest('.setColor');
                if (!toggle) return;
                const next = toggle.dataset.theme;
                if (next) applyTheme(next);
            });
        })();
    </script>
    @include('front.layouts.partials.scroll_to_top')
    <script src="{{ asset('assets/js/chalang-preview.js?v=') . time() }}"></script>
</body>


</html>