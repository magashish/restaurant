<!doctype html>
<html>
<head>
    @include('includes.head')
    @yield('page_style')
</head>
<body>
<header class="row header">
    @include('includes.header')
</header>
<div id="main">
    @yield('content')
</div>
<footer>
    @include('includes.footer')
</footer>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@yield('page_script')
</body>
</html>
