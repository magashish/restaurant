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
                            @if(empty(\Auth::user()->name))
                            <h6>Returning customer? <a href="{{ route('login') }}">Click here to login</a></h6><br>
                            @endif
                            <h5 style="color: red;" class="warning"></h5>
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
                                    <input type="text" value="{{ \Auth::user()->name ?? '' }}" name="shipping_address[first_name]" required>
                                    <input type="hidden" name="restaurant_id" value="{{ $data['restaurant'] }}" />
                                </div>
                                <div class="col-half">
                                    <label>Last Name<span>*</span></label>
                                    <input type="text" value="{{ \Auth::user()->name ?? '' }}" name="shipping_address[last_name]" required>
                                </div>
                                <div class="col-half">
                                    <label>Email Address<span>*</span></label>
                                    <input type="text" value="{{ \Auth::user()->email ?? '' }}" name="shipping_address[email]" required>
                                </div>
                                <div class="col-half">
                                    <label>Phone No.<span>*</span></label>
                                    <input type="text" name="shipping_address[mobile]" required>
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
                                    <input type="text" name="shipping_address[address]" required>
                                </div>
                                <div class="col-full">
                                    <label>Town/City<span>*</span></label>
                                    <input type="text" name="shipping_address[city]" required>
                                </div>
                                <div class="col-half">
                                    <label>State<span>*</span></label>
                                    <input type="text" name="shipping_address[state]" required>
                                </div>
                                <div class="col-half">
                                    <label>Zip<span>*</span></label>
                                    <input type="text" name="shipping_address[zip]" class="zipCode" required>
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
                            @php
                            $deliveryCharge = 0;
                            $tax = empty(session('tax')) ? 0 : session('tax');
                            @endphp
                            <ul>
                                <li>Subtotal <span>${{ $data['order_total'] }}</span></li>
                                <li>Tax <span class="tax_preview">${{ $tax }}</span></li>
                                <li>Delivery Charges <span>$<span id="delivery-charge">10</span></span></li>
                                @php
                                    $finalTotal = $data['order_total'] + $deliveryCharge + $tax;
                                @endphp
                                <li>Total <span>$<span id="final-total">{{ $finalTotal }}</span></span></li>
                            </ul>
                            <input type="hidden" name="order_total" id="order-total" value="{{ $data['order_total'] }}">
                            <input type="hidden" name="order_total_final" id="order-total-final" value="{{ $finalTotal }}">
                            <input type="hidden" name="delivery_charge" id="delivery-charge-hidden" value="0">
                            <input type="hidden" name="tax" id="tax" value="{{ $tax }}">
                            <div class="paymentmethod">
                                {{--<img src="{{ asset('images/paymentmethod.jpg') }}">--}}
                                <h3>Payment Method</h3>
                                <div class="md-radio md-radio-inline">
                                    <input id="3" type="radio" class="radio_check" name="payment_method" value="cod" checked>
                                    <label for="3">COD</label>
                                </div>
                                <div class="md-radio md-radio-inline">
                                    <input id="4" type="radio" class="radio_check" name="payment_method" value="paypal">
                                    <label for="4">PayPal</label>
                                </div>
                                <div class="md-radio md-radio-inline">
                                    <input id="5" type="radio" class="radio_check" name="payment_method" value="stripe">
                                    <label for="5">Stripe</label>
                                </div>
                            </div>
                            <div class="place_order">
                                <a onclick="check_login('{{ route('place.order') }}')" href="#">Place
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
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Stripe Card details</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="{{route('save.customer')}}">
                        @csrf
                        <div class="form-group">
                            <label for="username">Full name (on the card)</label>
                            <input type="text" name="name" placeholder="Random Name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="cardNumber">Card number</label>
                            <div class="input-group">
                                <input type="text" name="cc_number" placeholder="Your card number" class="form-control" required>
                                <div class="input-group-append">
                    <span class="input-group-text text-muted">
                                                <i class="fa fa-cc-visa mx-1"></i>
                                                <i class="fa fa-cc-amex mx-1"></i>
                                                <i class="fa fa-cc-mastercard mx-1"></i>
                                            </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label><span class="hidden-xs">Expiration</span></label>
                                    <div class="input-group">
                                        <input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==2) return false;"  placeholder="MM" name="month" class="form-control" required>
                                        <input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==4) return false;" placeholder="YYYY" name="year" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group mb-4">
                                    <label data-toggle="tooltip" title="Three-digits code on the back of your card">CVV
                                        <i class="fa fa-question-circle"></i>
                                    </label>
                                    <input type="text" name="cvv" required class="form-control">
                                </div>
                            </div>



                        </div>
                        <button type="submit" class="subscribe btn btn-primary btn-block rounded-pill shadow-sm"> Confirm  </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('page_script')
    <script type="text/javascript">
        function check_login(action) {
            @if(empty(\Auth::user()->name))
                swal("Please login/register before placing order");
            @else
                if($('input[name="shipping_address[zip]"]').val() !== '' && $('input[name="shipping_address[state]"]').val() !== '' && $('input[name="shipping_address[city]"]').val() !== '' || $('input[name="shipping_address[address]"]').val() !== '' && $('input[name="shipping_address[email]"]').val() !== '') {
                    document.getElementById('place-order-form').action = action;
                    document.getElementById('place-order-form').submit();
                } else {
                $('.warning').text('Please fill mandatory(*) fields');
            }
                /*document.getElementById('place-order-form').submit()*/
            @endif
        }
        $(document).ready(function () {
            @if(!empty(\Auth::user()->name))
                @if(empty(session('check_customer_stripe')))
                    $( "input[type=radio]" ).on( "click", function(e) {
                        if($(this).val() === 'stripe') {
                            $('#myModal').modal('show');
                        }
                    });
                @endif
            @endif
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

            $('.zipCode').on('input', function() {
                var zip = $(this).val();
                $.ajax({
                    url: "{{ route('check.tax') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        zip: zip,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        console.log(response.tax);
                        $('#tax').val(response.tax);
                        var order = $('#order-total-final').val();
                        var tax = response.tax;

                        var addTax = parseFloat(order) + parseFloat(tax);
                        
                        $('#order-total-final').val(addTax);
                        $('#final-total').text(addTax);
                        $('.tax_preview').text(response.tax);
                    },
                    error: function () {

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

            $.ajax({
                url: '{{ route('calculate.delivery.charge') }}',
                method: "post",
                data: {
                    _token: '{{ csrf_token() }}',
                    data: {
                        user: {
                            lat: "{{ \Auth::user()->lat ?? (Session::get('location')['lat'] ?? "29.5960") }}",
                            lng: "{{ \Auth::user()->lng ?? (Session::get('location')['lng'] ?? "76.1150") }}",
                        }
                    }
                },
                success: function (response) {
                    //window.location.reload();
                    if(response.success) {
                        $("#delivery-charge").text(response.delivery_charge);
                        $("#delivery-charge-hidden").val(response.delivery_charge);
                        var finalTotal = $("#final-total").text();
                        finalTotal = parseFloat(finalTotal) + parseFloat(response.delivery_charge);
                        finalTotal = finalTotal.toFixed(2);
                        $("#final-total").text(finalTotal);

                        $("#order-total-final").val(finalTotal);
                    }
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
