<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Task manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Task manager" name="description" />
    <meta content="goweb" name="author" />
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- DataTables -->
    <link href="{{ asset('admin/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Responsive datatable examples -->
    <link href="{{ asset('admin/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">
    <!-- Dragula css -->
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/dragula/dragula.min.css') }}" />
    <!-- Layout config Js -->
    <script src="{{ asset('admin/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('admin/assets/css/app.min.css?v='.time()) }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('admin/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/sr-1.1.1/datatables.min.css" />



    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <script src="{{ asset('admin/plugins/ckeditor/ckeditor.js') }}"></script>

</head>

<body>
    @include('sweetalert::alert')
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    <!-- Begin page -->
    <div id="layout-wrapper">



        @include('admin.inc.header')

        @include('admin.inc.left_sidebar')

        <div class="sidebar-background"></div>

        <div class="vertical-overlay"></div>
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    {{-- <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title"></h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">Əsas səhifə</a>
                                </li>
                                @yield('heading_breadcrumbs')
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-right  d-flex justify-content-end">
                                @yield('heading_buttons')
                            </div>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">@yield('heading_title')</h4>
            
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"> <a href="#">Əsas səhifə</a></li>
                                        <li class="breadcrumb-item active">Analytics</li>
                                    </ol>
                                </div>
            
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="float-right  d-flex justify-content-end">
                                @yield('heading_buttons')
                            </div>
                        </div>
                    </div>
                    @yield('content')

                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © GO Panel.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by Goweb team
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

    </div>



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->


    {{-- <div class="customizer-setting d-none d-md-block">
        <div class="btn-info btn-rounded shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas"
            data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
            <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
        </div>
    </div> --}}



    <!-- JAVASCRIPT -->
    <script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/feather-icons/feather.min.js') }}"></script>
    {{-- <script src="{{ asset('admin/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script> --}}
    <script src="{{ asset('js/ajax.js') }}"></script>
    <script src="{{ asset('admin/plugins/axios/axios.js') }}"></script>

    <script src="{{ asset('admin/assets/js/plugins.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

    {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script> --}}
    {{-- <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/date-1.1.2/kt-2.7.0/r-2.3.0/rg-1.2.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/sp-2.0.2/sl-1.4.0/sr-1.1.1/datatables.min.js">
    </script>
     --}}


    <!-- Required datatable js -->
    <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('admin/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables/buttons.colVis.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ asset('admin/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>


    <!-- dragula init js -->
    <script src="{{ asset('admin/assets/libs/dragula/dragula.min.js') }}"></script>

    <!-- dom autoscroll -->
    <script src="{{ asset('admin/assets/libs/dom-autoscroller/dom-autoscroller.min.js') }}"></script>

    <!--taks-kanban-->
    <script src="{{ asset('admin/assets/js/pages/tasks-kanban.init.js') }}"></script>

    <!-- list.js min js -->
    <script src="{{ asset('admin/assets/libs/list.js/list.min.js') }}"></script>

    <!--list pagination js-->
    <script src="{{ asset('admin/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!-- titcket init js -->
    {{-- <script src="{{ asset('admin/assets/js/pages/tasks-list.init.js') }}"></script> --}}



    {{-- <script src="{{ asset('admin/assets/js/pages/datatables.init.js') }}"></script> --}}

    <script src="{{ asset('admin/js/custom.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>

    {{-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            $(document).find("#preloader").show();

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            $(document).on('click', '.delete-button', function(event) {
                let form = $('#' + event.target.dataset.deleteId);
            swalWithBootstrapButtons.fire({
                    title: 'Silinmə',
                    text: "Sİlmək istədiyinizə əminsiniz ? bu məlumat geri qaytarılmaya bilər !",
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Bəli silinsin!',
                    cancelButtonText: 'Xeyr!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        swalWithBootstrapButtons.fire(
                            'Silindi!',
                            'yenilənir...',
                            'success'
                        )

                        form.submit();
                    }
                })
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(".select2").select2();
    </script>

    <script src="{{ asset('admin/assets/js/main.js?v=' . time()) }}"></script>
    {{-- <script src="{{ asset('admin/assets/js/pages/select2.init.js') }}"></script> --}}
    @stack('js_stack')
</body>

</html>
