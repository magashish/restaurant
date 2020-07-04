@extends('includes.seller.sellerView')
@section('title')
    Profile
@endsection
@section('content')

   <div class="container-fluid">
                    <div class="content-body">
                        <!-- Page Heading -->
                        <div class="content-heading d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 style="position: relative;margin-left: 389px;">Change Password</h1>
                            <!-- START Language list-->
                            <div class=" ml-auto ">
                                <ol class=" breadcrumb ">
                                    <li class=" breadcrumb-item "><a href=" javascript:void(0) ">Dashboard</a></li>
                                    <li class=" breadcrumb-item active "><a href=" javascript:void(0) ">Home</a></li>
                                </ol>
                            </div>
                            <!-- END Language list-->
                        </div>

                         <section class="section addProperty">
                            <div class="container">
                            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/seller/update-password-post') }}" name="update_pwd" id="update_pwd" novalidate="novalidate">
                     {{ csrf_field() }}
                   

                <div class="profileDetail">     
                    <div class="row">
                        <h1 class="title">Update Your Password</h1>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" name="current_pwd" id="current_pwd" placeholder="Current Pasword" />
                            </div>
                        </div>

                         <div class="col-md-8">
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="new_pwd" id="new_pwd" placeholder="New Pasword" />
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_pwd" id="confirm_pwd" placeholder="Confirm Pasword" />
                            </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                                <div class="inputGroup">
                                    <input class="submit" type="submit" value="Update" class="btn btn-success">
                                </div>
                            </div>
                        </div>
                       
                    </div>

                     
                   
                </form>
            </div>
      </section>

@endsection