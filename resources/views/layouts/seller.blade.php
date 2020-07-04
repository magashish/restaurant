<!DOCTYPE html>
<html lang="en">

<head>
@include('includes.seller.head')
    @yield('page_style')
</head>

<body>


<div id="preloader">
    <div class="loader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
        </svg>
    </div>
</div>

<div id="main-wrapper">
    @include('includes.seller.sidebar')

    @include('includes.seller.header')

    @yield('content')

    @include('includes.seller.footer')

    @yield('page_script')
</div>


</body>