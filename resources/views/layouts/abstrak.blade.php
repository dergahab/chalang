<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/media/favicon.png') }}">
    
    <title>@yield('title', 'Abstrak - Creative Agency')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/sal.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/green-audio-player.min.css') }}">
    
    <!-- Site Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <!-- CHALANG V2.0 GLOBAL (Preview System) -->
    <link rel="stylesheet" href="{{ asset('assets/css/chalang-preview.css') }}">

    @stack('styles')
</head>

<body class="sticky-header">
    @include('front.layouts.partials.scroll_to_top')


    <!-- Preloader Start Here -->
    <div id="preloader-wrapper"></div>
    <!-- Preloader End Here -->
    
    <div id="scroll-progress"></div>

    <div class="my_switcher d-none d-lg-block">
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
    </div>

    <div id="main-wrapper" class="main-wrapper">

        <!-- Header -->
        <x-layout.header />

        @yield('content')

        <!-- Footer -->
        <x-layout.footer />

        <!-- Offcanvas Menu -->
        <x-layout.offcanvas />

    </div>

    <!-- JS -->
    <script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/imagesloaded.pkgd.min.js') }}"></script>
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

    <!-- Site Scripts -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <!-- CHALANG V2.0 GLOBAL (Preview System) -->
    <script src="{{ asset('assets/js/chalang-preview.js') }}"></script>
    <script>
        // Inline Progress Bar Logic for Global Layout
        window.onscroll = function() {
            let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            let scrolled = (winScroll / height) * 100;
            const bar = document.getElementById('scroll-progress');
            if(bar) bar.style.width = scrolled + '%';
        };
    </script>

    @stack('scripts')
</body>
</html>
