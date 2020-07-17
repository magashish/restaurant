@extends('includes.seller.sellerView')
@section('content')
<style type="text/css">
  		.ajax-load{
  			background: #e1e1e1;
		    padding: 10px 0px;
		    width: 100%;
  		}
  	</style>
<div class="container-fluid">
    <div class="content-body">
        <!-- Page Heading -->
        <div class="content-heading d-sm-flex align-items-center justify-content-between mb-4">
            <h1>Dashboard</h1>
                <!-- START Language list-->
                <div class=" ml-auto ">
                <ol class=" breadcrumb ">
                    <li class=" breadcrumb-item active "><a href="{{ url('/owner/dashboard')}}">Home</a></li>
                </ol>
                </div>
                <!-- END Language list-->
        </div>
        <div class="row">
        
            @if(count($orders) > 0)
           
                <div class="col-lg-8" id="post-data">
                    @foreach($orders as $order) 
                           
                        @php
                            $created = new \Carbon\Carbon($order->created_at);
                            $now = \Carbon\Carbon::now();
                            $currentTime = \Carbon\Carbon::now();
                            $difference = ($created->diff($now)->days< 1) ? 'today' : $created->diffForHumans($now);
                            $spandate = date_create($order->created_at);
                            $span = date_format($spandate,"d M");
                            $diff_in_minutes = $currentTime->diffInMinutes($order->created_at);
                            $diffHours = $currentTime->diffInHours($order->created_at);
                         
                        @endphp
                       
                        <ul class="timeline">
                            <li class="timeline-inverted">
                                <div class="timeline-badge danger">{{$span}}</div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading" id="order_heading_{{$order->id}}">
                                        @if($order->status == 'PREPARING')
                                        <div class="alert alert-info">Order is now being prepared</div>
                                        @elseif($order->status == 'DISPATCHED')
                                        <div class="alert alert-success">Order is now dispatched</div>
                                        @endif
                                        <h4 class="timeline-title">Congratulations,You got a new order!
                                            @if($diff_in_minutes < 60)
                                           
                                                <span class="float-right">{{$diff_in_minutes}} Minutes Ago</span>
                                            @else
                                           
                                                <span class="float-right">{{$diffHours}} Hours Ago</span>
                                            @endif
                                        </h4>
                                    </div>
                                    <div class="timeline-body"> 
                                        <div class="card card-default">
                                            <div class="card-body">
                                               
                                                <p>
                                                    <label class="leftLabel">Restraunt Name-</label>
                                                    <label class="rightLabel">{{$order->restraunt->name}} </label>
                                                </p>
                                                <p>
                                                    <label class="leftLabel">OrderId</label>
                                                    <label class="rightLabel">{{$order->oid}} </label>
                                                </p>
                                                <p>
                                                    <label class="leftLabel">Final Total</label>
                                                    <label class="rightLabel">{{$order->final_total}}</label>
                                                </p>
                                                <p>
                                                    <label class="leftLabel">Order Date</label>
                                                    <label class="rightLabel">{{$order->created_at}}</label>
                                                </p>
                                                <p class="mb-0" id="footer_buttons_{{$order->id}}">

                                                    @if($order->status == 'RECEIVED')
                                                    <button class='btn btn-xs btn-success' data-toggle="modal" data-target="#cnfrmprep" data-message='Are you sure you want to process the order status to preparing' data-title="Mark Preparing" id='change_status{{$order->id}}' type='button' 
                                                        data-value="{{$order->id}}" data-status="PREPARING">Mark Preparing </button> &nbsp&nbsp
                                                    @elseif($order->status == 'PREPARING')
                                                    <button class='btn btn-xs btn-success' 
                                                    data-toggle="modal" data-target="#cnfrmdisp"
                                                    data-message='Are you sure you want to process the order status to dispatched' data-title="Mark Preparing" id='change_status{{$order->id}}' type='button' 
                                                        data-value="{{$order->id}}" data-status="DISPATCHED">Mark Dispatched </button> &nbsp&nbsp
                                                    @endif
                
                                                    <button class = "btn btn-primary vieworderdetails" data-user="{{$order->user->first_name}}" data-mobile="{{$order->user->mobile}}" data-amount="{{$order->amount}}" data-total="{{$order->final_total}}" data-tax="{{$order->tax}}" data-delivery="{{$order->delivery_charge}}" data-id= "{{$order->id}}" data-restid= "{{$order->restraunt_id}}" >Order Details</button>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    @endforeach      
                    <div class="ajax-load text-center" style="display:none">
                        <p><img src="{{asset('/images/loader.gif')}}">Loading More Orders</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<div id="ordersummary" class="modal fade" tabindex="-1">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="panel-title modal-title" id="exampleModalLabel">Order Summary</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body pb-0 pt-0">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                        <label class="mb-2"> <b>Customer Name :</b> &nbsp; <span id="customer_name"></span></label>
                                        <h4><span id="customer_name"> </span></h4>
                                    </td>
                                    <td>
                                        <label class="mb-2"><b> Customer Mobile :</b> &nbsp; <span id="customer_mobile"></span></label>
                                        <h4><span id="customer_mobile"> </span></h4>
                                    </td>
                                </tr>
                            </tbody>         
                        </table>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order Item</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                               
                                </tbody>

                                <tbody class="tbodyy">
                                    <tr>
                                        <td colspan="2" style="border-bottom: 1px dashed #ddddde;">&nbsp;</td>
                                    </tr>
                                    <tr class="total">
                                        <td><strong> Order Total</strong></td>
                                        <td>$<span id="order_total"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Tax</td>
                                        <td>$<span id="tax"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Delivery Fees</td>
                                        <td>$<span id="delivery_fees"></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="border-bottom: 1px dashed #ddddde;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Final Total</strong></td>
                                        <td>$<span id="subtotal"></span></td>
                                    </tr>

                                </tbody>

                                </table>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-light" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="cnfrmprep" role="dialog" aria-labelledby="cnfrmprepLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="confirmprep">Ok</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="cnfrmdisp" role="dialog" aria-labelledby="cnfrmdispLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="confirmdisp">Ok</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	var page = 1;
	$(window).scroll(function() {
	    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
	        page++;
	        loadMoreData(page);
	    }
	});

	function loadMoreData(page){
	  $.ajax(
	        {
	            url: '?page=' + page,
	            type: "get",
	            beforeSend: function()
	            {
	                $('.ajax-load').show();
	            }
	        })
	        .done(function(data)
	        {
	            if(data.html == ""){
                    $('.ajax-load').hide();
	                return;
	            }
	            $('.ajax-load').hide();
	            $("#post-data").append(data.html);
	        })
	        .fail(function(jqXHR, ajaxOptions, thrownError)
	        {
	              console.log('Loading Orders');
	        });
	}
