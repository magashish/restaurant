@extends('layouts.default')
@section('content')

    <div class="inner_banner" style="background-image: url({{ asset('images/inner_banner.jpg') }});">
        <div class="container">
            <div class="row">
                <div class='col-md-12 col-sm-12'>
                    <div class="restaurant_detail">
                        <section class="mb-4">
                            <h2 class="h1-responsive font-weight-bold text-center my-4">Search Results</h2>
                            <!--<p class="text-center w-responsive mx-auto mb-5">Do you have any questions? Please do not hesitate to contact us directly. Our team will come back to you within  a matter of hours to help you.</p>-->
                         </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                   <div class="row">
                   @foreach($results as $result)
                    <div class="col-md-3 col-sm-3">
                        <div class="restaurant">
                           <div class="restimg"><img src="{{asset('uploads').'/'.$result->logo}}"></div>
                           <div class="resttitle"><a href="{{route('restaurantfront.show', $result->id)}}">{{$result->name}}</a></div>
                        </div>
                    </div>
                   @endforeach
                   </div>
                </div>
            </div>
        </div>
    </div>
    @stop
@section('page_script')
    <script>

    </script>
@endsection
