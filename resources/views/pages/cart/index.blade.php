@extends('layouts.default')
@section('content')
    <div class="inner_banner title_banner" style="background-image: url(images/inner_banner.jpg);">
        <div class="container">
            <div class="row">
                <div class='col-md-12 col-sm-12'>
                    <div class="page-title"><h2>Cart</h2></div>
                </div>
            </div>
        </div>
    </div>

    <div class="content_sec">
        <div class="container cart-items-container">
            @if(!empty($data['data']))
                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <div class="cart_table">
                            <table>
                                <tr>
                                    <th>Ordered Dishes</th>
                                    <th>Price</th>
                                    <th>Quatity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>

                                <?php $total = 0 ?>
                                @if(!empty($data['data']))
                                    @foreach($data['data'] as $key => $menu)
                                        @php
                                            $total += $menu['price'] * $menu['quantity'];
                                        @endphp
                                        <tr data-cart-id="{{ $menu['id'] }}">
                                            <td class="cart_img">
                                                <div class="productimg">
                                                    <img width="80px"
                                                         src="{{ $menu['product_detail']['image'] }}">
                                                </div>
                                                <div class="productname">{{ $menu['product_detail']['dishname'] }}</div>
                                            </td>
                                            <td class="cartprice">$ {{ $menu['price']}}</td>
                                            <td class="cart_qty">
                                                <input type="number" class="item-quantity" name="quantity"
                                                       value="{{ $menu['quantity'] }}" min="1" max="5">
                                            </td>
                                            <td class="carttotal">$ {{$menu['price'] * $menu['quantity']}}</td>
                                            <td class="cartremove">
                                                {{--<button class="btn btn-info btn-sm update-cart" data-id="{{ $key }}"><i
                                                        class="far fa-sync-alt"></i></button>--}}
                                                @auth

                                                @endauth
                                                <button class="btn btn-danger btn-sm remove-from-cart delete-cart-item"
                                                        data-id="{{ $key }}">
                                                    <i class="far fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>

                        <!--<div class="coupon">
                            <h4>Apply Coupon Code</h4>
                            <form>
                                <input type="text" name="" placeholder="Coupon code">
                                <input type="submit" name="" value="Apply Coupon">
                            </form>
                        </div>
                        <div class="picupordelivery">
                            <h4>Apply Coupon Code</h4>
                            <form>
                                <span><input type="radio" name="pickupdelivery" id="delivery"><label for="delivery">Delivery</label></span>
                                <span><input type="radio" name="pickupdelivery" id="pickup"><label for="pickup">Pickup</label></span>
                            </form>
                        </div>-->

                    </div>

                    <div class="col-lg-4 col-sm-12">
                        <div class="cart_total">
                            <h3>Cart Total</h3>
                            <ul>
                                <li>Subtotal <span>$ {{ $total }}</span></li>
                                <!--<li>Total <span>${{ $total }}</span></li>-->
								<li>Delivery and Tax will be calculated at checkout</li>
                            </ul>
                        <!--<div class="updatecrt">
                       <a href="{{ route('updatecart') }}">Update Cart</a>
                    </div>-->
                            <div class="checkout_btn">
                                <a href="{{ route('checkout') }}">Checkout</a>
                            </div>
                        </div>
                        <div class="special_img">
                            <img src="images/special_img.png">
                        </div>
                    </div>

                </div>
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <div class="cart_table empty-cart-container">
                            <h3>Empty Cart</h3>
                            <a href="{{ route('restaurant.all') }}" class="btn btn-primary">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            @endif
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
                            if(response.session_cart) {
                                location.reload();
                            } else {
                                $(".cart-items-container").html(response.html);
                            }
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
                                        if(response.session_cart) {
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
