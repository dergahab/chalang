<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', config('app.name', 'Chalang'))</title>
    <meta name="description" content="@yield('meta_description', __('front.meta.default_description'))">
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
    <link rel="stylesheet" href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/fontawesome-free-6.2.0-web/css/all.min.css') }}">

    <script src="{{ asset('vendor/fancybox/fancybox.umd.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('vendor/fancybox/fancybox.css') }}" />
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        window.changeLangUrlTemplate = "{{ route('lang.change', ['lang' => ':lang']) }}";
    </script>


</head>

<body class="sticky-header">
    @php
        $siteSettings = $siteSettings ?? [
            'name' => config('app.name', 'Chalang'),
            'tagline' => null,
            'email' => null,
            'phone' => null,
            'address' => null,
            'logo' => asset('assets/media/logo.svg'),
            'social' => [],
        ];
        $configuredSocial = array_filter($siteSettings['social'] ?? []);
        $availableLanguages = $languages ?? collect();
        $socialMediaRecords = $socialmedia ?? collect();
    @endphp

    <a href="#main-wrapper" id="backto-top" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->

    {{-- <div class="my_switcher d-none d-lg-block">
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
    </div> --}}

    <div id="main-wrapper" class="main-wrapper">

        <!--=====================================-->
        <!--=        Header Area Start       	=-->
        <!--=====================================-->
        @php
            $menuCollection = collect($headerMenu ?? collect());
            $fallbackMenu = [
        [
            'route' => '/',
            'label' => __('front.navigation.home'),
            'icon' => 'fa-solid fa-house',
        ],
        [
            'route' => 'services',
            'label' => __('front.navigation.services'),
            'icon' => 'fa-solid fa-briefcase',
        ],
        [
            'route' => 'portfolio',
            'label' => __('front.navigation.portfolio'),
            'icon' => 'fa-solid fa-images',
        ],
        [
            'route' => 'about-us',
            'label' => __('front.navigation.about'),
            'icon' => 'fa-solid fa-user-group',
        ],
        [
            'route' => 'blogs',
            'label' => __('front.navigation.blog'),
            'icon' => 'fa-solid fa-pen-nib',
        ],
        [
            'route' => 'contact',
            'label' => __('front.navigation.contact'),
            'icon' => 'fa-solid fa-phone',
        ],
            ];
        @endphp

        <header class="site-header glassy-header" id="site-header">
            <div class="container nav-shell">
                <div class="brand-area">
                    <a href="{{ route('/') }}" class="brand-link">
                        <img src="{{ $siteSettings['logo'] ?? asset('assets/media/logo.svg') }}" alt="{{ config('app.name', 'Chalang') }}" class="brand-logo">
                    </a>
                    <button class="menu-toggle d-lg-none" id="mobileNavToggle" aria-label="{{ __('Toggle menu') }}">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
                <nav class="primary-nav d-none d-lg-flex">
                    @include('front.layouts.partials.menu-list', [
                        'menuCollection' => $menuCollection,
                        'fallbackMenu' => $fallbackMenu,
                        'listClass' => 'nav-list bubble-nav'
                    ])
                </nav>
                <div class="nav-actions">
                    @php
                        $languageIcons = [
                            'az' => 'fa-solid fa-flag',
                            'en' => 'fa-solid fa-globe',
                            'ru' => 'fa-solid fa-earth-europa',
                        ];
                    @endphp
                    <div class="lang-select-container d-none d-lg-block">
                        <button id="langDropdownButton" class="selected-lang" aria-haspopup="listbox"
                            aria-expanded="false" aria-controls="langDropdown" title="{{ __('select_language') }}">
                            {{ strtoupper(app()->getLocale()) }}
                        </button>
                        <ul class="lang-list" id="langDropdown" role="listbox" aria-labelledby="langDropdownButton">
                            @foreach($availableLanguages as $language)
                                @if(app()->getLocale() != $language->lang)
                                    <li role="option">
                                        <button class="lang-option" type="button" onclick="changeLang('{{ $language->lang }}')" title="{{ $language->lang }}">
                                            <i class="{{ $languageIcons[$language->lang] ?? 'fa-solid fa-globe' }}"></i>
                                            <span>{{ strtoupper($language->lang) }}</span>
                                        </button>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="theme-switcher d-none d-lg-flex">
                        <button class="theme-btn" id="themeToggleButton" aria-haspopup="listbox" aria-expanded="false" aria-controls="themeDropdown">
                            <i class="fas fa-adjust"></i>
                        </button>
                        <ul class="theme-dropdown" id="themeDropdown" role="listbox" aria-labelledby="themeToggleButton">
                            <li class="theme-toggle">
                                <a href="javascript:void(0)" class="setColor light" data-theme="light" aria-label="{{ __('light_mode') }}">
                                    <i class="fal fa-lightbulb-on"></i>
                                </a>
                                <a href="javascript:void(0)" class="setColor dark" data-theme="dark" aria-label="{{ __('dark_mode') }}">
                                    <i class="fas fa-moon"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <div class="mobile-nav-overlay" id="mobileNav" aria-hidden="true">
            <div class="mobile-nav-panel">
                <div class="mobile-nav-header">
                    <a href="{{ route('/') }}" class="brand-link">
                        <img src="{{ $siteSettings['logo'] ?? asset('assets/media/logo.svg') }}" alt="{{ config('app.name', 'Chalang') }}">
                    </a>
                    <button class="mobile-nav-close" id="mobileNavClose" aria-label="{{ __('Close menu') }}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="mobile-nav-body">
                    @include('front.layouts.partials.menu-list', [
                        'menuCollection' => $menuCollection,
                        'fallbackMenu' => $fallbackMenu,
                        'listClass' => 'mobile-nav-list'
                    ])
                </nav>
                <div class="mobile-nav-footer">
                    <div class="mobile-lang">
                        <span>{{ __('select_language') }}</span>
                        <div class="mobile-lang-options">
                            @php($currentLocale = app()->getLocale())
                            <button type="button" class="active" disabled>{{ strtoupper($currentLocale) }}</button>
                            @foreach($availableLanguages as $language)
                                @if($language->lang !== $currentLocale)
                                    <button type="button" onclick="changeLang('{{ $language->lang }}')">
                                        <i class="{{ $languageIcons[$language->lang] ?? 'fa-solid fa-globe' }}"></i>
                                        <span>{{ strtoupper($language->lang) }}</span>
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="mobile-theme-switcher">
                        <span>{{ __('theme_mode') }}</span>
                        <div class="mobile-theme-options">
                            <a href="javascript:void(0)" class="setColor light" data-theme="light" aria-label="{{ __('light_mode') }}">
                                <i class="fal fa-lightbulb-on"></i>
                            </a>
                            <a href="javascript:void(0)" class="setColor dark" data-theme="dark" aria-label="{{ __('dark_mode') }}">
                                <i class="fas fa-moon"></i>
                            </a>
                        </div>
                    </div>
                    <div class="mobile-theme-switcher">
                        <span>{{ __('theme_mode') }}</span>
                        <div class="mobile-theme-options">
                            <a href="javascript:void(0)" class="setColor light" data-theme="light" aria-label="{{ __('light_mode') }}">
                                <i class="fal fa-lightbulb-on"></i>
                            </a>
                            <a href="javascript:void(0)" class="setColor dark" data-theme="dark" aria-label="{{ __('dark_mode') }}">
                                <i class="fas fa-moon"></i>
                            </a>
                        </div>
                    </div>
                    <ul class="social-share list-unstyled">
                        @forelse ($configuredSocial as $network => $link)
                            <li><a href="{{ $link }}" target="_blank"><i class="fab fa-{{ $network }}"></i></a></li>
                        @empty
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        @yield('content')
        <!--=====================================-->
        <!--=        Footer Area Start       	=-->
        <!--=====================================-->
        <footer class="footer-area">
            <div class="container">
                <div class="footer-top">
                    <div class="footer-social-link">
                        <ul class="list-unstyled">
                            @if (!empty($configuredSocial))
                                @foreach ($configuredSocial as $network => $link)
                                    <li>
                                        <a href="{{ $link }}" target="_blank" data-sal="slide-up" data-sal-duration="500"
                                            data-sal-delay="100">
                                            <i class="fab fa-{{ $network }}"></i>
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                @foreach ($socialMediaRecords as $media)
                                    <li><a href="{{ $media->link }}" target="_blnck" data-sal="slide-up"
                                            data-sal-duration="500" data-sal-delay="100">
                                            <i class="{{ $media->icon }}"></i></a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="footer-main">
                    <div class="row">
                        <div class="col-xl-6 col-lg-5" data-sal="slide-right" data-sal-duration="800"
                            data-sal-delay="100">
                            <div class="footer-widget border-end">
                                <div class="footer-newsletter">
                                    @if (session('newsletter_success'))
                                        <div class="alert alert-success">
                                            {{ session('newsletter_success') }}
                                        </div>
                                    @endif
                                    <h2 class="title">{{ __('front.footer.get_in_touch') }}</h2>
                                    <p>{{ $siteSettings['tagline'] ?? __('Xəbərlərimizə abunə olun.') }}</p>
                                    <form action="{{ route('subscribe') }}" method="POST" id="newsletter-form">
                                        @csrf
                                        <div class="input-group">
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Email address" required>
                                            <button class="subscribe-btn" type="submit">{{ __('subscribe') }}</button>
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
                                                @forelse ($footerMenu ?? [] as $footerItem)
                                                    <li><a href="{{ $footerItem->url }}"
                                                            target="{{ $footerItem->target }}">{{ $footerItem->title }}</a></li>
                                                @empty
                                                    <li><a href="{{ route('blogs') }}">{{ __('blog') }}</a></li>
                                                    <li><a href="{{ route('portfolio') }}">{{ __('portfolio') }}</a></li>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="footer-widget">
                                        <h6 class="widget-title">{{__("Suport")}}</h6>
                                        <div class="footer-menu-link">
                                            <ul class="list-unstyled">
                                                <li><a href="{{ route('contact') }}">{{ __('front.contact.title') }}</a></li>
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
                                <span class="copyright-text">© <?= date('Y') ?>. All rights reserved .</span>
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
                            @foreach ($headerMenu ?? [] as $item)
                                <li><a href="{{ $item->url }}" target="{{ $item->target }}">{{ $item->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-7 col-xl-6">
                        <div class="contact-info-wrap">
                            <div class="contact-inner">
                                <address class="address">
                                    <span class="title">{{ __('Contact Information') }}</span>
                                    <p>{{ $siteSettings['address'] }}</p>
                                </address>
                                <address class="address">
                                    <span class="title">{{ __('Əlaqə üçün') }}</span>
                                    @if ($siteSettings['phone'])
                                        @php($plainPhone = preg_replace('/\D+/', '', $siteSettings['phone']))
                                        <a class="tel" href="tel:{{ $plainPhone }}">
                                            <i class="fas fa-phone"></i>{{ $siteSettings['phone'] }}
                                        </a>
                                    @endif
                                    @if ($siteSettings['email'])
                                        <a class="tel" href="mailto:{{ $siteSettings['email'] }}">
                                            <i class="fas fa-envelope"></i>{{ $siteSettings['email'] }}
                                        </a>
                                    @endif
                                </address>
                            </div>
                            <div class="contact-inner">
                                <h5 class="title">{{ __('front.footer.find_us') }}</h5>
                                <div class="contact-social-share">
                                    <ul class="social-share list-unstyled">
                                        @forelse ($configuredSocial as $network => $link)
                                            <li><a href="{{ $link }}" target="_blank"><i
                                                        class="fab fa-{{ $network }}"></i></a></li>
                                        @empty
                                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery Js -->
    <script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/counterup.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/sal.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/js.cookie.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.style.switcher.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const setTheme = function (mode) {
                localStorage.setItem('theme_mode', mode);
                const root = document.documentElement;
                root.classList.toggle('active-dark-mode', mode === 'dark');

                document.querySelectorAll('.setColor').forEach(function (btn) {
                    btn.classList.toggle('active', btn.dataset.theme === mode);
                });
            };

            const storedTheme = localStorage.getItem('theme_mode') || 'light';
            setTheme(storedTheme);

            document.querySelectorAll('.setColor').forEach(function (btn) {
                btn.addEventListener('click', function (event) {
                    event.preventDefault();
                    setTheme(btn.dataset.theme);
                });
            });
        });
    </script>
    <script src="{{ asset('assets/js/theme-switch.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/tilt.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/green-audio-player.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.nav.js') }}"></script>
    <script>
        window.changeLang = function (lang) {
            if (!window.changeLangUrlTemplate) {
                return;
            }

            var url = window.changeLangUrlTemplate.replace(':lang', lang);
            window.location.href = url;
        };

        document.addEventListener('DOMContentLoaded', function () {
            const dropdownButton = document.getElementById('langDropdownButton');
            const dropdownList = document.getElementById('langDropdown');
            const themeButton = document.getElementById('themeToggleButton');
            const themeDropdown = document.getElementById('themeDropdown');
            const mobileToggle = document.getElementById('mobileNavToggle');
            const mobileOverlay = document.getElementById('mobileNav');
            const mobileClose = document.getElementById('mobileNavClose');

            const closeLang = function () {
                if (dropdownList && dropdownButton) {
                    dropdownList.style.display = 'none';
                    dropdownButton.setAttribute('aria-expanded', 'false');
                }
            };

            const closeTheme = function () {
                if (themeDropdown && themeButton) {
                    themeDropdown.style.display = 'none';
                    themeButton.setAttribute('aria-expanded', 'false');
                }
            };

            if (dropdownButton && dropdownList) {
                dropdownButton.addEventListener('click', function (event) {
                    event.stopPropagation();
                    closeTheme();
                    const isOpen = dropdownList.style.display === 'block';
                    dropdownList.style.display = isOpen ? 'none' : 'block';
                    dropdownButton.setAttribute('aria-expanded', String(!isOpen));
                });

                document.addEventListener('click', function (event) {
                    const target = event.target;
                    if (target === dropdownButton || dropdownList.contains(target)) {
                        return;
                    }

                    closeLang();
                });
            }

            if (themeButton && themeDropdown) {
                themeButton.addEventListener('click', function (event) {
                    event.stopPropagation();
                    closeLang();
                    const isOpen = themeDropdown.style.display === 'block';
                    themeDropdown.style.display = isOpen ? 'none' : 'block';
                    themeButton.setAttribute('aria-expanded', String(!isOpen));
                });

                document.addEventListener('click', function (event) {
                    const target = event.target;
                    if (target === themeButton || themeDropdown.contains(target)) {
                        return;
                    }

                    closeTheme();
                });
            }

            if (mobileToggle && mobileOverlay && mobileClose) {
                const setOverlayState = function (isOpen) {
                    mobileOverlay.classList.toggle('is-open', isOpen);
                    mobileOverlay.setAttribute('aria-hidden', String(!isOpen));
                    document.body.classList.toggle('no-scroll', isOpen);
                };

                mobileToggle.addEventListener('click', function () {
                    setOverlayState(true);
                });

                mobileClose.addEventListener('click', function () {
                    setOverlayState(false);
                });

                mobileOverlay.addEventListener('click', function (event) {
                    if (event.target === mobileOverlay) {
                        setOverlayState(false);
                    }
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        setOverlayState(false);
                    }
                });
            }
        });
    </script>
    <!-- Swiper JS -->
    <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Site Scripts -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    @stack('js_script')
</body>
</html>
