@php
// Safe Fallback for $ct helper if it's not defined
if (!isset($ct)) {
$ct = function ($key, $default = '') {
return $default;
};
}
@endphp
<div class="navbar-container">
    <div class="nav-island island-left">
        <a href="{{ route(request()->is('preview*') && !request()->is('preview') ? 'preview' : '/') }}" aria-label="Chalang">
            <svg class="logo-svg" viewBox="0 0 81.87 15.74">
                <g>
                    <path fill="currentColor" d="M25.7,5.95c-.49-.62-1.3-1.22-2.46-1.22-1.96,0-3.33,1.59-3.33,3.31,0,1.84,1.46,3.38,3.34,3.38.87,0,1.75-.34,2.36-1.14h2.11c-.81,1.72-2.38,2.9-4.52,2.9-3.43,0-5.1-2.89-5.1-5.14s1.66-5.07,5.13-5.07c2.03,0,3.72,1.1,4.54,2.98h-2.07Z" />
                    <path fill="currentColor" d="M28.72,3.14h1.82v3.93h3.58v-3.93h1.82v9.8h-1.82v-4.11h-3.58v4.11h-1.82V3.14Z" />
                    <path fill="currentColor" d="M40.67,3.14h1.46l4.08,9.8h-2l-1.01-2.53h-3.6l-1.01,2.53h-2l4.08-9.8ZM42.51,8.65l-1.11-2.86-1.11,2.86h2.23Z" />
                    <path fill="currentColor" d="M46.89,3.14h1.82v8.04h2.99v1.76h-4.81V3.14Z" />
                    <path fill="currentColor" d="M56.09,3.14h1.46l4.08,9.8h-2l-1.01-2.53h-3.6l-1.01,2.53h-2l4.08-9.8ZM57.93,8.65l-1.11-2.86-1.11,2.86h2.23Z" />
                    <path fill="currentColor" d="M62.3,3.14h1.82l4.37,6.62V3.14h1.82v9.8h-1.82l-4.37-6.62v6.62h-1.82V3.14Z" />
                    <path fill="currentColor" d="M81.87,7.95c-.03,2.33-1.46,5.23-5.21,5.23s-5.23-2.72-5.23-5.07,1.78-5.14,5.21-5.14c2.25,0,4.01,1.14,4.74,3.06h-2.17c-.76-1.25-2.11-1.3-2.57-1.3-2.29,0-3.39,1.78-3.39,3.31,0,1.67,1.22,3.38,3.47,3.38,1.19,0,2.33-.54,2.86-1.76h-4.09v-1.71h6.39Z" />
                    <path fill="currentColor" d="M8.88.03C3.91-.37-.27,3.73.01,8.7c.18,3.15,2.14,5.82,4.88,7.04.02,0,.04-.02.03-.03-.22-.3-.35-.68-.35-1.08,0-.87.6-1.6,1.41-1.8.02,0,.02-.03,0-.04-1.88-.92-3.1-2.96-2.8-5.26.27-2.08,2.21-4.04,4.29-4.34,3.14-.44,5.82,1.98,5.82,5.03,0,2-1.16,3.74-2.85,4.56-.02,0-.02.04,0,.04.81.2,1.41.93,1.41,1.8,0,.4-.13.77-.34, 1.08-.01.02,0,.04.03.03,2.88-1.28,4.89-4.16,4.89-7.52C16.44,3.9,13.11.36,8.88.03Z" />
                </g>
            </svg>
        </a>
    </div>
    <div class="nav-island island-center nav-desktop">
        <ul id="site-navigation">
            <!-- HOME -->
            <li class="{{ request()->is('preview') || request()->is('preview/home') ? 'active' : '' }}">
                <a href="{{ route('preview') }}">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg>
                    <span>{{ __('preview.nav.home') }}</span>
                </a>
            </li>

            <!-- COMPANY -->
            <li class="nav-item-dropdown {{ request()->is('preview/about-us') || request()->is('preview/team*') ? 'active' : '' }}">
                <a href="#">
                    <!-- Dynamic Label Logic (Company) -->
                    @if(request()->is('preview/about-us'))
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.about') }}</span>
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.company') }}</span>
                    </span>
                    @elseif(request()->is('preview/team*'))
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.team') }}</span>
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.company') }}</span>
                    </span>
                    @else
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.company') }}</span>
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.company') }}</span>
                    </span>
                    @endif
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('preview.about-us') }}" class="dropdown-item {{ request()->is('preview/about-us') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                        </svg>
                        {{ __('preview.nav.about') }}
                    </a>
                    <a href="{{ route('preview.team.index') }}" class="dropdown-item {{ request()->is('preview/team*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg>
                        {{ __('preview.nav.team') }}
                    </a>
                    <a href="#" class="dropdown-item">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg>
                        {{ __('preview.nav.partners') }}
                    </a>
                    <a href="#" class="dropdown-item">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z" />
                        </svg>
                        {{ __('preview.nav.legal') }}
                    </a>
                </div>
            </li>

            <!-- SOLUTIONS -->
            <li class="nav-item-dropdown {{ request()->is('preview/services*') || request()->is('preview/packages*') ? 'active' : '' }}">
                <a href="#">
                    <!-- Dynamic Label Logic -->
                    @if(request()->is('preview/services*'))
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.services') }}</span>
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2 2 7l10 5 10-5-10-5zm0 9 2.5-1.25L12 8.5 9.5 9.75 12 11zm0 2.5-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.solutions') }}</span>
                    </span>
                    @elseif(request()->is('preview/packages*'))
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21 8V7l-9-4-9 4v1l9 4 9-4zm-9 6-9-4v7l9 4 9-4v-7l-9 4z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.products') }}</span>
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2 2 7l10 5 10-5-10-5zm0 9 2.5-1.25L12 8.5 9.5 9.75 12 11zm0 2.5-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.solutions') }}</span>
                    </span>
                    @else
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2 2 7l10 5 10-5-10-5zm0 9 2.5-1.25L12 8.5 9.5 9.75 12 11zm0 2.5-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.solutions') }}</span>
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2 2 7l10 5 10-5-10-5zm0 9 2.5-1.25L12 8.5 9.5 9.75 12 11zm0 2.5-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.solutions') }}</span>
                    </span>
                    @endif
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('preview.services') }}" class="dropdown-item {{ request()->is('preview/services*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" />
                        </svg>
                        {{ __('preview.nav.services') }}
                    </a>
                    <a href="{{ route('preview.packages') }}" class="dropdown-item {{ request()->is('preview/packages*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21 8V7l-9-4-9 4v1l9 4 9-4zm-9 6-9-4v7l9 4 9-4v-7l-9 4z" />
                        </svg>
                        {{ __('preview.nav.products') }}
                    </a>
                    <a href="#" class="dropdown-item">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
                        </svg>
                        {{ __('preview.nav.industries') }}
                    </a>
                </div>
            </li>

            <!-- WORK -->
            <li class="nav-item-dropdown {{ request()->is('preview/portfolio*') || request()->is('preview/case-studies*') ? 'active' : '' }}">
                <a href="#">
                    <!-- Dynamic Label Logic -->
                    @if(request()->is('preview/case-studies*'))
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.case_studies') }}</span>
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.work') }}</span>
                    </span>
                    @elseif(request()->is('preview/portfolio*'))
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.clients') }}</span>
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.work') }}</span>
                    </span>
                    @else
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.work') }}</span>
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.work') }}</span>
                    </span>
                    @endif
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('preview.case-study.index') }}" class="dropdown-item {{ request()->is('preview/case-studies*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                        </svg>
                        {{ __('preview.nav.case_studies') }}
                    </a>
                    <a href="{{ route('preview.portfolio') }}" class="dropdown-item {{ request()->is('preview/portfolio*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                        {{ __('preview.nav.clients') }}
                    </a>
                </div>
            </li>

            <!-- INSIGHTS -->
            <li class="nav-item-dropdown {{ request()->is('preview/blogs*') || request()->is('preview/blog*') ? 'active' : '' }}">
                <a href="#">
                    <!-- Dynamic Label Logic -->
                    @if(request()->is('preview/blog*'))
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                        </svg>
                        {{ __('preview.nav.blog') }}
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 21c0 .5.5 1 1 1h4c.5 0 1-.5 1-1v-1H9v1zm3-19C8.1 2 5 5.1 5 9c0 2.4 1.2 4.5 3 5.7V17c0 .5.5 1 1 1h6c.5 0 1-.5 1-1v-2.3c1.8-1.3 3-3.4 3-5.7 0-3.9-3.1-7-7-7z" />
                        </svg>
                        {{ __('preview.nav.insights') }}
                    </span>
                    @elseif(request()->is('preview/events*'))
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" />
                        </svg>
                        {{ __('preview.nav.events') }}
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 21c0 .5.5 1 1 1h4c.5 0 1-.5 1-1v-1H9v1zm3-19C8.1 2 5 5.1 5 9c0 2.4 1.2 4.5 3 5.7V17c0 .5.5 1 1 1h6c.5 0 1-.5 1-1v-2.3c1.8-1.3 3-3.4 3-5.7 0-3.9-3.1-7-7-7z" />
                        </svg>
                        {{ __('preview.nav.insights') }}
                    </span>
                    @elseif(request()->is('preview/reports*'))
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z" />
                        </svg>
                        {{ __('preview.nav.reports') }}
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 21c0 .5.5 1 1 1h4c.5 0 1-.5 1-1v-1H9v1zm3-19C8.1 2 5 5.1 5 9c0 2.4 1.2 4.5 3 5.7V17c0 .5.5 1 1 1h6c.5 0 1-.5 1-1v-2.3c1.8-1.3 3-3.4 3-5.7 0-3.9-3.1-7-7-7z" />
                        </svg>
                        {{ __('preview.nav.insights') }}
                    </span>
                    @elseif(request()->is('preview/tools*'))
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z" />
                        </svg>
                        {{ __('preview.nav.tools') }}
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 21c0 .5.5 1 1 1h4c.5 0 1-.5 1-1v-1H9v1zm3-19C8.1 2 5 5.1 5 9c0 2.4 1.2 4.5 3 5.7V17c0 .5.5 1 1 1h6c.5 0 1-.5 1-1v-2.3c1.8-1.3 3-3.4 3-5.7 0-3.9-3.1-7-7-7z" />
                        </svg>
                        {{ __('preview.nav.insights') }}
                    </span>
                    @elseif(request()->is('preview/media*'))
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18 4l2 4h-3l-2-4h-2l2 4h-3l-2-4H8l2 4H7L5 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4h-4z" />
                        </svg>
                        {{ __('preview.nav.media_kit') }}
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 21c0 .5.5 1 1 1h4c.5 0 1-.5 1-1v-1H9v1zm3-19C8.1 2 5 5.1 5 9c0 2.4 1.2 4.5 3 5.7V17c0 .5.5 1 1 1h6c.5 0 1-.5 1-1v-2.3c1.8-1.3 3-3.4 3-5.7 0-3.9-3.1-7-7-7z" />
                        </svg>
                        {{ __('preview.nav.insights') }}
                    </span>
                    @else
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 21c0 .5.5 1 1 1h4c.5 0 1-.5 1-1v-1H9v1zm3-19C8.1 2 5 5.1 5 9c0 2.4 1.2 4.5 3 5.7V17c0 .5.5 1 1 1h6c.5 0 1-.5 1-1v-2.3c1.8-1.3 3-3.4 3-5.7 0-3.9-3.1-7-7-7z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.insights') }}</span>
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 21c0 .5.5 1 1 1h4c.5 0 1-.5 1-1v-1H9v1zm3-19C8.1 2 5 5.1 5 9c0 2.4 1.2 4.5 3 5.7V17c0 .5.5 1 1 1h6c.5 0 1-.5 1-1v-2.3c1.8-1.3 3-3.4 3-5.7 0-3.9-3.1-7-7-7z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.insights') }}</span>
                    </span>
                    @endif
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('preview.blogs') }}" class="dropdown-item {{ request()->is('preview/blog*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                        </svg>
                        {{ __('preview.nav.blog') }}
                    </a>
                    <a href="#" class="dropdown-item {{ request()->is('preview/events*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z" />
                        </svg>
                        {{ __('preview.nav.events') }}
                    </a>
                    <a href="#" class="dropdown-item {{ request()->is('preview/reports*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z" />
                        </svg>
                        {{ __('preview.nav.reports') }}
                    </a>
                    <a href="#" class="dropdown-item {{ request()->is('preview/tools*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z" />
                        </svg>
                        {{ __('preview.nav.tools') }}
                    </a>
                    <a href="#" class="dropdown-item {{ request()->is('preview/media*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18 4l2 4h-3l-2-4h-2l2 4h-3l-2-4H8l2 4H7L5 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4h-4z" />
                        </svg>
                        {{ __('preview.nav.media_kit') }}
                    </a>
                </div>
            </li>

            <!-- CAREERS -->
            <li class="nav-item-dropdown">
                <a href="#">
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.careers') }}</span>
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.careers') }}</span>
                    </span>
                </a>
                <div class="dropdown-menu">
                    <a href="#" class="dropdown-item">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 11.75c-.69 0-1.25.56-1.25 1.25s.56 1.25 1.25 1.25 1.25-.56 1.25-1.25-.56-1.25-1.25-1.25zm6 0c-.69 0-1.25.56-1.25 1.25s.56 1.25 1.25 1.25 1.25-.56 1.25-1.25-.56-1.25-1.25-1.25zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8 0-.29.02-.58.05-.86 2.36-1.05 4.23-2.98 5.21-5.37C11.07 8.33 14.05 10 17.42 10c.78 0 1.53-.09 2.25-.26.21 1.01.33 2.05.33 3.12 0 4.41-3.59 8-8 8z" />
                        </svg>
                        {{ __('preview.nav.join_us') }}
                    </a>
                    <a href="#" class="dropdown-item">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72l5 2.73 5-2.73v3.72z" />
                        </svg>
                        {{ __('preview.nav.interns') }}
                    </a>
                    <a href="#" class="dropdown-item">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                        {{ __('preview.nav.culture') }}
                    </a>
                </div>
            </li>

            <!-- CONTACT -->
            <li class="nav-item-dropdown {{ request()->is('preview/contact') ? 'active' : '' }}">
                <a href="#">
                    <!-- Dynamic Label Logic (Contact) -->
                    @if(request()->is('preview/contact'))
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.start_project') }}</span>
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.contact') }}</span>
                    </span>
                    @else
                    <span class="nav-swap-default">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.contact') }}</span>
                    </span>
                    <span class="nav-swap-hover">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                        </svg>
                        <span class="nav-text">{{ __('preview.nav.contact') }}</span>
                    </span>
                    @endif
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('preview.contact') }}" class="dropdown-item {{ request()->is('preview/contact') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                        </svg>
                        {{ __('preview.nav.start_project') }}
                    </a>
                    <a href="#" class="dropdown-item">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z" />
                        </svg>
                        {{ __('preview.nav.support') }}
                    </a>
                    <a href="#" class="dropdown-item">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                        </svg>
                        {{ __('preview.nav.locations') }}
                    </a>
                </div>
            </li>

        </ul>
    </div>
    <div class="nav-island island-right controls">
        <!-- Utility Links (Visible on Desktop) -->
        <a href="{{ route('login') }}" class="control-btn utility-link d-none d-lg-flex" title="{{ __('preview.nav.client_portal') }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
        </a>
        <a href="#" class="control-btn utility-link d-none d-lg-flex" title="{{ __('preview.nav.partner_hub') }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
            </svg>
        </a>

        <button class="control-btn" id="search-toggle"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                <path d="M19 1l-1.25 2.75L15 5l2.75 1.25L19 9l1.25-2.75L23 5l-2.75-1.25L19 1z" />
            </svg></button>

        <div class="lang-dropdown-wrapper" id="lang-dropdown-wrapper">
            <button class="control-btn lang-btn" id="lang-btn" data-lang-change-url="{{ route('lang.change', ['lang' => ':lang']) }}" data-current-lang="{{ strtoupper(app()->getLocale()) }}">{{ strtoupper(app()->getLocale()) }}</button>
            <div class="lang-dropdown-menu">
                <div class="lang-item" data-lang="az">AZ</div>
                <div class="lang-item" data-lang="en">EN</div>
                <div class="lang-item" data-lang="ru">RU</div>
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

        <button id="mobile-menu-toggle"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" />
            </svg></button>
    </div>
</div>