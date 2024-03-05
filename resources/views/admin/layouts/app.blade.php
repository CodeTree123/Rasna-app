
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ $general->siteName($pageTitle ?? '') }}</title>
    @stack('style-lib')
    @stack('style')
    <!-- Custom fonts for this template-->
    @include('admin.include.css')
    <link rel="stylesheet" href="{{asset('assets/admin/css/vendor/select2.min.css')}}">

</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('admin.include.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
            @include('partials.notify')
                @include('admin.include.topbar')
                @include('admin.partials.breadcrumb')
                @yield('content')
            @include('admin.include.footer')
            <!-- End of Footer -->
            </div>
        <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    @include('admin.include.js') 
    @stack('script-lib')
    @stack('script')
</body>

</html> 

