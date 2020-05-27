<div class="header_top">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="header_top_left">
                    <div class="select_city"><i class="fas fa-map-marker-alt"></i> Select City</div>
                    <div class="phone"><a href="tel:1234567890"><i class="fas fa-phone-alt"></i> (123) 456 7890</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="header_top_right">
                    @guest
                    <div class="login"><a href="{{ route('cart') }}"> <i class="fa fa-shopping-cart" aria-hidden="true"></i>Cart</a></div>
                        <div class="login"><a href="{{route('login')}}"><i
                                    class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a></div>
                        @if (Route::has('register'))
                            <div class="signup"><a href="{{route('register')}}"><i
                                        class="far fa-edit"></i> {{ __('Sign Up') }}</a></div>
                        @endif
                    @else
                        {{--<div class="login"><a href="{{route('login')}}"><i
                                    class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a></div>--}}
                        <div class="login"><a href="javascript:void(0)"> {{ Auth::user()->name }}</a></div>
                        <div class="login"><a href="{{ route('cart') }}"> <i class="fa fa-shopping-cart" aria-hidden="true"></i>Cart</a></div>
                        <div class="signup"><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                    class="far fa-edit"></i> {{ __('Logout') }}</a></div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
<div class="header_bottom">
    <div class="container">
        <div class="headerflex">
            <div class="logo">
                <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}"></a>
            </div>
            <div class="navbar">
                <div class="close_icon"><img src="{{ asset('images/close_icon.png') }}"></div>
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{route('about')}}">About</a></li>
                    <li><a href="{{route('restaurantfront.all')}}">Restaurants</a></li>
                    <li><a href="{{route('contact')}}">Contact</a></li>
                </ul>
            </div>
            <div class="header_search">
            <form id="search-from" method="GET" action="{{route('search')}}">
                    <input type="text" name="name" placeholder="Search Menu">
                    <button class="searchform" type="submit" name="" value="ok"></button>
                </form>
            </div>
            <div class="mob_view">
                <div class="menu_icon">
                    <img src="{{ asset('images/menu_icon.png') }}">
                </div>
                <div class="mob_serach_icon"><img src="{{ asset('images/mob_search_icon.png') }}"></div>
            </div>
        </div>
    </div>
</div>
