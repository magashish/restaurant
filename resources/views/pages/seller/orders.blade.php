@extends('includes.seller.sellerView')
@section('title')
    Orders
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
                <h1 style="position: relative;margin-left: 389px;">Orders</h1>
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
                <h1 class="title">Order Summary</h1>
    
                <div class="profileDetail">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration" id = "pendingstable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Order Id</th>
                                        <th>Customer Name </th>
                                        <th>Customer Contact </th>
                                        <th>Restraunt Name </th>
                                        <th>Total Amount</th>
                                        <th>Order Date</th>
                                        <th class="text-center ">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(count($get_seller_orders)!=0)
                                @foreach($get_seller_orders as $key => $seller_order)
                                    
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$seller_order->oid}}</td>
                                        <td>{{$seller_order->user->first_name}}</td>
                                        @if($seller_order->user->mobile != null)
                                        <td>{{$seller_order->user->mobile}}</td>
                                        @else
                                        <td>Not Yet Added</td>
                                        @endif
                                        <td>{{$seller_order->restraunt->name}}</td>
                                        <td>{{$seller_order->final_total}}</td>
                                        <td>{{$seller_order->created_at}}</td>
                                        <td class="text-center ">
                                            <a href="{{ route('order.details', $seller_order->id) }}" data-row-id="10253 " title="View Price Details" class="btn btn-sm btn-info command-edit mb-2"><em class="fa fa-eye fa-fw "></em></a>                                        </td>
                                    </tr>
                                    
                                @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
    
            </div>
   

        </section>
    </div>
@endsection