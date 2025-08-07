<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Chalang</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/media/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css?v=') . time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/font-awesome.css?v=') . time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/sal.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css?v=') . time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/magnific-popup.css?v=') . time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/green-audio-player.min.css?v=') . time() }}">

    <!-- Site Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body class="sticky-header">

    <a href="#main-wrapper" id="backto-top" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Preloader Start Here -->
    <div id="preloader-wrapper">
        <div class="spinner"></div>
    </div>    <!-- Preloader End Here -->

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
        <header class="header axil-header header-style-1">
            <div id="axil-sticky-placeholder"></div>
            <div class="axil-mainmenu">
                <div class="container">
                    <div class="header-navbar">
                        <div class="header-logo" style="width: 10% !immortant">
                            <a href="{{ route('/') }}">
                                <img class="light-version-logo" style="width: 85% !important"
                                    src="{{ asset('assets/media/logo.svg') }}" alt="logo">
                            </a>
                            <a href="{{ route('/') }}">
                                <img class="dark-version-logo" style="width: 85% !important;"
                                    src="{{ asset('assets/media/logo.svg') }}" alt="logo">
                            </a>
                            <a href="{{ route('/') }}">
                                <img class="sticky-logo" style="width: 85% !important;"
                                    src="{{ asset('assets/media/logo.svg') }}" alt="logo">
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
                                                    src="{{ asset('assets/media/logo-2.svg') }}" alt="Site Logo">
                                                <img class="dark-mode" width="85%"
                                                    src="{{ asset('assets/media/logo-3.svg') }}" alt="Site Logo">
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
                                        <a href="{{ route('cuntuct-us') }}" class="{{ request()->segment(1) == 'contact' ? 'active' : '' }}">
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


                                <li class="  my_switcher d-lg-block d-none">
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
                                <li class="mobile-menu-btn sidemenu-btn d-lg-none d-block">
                                    <button class="btn-wrap" data-bs-toggle="offcanvas"
                                        data-bs-target="#mobilemenu-popup">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </button>
                                </li>
                                <li class="my_switcher d-lg-block d-lg-none">
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
                                                <li><a href="{{ route('cuntuct-us') }}">{{__("contact")}}</a></li>
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
                                    <p>Theodore Lowe, Ap #867-859 <br> Sit Rd, Azusa New York</p>
                                </address>
                                <address class="address">
                                    <span class="title">We're Available 24/7. Call Now.</span>
                                    <a class="tel" href="tel:8884562790"><i class="fas fa-phone"></i>(888)
                                        456-2790</a>
                                    <a class="tel" href="tel:12125553333"><i class="fas fa-fax"></i>(121)
                                        255-53333</a>
                                </address>
                            </div>
                            <div class="contact-inner">
                                <h5 class="title">{{ __('front.footer.find_us') }}</h5>
                                <div class="contact-social-share">
                                    <ul class="social-share list-unstyled">
                                        <li><a href="../../../index.htm"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="../../../index-1.htm"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="../../../index-7.htm"><i class="fab fa-behance"></i></a></li>
                                        <li><a href="../../../index-3.htm"><i class="fab fa-linkedin-in"></i></a></li>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.4/imagesloaded.pkgd.min.js"></script>

    <script src="{{ asset('assets/js/vendor/isotope.pkgd.min.js?v=') . time() }}"></script>
    <script src="{{ asset('assets/js/vendor/imagesloaded.pkgd.min.js?v=') . time() }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js?v=') . time() }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js?v=') . time() }}"></script>
    <script src="{{ asset('assets/js/vendor/waypoints.min.js?v=') . time() }}"></script>
    <script src="{{ asset('assets/js/vendor/counterup.js?v=') . time() }}"></script>
    <script src="{{ asset('assets/js/vendor/slick.min.js?v=') . time() }}"></script>
    <script src="{{ asset('assets/js/vendor/sal.js?v=') . time() }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.magnific-popup.min.js?v=') . time() }}"></script>
    <script src="{{ asset('assets/js/vendor/js.cookie.js?v=') . time() }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.style.switcher.js?v=') . time() }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.countdown.min.js?v=') . time() }}"></script>
    <script src="{{ asset('assets/js/vendor/tilt.js?v=') . time() }}"></script>
    <script src="{{ asset('assets/js/vendor/green-audio-player.min.js?v=') . time() }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.nav.js?v=') . time() }}"></script>
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
    <script src="{{ asset('assets/js/app.js?v=') . time() }}"></script>
    <script src="{{ asset('assets/js/custom.js?v=') . time() }}"></script>

    @stack('js_script')
<script>
    window.addEventListener("load", function () {
        const preloader = document.getElementById("preloader-wrapper");
        if (preloader) {
            preloader.style.opacity = "0";
            preloader.style.visibility = "hidden";
            preloader.style.transition = "opacity 0.5s ease-out";
        }
    });
</script>
</body>

</html>
