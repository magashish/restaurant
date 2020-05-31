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
                            <div class="resort_logo"><a href="{{route('restaurantfront.show', $restaurant->id)}}"><img src="{{$restaurant->logo}}"></a></div>
                            <a href="{{route('restaurantfront.show', $restaurant->id)}}">{{$restaurant->name}}</a>
                        </div>
                      @endforeach
                        <div class="resort_inner view_btn">
                            <a href="{{route('restaurantfront.all')}}">View All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="realestate_sec">
        <div class="container">
            <h2>Real Estates</h2>
            <div class="row">
                <div class='col-md-4 col-sm-12'>
                    <div class="realestate_col">
                        <div class="property-item-box">
                            <div class="box-thumbnail">
                                <a href="#" class="box-link">
                                    <img width="514" height="340" src="images/house_img.jpg">
                                </a>
                                <div class="box-status">
                                    <span class="label-default"><a href="#">For Rent</a></span>
                                </div>
                                <ul class="beplus-icons actions">

                                    <li>
                                        <span data-toggle="tooltip" data-placement="top" data-original-title="" title="">
                                            <i class="fa fa-camera-retro"></i>
                                            <span class="rlc-text">Photos (3) </span>
                                        </span>
                                    </li>
                                </ul>
                            </div>

                            <div class="box-content">
                                <span class="label label-default label-color-76">Villa Savoye Plan</span>
                                <a href="#" class="box-link">
                                    <h3 class="box-title">Ancient Francisco House</h3>
                                </a>
                                <div class="info-proty user-date">
                                    <div class="prop-user-agent"><i class="fa fa-user"></i> Michael Bobo</div>
                                    <div class="prop-user-agent"><i class="fa fa-calendar"></i> 2 months ago</div>
                                </div>

                                <div class="box-price price">
                                    <span class="item-price">$5,000</span><span class="item-sub-price">$3,000/Sqft</span>
                                </div>
                                <div class="box-footer">
                                    <div class="box-info">
                                        <div class="box-meta"><p><span class="h-beds">Beds: 4</span><span class="h-baths">Baths: 2</span><span class="h-area">Sqft: 5000</span></p></div>
                                        <div class="box-address">353 Monticello St, San Francisco</div>
                                    </div>
                                    <a href="" class="btn btn-primary"><i class="fa fa-angle-right fa-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-md-4 col-sm-12'>
                    <div class="realestate_col">
                        <div class="property-item-box">
                            <div class="box-thumbnail">
                                <a href="#" class="box-link">
                                    <img width="514" height="340" src="images/house_img.jpg">
                                </a>
                                <div class="box-status">
                                    <span class="label-default"><a href="#">For Rent</a></span>
                                </div>
                                <ul class="beplus-icons actions">

                                    <li>
                                        <span data-toggle="tooltip" data-placement="top" data-original-title="" title="">
                                            <i class="fa fa-camera-retro"></i>
                                            <span class="rlc-text">Photos (3) </span>
                                        </span>
                                    </li>
                                </ul>
                            </div>

                            <div class="box-content">
                                <span class="label label-default label-color-76">Villa Savoye Plan</span>
                                <a href="#" class="box-link">
                                    <h3 class="box-title">Ancient Francisco House</h3>
                                </a>
                                <div class="info-proty user-date">
                                    <div class="prop-user-agent"><i class="fa fa-user"></i> Michael Bobo</div>
                                    <div class="prop-user-agent"><i class="fa fa-calendar"></i> 2 months ago</div>
                                </div>

                                <div class="box-price price">
                                    <span class="item-price">$5,000</span><span class="item-sub-price">$3,000/Sqft</span>
                                </div>
                                <div class="box-footer">
                                    <div class="box-info">
                                        <div class="box-meta"><p><span class="h-beds">Beds: 4</span><span class="h-baths">Baths: 2</span><span class="h-area">Sqft: 5000</span></p></div>
                                        <div class="box-address">353 Monticello St, San Francisco</div>
                                    </div>
                                    <a href="" class="btn btn-primary"><i class="fa fa-angle-right fa-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-md-4 col-sm-12'>
                    <div class="realestate_col">
                        <div class="property-item-box">
                            <div class="box-thumbnail">
                                <a href="#" class="box-link">
                                    <img width="514" height="340" src="images/house_img.jpg">
                                </a>
                                <div class="box-status">
                                    <span class="label-default"><a href="#">For Rent</a></span>
                                </div>
                                <ul class="beplus-icons actions">

                                    <li>
                                        <span data-toggle="tooltip" data-placement="top" data-original-title="" title="">
                                            <i class="fa fa-camera-retro"></i>
                                            <span class="rlc-text">Photos (3) </span>
                                        </span>
                                    </li>
                                </ul>
                            </div>

                            <div class="box-content">
                                <span class="label label-default label-color-76">Villa Savoye Plan</span>
                                <a href="#" class="box-link">
                                    <h3 class="box-title">Ancient Francisco House</h3>
                                </a>
                                <div class="info-proty user-date">
                                    <div class="prop-user-agent"><i class="fa fa-user"></i> Michael Bobo</div>
                                    <div class="prop-user-agent"><i class="fa fa-calendar"></i> 2 months ago</div>
                                </div>

                                <div class="box-price price">
                                    <span class="item-price">$5,000</span><span class="item-sub-price">$3,000/Sqft</span>
                                </div>
                                <div class="box-footer">
                                    <div class="box-info">
                                        <div class="box-meta"><p><span class="h-beds">Beds: 4</span><span class="h-baths">Baths: 2</span><span class="h-area">Sqft: 5000</span></p></div>
                                        <div class="box-address">353 Monticello St, San Francisco</div>
                                    </div>
                                    <a href="" class="btn btn-primary"><i class="fa fa-angle-right fa-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--<div class="about_sec">
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
    </div>-->
@stop
