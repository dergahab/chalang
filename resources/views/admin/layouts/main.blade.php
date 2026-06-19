<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar-size="lg" data-preloader="disable" data-theme="dark">

<head>

    <meta charset="utf-8" />
    <title>{{ \App\Models\Setting::getValue('site_title') ?? 'Chalang' }} - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ \App\Models\Setting::getValue('site_title') ?? 'Chalang' }} Admin" name="description" />
    <meta content="goweb" name="author" />
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}" />
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ \App\Models\Setting::getValue('site_favicon') ?? asset('admin_assets/assets/images/favicon.ico') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('admin_assets/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('admin_assets/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('admin_assets/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('admin_assets/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('admin_assets/assets/css/admin-vision.css') }}?v=1.4" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin_assets/assets/css/datatables-dark.css') }}?v={{ time() }}" rel="stylesheet" type="text/css" />
    <!-- Ensure jQuery is loaded early -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <style>
        /* Force Sidebar Docking (Override Vision Theme Floating) */
        .app-menu.navbar-menu {
            top: 0 !important;
            bottom: 0 !important;
            left: 0 !important;
            border-radius: 0 !important;
            margin: 0 !important;
            height: 100vh !important;
            box-shadow: 0 0 20px rgba(0,0,0,0.2) !important; /* Standard shadow, no glow */
        }
        /* Fix Topbar position if needed */
        #page-topbar {
            top: 0 !important;
            left: var(--sidebar-width) !important;
            right: 0 !important;
            border-radius: 0 !important;
            width: auto !important;
        }
        /* Adjust Main Content margin if needed */
        .main-content {
            margin-left: var(--sidebar-width) !important;
        }
        .footer {
            left: var(--sidebar-width) !important;
        }
    </style>
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        {{-- Original header disabled to avoid double topbar --}}
        {{-- @include('admin.inc.header') --}}
        @include('admin.inc.left_sidebar')

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    
                    <!-- Vision UI Topbar -->
                                        <div id="page-topbar">
    <div class="topbar-left">
        <div class="hamburger-icon" id="topnav-hamburger-icon">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    
    <!-- Global Search -->
    <div class="global-search-wrapper">
        <div class="global-search">
            <i class="ri-search-line global-search-icon"></i>
            <input type="text" class="global-search-input" placeholder="Axtar... (Ctrl+K)" id="global-search">
            <kbd class="global-search-kbd">Ctrl+K</kbd>
        </div>
        <div id="global-search-results" class="global-search-dropdown" style="display:none;"></div>
    </div>
    
    <div class="topbar-right">
        <!-- Notifications -->
        <div class="dropdown d-inline-block">
            <button type="button" class="notification-btn" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ri-notification-3-line"></i>
                <span class="notification-badge" id="notification-count">0</span>
            </button>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-vision notification-dropdown" id="notification-dropdown">
                <div class="notification-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Bildirişlər</h6>
                    <div class="d-flex gap-2">
                        <button class="btn btn-link btn-sm p-0 text-start" type="button" id="mark-all-read">Hamısını oxunmuş et</button>
                        <a href="{{ route('admin.notifications.index') }}" class="btn btn-link btn-sm p-0 text-start">Tarixçə</a>
                    </div>
                </div>
                <div class="notification-list" id="notification-list">
                    <div class="p-3 text-muted small">Bildiriş yoxdur</div>
                </div>
                <div class="notification-footer text-start px-3 pb-2">
                    <span class="notification-count" id="notification-count-text">0 yeni</span>
                </div>
            </div>
        </div>
        <!-- Theme Toggle -->
        <button type="button" class="theme-toggle-btn" id="theme-toggle">
            <i class="ri-moon-line" id="theme-icon"></i>
        </button>

        <!-- Language Switcher -->
        <div class="dropdown d-inline-block">
            <button type="button" class="lang-switcher-btn" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ri-global-line"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-vision">
                <a href="javascript:void(0);" class="dropdown-item dropdown-item-vision">Azərbaycan</a>
                <a href="javascript:void(0);" class="dropdown-item dropdown-item-vision">English</a>
                <a href="javascript:void(0);" class="dropdown-item dropdown-item-vision">Русский</a>
            </div>
        </div>

        <!-- User Profile -->
        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item bg-transparent border-0" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="d-flex align-items-center">
                    <img class="rounded-circle header-profile-user" src="{{ asset('admin_assets/assets/images/users/avatar-1.jpg') }}" alt="Header Avatar">
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-vision">
                <a class="dropdown-item dropdown-item-vision" href="#"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item dropdown-item-vision" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </div>
    </div>
</div>

