<header class="header axil-header header-style-1">
    <div id="axil-sticky-placeholder"></div>
    <div class="axil-mainmenu">
        <div class="container">
            <div class="header-navbar">
                <div class="header-logo">
                    <a href="{{ url('/') }}"><img class="light-version-logo" src="{{ asset('assets/media/logo.svg') }}" alt="logo"></a>
                    <a href="{{ url('/') }}"><img class="dark-version-logo" src="{{ asset('assets/media/logo-3.svg') }}" alt="logo"></a>
                    <a href="{{ url('/') }}"><img class="sticky-logo" src="{{ asset('assets/media/logo-2.svg') }}" alt="logo"></a>
                </div>
                <!-- Main Navigation -->
                <div class="header-main-nav">
                    <!-- Start Mainmanu Nav -->
                    <nav class="mainmenu-nav" id="mobilemenu-popup">
                        <div class="d-block d-lg-none">
                            <div class="mobile-nav-header">
                                <div class="mobile-nav-logo">
                                    <a href="{{ url('/') }}">
                                        <img class="light-mode" src="{{ asset('assets/media/logo-2.svg') }}" alt="Site Logo">
                                        <img class="dark-mode" src="{{ asset('assets/media/logo-3.svg') }}" alt="Site Logo">
                                    </a>
                                </div>
                                <button class="mobile-menu-close" data-bs-dismiss="offcanvas"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <ul class="mainmenu">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ url('/services') }}">Services</a></li>
                            <li><a href="{{ url('/projects') }}">Portfolio</a></li>
                            <li><a href="{{ url('/about') }}">About Us</a></li>
                            <li><a href="{{ url('/contact') }}">Contact</a></li>
                        </ul>
                    </nav>
                    <!-- End Mainmanu Nav -->
                </div>
                <div class="header-action">
                    <ul class="list-unstyled">
                        <li class="sidemenu-btn d-lg-block d-none">
                            <button class="btn-wrap" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenuRight">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </li>
                        <li class="mobile-menu-btn sidemenu-btn d-lg-none d-block">
                            <button class="btn-wrap" data-bs-toggle="offcanvas" data-bs-target="#mobilemenu-popup">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </li>
                        <li class="my_switcher d-block d-lg-none">
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