</script>

<script>

    $('#cnfrmprep').on('show.bs.modal', function (e) {
        $message = $(e.relatedTarget).attr('data-message');
        $(this).find('.modal-body p').text($message);
        var id = $(e.relatedTarget).attr('data-value');
        $('#confirmprep').attr('id', $(e.relatedTarget).attr('data-value'));
    });

    $('#cnfrmdisp').on('show.bs.modal', function (e) {
        $message = $(e.relatedTarget).attr('data-message');
        $(this).find('.modal-body p').text($message);
        var id = $(e.relatedTarget).attr('data-value');
        $('#confirmdisp').attr('id', $(e.relatedTarget).attr('data-value'));
    });

    $('#confirmprep').on('click', function (e) {
        var url = "/seller/changeOrderStatus";
        var id = $(this).attr('id');
        var status = 'PREPARING';
        $.ajax({
                    type: 'POST',
                    url: url,
                    data: {"_token": $("input[name='_token']").val(),"order_id":id,"status":status},
                    beforeSend: function(){
                        $("#change_status"+id).html('<span class="spinner"><i class="fa fa-spinner fa-spin"></i></span> Loading ...');
                        $("#change_status"+id).attr('disabled','disabled');                
                    },    
                    success: function(data) {
                        console.log(data);
                        if(data.status = 'success')
                        {
                        location.reload();
                        }
                    },
                    error: { }
                });
    });

    $('#confirmdisp').on('click', function (e) {
        var url = "/seller/changeOrderStatus";
        var id = $(this).attr('id');
        var status = 'DISPATCHED';
        $.ajax({
                    type: 'POST',
                    url: url,
                    data: {"_token": $("input[name='_token']").val(),"order_id":id,"status":status},
                    beforeSend: function(){
                        $("#change_status"+id).html('<span class="spinner"><i class="fa fa-spinner fa-spin"></i></span> Loading ...');
                        $("#change_status"+id).attr('disabled','disabled');                
                    },    
                    success: function(data) {
                        console.log(data);
                        if(data.status = 'success')
                        {
                            location.reload();
                        }
                    },
                    error: { }
                });
    });

    $(document).on('click','body .vieworderdetails',function(){
        var id = $(this).data("id");
        var restraunt_id = $(this).data("restid");
        var user_name = $(this).data("user");
        var user_mobile = $(this).data("mobile");
        var order_total = $(this).data("amount");
        var final_total = $(this).data("total");
        var tax = $(this).data("tax");
        var delivery_charge = $(this).data("delivery");
            $.ajax({

                type:'POST',
                url:'/seller/vieworderdetails',
                data:{"_token": $("input[name='_token']").val(),delivery_charge:delivery_charge,tax:tax,final_total:final_total,order_total:order_total,user_mobile:user_mobile,user_name:user_name,order_id:id,restraunt_id:restraunt_id},
                success:function(data){
                    console.log(data);
                    $("#customer_name").html(data.user_name);
                    $("#customer_mobile").html(data.user_mobile);
                    $("#order_address").html('test');
                    var detail = ''; 
                    $.each(data.data, function (i, detail) {
                        var $row = $('<tr>'+
                        '<td>' + detail.item_detail.dishname + '*' + detail.quantity + '</td>'+
                        '<td>'+detail.price+'</td>'+
                        '</tr>'); 
                        $('.tbody').append($row);
                    });
                    $("#tax").html(data.tax);
                    $("#delivery_fees").html(data.delivery_charge);
                    $("#order_total").html(data.order_total);
                    $("#subtotal").html(data.final_total);

                    $('#ordersummary').modal('show');
                    //   $('#ordersummary').on('hidden.bs.modal', function () {
                    //         $(".tbody").remove();
                    //     })
                },
                error: function(data, errorThrown)
                {
                alert('error');
                }
            });
            return false;
    });

</script>
@endsection