@include('admin.inc.breadcrumbs')
                    @yield('content')

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            {{-- Footer removed --}}
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('admin_assets/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/js/plugins.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('admin_assets/assets/js/app.js') }}"></script>

    <!-- Vision UI Theme Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const html = document.documentElement;

            // Check localStorage
            const savedTheme = localStorage.getItem('vision-theme') || 'dark';
            html.setAttribute('data-theme', savedTheme);
            updateIcon(savedTheme);

            toggleBtn.addEventListener('click', function() {
                const currentTheme = html.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                html.setAttribute('data-theme', newTheme);
                localStorage.setItem('vision-theme', newTheme);
                updateIcon(newTheme);
            });

            function updateIcon(theme) {
                if (theme === 'dark') {
                    themeIcon.classList.remove('ri-sun-line');
                    themeIcon.classList.add('ri-moon-line');
                } else {
                    themeIcon.classList.remove('ri-moon-line');
                    themeIcon.classList.add('ri-sun-line');
                }
            }
        });
        
        // Ctrl+K Global Search Shortcut
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                document.getElementById('global-search').focus();
            }
        });

        $(document).ready(function() {
            let searchTimeout;
            const searchInput = $('#global-search');
            const searchResults = $('#global-search-results');

            searchInput.on('keyup', function() {
                clearTimeout(searchTimeout);
                const query = $(this).val();

                if (query.length < 2) {
                    searchResults.hide();
                    return;
                }

                searchTimeout = setTimeout(function() {
                    $.ajax({
                        url: "{{ route('admin.global.search') }}",
                        data: { query: query },
                        success: function(data) {
                            let html = '';
                            if (data.length > 0) {
                                html += '<div class="search-results-list">';
                                data.forEach(item => {
                                    html += `
                                        <a href="${item.url}" class="search-result-item">
                                            <div class="search-result-icon">
                                                <i class="${item.icon}"></i>
                                            </div>
                                            <div class="search-result-info">
                                                <span class="search-result-title">${item.title}</span>
                                                <span class="search-result-type">${item.type}</span>
                                            </div>
                                        </a>
                                    `;
                                });
                                html += '</div>';
                            } else {
                                html = '<div class="p-3 text-center text-muted">Nəticə tapılmadı</div>';
                            }
                            searchResults.html(html).show();
                        }
                    });
                }, 300);
            });

            // Close search results when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.global-search-wrapper').length) {
                    searchResults.hide();
                }
            });

            // Sidebar Menu Search
            $('#sidebar-search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                
                // Search in main items
                $('#navbar-nav > .nav-item').each(function() {
                    var item = $(this);
                    var text = item.text().toLowerCase();
                    
                    // Skip menu titles
                    if(item.hasClass('menu-title')) return;

                    if(text.indexOf(value) > -1) {
                        item.show();
                        // If it has submenu, expand it if match is inside
                        if(value.length > 0) {
                            var collapse = item.find('.collapse');
                            if(collapse.length > 0) {
                                collapse.addClass('show');
                            }
                        }
                    } else {
                        item.hide();
                    }
                });

                // Show menu titles only if there are visible items following them
                $('.menu-title').each(function() {
                    var title = $(this);
                    var nextItems = title.nextUntil('.menu-title', ':visible');
                    if(nextItems.length > 0) {
                        title.show();
                    } else {
                        title.hide();
                    }
                });
            });
        });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <!-- Required datatable js -->
    <script src="{{ asset('admin_assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('admin_assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ asset('admin_assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>


    <!-- dragula init js -->
    <script src="{{ asset('admin_assets/assets/libs/dragula/dragula.min.js') }}"></script>


    <!-- list.js min js -->
    <script src="{{ asset('admin_assets/assets/libs/list.js/list.min.js') }}"></script>

    <!--list pagination js-->
    <script src="{{ asset('admin_assets/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!-- form mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>


    {{-- <script src="{{ asset('admin_assets/assets/js/pages/datatables.init.js') }}"></script> --}}

    <script src="{{ asset('admin_assets/js/custom.js?v='.time()) }}"></script>

    {{-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(".select2").select2();
    </script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
      integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet"/>


    <script src="{{ asset('admin_assets/assets/js/main.js?v=' . time()) }}"></script>
    {{-- <script src="{{ asset('admin_assets/assets/js/pages/select2.init.js') }}"></script> --}}

    @stack('js_stack')
    
    <script>
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        @if(Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif

        @if(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif
    </script>
    <!-- Notification JS -->
    <script>
        $(document).ready(function() {
            function fetchNotifications() {
                $.get("{{ route('admin.notifications.latest') }}", function(data) {
                    // Update Badge
                    if (data.count > 0) {
                        $('.notification-badge').text(data.count).show();
                    } else {
                        $('.notification-badge').hide();
                    }

                    $('#notification-count-text').text(data.count + ' yeni');

                    // Update List
                    let html = '';
                    if (data.notifications.length > 0) {
                        data.notifications.forEach(function(notif) {
                            let iconClass = 'info';
                            let icon = 'ri-information-line';
                            
                            if (notif.data.type === 'info') { iconClass = 'info'; icon = notif.data.icon; }
                            
                            html += `
                                <a href="${notif.data.url}" class="notification-item" onclick="markAsRead('${notif.id}')">
                                    <div class="notification-icon ${iconClass}">
                                        <i class="${icon}"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-title">${notif.data.title}</p>
                                        <span class="notification-time">${moment(notif.created_at).fromNow()}</span>
                                    </div>
                                </a>
                            `;
                        });
                    } else {
                        html = '<div class="text-center p-3 text-muted">Bildiriş yoxdur</div>';
                    }
                    $('.notification-list').html(html);
                    $('.notification-count').text(data.count + ' yeni');
                });
            }

            // Poll every 30 seconds
            setInterval(fetchNotifications, 30000);
            fetchNotifications(); // Initial call

            window.markAsRead = function(id) {
                $.post("{{ url('admin/notifications') }}/" + id + "/read", {
                    _token: "{{ csrf_token() }}"
                });
            }

            $('.notification-footer').on('click', function(e) {
                e.preventDefault();
                $.post("{{ route('admin.notifications.readAll') }}", {
                    _token: "{{ csrf_token() }}"
                }, function() {
                    $('.notification-badge').hide();
                    $('.notification-list').html('<div class="p-3 text-muted small">Bildiriş yoxdur</div>');
                    $('.notification-count').text('0 yeni');
                    $('#notification-count-text').text('0 yeni');
                });
            });
        });
    </script>
</body>

</html>





