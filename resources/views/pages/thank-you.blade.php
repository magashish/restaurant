@extends('layouts.default')
@section('content')
    <div class="content_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="jumbotron text-center">
                        <h1 class="display-3">Thank You!</h1>
                        <p class="lead"><strong>Please check your email</strong> for order details. Your order id is #100001</p>
                        <hr>
                        <p>
                            Having questions? <a href="">Contact us</a>
                        </p>
                        <p class="lead">
                            <a class="btn btn-primary btn-sm addtocart" href="{{ route('pages.home') }}" role="button">Continue to homepage</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
