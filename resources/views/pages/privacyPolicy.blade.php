@extends('layouts.default')
@section('content')
<div class="about_sec">
   <div class="container">
      <div class="row">
	      <div class="col-md-12">
         <!--Section: Contact v.2-->
         <section class="mb-4">
            <!--Section heading-->
            <h2 class="h1-responsive font-weight-bold text-center my-4">{{$cms[4]->title}}</h2>
            <!--Section description-->
            <p class="text-center w-responsive mx-auto mb-5">{{$cms[4]->short_description}}</p>
            <div class="row">
            {!!$cms[4]->description!!}
            </div>
         </section>
         <!--Section: Contact v.2-->
		 </div>
      </div>
   </div>
</div>
@stop