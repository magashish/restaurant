<!doctype html>
<html>
<head>
    @include('includes.head')
    <style>
        .list-group-profile-sidebar.list-group-item.active {
            background-color: #b10700;
            border-color: #b10700;
        }
    </style>
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
