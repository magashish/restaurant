<!DOCTYPE html>

<html lang="en">
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">

    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js "></script>
    
    <title>Restraunt | Order your food online&amp; more</title>
    <!-- Bootstrap Core CSS -->
    @yield('css')
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
   
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" >
   
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700&display=swap" rel="stylesheet">
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
 
    
    <!-- Theme CSS -->
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/login.css') }}">
    <style>

        dropdown:hover .dropdown-toggle {background-color: #ddd;}
    </style>
</head>
<body>
<!-- Wrapper -->
<div class="wrapper">
    <nav class="navbar navbar-expand-md fixed-top siteHeader">
        <div class="container">
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse w-100">
                <ul class="nav navbar-nav nav-left  w-100">
                </ul>
            </div>
            <a class="navbar-brand order-first order-md-0 mx-0" href="/"><img src="{{ asset('images/logo.png') }}" alt="" height="100" style="margin-left:67px;"></a>
            <div class="collapse navbar-collapse w-100">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item">
                                                
                        </li><li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre="">Login</a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('login') }}">
                                User/Seller Login
                            </a>
                            <a class="dropdown-item" href="{{ route('rider.login') }}">
                                Rider Login
                            </a>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    @yield('content')

    <!-- Footer -->
    <footer class="bg-white sticky-login-footer">
        <div class=" container my-auto ">
            <div class=" copyright text-center my-auto ">
            <span>Copyright &copy; 2020 Rishabh Mishra, All rights reserved.</span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

</div>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


    </body>
</html>