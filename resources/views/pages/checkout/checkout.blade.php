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
                            <h3>Billing details</h3>

                            <div class="col-half">
                                <label>First Name<span>*</span></label>
                                <input type="text" name="shipping_address[first_name]">
                            </div>
                            <div class="col-half">
                                <label>Last Name<span>*</span></label>
                                <input type="text" name="shipping_address[last_name]">
                            </div>
                            <div class="col-half">
                                <label>Email Address<span>*</span></label>
                                <input type="text" name="shipping_address[email]">
                            </div>
                            <div class="col-half">
                                <label>Phone No.<span>*</span></label>
                                <input type="text" name="shipping_address[mobile]">
                            </div>
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
                            <div class="diff_ship">
                                <h3>Ship to a different address?</h3>
                                <input type="checkbox" name="" id="shipdiff">
                                <label for="shipdiff"></label>
                            </div>

                            <div class="col-full">
                                <label>Order Notes</label>
                                <textarea></textarea>
                            </div>
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
                                <a onclick="document.getElementById('place-order-form').submit()" href="#">Place Order</a>
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
        });
    </script>
@endsection
@section('page_style')
    <style>
        .empty-cart-container {
            text-align: center;
        }
    </style>
@endsection
