<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Favicon icon -->
   
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend/assets/images/favicon.png') }}">
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="{{asset('frontend/assets/css/pickmeup.css') }}" type="text/css" /> -->
    
    <!-- Custom Stylesheet -->
  
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js "></script>

</head>

<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
      </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar" id="accordionSidebar">
            <!-- Sidebar Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('/owner/dashboard')}}">
                <div class="sidebar-brand-icon mx-2">
                    <img src="{{ asset('frontend/assets/images/favicon.png') }}" class="img-fluid" alt="">
                </div>
                
                <div class="sidebar-brand-text mx-3"><img src="{{ asset('images/logo.png') }}" class="img-fluid" alt=""></div>
            </a>
            <!-- Divider -->
           <hr class="sidebar-divider">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('/seller/dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link"  href="{{ url('/seller/orders') }}" >
                    <i class="fas fa-fw fa-link" ></i>
                    <span>Orders</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#homeSubmenus" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                <i class="fa fa-users-cog"></i>
                    <span>Account Settings</span>
                </a>
               <ul class="collapse list-unstyled" id="homeSubmenus">
                    <li>
                        <a class="nav-link" href="{{ route('seller.account') }}">
                        <i class="fa fa-user"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ url('/seller/change-password/'.Auth::user()->id) }}">
                        <i class="fa fa-key"></i>
                            <span>Manage Passwords</span>
                        </a>
                    </li>
               </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link"  href="{{ url('/link-bank-account') }}" >
                    <i class="fas fa-fw fa-link" ></i>
                    <span>Link account</span>
                </a>
               
            </li>
           
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand bg-white topbar">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggle" class="btn btn-link hamburger"></button>
        
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav rightNavbar ml-auto">
                       <!-- Nav Item - User Information -->
                        
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                       
                        @guest
                            <li class="nav-item dropdown no-arrow">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ __('Login') }}</a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            
                                    <a class="dropdown-item" href="#">
                                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>  Traveller's login
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Owner's login
                                    </a>
                                </div>
                            </li>
                        @else
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> {{ Auth::user()->name }} </span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> {{ __('Logout') }}
                                </a>
                                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                      
                            @endguest
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('content')

            <!-- Footer -->
            <footer class=" sticky-footer bg-white ">
                <div class=" container my-auto ">
                    <div class=" copyright text-center my-auto ">
                    <span>Copyright &copy; 2020 VacayHub, All rights reserved.</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
    Scripts
    ***********************************-->

<!-- JS files starts here -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{asset('frontend/assets/js/jquery-ui-1.7.custom.min.js') }}"></script>
<script src=" {{ asset('frontend/assets/js/custom.min.js') }} "></script>
<script src = "https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src = "https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src = "https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
<script src = "https://cdn.datatables.net/buttons/1.6.0/js/buttons.bootstrap4.min.js"></script>
<!-- JS files ends here -->



</body>

</html>