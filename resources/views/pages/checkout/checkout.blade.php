@extends('layouts.default')
@section('content')
    <div class="inner_banner title_banner" style="background-image: url(images/inner_banner.jpg);">
        <div class="container">
            <div class="row">
                <div class='col-md-12 col-sm-12'>
                    <div class="page-title"><h2>Checkout</h2></div>
                </div>
            </div>
        </div>
    </div>

    <div class="content_sec">
        <div class="container">
            <form id="place-order-form" method="post" class="billingform" action="{{ route('place.order') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <div class="billingdetail">
                            <h6>Returning customer? <a href="javascript:void(0)">Click here to login</a></h6><br>
                            <h3>Billing details</h3>
                            @if(session('error'))
                                <div class="col-full">
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                </div>
                            @endif
                            <div id="new-address-container">
                                <div class="col-half">
                                    <label>First Name<span>*</span></label>
                                    <input type="text" value="{{ \Auth::user()->name }}" name="shipping_address[first_name]">
                                </div>
                                <div class="col-half">
                                    <label>Last Name<span>*</span></label>
                                    <input type="text" value="{{ \Auth::user()->name }}" name="shipping_address[last_name]">
                                </div>
                                <div class="col-half">
                                    <label>Email Address<span>*</span></label>
                                    <input type="text" value="{{ \Auth::user()->email }}" name="shipping_address[email]">
                                </div>
                                <div class="col-half">
                                    <label>Phone No.<span>*</span></label>
                                    <input type="text" name="shipping_address[mobile]">
                                </div>
                                @guest
                                    <input type="hidden" name="is_authenticated" value="false">
                                    <div class="col-half">
                                        <label>Password<span>*</span></label>
                                        <input type="password" name="shipping_address[password]">
                                    </div>
                                    <div class="col-half">
                                        <label>Password Confirmation<span>*</span></label>
                                        <input type="password" name="shipping_address[password_confirmation]">
                                    </div>
                                @endguest
                                <div class="col-full">
                                    <label>Address<span>*</span></label>
                                    <input type="text" name="shipping_address[address]">
                                </div>
                                <div class="col-full">
                                    <label>Town/City<span>*</span></label>
                                    <input type="text" name="shipping_address[city]">
                                </div>
                                <div class="col-half">
                                    <label>State<span>*</span></label>
                                    <input type="text" name="shipping_address[state]">
                                </div>
                                <div class="col-half">
                                    <label>Zip<span>*</span></label>
                                    <input type="text" name="shipping_address[zip]">
                                </div>
                                <div class="col-full">
                                    <label>Order Notes (optional)</label>
                                    <textarea name="shipping_address['notes']"></textarea>
                                </div>
                                <div class="col-full save-address-checkbox">
                                    <input type="checkbox" id="save-address-checkbox-1" name="save_address"
                                           class="save_address">
                                    <label for="save-address-checkbox-1">Save address</label>
                                </div>
                            </div>
                            @auth
                                <div class="diff_ship">
                                    <h3>Ship to a different address?</h3>
                                    <input type="checkbox" name="ssss" id="shipdiff">
                                    <label for="shipdiff"></label>
                                </div>
                                @if(count($data['saved_addresses']) > 0)
                                    <div class="col-full" id="saved-address-container">

                                        <input type="hidden" id="saved-address-count"
                                               value="{{ count($data['saved_addresses']) }}">
                                        @foreach($data['saved_addresses'] as $address)
                                            <input type="radio" name="address_id"
                                                   id="saved-address-id-{{ $address->id }}" class="saved-address-radio"
                                                   value="{{ $address->id }}">
                                            <label
                                                for="saved-address-id-{{ $address->id }}">{{ $address->first_name." ".$address->lasst_name }}
                                                , {{ $address->address }}, {{ $address->city }}, {{ $address->state }}
                                                , {{ $address->zip }}</label>
                                            <br>
                                        @endforeach
                                    </div>
                                @else
                                    <input type="hidden" id="saved-address-count" value="0">
                                    <div class="col-full" id="no-saved-address-container">
                                        <h3>No saved address</h3>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 checkoutorder">
                        <h3>Your Order</h3>
                        <div class="cart_total">
                            <ul>
                                <li>Subtotal <span>${{ $data['order_total'] }}</span></li>
                                <li>Tax <span>$0</span></li>
                                <li>Delivery Charges <span>$10</span></li>
                                @php
                                    $finalTotal = $data['order_total'] + 10;
                                @endphp
                                <li>Total <span>${{ $finalTotal }}</span></li>
                            </ul>
                            <div class="paymentmethod">
                                {{--<img src="{{ asset('images/paymentmethod.jpg') }}">--}}
                                <h3>Payment Method</h3>
                                <div class="md-radio md-radio-inline">
                                    <input id="3" type="radio" name="payment_method" value="cod" checked>
                                    <label for="3">COD</label>
                                </div>
                                <div class="md-radio md-radio-inline">
                                    <input id="4" type="radio" name="payment_method" value="paypal">
                                    <label for="4">PayPal</label>
                                </div>
                            </div>
                            <div class="place_order">
                                <a onclick="document.getElementById('place-order-form').submit()" href="#">Place
                                    Order</a>
                            </div>
                        </div>
                        <div class="special_img">
                            <img src="images/special_img.png">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('page_script')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".update-cart").click(function (e) {
                e.preventDefault();
                var ele = $(this);
                $.ajax({
                    url: '{{ url('update-cart') }}',
                    method: "patch",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.attr("data-id"),
                        quantity: ele.parents("tr").find(".quantity").val()
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            });

            $("body").on("change", ".item-quantity", function () {
                var quantity = $(this).val();
                var cart_id = $(this).parents("tr").data("cart-id");

                $.ajax({
                    url: "{{ route('update.cart') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        quantity: quantity,
                        cart_id: cart_id,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        if (response.success) {
                            $(".cart-items-container").html(response.html);
                        }
                    },
                    error: function () {

                    }
                });
            });

            $("body").on("click", ".delete-cart-item", function () {
                swal({
                    title: "Are you sure?",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            var cart_id = $(this).parents("tr").data("cart-id");

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
                                        $(".cart-items-container").html(response.html);
                                    }
                                },
                                error: function () {

                                }
                            });
                        }
                    });
            });

            /*$(".remove-from-cart").click(function (e) {
                e.preventDefault();
                var ele = $(this);
                if (confirm("Are you sure")) {
                    $.ajax({
                        url: '{{ url('remove-from-cart') }}',
                        method: "DELETE",
                        data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                        success: function (response) {
                            window.location.reload();
                        }
                    });
                }
            });*/

            $("#shipdiff").on("change", function () {
                const savedAddressCount = $("#saved-address-count").val();
                if ($(this).is(":checked")) {
                    if (savedAddressCount > 0) {
                        $("#new-address-container").hide();
                        $("#saved-address-container").show();

                        $("#no-saved-address-container").hide();
                    } else {
                        $("#no-saved-address-container").show();
                    }
                } else {
                    $("#new-address-container").show();
                    $("#saved-address-container").hide();

                    $("#no-saved-address-container").hide();
                }
            });
        });
    </script>
@endsection
@section('page_style')
    <style>
        .empty-cart-container {
            text-align: center;
        }

        /*.save-address-checkbox #save-address-checkbox-1, .saved-address-radio {
            position: inherit !important;
            opacity: 1 !important;
            visibility: inherit !important;
        }*/

        #saved-address-container, #no-saved-address-container {
            display: none;
        }

        input#save-address-checkbox-1 {
            display: none;
        }
    </style>
@endsection
