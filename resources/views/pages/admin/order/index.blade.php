@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Orders</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Orders</li>
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
                                <th>No</th>
                                <th>Order Id</th>
                                <th>UserID</th>
                                <th>Order Date</th>
                                <th width="100px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($orders))
                                @foreach($orders as $key => $order)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->oid }}</td>
                                        <td>{{ $order->user_id }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>
                                        <a href="{{ route('admin.order.detail', $order->id) }}"
                                               class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="text-right my-float-right">
                            {{ $orders->links() }}
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
