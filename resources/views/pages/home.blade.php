@extends('layouts.default')
@section('content')
      <div class="main_slider">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div id="main_slider" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ul class="carousel-indicators">
                            <li data-target="#main_slider" data-slide-to="0" class="active"></li>
                            <li data-target="#main_slider" data-slide-to="1"></li>
                            <li data-target="#main_slider" data-slide-to="2"></li>
                        </ul>
                        <!-- The slideshow -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('images/slide1.jpg') }}">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/slide1.jpg') }}">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/slide1.jpg') }}">
                            </div>
                        </div>
                        <!-- Left and right controls -->
                        <a class="carousel-control-prev" href="#main_slider" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#main_slider" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="restaurant_logo">
                      @foreach($restaurants as $restaurant)
                        <div class="resort_inner">
                            <div class="resort_logo"><a href="{{route('restaurantfront.show', $restaurant->id)}}"><img src="{{asset('uploads').'/'.$restaurant->logo}}"></a></div>
                            <a href="{{route('restaurantfront.show', $restaurant->id)}}">{{$restaurant->name}}</a>
                        </div>
                      @endforeach
                        <div class="resort_inner view_btn">
                            <a href="#">View All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="about_sec">
        <div class="container">
            <div class="row">
                <div class='col-md-7 col-sm-12'>
                    <h2>The History</h2>
                    <p>Nullam diam nisl, condi in eleifend sit amet, interdum vel quam. Curabitur laoreet viverra eleifend. Vivamus viverra justo eu neque. Integer ac dapibus amet velit. Suspendisse sit amet orci augue, imperdiet amet blandit enim. Duis nec mi sapien.Quisque eleifend mi at nisl pretium non dignissim felis euismod. Nullam sagittis In teger tortor et eiaculis dapibus amet dignissim.</p>
                    <p>Nullam diam nisl, condi in eleifend sit amet, interdum vel quam. Curabitur laoreet viverra eleifend. Vivamus viverra.</p>
                    <p>Nullam diam nisl, condi in eleifend sit amet, interdum vel quam. Curabitur laoreet viverra eleifend. Vivamus viverra justo eu neque. Integer ac dapibus amet velit. Suspendisse sit amet orci augue, imperdiet amet blandit enim.</p>
                </div>
                <div class="col-md-5 col-sm-12">
                    <img src="{{ asset('images/about_img.jpg') }}">
                </div>
            </div>
        </div>
    </div>
@stop
