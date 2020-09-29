<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$MainMenus->menu_system_name}}</title>
    <link href="{{asset('assets/extra-libs/prism/prism.css')}}" rel='stylesheet' media='screen'>
    <link href="{{asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel='stylesheet' media='screen'>
    <link href="{{asset('assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css')}}" rel='stylesheet' media='screen'>
    <link href="{{asset('dist/css/style.min.css')}}" rel='stylesheet' media='screen'>
    <link href="{{asset('assets/libs/sweetalert/css/sweetalert.css')}}" rel='stylesheet' media='screen'>
    <link href="{{asset('assets/libs/select2/dist/css/select2.min.css')}}" rel='stylesheet' media='screen'>
    <link href="{{asset('assets/libs/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css')}}" rel='stylesheet' media='screen'>
    <link href="{{asset('assets/css/bootstrap2-toggle.min.css')}}" rel='stylesheet' media='screen'>
    <link href="{{asset('assets/libs/jquery-steps/jquery.steps.css')}}" rel='stylesheet' media='screen'>
    <link href="{{asset('assets/libs/jquery-steps/steps.css')}}" rel='stylesheet' media='screen'>
    <link href="{{asset('assets/libs/fullcalendar/dist/fullcalendar.min.css')}}" rel='stylesheet' media='screen'>
    <link href="{{asset('assets/extra-libs/calendar/calendar.css')}}" rel='stylesheet' media='screen'>
    <link href="{{asset('assets/dist/admin/bootstrap-select.min.css')}}" rel='stylesheet' media='screen'>
    <link href='https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css' rel='stylesheet' media='screen'>
    <link href="{{asset('assets/dist/admin/style_print.css')}}" rel='stylesheet' media='print'>
    <link href="{{asset('css/select2/select2.min.css')}}">
    <link href="{{asset('assets/libs/dropzone/dist/min/dropzone.min.css')}}" rel='stylesheet' media='screen'>
  

    <style media="screen">
        .select2-container {
            width: 100% !important;
        }

        .modal {
            overflow: auto !important;
        }

        .navbar-collapse {
            background: #007bff !important;
        }

        .sidebar-nav ul .sidebar-item.selected>.sidebar-link {
            background-color: #007bff !important;

        }
        
    </style>
</head>

<body class="">
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper">
        @include('layouts.header')
        @include('layouts.sidebar')
        <div class="page-wrapper">
            <div class="page-breadcrumb bg-white">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                        <h5 class="font-medium text-uppercase mb-0">{{$MainMenus->menu_system_name}}</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0 bg-white">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$MainMenus->menu_system_name}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="page-content container-fluid">
                @yield('content')

                @yield('modal')


            </div>
            <footer class="footer text-center">
                All Rights Reserved by Ample admin. Designed and Developed by
                <a href="https://wrappixel.com">WrapPixel</a>.
            </footer>
        </div>
    </div>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script> -->
    <script src="{{asset('assets/js/jquery-1.12.4.js')}}"></script>
    <script src="{{asset('assets/jquery/ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('dist/js/app.min.js')}}"></script>
    <script src="{{asset('dist/js/app.init.minimal.js')}}"></script>
    <script src="{{asset('dist/js/app-style-switcher.js')}}"></script>
    <script src="{{asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('assets/extra-libs/sparkline/sparkline.js')}}"></script>
    <script src="{{asset('dist/js/waves.js')}}"></script>
    <script src="{{asset('dist/js/sidebarmenu.js')}}"></script>
    <script src="{{asset('dist/js/custom.min.js')}}"></script>
    <script src="{{asset('assets/extra-libs/prism/prism.js')}}"></script>
    <script src="{{asset('assets/extra-libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('dist/js/pages/datatable/datatable-basic.init.js')}}"></script>
    <script src="{{asset('assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/libs/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('dist/js/pages/forms/select2/select2.init.js')}}"></script>
    <script src="{{asset('assets/libs/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('assets/libs/ckeditor/samples/js/sample.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap2-toggle.min.js')}}"></script>
    <script src="{{asset('dist/js/pages/datatable/datatable-advanced.init.js')}}"></script>
    <script src="{{asset('assets/extra-libs/jqbootstrapvalidation/validation.js')}}"></script>
    <script src="{{asset('assets/js/all_foot.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('assets/js/jszip.min.js')}}"></script>
    <script src="{{asset('assets/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/js/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/js/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('dist/js/custom.js')}}"></script>
    <script src="{{asset('assets/libs/jquery-steps/build/jquery.steps.min.js')}}"></script>
    <script src="{{asset('assets/libs/jquery-validation/dist/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/extra-libs/taskboard/js/jquery.ui.touch-punch-improved.js')}}"></script>
    <script src="{{asset('assets/libs/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('assets/libs/fullcalendar/dist/fullcalendar.min.js')}}"></script>
    <script src="{{asset('js/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('js/jquery.priceformat.js')}}"></script>
    <script src="{{asset('js/function.js')}}"></script>
    <script src="{{asset('assets/libs/dropzone/dist/min/dropzone.min.js')}}"></script>

    <script>
        var url_gb = "{{url('/')}}";
        var asset_gb = "{{asset('/')}}";

        // CKEDITOR.replace('add_event_details_description_1', {
        //     height: 400
        // });
        // CKEDITOR.replace('add_event_details_description_2', {
        //     height: 400
        // });
        // CKEDITOR.replace('edit_event_details_description_1', {
        //     height: 400
        // });
        // CKEDITOR.replace('edit_event_details_description_2', {
        //     height: 400
        // });


        // $('.select2').select2();
    </script>
    @yield('scripts')
</body>
<style media="screen">
    .gray {
        background-color: #ccc;
    }
</style>

</html>