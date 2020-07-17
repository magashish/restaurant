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
                <h1 class="title">Order Item Details</h1>
    
                <div class="profileDetail">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration" id = "pendingstable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Item Price</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(count($get_details)!=0)
                                @foreach($get_details as $key => $details)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$details->item_detail->dishname}}</td>
                                        <td>{{$details->quantity}}</td>
                                        <td>{{$details->price}}</td>
                                        <td>{{$details->price}} * {{$details->quantity}}</td>
                                    </tr>
                                @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                <div class="block-dates-inner">
                        <div class="row">   
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for = "check_in" class="mb-2"><b>Delivery Charge:</b></label>
                                   
                                    <span id="data">{{$order_details->delivery_charge}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">    
                                <div class="form-group">
                                    <label for = "check_out" class="mb-2"><b>Tax:</b></label>
                                    <span id="data1">{{$order_details->tax}}</span>
                            </div>  
                        </div>
                        <div class="col-md-4 mt-4">
                                <div class="form-group">
                                    <label for = "check_in" class="mb-2"><b>Sub Total:</b></label>
                                    <span id="data1">{{$order_details->final_total}}</span>
                                </div>
                        </div>  
                </div>
            </div>
        </section>
    </div>
@endsection