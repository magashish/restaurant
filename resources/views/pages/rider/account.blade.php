@extends('includes.rider.riderView')
@section('title')
    Profile
@endsection
@section('content')
<style>
    img {
  border-radius: 50%;
}
</style>
   <div class="container-fluid">
                    <div class="content-body">
                        <!-- Page Heading -->
                        <div class="content-heading d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 style="position: relative;margin-left: 389px;">My Profile</h1>
                            <!-- START Language list-->
                            <div class=" ml-auto ">
                                <ol class=" breadcrumb ">
                                    <li class=" breadcrumb-item "><a href=" javascript:void(0) ">Dashboard</a></li>
                                    <li class=" breadcrumb-item active "><a href=" javascript:void(0) ">Home</a></li>
                                </ol>
                            </div>
                            <!-- END Language list-->
                        </div> @if(Session::has('success'))
         <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
               <div id="charge-message" class="alert alert-success">
                  {{  Session::get('success') }}
               </div>
            </div>
         </div>
         @endif
         @if(Session::has('error'))
         <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
               <div id="charge-message" class="alert alert-danger">
                  {{  Session::get('error') }}
               </div>
            </div>
         </div>
         @endif
                       
         <section class="section addProperty">

   <div class="container">
   <h1 class="title">Edit Your Profile</h1>
  
      <div class="profileDetail">
         <div class="row">
        
            <div class="col-md-8 col-sm-12">
                <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ route('rider.update') }}" name="add_Property" id="add_Property" novalidate="novalidate">
                {{ csrf_field() }}
               
               <div class="form-group">
                  <label>First Name</label>
                  <input type="text" class="form-control" required  name="name" id="name"  value="{{ \Auth::guard('rider')->user()->name ?? '' }}" >
               </div>
               <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" readonly="true"  name="email" id="email"  value="{{ \Auth::guard('rider')->user()->email ?? '' }}" >
               </div>
               <div class="form-group">
                  <label>Ph.Number</label>
                  <input type="text" class="form-control" required name="contact_number" id="contact_number"  value="{{ \Auth::guard('rider')->user()->contact_number ?? '' }}" >
               </div>
               <div class="form-group">
                  <div class="inputGroup">
                     <input class="submit" type="submit" value="Update" class="btn btn-success">
                  </div>
                </div>
               </form>
            </div>
        </div>
   </div>
  
</div>
   

</section>

@endsection