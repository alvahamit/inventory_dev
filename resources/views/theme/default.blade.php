<!DOCTYPE html>
<!-- 
    Author:     Alvah Amit Halder
    Document:   Theme default template. 
    Provider:   startbootstrap.com 
    Desc:       SB Admin 2. A free Bootstrap 4 admin theme built with HTML/CSS.
-->

<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>@yield('title', 'SB Admin 2')</title>
        
        <!--Laravel Compiled CSS-->
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
        
        <!-- Custom fonts for this template-->
        <link href="{!! asset('theme/vendor/fontawesome-free/css/all.min.css') !!}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="{!! asset('theme/css/sb-admin-2.min.css') !!}" rel="stylesheet">
        
        <!--For Datatable Styles-->
        <link href="{{asset('vendor/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet">
        
        <!--For Bootstrap searchable multi select-->
        <link rel="stylesheet" href="{{asset('theme/css/bootstrap-select.min.css')}}" />
    </head>

    <body id="page-top">
        <!--<div id='app'></div>-->
        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            @include('theme.sidebar')
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    @include('theme.topbar')
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">@yield('pageheading', 'Heading')</h1>
                            <!--<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
                        </div>
                        
                        <!--Display page messages via jQuery-->
                        <div id="pageMsg"></div>
                        
                        <!-- Content Row -->
                        @yield('content','Your content goes here.')

                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                @include('theme.footer')
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        @include('theme.logoutmodal')
        
        <!-- Laravel compiled js -->
        <script src="{!! asset('js/app.js') !!}"></script>
        
        <!-- Bootstrap core JavaScript-->
        <!--<script src="{!! asset('theme/vendor/jquery/jquery.min.js') !!}"></script>-->
        <!--<script src="{!! asset('theme/vendor/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>-->
        

        <!-- Core plugin JavaScript-->
        <script src="{!! asset('theme/vendor/jquery-easing/jquery.easing.min.js') !!}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{!! asset('theme/js/sb-admin-2.min.js') !!}"></script>

        <!--For Datatables to work-->
        <script src="{{asset('vendor/datatables/jquery.dataTables.js')}}"></script>
        <script src="{{asset('vendor/datatables/dataTables.bootstrap4.js')}}"></script>
        
        <!--Bootbox CDN-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
        
        <!--For bootstrap-select-->
        <script src="{!! asset('theme/js/bootstrap-select.min.js') !!}"></script>
        
        @yield('scripts')
        
    </body>

</html>