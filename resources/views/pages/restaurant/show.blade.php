@extends('layouts.default')
@section('content')

    @if(isset($restaurantData->isopen) && $restaurantData->isopen  ===0)
        @php $status = 'Closed'; @endphp
    @else
        @php $status = 'Open'; @endphp
    @endif

    <div class="inner_banner" style="background-image: url({{ asset('images/inner_banner.jpg') }});">
        <div class="container">
            <div class="row">
                <div class='col-md-12 col-sm-12'>
                    <div class="restaurant_detail">
                        <div class="restaurant_img"><img src="{{$restaurantData->logo}}"></div>
                        <div class="restaurant_info">
                            <div class="resort_open">{{$status}}</div>
                            <h2>{{$restaurantData->name}}</h2>
                            <p>{{$restaurantData->shortdescription }}</p>
                            <!--<div class="min_order"><i class="fas fa-check"></i> Min $ 10.00</div>-->
                            <div class="time"><i class="far fa-clock"></i> {{$restaurantData->timings}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    @if(session('error'))
        <div class="col-full">
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        </div>
    @endif
    @if(session('success'))
    <div class="col-full">
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    </div>
    @endif
    <div class="content_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <div class="menu_tabs">

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#Menu">Menu</a>
                            </li>
                            <!--<li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#Reviews">Reviews</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#book_table">Book a Table</a>
                            </li>-->
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#restaurant_info">Restaurant info</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane container active" id="Menu">
                            
                                <h4>POPULAR ORDERS Delicious hot food!</h4>
                                @if(isset($data->menu) && !empty($data->menu))
                                    @foreach($data->menu as $proddata)
                                        <?php
                                        if($category != '' && $category != $proddata->category_id) {
                                            continue;
                                        }
                                        ?>
                                        <div class="product_info">
                                            <div class="product_left">
                                                <div class="product_img"><img
                                                        src="{{ $proddata->image }}">
                                                </div>
                                                <div class="rating"><img src="{{ asset('images/rating_img.png') }}">
                                                </div>
                                            </div>
                                            <div class="prodcut_cat">
                                                <h3>{{ $proddata->name }}</h3>
                                                <span>{{ $proddata->dishname }}</span>
                                                <span class="menu-item-price-span">$ <span
                                                        class="menu-item-price">{{ $proddata->price }}</span></span>
                                                    <button type="button" class="addtocart get-options" name="View Options" value="View Options" data-id= "{{$proddata->id}}">View Options</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <h3 class="text-center padding-100px">No Food Found</h3>
                                @endif

                            </div>
                           
                            <div class="tab-pane container fade" id="restaurant_info">
                                <h4>POPULAR ORDERS Delicious hot food!</h4>
                                <div class="tab_inner">
                                    {{$restaurantData->description }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="col-md-4 col-sm-12">
                @if(count($catData)>0)
                    <div class="choose_menu">
                        <h2>Choose menu <i class="fas fa-utensils"></i></h2>
                        <ul>
                            <?php //$catData
                            ?>
                            @foreach($catData as $key => $cat)
                                <li>
                                    <a href="{{ route('restaurantfront.show', [$restaurantId, 'cat' => $cat->category_id]) }}">{{$cat->category_detail->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    @if(!empty($datas['data']))
                        <div class="special_img">
                            <!-- <img src="{{ asset('images/special_img.png') }}"> -->
                            <div class="choose_menu">
                                <h2>Cart Summary<i class="fa fa-shopping-cart"></i></h2>
                                <div class="cart_table">
                                    <table>
                                        <tr>
                                            <th>Dishes</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Extra Item</th>
                                            <!-- <th>Total</th> -->
                                            <!-- <th>Action</th> -->
                                        </tr>
                                        <?php $total = 0 ?>
                                        <?php $extraItemtotal = 0 ?>
                                        @foreach($datas['data'] as $key => $menu)
                                            @php
                                                $total += $menu['price'] * $menu['quantity'];
                                            @endphp
                                            <tr>
                                                <td class="cart_img">
                                                    <div class="productname">
                                                        <!-- <a href="javascript:void(0)" onclick="openextraitem(this)" >{{ $menu['product_detail']['dishname'] }}</a> -->
                                                        {{ $menu['product_detail']['dishname'] }}
                                                    </div>
                                                </td>
                                                <td class="cartprice">$ {{ $menu['price']}}</td>
                                                <td class="cart_qty">
                                                    {{ $menu['quantity']}}
                                                </td>
                                                <td>
                                                    @php
                                                        $menuOptionsTotal = 0;
                                                    @endphp
                                                    @if(count($menu['menu_options']) > 0)
                                                        @foreach($menu['menu_options'] as $menuOption)
                                                            @php
                                                                $menuOptionsTotal += $menuOption['menu_option_detail']['price'];
                                                            @endphp
                                                            <span><strong>{{ $menuOption['menu_option_detail']['name'] }}:</strong> ${{ $menuOption['menu_option_detail']['price'] }}</span>
                                                            <br>
                                                        @endforeach
                                                    @endif
                                                    @php
                                                        $total += $menuOptionsTotal;
                                                    @endphp
                                                </td>
                                                <!-- <td>
                                                    $ {{($menu['price'] * $menu['quantity']) + $menuOptionsTotal}}</td>
                                                </td> -->
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <h4>Total:-  $ {{ $total + $extraItemtotal }}</h4>
                                <!-- <h2><a href="{{ route('checkout') }}">Confirm Your Order</a></h2> -->
                            </div>
                            <!-- <button type="button" class="addtocart" name="Confirm Your Order" value="Confirm Your Order"> -->
                            <a class="addtocart" href="{{ route('cart') }}">View Full Details</a>
                            <!-- </button> -->

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

<div id="product-options" class="modal fade" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="panel-title modal-title" id="exampleModalLabel">Menu Options</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body pb-0 pt-0">
                            <!-- <table class="table table-bordered">
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
                            </table> -->
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Menu Id</th>
                                            <th>Menu Name</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="product_name" id="test" disabled checked value="test">
    										    <label for="test"></label>
                                            </td>
                                            <td><span id="product_id"></span></td>
                                            <td><span id="product_name"></span></td>
                                            <td>$<span id="product_price"></span></td>
                                        </tr>
                                    </tbody>

                                    <tbody class="tbodyy">
                                        <tr>
                                            <td colspan="4" style="border-bottom: 1px dashed #ddddde;">&nbsp;</td>
                                        </tr>
                                        <!-- <tr class="total">
                                            <td><strong> Menu Options</strong></td>
                                        </tr> -->
                                    </tbody>

                                    </table>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-primary waves-effect waves-light add-to-cart-submit" id="add-to-cart-submit">Add to Cart</button>
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

@stop
@section('page_script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <script>

        $(document).on('click','body .get-options',function(){
                var prod_id = $(this).data("id");
                $.ajax({
                    url: "{{ route('get-product-options') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        product_id: prod_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            console.log(response.menu_options.options);
                            $("#product_name").html(response.menu_options.dishname);
                            $("#product_id").html(response.menu_options.id);
                            $("#product_price").html(response.menu_options.price);
                            var option = ''; 
                            if(response.menu_options.options.length > 0)
                            {
                                var $rows = $('<tr>'+ '<td>'+ '<strong>' + "Extra Items" + '</strong>' + '</td>' + '</tr>');
                                $('.tbodyy').append($rows);
                            }
                           
                            $.each(response.menu_options.options, function (i, option) {
                            var $row = $('<tr>'+           
                            '<td>' + '<input type="checkbox" class="menu-option-checkbox" id="'+option.name+ '-' +option.id+'" onclick="change_price(this)" name="itemoption[]" value="'+option.id+'">' + '<label for="'+option.name+ '-' +option.id+'">'  + '</td>'+
                            '<td>' + option.id  + '</td>'+
                            '<td id="option_name-'+option.id+'">' + option.name  + '</td>'+
                            '<td id="option_price-'+option.id+'">' + option.price+'</td>'+
                            '</tr>'); 
                            $('.tbodyy').append($row);
                        });
                            $("#product-options").modal('show');
                        } else {
                            swal("Oops! some error occured");
                        }
                    },
                    error: function (error) {
                        swal("Oops! some error occured");
                    }
                });
        }); 
    </script>

    <script>
        $('#product-options').on('hidden.bs.modal', function () {
            location.reload();
        });

        $("body").on("click", ".delete-cart-item", function () {
                swal({
                    title: "Are you sure?",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            console.log(this);
                            var cart_id = this.value;
                            $.ajax({
                                url: "{{ route('delete.cart.item') }}",
                                type: "POST",
                                dataType: "JSON",
                                data: {
                                    cart_id: cart_id,
                                    _token: '{{ csrf_token() }}',
                                },
                                success: function (response) {
                                    if (response.success) {
                                        if (response.session_cart) {
                                            location.reload();
                                        } else {
                                            $(".cart-items-container").html(response.html);
                                        }
                                    }
                                },
                                error: function () {

                                }
                            });
                        }
                    });
            });
        var itemoption = [];
        function change_price(detail)
        {
            console.log(detail);
            var itemPrice =  $("#product_price").html();
            var optionPrice =  $("#option_price-"+detail.value).html();
            var optionName =  $("#option_name-"+detail.value).html();
            if ($(detail).is(":checked"))
            {
                // alert('checked');
                itemoption.push(detail.value);
                itemPrice = parseFloat(itemPrice) + parseFloat(optionPrice);
            }
            else{
                // alert('unchecked');
                itemoption.pop(detail.value);
                itemPrice = parseFloat(itemPrice) - parseFloat(optionPrice);
            }
            console.log(itemoption);
            itemPrice = itemPrice.toFixed(2);
            $("#product_price").html(itemPrice);
            // alert(itemPrice)
        }
        
            $(".add-to-cart-submit").on("click", function () {
                var $this = $(this);
                console.log($this);
                var menu_id =  $("#product_id").html();
                $.ajax({
                    url: "{{ route('check-same-restaurant') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        menu_id: menu_id,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function(){
                        $("#add-to-cart-submit").html('<span class="spinner"><i class="fa fa-spinner fa-spin"></i></span> Loading ...');
                        $("#add-to-cart-submit").attr('disabled','disabled');                
                    }, 
                    success: function (response) {
                        if (response.success) {
                            submitForm();
                        } else {
                            swal("You can't add item from different restaurant. Please select item from same restaurant");
                        }
                    },
                    error: function (error) {
                        swal("Oops! some error occured");
                    }
                });
            });
        // });
    </script>

    <script>
        function submitForm()
        {
            var previous_url = "{{ \Request::fullUrl() }}";
            var pid = $("#product_id").html();
            var pname = $("#product_name").html();
            var price = $("#product_price").html();
            var pqty = 1;
            console.log(pid,pname,price,pqty);
            $.ajax({
                    url: "{{ route('addtocart') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        pid: pid,
                        previous_url: previous_url,
                        pname: pname,
                        price: price,
                        pqty: pqty,
                        itemoption : itemoption,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if(response.status == 'error') {
                            $("#product-options").modal('hide');
                                alert(response.message);
                        }else{
                            $("#product-options").modal('hide');
                            alert(response.message);
                        }
                    },
                    error: function (error) {
                        $("#product-options").modal('hide');
                        swal("Oops! some error occured");
                    }
                });
        }
    </script>
@endsection

@section('page_style')
    <style>
        .padding-100px {
            padding: 100px;
        }
    </style>
@endsection
