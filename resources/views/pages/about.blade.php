@extends('layouts.default')
@section('content')
<div class="about_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <h1>{{$cms[10]->short_description}}</h1>
                    <br>
                    {!!$cms[10]->description!!}
				</div>
				<div class="col-md-6 col-sm-12">
                    <div class="aboutimg"><img src="{{ asset('images/food-delivery-solution.png') }}"></div>
				</div>
		    </div>
	   </div>
</div>
@stop
