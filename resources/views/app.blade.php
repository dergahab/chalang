@php
    $themeCookie = request()->cookie('styleCookieName', 'light');
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $themeCookie }}" data-theme="{{ $themeCookie }}">
<head>
    <meta charset="utf-8">
    <script>
        (function() {
            const cookieName = 'styleCookieName';
            const match = document.cookie.match(new RegExp('(^| )' + cookieName + '=([^;]+)'));
            // Default 'dark' — ThemeProvider.tsx ilə sinxron (.cursorrules §4.3)
            const theme = match ? match[2] : 'dark';
            document.documentElement.setAttribute('data-theme', theme);
            document.documentElement.classList.remove('dark', 'light');
            document.documentElement.classList.add(theme);

            // prefers-reduced-motion (id: 810) — sistem animasiya azaltma
            if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                document.documentElement.classList.add('reduced-motion');
            }
        })();
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icons (Font Awesome 6.4 - required for social media icons in About) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<!-- LEGACY CSS (Shared with React for 1:1 parity) - Skip for React routes -->
    
    <link rel="stylesheet" href="{{ asset('assets/css/chalang-core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/chalang-preview.css') }}">


    <!-- Dynamic Styles from Admin (colors, fonts, radius) -->
    @include('front.layouts.partials.dynamic-styles')

    <!-- Error Logger (Temporary) -->
    <script>
        window.onerror = function(message, source, lineno, colno, error) {
            // ResizeObserver browser-in daxili davranışıdır, layihə xətası deyil — filtr et
            if (typeof message === 'string' && message.includes('ResizeObserver')) return true;
            const errorContainer = document.createElement('div');
            errorContainer.style.position = 'fixed';
            errorContainer.style.top = '0';
            errorContainer.style.left = '0';
            errorContainer.style.width = '100%';
            errorContainer.style.background = 'red';
            errorContainer.style.color = 'white';
            errorContainer.style.padding = '20px';
            errorContainer.style.zIndex = '999999';
            errorContainer.innerHTML = `<h3>Javascript Error:</h3><p>${message}</p><p>${source}:${lineno}:${colno}</p>`;
            document.body.appendChild(errorContainer);
        };
    </script>

    <!-- Scripts -->

    @viteReactRefresh
    @vite(['resources/js/app.tsx'])

    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
