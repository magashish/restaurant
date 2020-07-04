@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Settings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Restaurants</li>
                    </ol>
                </div><!-- /.col -->
                @if(Session::has('success'))
                    <div style="width:100%" class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div style="width:100%" class = "alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                        <div class="">
                            <form action="{{ route('admin.settings') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <h5>Tax Setting</h5>
                                <div class="form-group col-lg-6">
                                    <label for="name">Tax</label>
                                    <input class="form-control" type="text" name="tax" value="{{ $settingObj->tax ?? '' }}" required>
                                </div>
                                <!-- <h5>Email Setting</h5>
                                <div class="form-group col-lg-6">
                                    <label for="name">Email</label>
                                    <input class="form-control" type="text" name="username" value="{{$settingObj->name ?? '' }}" required>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">Password</label>
                                    <input class="form-control" type="text" name="password" value="{{ $settingObj->password ?? '' }}" required>
                                </div> -->
                                <h5>Stripe Keys</h5>
                                <div class="form-group col-lg-6">
                                    <label for="name">Secret Key</label>
                                    <input class="form-control" type="text" name="stripe_s_key" value="{{$settingObj->stripe_s_key ?? '' }}" required>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">Public Key</label>
                                    <input class="form-control" type="text" name="stripe_p_key" value="{{ $settingObj->stripe_p_key ?? '' }}" required>
                                </div>
                                <h5>Google Key</h5>
                                <div class="form-group col-lg-6">
                                    <!-- <label for="name">Secret Key</label> -->
                                    <input class="form-control" type="text" name="google_key" value="{{$settingObj->google_key ?? '' }}" required>
                                </div>
                                <!-- <h5>Delivery Charges</h5>
                                <div class="form-group col-lg-6">
                                    <label for="name">Password</label>
                                    <input class="form-control" type="text" name="settings[mail][password]" value="{{ $settingObj->password ?? '' }}" required>
                                </div> -->
                                <input type="submit" class="btn btn-primary">
                            </form>
                        </div>

                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@stop

