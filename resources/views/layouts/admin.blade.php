<!doctype html>
<html>
<head>
    @include('includes.admin.head')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
@include('includes.admin.header')
<!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        @include('includes.admin.sidebar')
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    @include('includes.admin.footer')
</div>
@yield('page_script')
</body>
</html>
