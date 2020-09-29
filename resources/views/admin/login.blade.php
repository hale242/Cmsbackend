<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
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
</head>

<body class="login-page">
    <!DOCTYPE html>
    <html dir="ltr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Intervison template</title>
        <link rel="canonical" href="https://www.wrappixel.com/templates/ampleadmin/" />
        <link href="{{asset('dist/css/style.min.css')}}" rel="stylesheet">
    </head>

    <body>
        <div class="main-wrapper">
            <div class="preloader">
                <div class="lds-ripple">
                    <div class="lds-pos"></div>
                    <div class="lds-pos"></div>
                </div>
            </div>
            <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(http://intervision.co/mock-up/assets/images/background/login-register.jpg) no-repeat center center;">
                <div class="auth-box on-sidebar">
                    <div id="loginform">
                        <div class="logo">
                            <span class="db"><img src="{{asset('assets/images/logos/logo-icon.png')}}" alt="logo" /></span>
                            <h5 class="font-medium mb-3">Sign In to Admin</h5>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <form id="FormLogin" class="needs-validation" novalidate>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                                        </div>

                                        <input type="text" class="form-control form-control-lg" name="username" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                                        </div>
                                        <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">Remember me</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <div class="col-xs-12 pb-3">
                                            <button class="btn btn-block btn-lg btn-info" type="submit">Log In</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="recoverform">
                        <div class="logo">
                            <span class="db"><img src="{{asset('assets/images/logos/logo-icon.png')}}" alt="logo" /></span>
                            <h5 class="font-medium mb-3">Recover Password</h5>
                            <span>Enter your Email and instructions will be sent to you!</span>
                        </div>
                        <div class="row mt-3">
                            <form class="col-12" action="index.html">
                                <div class="form-group row">
                                    <div class="col-12">
                                        <input class="form-control form-control-lg" type="email" required="" placeholder="Username">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <button class="btn btn-block btn-lg btn-danger" type="submit" name="action">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
        <script src="{{asset('assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
        <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <script>
            $('[data-toggle="tooltip"]').tooltip();
            $(".preloader").fadeOut();
            $('#to-recover').on("click", function() {
                $("#loginform").slideUp();
                $("#recoverform").fadeIn();
            });
        </script>
    </body>

    </html>

    <script>
        $(document).ready(function() {
            $('.table-autosort').DataTable({

                "pageLength": 10,
                "scrollX": true,
                "dom": 'Bfrtip',
                "columnDefs": [{
                    className: 'noVis',
                    visible: false
                }],
                "buttons": [
                    'colvis', {
                        extend: 'copy',
                        exportOptions: {
                            columns: ':visible'
                        },
                    }, {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':visible'
                        },
                    }, {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        },
                    }, {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        },
                    },

                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible'
                        },
                    },

                ],
            });
        });

        var buttonCommon = {
            exportOptions: {
                format: {
                    body: function(data, column, row, node) {
                        if (column == 6) {
                            return data
                        } else return data
                    }
                }
            }
        };
    </script>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js'></script>
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
    <script src="{{asset('js/function.js')}}"></script>
    <script type = "text/javascript">
        $('body').on('submit', '#FormLogin', function(e) {
            e.preventDefault();
            var form = $(this);
            loadingButton(form.find('button[type=submit]'));
            $.ajax({
                method: "POST",
                url: "{{url('admin/CheckLogin')}}",
                data: form.serialize()
            }).done(function(res) {
                if (res.status == 0) {
                    swal(res.title, res.content, 'error');
                    resetButton(form.find('button[type=submit]'));
                } else {
                    window.location = "{{url('/admin/Dashboard')}}";
                }
            }).fail(function(data) {
                resetButton(form.find('button[type=submit]'));
            });
        });
    </script>
</body>

</html>
