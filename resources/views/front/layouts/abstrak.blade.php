<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="{{ request()->cookie('styleCookieName', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Chalang')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Questrial&display=swap&subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/chalang-preview.css') }}">
    @include('front.layouts.partials.dynamic-styles')
    @include('front.layouts.partials.analytics')
    @stack('css')
</head>
<body>
    <div id="scroll-progress"></div>
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>
    <div class="noise-overlay"></div>
    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <div class="mobile-nav" id="mobile-nav">
        <button class="close-btn" id="close-menu" aria-label="{{ __('Close menu') }}">
            <svg width="32" height="32" viewBox="0 0 24 24"><path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" fill="currentColor"/></svg>
        </button>
        <ul>
            <li><a href="{{ route('/') }}">{{ __('front.home') }}</a></li>
            <li><a href="{{ route('preview.services') }}">{{ __('services') }}</a></li>
            <li><a href="{{ route('preview.portfolio') }}">{{ __('portfolio') }}</a></li>
            <li><a href="{{ route('case-study.index') }}">Case Studies</a></li>
            <li><a href="{{ route('preview.about-us') }}">{{ __('about') }}</a></li>
            <li><a href="{{ route('preview.blogs') }}">{{ __('blog') }}</a></li>
           <li><a href="{{ route('preview.contact') }}">{{ __('contact') }}</a></li>
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
            Dark Mode
        </button>
        </div>
    </div>

        <div class="search-overlay" id="search-overlay">
        <div class="search-container">
            <div class="search-header">
                <svg class="search-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    <path d="M19 1 17.75 3.75 15 5l2.75 1.25L19 9l1.25-2.75L23 5l-2.75-1.25L19 1z"/>
                </svg>
                <input type="text" class="search-input" id="search-input" placeholder="{{ __('preview.search.placeholder') }}" data-lang-placeholder="search_placeholder">
                <button class="search-close" id="search-close">{{ __('preview.search.close') }}</button>
            </div>
            <div class="search-results" id="search-results"></div>
        </div>
    </div>


    <div class="navbar-container">
        <div class="nav-island island-left">
            <a href="{{ route('/') }}" aria-label="Chalang">
                <svg class="logo-svg" viewBox="0 0 81.87 15.74">
                    <g>
                        <path fill="currentColor" d="M25.7,5.95c-.49-.62-1.3-1.22-2.46-1.22-1.96,0-3.33,1.59-3.33,3.31,0,1.84,1.46,3.38,3.34,3.38.87,0,1.75-.34,2.36-1.14h2.11c-.81,1.72-2.38,2.9-4.52,2.9-3.43,0-5.1-2.89-5.1-5.14s1.66-5.07,5.13-5.07c2.03,0,3.72,1.1,4.54,2.98h-2.07Z"/>
                        <path fill="currentColor" d="M28.72,3.14h1.82v3.93h3.58v-3.93h1.82v9.8h-1.82v-4.11h-3.58v4.11h-1.82V3.14Z"/>
                        <path fill="currentColor" d="M40.67,3.14h1.46l4.08,9.8h-2l-1.01-2.53h-3.6l-1.01,2.53h-2l4.08-9.8ZM42.51,8.65l-1.11-2.86-1.11,2.86h2.23Z"/>
                        <path fill="currentColor" d="M46.89,3.14h1.82v8.04h2.99v1.76h-4.81V3.14Z"/>
                        <path fill="currentColor" d="M56.09,3.14h1.46l4.08,9.8h-2l-1.01-2.53h-3.6l-1.01,2.53h-2l4.08-9.8ZM57.93,8.65l-1.11-2.86-1.11,2.86h2.23Z"/>
                        <path fill="currentColor" d="M62.3,3.14h1.82l4.37,6.62V3.14h1.82v9.8h-1.82l-4.37-6.62v6.62h-1.82V3.14Z"/>
                        <path fill="currentColor" d="M81.87,7.95c-.03,2.33-1.46,5.23-5.21,5.23s-5.23-2.72-5.23-5.07,1.78-5.14,5.21-5.14c2.25,0,4.01,1.14,4.74,3.06h-2.17c-.76-1.25-2.11-1.3-2.57-1.3-2.29,0-3.39,1.78-3.39,3.31,0,1.67,1.22,3.38,3.47,3.38,1.19,0,2.33-.54,2.86-1.76h-4.09v-1.71h6.39Z"/>
                        <path fill="currentColor" d="M8.88.03C3.91-.37-.27,3.73.01,8.7c.18,3.15,2.14,5.82,4.88,7.04.02,0,.04-.02.03-.03-.22-.3-.35-.68-.35-1.08,0-.87.6-1.6,1.41-1.8.02,0,.02-.03,0-.04-1.88-.92-3.1-2.96-2.8-5.26.27-2.08,2.21-4.04,4.29-4.34,3.14-.44,5.82,1.98,5.82,5.03,0,2-1.16,3.74-2.85,4.56-.02,0-.02.04,0,.04.81.2,1.41.93,1.41,1.8,0,.4-.13.77-.34,1.08-.01.02,0,.04.03.03,2.88-1.28,4.89-4.16,4.89-7.52C16.44,3.9,13.11.36,8.88.03Z"/>
                        <path fill="currentColor" d="M8.23,13.3l.19.37c.14.28.36.5.64.64l.37.19s.01.02,0,.03l-.37.19c-.28.14-.5.36-.64.64l-.19.37s-.02.01-.03,0l-.19-.37c-.14-.28-.36-.5-.64-.64l-.37-.19s-.01-.02,0-.03l.37-.19c.28-.14.5-.36.64-.64l.19-.37s.02-.01.03,0Z"/>
                    </g>
                </svg>
            </a>
        </div>
        <div class="nav-island island-center nav-desktop">
            <ul>
                <li class="{{ request()->segment(1) === null ? 'active' : '' }}"><a href="{{ route('/') }}" data-lang="nav_home"><svg viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg><span>{{ __('front.home') }}</span></a></li>
                <li><a href="{{ route('preview.services') }}" data-lang="nav_services"><svg viewBox="0 0 24 24"><path d="M12 2 2 7l10 5 10-5-10-5zm0 9 2.5-1.25L12 8.5 9.5 9.75 12 11zm0 2.5-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg><span>{{ __('services') }}</span></a></li>
                <li><a href="{{ route('preview.portfolio') }}" data-lang="nav_portfolio"><svg viewBox="0 0 24 24"><path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z"/></svg><span>{{ __('portfolio') }}</span></a></li>
                <li><a href="{{ route('case-study.index') }}" data-lang="nav_case"><svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg><span>Case Studies</span></a></li>
                <li><a href="{{ route('preview.about-us') }}" data-lang="nav_about"><svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg><span>{{ __('about') }}</span></a></li>
                <li><a href="{{ route('preview.blogs') }}" data-lang="nav_blog"><svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg><span>{{ __('blog') }}</span></a></li>
                <li><a href="{{ route('preview.contact') }}" data-lang="nav_contact"><svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/></svg><span>{{ __('contact') }}</span></a></li>
            </ul>
        </div>
        <div class="nav-island island-right controls">
            <button class="control-btn" id="search-toggle" aria-label="{{ __('Search') }}" aria-expanded="false">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/><path d="M19 1 17.75 3.75 15 5l2.75 1.25L19 9l1.25-2.75L23 5l-2.75-1.25L19 1z"/></svg>
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
        <button id="mobile-menu-toggle" aria-label="{{ __('Open menu') }}" aria-expanded="false"><svg viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg></button>
    </div>

    @yield('content')

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
                <button class="ai-send" id="ai-send" aria-label="{{ __('Send') }}" type="button"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M2.01 21 23 12 2.01 3 2 10l15 2-15 2z"/></svg></button>
            </div>
        </div>
        <button class="ai-trigger" id="ai-trigger" aria-label="Chalang AI"><svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor"><path d="M19 9.3V4h-3v2.6L12 3 2 12h3v8h5v-6h4v6h5v-8h3l-3-2.7zm-9 .7c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2z"/></svg></button>
    </div>

    <footer>
        <div class="footer-grid">
            @php $footerText = __('front.footer.get_in_touch'); @endphp
            <div class="footer-col"><h4>CHALANG</h4><p>{{ $footerText !== 'front.footer.get_in_touch' ? $footerText : 'Gələcəyi dizayn edirik.' }}</p></div>
            <div class="footer-col"><h4>{{ __('contact') }}</h4><p>{{ config('mail.from.address', 'hello@chalang.com') }}</p></div>
            <div class="footer-col"><h4>{{ __('services') }}</h4>
                <ul>
                    <li><a href="{{ route('preview.services') }}">Bütün Xidmətlər</a></li>
            <div class="ai-input-group">
                <input type="text" class="ai-input" id="ai-input" placeholder="Sual verin..." aria-label="AI sualı">
                <button class="ai-send" id="ai-send" aria-label="{{ __('Send') }}" type="button"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M2.01 21 23 12 2.01 3 2 10l15 2-15 2z"/></svg></button>
            </div>
        </div>
        <button class="ai-trigger" id="ai-trigger" aria-label="Chalang AI"><svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor"><path d="M19 9.3V4h-3v2.6L12 3 2 12h3v8h5v-6h4v6h5v-8h3l-3-2.7zm-9 .7c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2z"/></svg></button>
    </div>

    <footer>
        <div class="footer-grid">
            @php $footerText = __('front.footer.get_in_touch'); @endphp
            <div class="footer-col"><h4>CHALANG</h4><p>{{ $footerText !== 'front.footer.get_in_touch' ? $footerText : 'Gələcəyi dizayn edirik.' }}</p></div>
            <div class="footer-col"><h4>{{ __('contact') }}</h4><p>{{ config('mail.from.address', 'hello@chalang.com') }}</p></div>
            <div class="footer-col"><h4>{{ __('services') }}</h4>
                <ul>
                    <li><a href="{{ route('preview.services') }}">Bütün Xidmətlər</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">&copy; {{ now()->year }} Chalang Group.</div>
    </footer>

    @include('front.layouts.partials.cookie-consent')
    @include('front.layouts.partials.scroll_to_top')

    <script src="{{ asset('assets/js/vendor/js.cookie.js') }}"></script>
    <script src="{{ asset('assets/js/chalang-preview.js') }}"></script>
    @stack('js')
</body>
</html>
