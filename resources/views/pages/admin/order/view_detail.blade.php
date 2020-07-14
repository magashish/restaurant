@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">View Order Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Order Management</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
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
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="container">
                        <h1></h1>
                        <table class="table table-bordered data-table init-data-table">
                            <thead>
                            <tr>
                                <th>Order Total</th>
                                <th>Delivery Charge</th>
                                <th>Tax</th>
                                <th>SubTotal</th>
                                <th>Delivered To</th>
                                <th>Delivered At</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                       <td>{{$get_order_detail->amount}}</td>
                                       <td>{{$get_order_detail->delivery_charge}}</td>
                                       <td>{{$get_order_detail->tax}}</td>
                                       <td>{{$get_order_detail->final_total}}</td>
                                       <td>{{$get_order_address->first_name}}</td>
                                       <td>{{$get_order_address->address}}</td>
                                    </tr>
                            </tbody>
                        </table>
                        <div class="text-right my-float-right">
                           
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@stop

@section('page_style')
    <style>
        .my-float-right {
            float: right;
        }
    </style>
@endsection
