@extends('layouts.default')
@section('content')
    <div class="inner_banner title_banner" style="background-image: url(images/inner_banner.jpg);">
        <div class="container">
            <div class="row">
                <div class='col-md-12 col-sm-12'>
                    <div class="page-title"><h2 id="booking_heading">Checkout</h2></div>
                </div>
            </div>
        </div>
    </div>

    <div class="content_sec">
        <!-- <form id="place-order-form" method="post" class="billingform" action="{{ route('place.order') }}"> -->
            <div class="container billing-address-container">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <div class="billingdetail">
                            @guest
                                <h6>Returning customer? <a href="{{ route('login') }}">Click here to login</a></h6><br>
                            @endguest
                            <h3>Billing details</h3>
                            @if(Session::has('success'))
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                                    <div id="charge-message" class="alert alert-success">
                                        {{  Session::get('success') }}
                                    </div>
                                    </div>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="col-full">
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                </div>
                            @endif
                            <span class="hide" id="pricing_error2" style="color:#cd4040;font-size:17px;" ></span>
                            <div id="new-address-container">
                                <div class="col-half">
                                    <label>First Name<span>*</span></label>
                                    <input type="text" id="fName" value="{{ \Auth::user()->name ?? '' }}"
                                           name="shipping_address[first_name]">
                                </div>
                                <div class="col-half">
                                    <label>Last Name<span>*</span></label>
                                    <input type="text" id="lName" value="{{ \Auth::user()->last_name ?? '' }}"
                                           name="shipping_address[last_name]">
                                </div>
                                <div class="col-half">
                                    <label>Email Address<span>*</span></label>
                                    <input type="text" id="email" value="{{ \Auth::user()->email ?? '' }}"
                                           name="shipping_address[email]">
                                </div>
                                <div class="col-half">
                                    <label>Phone No.<span>*</span></label>
                                    <input type="text" id="mobile" name="shipping_address[mobile]"
                                           value="{{ \Auth::user()->mobile ?? '' }}" required>
                                </div>
                                @guest
                                    <input type="hidden" id="is_authenticated" name="is_authenticated" value="false">
                                    <div class="col-half">
                                        <label>Password<span>*</span></label>
                                        <input type="password" id="password" name="shipping_address[password]">
                                        
                                    </div>
                                    <div class="col-half">
                                        <label>Password Confirmation<span>*</span></label>
                                        <input type="password" id="password_confirmation" name="shipping_address[password_confirmation]">
                                        
                                    </div>
                                @endguest 
                                <div class="col-full">
                                    <label>Town/City<span>*</span></label>
                                    <input type="text" id="city" name="shipping_address[city]"
                                           value="{{ \Auth::user()->city ?? '' }}" required>
                                </div>
                                <div class="col-half">
                                    <label>State<span>*</span></label>
                                    <input type="text" id="state" name="shipping_address[state]"
                                           value="{{ \Auth::user()->state ?? '' }}" required>
                                </div>
                                <div class="col-half">
                                    <label>Country<span>*</span></label>
                                    <input type="text" id="country" name="shipping_address[country]"
                                           value="{{ \Auth::user()->country ?? '' }}" required>
                                </div>
                                <div class="col-full">
                                    <label>Address<span>*</span></label>
                                        <input type="text" class="address" id="address" name="shipping_address[address]" required  value="{{ \Auth::user()->address ?? '' }}">
                                </div>
                                <div class="col-half">
                                    <label>Zip<span>*</span></label>
                                    <input type="text" id="zip" name="shipping_address[zip]"
                                           value="{{ \Auth::user()->zip ?? '' }}" class="zipCode" required>
                                </div>
                                <div class="col-full">
                                    <label>Order Notes (optional)</label>
                                    <textarea name="shipping_address['notes']" id="notes"></textarea>
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
                                $tax = $zipTax ?? 0;
                                $deliveryCharge = 0;
                                //$tax = empty(session('tax')) ? 0 : session('tax');
                            @endphp
                            <ul>
                                <li>Subtotal <span>${{ $data['order_total'] }}</span></li>
                                <li>Tax <span class="tax_preview">${{ $tax }}</span></li>
                                <li>Delivery Charges <span>$<span id="delivery-charge">{{ $deliveryCharge }}</span></span></li>
                                @php
                                    $finalTotal = $data['order_total'] + $deliveryCharge + $tax;
                                @endphp
                                <li>Total <span>$<span id="final-total">{{ $finalTotal }}</span></span></li>
                            </ul>
                            <input type="hidden" name="order_total" id="order-total" value="{{ $data['order_total'] }}">
                            <input type="hidden" name="order_total_final" id="order-total-final"
                                   value="{{ $finalTotal }}">
                            <input type="hidden" name="delivery_charge" id="delivery-charge-hidden" value="0">
                            <input type="hidden" name="tax" id="tax" value="{{ $tax }}">
                            <div class="paymentmethod">
                                <h3>Self Pickup</h3>
                                <div class="md-radio md-radio-inline">
                                    <input id="1" type="radio" id="self_pickup" class="radio_check" name="self_pickup"  value="yes" checked>
                                    <label for="1">Yes</label>
                                </div>
                                <div class="md-radio md-radio-inline">
                                    <input  id="2" type="radio" id="self_pickup" class="radio_check" name="self_pickup" value="no">
                                    <label for="2">No</label>
                                </div>
                                <br>
                                <span><strong>Note:</strong> If yes then delivery charges will remove</span>
                            </div>
                            <div class="paymentmethod">
                                
                                <h3>Payment Method</h3>
                                <div class="md-radio md-radio-inline">
                                    <input id="3" type="radio" id="payment_method" class="radio_check" name="payment_method" value="cod"
                                           checked>
                                    <label for="3">COD</label>
                                </div>
                                
                                <div class="md-radio md-radio-inline">
                                    <input id="5" type="radio" id="payment_method" class="radio_check" name="payment_method" value="stripe">
                                    <label for="5">Stripe</label>
                                </div>
                            </div>
                            <div class="place_order">
                                <!-- <input type="submit" class="btn btn-success" id="place-order-btn-checkout"  disabled="disabled" /> -->
                                <!-- <button class="btn btn-success"  type="submit" id="place-order-btn-checkout">Continue</button> -->
                                <a id="place-order-btn-checkout" class="button" href="javascript:void(0)">Continue</a>

                            </div>
                        </div>
                        <div class="special_img">
                            <img src="images/special_img.png">
                        </div>
                    </div>
                </div>
            </div>
          
            <div id="stripe-payment-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if (Session::has('success'))
                                <div class="alert alert-success text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                </div>
                            @endif
                            
                            <form action="{{ '/place-order' }}" method="POST">
                                <div class="form-group">
                                    <label for="username">Full name (on the card)</label>
                                    <input type="text" name="name" placeholder="Name" required
                                        class="form-control" id="card-name"> 
                                </div>
                                <div class="form-group">
                                    <label for="cardNumber">Card number</label>
                                    <div class="input-group">
                                        <input type="text" name="cc_number" placeholder="Your card number"
                                            class="form-control" id="card-number"
                                            required>
                                        <div class="input-group-append">
                                                <span class="input-group-text text-muted">
                                                    <i class="fa fa-cc-visa"></i>
                                                    <i class="fa fa-cc-amex"></i>
                                                    <i class="fa fa-cc-mastercard"></i>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label><span class="hidden-xs">Expiration</span></label>
                                            <div class="input-group">
                                                <input type="number" pattern="/^-?\d+\.?\d*$/"
                                                    placeholder="MM" id="card-expiry-month"
                                                    name="month" class="form-control" required>
                                                <input type="number" pattern="/^-?\d+\.?\d*$/"
                                                    placeholder="YYYY" id="card-expiry-year"
                                                    name="year" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group mb-4">
                                            <label data-toggle="tooltip"
                                                title="Three-digits code on the back of your card">CVV
                                                <i class="fa fa-question-circle"></i>
                                            </label>
                                            <input type="text" id="card-cvc" name="cvv" required class="form-control">
                                        </div>
                                    </div>
                                </div>
                                 <!-- <div class='form-row'>
                                        <div class='col-md-12 error form-group hide'>
                                            <div class='alert-danger alert errmsg'>Please correct the errors and try again.</div>
                                        </div>
                                 </div> -->
                                <button type="submit" id="filldetails"
                                        class="subscribe btn btn-primary btn-block rounded-pill shadow-sm">
                                    Confirm
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <!-- </form> -->


        <div class="modal" tabindex="-1" role="dialog" id="cod-payment-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ '/place-order' }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">COD Confirmation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to choose this method of payment?</p>
                        </div>
                        <input type = "hidden" data-id="" id="confirmCOD" >
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success confirm_delete" onclick="opencodconfirmation();" id="confirm-cod">Confirm</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

       
        <div class="modal fade" id="ignismyModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="opencartpage();" aria-label=""><span>×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="thank-you-pop">
                            <img src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png" alt="">
                            <h1>Thank You!</h1>
                            <p id="vc">Your submission is received and we will contact you soon</p>
                            <h3 class="cupon-pop" id="oid">Your Id: <span>12345</span></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="errorModal" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body text-center">
                        <h4>Ooops!</h4>	
                        <p id ="vcs">Something went wrong. File was not uploaded.</p>
                        <button class="btn btn-success" data-dismiss="modal" onclick="reloadpage();">Try Again</button>
                    </div>
                </div>
            </div>
        </div>    

    </div>
   
@endsection
@section('page_script')
<script src="https://js.stripe.com/v2/"></script>
<script src="https://js.stripe.com/v3/"></script>

    <script type="text/javascript">
        function check_login(action) {
            @if(empty(\Auth::user()->name))
            swal("Please login/register before placing order");
            @else
            if ($('input[name="shipping_address[zip]"]').val() !== '' && $('input[name="shipping_address[state]"]').val() !== '' && $('input[name="shipping_address[city]"]').val() !== '' || $('input[name="shipping_address[address]"]').val() !== '' && $('input[name="shipping_address[email]"]').val() !== '') {
                document.getElementById('place-order-form').action = action;
                document.getElementById('place-order-form').submit();
            } else {
                $('.warning').text('Please fill mandatory(*) fields');
            }
            /*document.getElementById('place-order-form').submit()*/
            @endif
        }

        function opencartpage()
        {
             window.location.href = "/cart";
        }

        function reloadpage()
        {
            location.reload();
        }
        function opencodconfirmation()
        {
            var first_name = $("#fName").val();
            var last_name = $("#lName").val();
            var email = $("#email").val();
            var mobile = $("#mobile").val();
            var is_authenticated =$("#is_authenticated").val();
            var password = $("#password").val();
            var password_confirmation = $("#password_confirmation").val();
            var address = $("#address").val();
            var city = $("#city").val();
            var state = $("#state").val();
            var zip = $("#zip").val();
            var notes = document.getElementById('notes').value;
            var save_address = $("input[name='save_address']:checked").val();
            var address_count = $("#saved-address-count").val();
            var address_id = $("input[name='address_id']:checked").val();
            var order_total = $("#order-total").val();
            var order_total_final = $("#order-total-final").val();
            var delivery_charge_hidden = $("#delivery-charge-hidden").val();
            var tax = $("#tax").val();
            var self_pickup = $("#self_pickup").val();
            var paymentMethod = $("input[name='payment_method']:checked").val();
            var shipping_address = [];
            shipping_address.push(first_name);
            shipping_address.push(last_name);
            shipping_address.push(email);
            shipping_address.push(mobile);
            shipping_address.push(password);
            shipping_address.push(password_confirmation);
            shipping_address.push(address);
            shipping_address.push(city);
            shipping_address.push(state);
            shipping_address.push(zip);
            shipping_address.push(notes);
            console.log(shipping_address);
            $.ajax({
                        type:'POST',
                        url:'/place-order',
                        data:{"_token": $("input[name='_token']").val(),is_authenticated:is_authenticated,shipping_address:shipping_address,save_address:save_address,address_count:address_count,address_id:address_id,order_total:order_total,order_total_final:order_total_final,delivery_charge_hidden:delivery_charge_hidden,tax:tax,self_pickup:self_pickup,paymentMethod}, 
                        success:function(response){
                            if(response.status == 'error') {
                            $('#cod-payment-modal').modal('hide');
                            document.getElementById("vcs").innerHTML =response.message;
                            $('#errorModal').modal('show');
                            // location.reload();
                            }
                            if(response.status == 'success') {
                            $('#cod-payment-modal').modal('hide');
                            document.getElementById("vc").innerHTML =response.message;
                            document.getElementById("oid").innerHTML = 'Your Order Id is ' + response.oid;
                            $('#ignismyModal').modal('show');
                            // window.location.href = "/cart";
                            }
                        },
                        complete:function(data){
                            $("#confirm-cod").html('Submit');
                            $("#confirm-cod").removeAttr("disabled");
                            },
                        error: function(data, errorThrown)
                        {
                        alert('error');
                        }
                    });
        }

        $(document).ready(function () {
            @if(!empty(\Auth::user()->name))
            @if(empty(session('check_customer_stripe')))
            $("input[type=radio]").on("click", function (e) {
                if ($(this).val() === 'stripe') {
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

            $('.zipCode').on('input', function () {
                var zip = $(this).val();
                $.ajax({
                    url: "{{ route('input.check.tax') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        zip: zip,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        console.log(response.tax);
                        $('#tax').val(response.tax);
                        var order = $('#order-total').val();
                        var tax = response.tax;

                        var delivery_charges = $("#delivery-charge-hidden").val();

                        var addTax = parseFloat(order) + parseFloat(tax) + parseFloat(delivery_charges);

                        $('#order-total-final').val(addTax.toFixed(2));
                        $('#final-total').text(addTax.toFixed(2));
                        $('.tax_preview').text("$" + response.tax);
                    },
                    error: function () {

                    }
                });
            });

            // $('.address').on('change', function () {
            //   var address =  document.getElementById('address').value;
            //   var city =  document.getElementById('city').value;
            //   var state = document.getElementById('state').value;
            //   var country = document.getElementById('country').value;
            //     $.ajax({
            //         url: "{{ route('input.calculate.delivery.charge') }}",
            //         type: "POST",
            //         dataType: "JSON",
            //         data: {
            //             _token: '{{ csrf_token() }}',
            //             data: {
            //             user: {
            //                 address : address,
            //                 city : city,
            //                 state : state,
            //                 country : country
            //             }
            //         }  
            //         },
            //         success: function (response) {
            //         console.log(response);
            //         if (response.delivery_charge != 0 ) {
            //             $("#delivery-charge").text(response.delivery_charge);
            //             $("#delivery-charge-hidden").val(response.delivery_charge);
            //             var order = $('#order-total').val();
                        
            //             var delivery_charge = response.delivery_charge;
                        
            //             var tax = $("#tax").val();
                        
            //             var finalTotal = parseFloat(order) + parseFloat(delivery_charge) + parseFloat(tax);
                       
            //             $('#order-total-final').val(finalTotal.toFixed(2));
            //             $('#final-total').text(finalTotal.toFixed(2));
                        
            //         }
            //         else if(response.message == 'Please Enter the Address'){
            //             alert(response.message);
                       
            //             $('#delivery-charge-hidden').val(response.delivery_charge);
            //             var order = $('#order-total').val();
                       
            //             var delivery_charge = response.delivery_charge;
                        
            //             var tax = $("#tax").val();
                        
            //             var adddeliveryCharge = parseFloat(order) + parseFloat(delivery_charge) + parseFloat(tax);
                      
            //             $('#order-total-final').val(adddeliveryCharge.toFixed(2));
            //             $('#final-total').text(adddeliveryCharge.toFixed(2));
            //             $('#delivery-charge').text(response.delivery_charge);
            //         }
            //         else if(response.message == 'This restraunt can not serve you at your location'){
            //             alert(response.message);
            //             $('#delivery-charge-hidden').val(response.delivery_charge);
            //             var order = $('#order-total').val();
                       
            //             var delivery_charge = response.delivery_charge;
                      
            //             var tax = $("#tax").val();
                       
            //             var adddeliveryCharge = parseFloat(order) + parseFloat(delivery_charge) + parseFloat(tax);
                        
            //             $('#order-total-final').val(adddeliveryCharge.toFixed(2));
            //             $('#final-total').text(adddeliveryCharge.toFixed(2));
            //             $('#delivery-charge').text(response.delivery_charge);
            //         }
            //     }
                   
            //     });
            // });

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

            $('#filldetails').on('click', function(e)
            {
                e.preventDefault();
                $('.has-error').removeClass('has-error');
                $('.error').addClass('hide')
                valid = true;
                if(document.getElementById('card-name').value=='')
                {
                document.getElementById('card-name').parentElement.className = "has-error";
                $('.errmsg').html('Please enter your card name');
                $('.hide').removeClass('hide');
                valid = false;
                return false;
                }
                else if(document.getElementById('card-number').value=='')
                {
                document.getElementById('card-number').parentElement.className = "has-error";
                $('.errmsg').html('Please enter your card number');
                $('.hide').removeClass('hide');
                valid = false;
                return false;
                }
                else if(document.getElementById('card-cvc').value=='')
                {
                document.getElementById('card-cvc').parentElement.className = "has-error";
                $('.errmsg').html('Please enter your card CVV number');
                $('.hide').removeClass('hide');
                valid = false;
                return false;
                }
                else if(document.getElementById('card-expiry-month').value=='')
                {
                document.getElementById('card-expiry-month').parentElement.className = "has-error";
                $('.errmsg').html('Please enter your card Expiry Month : eg: 01');
                $('.hide').removeClass('hide');
                valid = false;
                return false;
                }
                else if(document.getElementById('card-expiry-year').value=='')
                {
                document.getElementById('card-expiry-year').parentElement.className = "has-error";
                $('.errmsg').html('Please enter your card Expiry Year : eg: 2021');
                $('.hide').removeClass('hide');
                valid = false;
                return false;
                }
                
                //=== If no error then call stripe function ======================
                if(valid==true)
                {
                $("#filldetails").html('<span class="spinner"><i class="fa fa-spinner fa-spin"></i></span> Loading ...');
                $("#filldetails").attr('disabled','disabled');
                Stripe.setPublishableKey('<?php echo $stripe->stripe_p_key ?>');
                Stripe.createToken({
                    number: $('#card-number').val(),
                    cvc: $('#card-cvc').val(),
                    exp_month: $('#card-expiry-month').val(),
                    exp_year: $('#card-expiry-year').val()
                    }, stripeResponseHandler);
                }

                function stripeResponseHandler(status, response)
                {
                    if (response.error) {
                            $("#filldetails").html('Submit');
                            $("#filldetails").removeAttr("disabled");
                            $('.error').removeClass('hide').find('.alert').text(response.error.message);
                    } else {
                        var token = response.id;
                        var card_name = $("#card-name").val();
                        var first_name = $("#fName").val();
                        var last_name = $("#lName").val();
                        var email = $("#email").val();
                        var mobile = $("#mobile").val();
                        var is_authenticated =$("#is_authenticated").val();
                        var password = $("#password").val();
                        var password_confirmation = $("#password_confirmation").val();
                        var address = $("#address").val();
                        var city = $("#city").val();
                        var state = $("#state").val();
                        var zip = $("#zip").val();
                        var notes = document.getElementById('notes').value;
                        var save_address = $("input[name='save_address']:checked").val();
                        var address_count = $("#saved-address-count").val();
                        var address_id = $("input[name='address_id']:checked").val();
                        var order_total = $("#order-total").val();
                        var order_total_final = $("#order-total-final").val();
                        var delivery_charge_hidden = $("#delivery-charge-hidden").val();
                        var tax = $("#tax").val();
                        var self_pickup = $("#self_pickup").val();
                        var paymentMethod = $("input[name='payment_method']:checked").val();
                        var shipping_address = [];
                        shipping_address.push(first_name);
                        shipping_address.push(last_name);
                        shipping_address.push(email);
                        shipping_address.push(mobile);
                        shipping_address.push(password);
                        shipping_address.push(password_confirmation);
                        shipping_address.push(address);
                        shipping_address.push(city);
                        shipping_address.push(state);
                        shipping_address.push(zip);
                        shipping_address.push(notes);
                        $.ajax({
                        type:'POST',
                        url:'/place-order',
                        data:{"_token": $("input[name='_token']").val(),stripetoken:token,is_authenticated:is_authenticated,shipping_address:shipping_address,save_address:save_address,address_count:address_count,address_id:address_id,order_total:order_total,order_total_final:order_total_final,delivery_charge_hidden:delivery_charge_hidden,tax:tax,self_pickup:self_pickup,paymentMethod}, 
                        success:function(response){
                            if(response.status == 'error') {
                            $('#stripe-payment-modal').modal('hide');
                            document.getElementById("vcs").innerHTML = response.message;
                            $('#errorModal').modal('show');
                            // location.reload();
                            }
                            if(response.status == 'success') {
                            $('#stripe-payment-modal').modal('hide')
                            document.getElementById("vc").innerHTML =response.message;
                            document.getElementById("oid").innerHTML = 'Your Order Id is ' + response.oid;
                            $('#ignismyModal').modal('show')
                            // window.location.href = "/thank-you";
                            }
                        },
                        complete:function(data){
                            $("#filldetails").html('Submit');
                            $("#filldetails").removeAttr("disabled");
                            },
                        error: function(response, errorThrown)
                        {
                        alert('error');
                        }
                    });
                    }
                }
                return false;
            });

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
          
            // $.ajax({
            //     url: '{{ route('calculate.delivery.charge') }}',
            //     method: "post",
            //     data: {
            //         _token: '{{ csrf_token() }}',
            //         data: {
            //             user: {
            //                 lat: "{{ \Auth::user()->lat ?? (Session::get('location')['lat'] ?? "0") }}",
            //                 lng: "{{ \Auth::user()->lng ?? (Session::get('location')['lng'] ?? "0") }}",
            //             }
            //         }
            //     },
            //     success: function (response) {
            //             console.log(response);
            //         if (response.delivery_charge != 0 ) {
            //             alert('in');
            //             $("#delivery-charge").text(response.delivery_charge);
            //             $("#delivery-charge-hidden").val(response.delivery_charge);
            //             var finalTotal = $("#final-total").text();
            //             finalTotal = parseFloat(finalTotal) + parseFloat(response.delivery_charge);
            //             finalTotal = finalTotal.toFixed(2);
            //             $("#final-total").text(finalTotal);
            //             $("#order-total-final").val(finalTotal);
            //             // $('#delivery-charge').text(response.tax);
                      
            //         }
            //         else{
            //             $("#delivery-charge").text(response.delivery_charge);
            //             $("#delivery-charge-hidden").val(response.delivery_charge);
            //             var finalTotal = $("#final-total").text();
            //             finalTotal = parseFloat(finalTotal) + parseFloat(response.delivery_charge);
            //             finalTotal = finalTotal.toFixed(2);
            //             $("#final-total").text(finalTotal);
            //             $("#order-total-final").val(finalTotal);
            //             // $('#delivery-charge').text(response.tax);
            //             // alert(response.message);
            //             //$("#booking_heading").html('<div class="alert alert-danger">This restraunt can not serve you at your location</div>');

            //         }
            //     }
            // });

            $.ajax({
                    url: "{{ route('check.tax') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        
                        zip: "{{ \Auth::user()->zip ?? "0" }}",
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        console.log(response);
                        $('#tax').val(response.tax);
                        var order = $('#order-total').val();
                        var tax = response.tax;

                        var delivery_charges = $("#delivery-charge-hidden").val();

                        var addTax = parseFloat(order) + parseFloat(tax) + parseFloat(delivery_charges);

                        $('#order-total-final').val(addTax.toFixed(2));
                        $('#final-total').text(addTax.toFixed(2));
                        $('.tax_preview').text("$" + response.tax);
                    },
                    error: function () {

                    }
            });

            $("#place-order-btn-checkout").on("click", function (e) {
                var err = 0;
                if($("#fName").val()=="")
                {    
                    $("#pricing_error2").removeClass("hide");
                    $("#pricing_error2").addClass("show");
                    $("#pricing_error2").html('Please enter your first name!');
                    $("#fName" ).focus();
                    var err=1;
                }
                
                else if($("#lName").val()=="")
                {    
                    $("#pricing_error2").removeClass("hide");
                    $("#pricing_error2").addClass("show");
                    $("#pricing_error2").html('Please enter your last name!');
                    $("#lName" ).focus();
                    var err=1;
                }

                else if($("#email").val()=="")
                {    
                    $("#pricing_error2").removeClass("hide");
                    $("#pricing_error2").addClass("show");
                    $("#pricing_error2").html('Please enter your email!');
                    $("#email" ).focus();
                    var err=1;
                }

                else if($("#mobile").val()=="")
                {    
                    $("#pricing_error2").removeClass("hide");
                    $("#pricing_error2").addClass("show");
                    $("#pricing_error2").html('Please enter your mobile number!');
                    $("#mobile" ).focus();
                    var err=1;
                }

                else if($("#city").val()=="")
                {    
                    $("#pricing_error2").removeClass("hide");
                    $("#pricing_error2").addClass("show");
                    $("#pricing_error2").html('Please enter your city!');
                    $("#city" ).focus();
                    var err=1;
                }

                else if($("#state").val()=="")
                {    
                    $("#pricing_error2").removeClass("hide");
                    $("#pricing_error2").addClass("show");
                    $("#pricing_error2").html('Please enter your state!');
                    $("#state" ).focus();
                    var err=1;
                }

                else if($("#country").val()=="")
                {    
                    $("#pricing_error2").removeClass("hide");
                    $("#pricing_error2").addClass("show");
                    $("#pricing_error2").html('Please enter your country!');
                    $("#country" ).focus();
                    var err=1;
                }

                else if($("#address").val()=="")
                {    
                    $("#pricing_error2").removeClass("hide");
                    $("#pricing_error2").addClass("show");
                    $("#pricing_error2").html('Please enter your street address!');
                    $("#address" ).focus();
                    var err=1;
                }

                else if($("#zip").val()=="")
                {    
                    $("#pricing_error2").removeClass("hide");
                    $("#pricing_error2").addClass("show");
                    $("#pricing_error2").html('Please enter your zipcode!');
                    $("#zip" ).focus();
                    var err=1;
                }

                if(err == 0)
                {
                    $("#pricing_error2").removeClass("show");
                    $("#pricing_error2").addClass("hide");
                    $("#pricing_error2").html('');
                    var paymentMethod = $("input[name='payment_method']:checked").val();
                    if (paymentMethod == "stripe") {
                    // $("#stripe-payment-modal").find('input:text').val('');
                    $("#stripe-payment-modal").modal('show');
                    } else if (paymentMethod == "cod") {
                    // $("#place-order-form").submit();
                    $("#cod-payment-modal").modal('show');
                    }
                }
            });

           

            $("input[name='self_pickup']").on("change", function () {

                var err = 0;
                if($("#city").val()=="")
                {    
                    $("#pricing_error2").removeClass("hide");
                    $("#pricing_error2").addClass("show");
                    $("#pricing_error2").html('Please enter your city first!');
                    $("#city" ).focus();
                   $(this).prop('checked', false);
                    var err=1;
                }
                else if($("#state").val()=="")
                {    
                    $("#pricing_error2").removeClass("hide");
                    $("#pricing_error2").addClass("show");
                    $("#pricing_error2").html('Please enter your state first!');
                    $("#state" ).focus();
                   $(this).prop('checked', false);
                    var err=1;
                }

                else if($("#country").val()=="")
                {    
                    $("#pricing_error2").removeClass("hide");
                    $("#pricing_error2").addClass("show");
                    $("#pricing_error2").html('Please enter your country first!');
                    $("#country" ).focus();
                   $(this).prop('checked', false);
                    var err=1;
                }

                else if($("#address").val()=="")
                {    
                    $("#pricing_error2").removeClass("hide");
                    $("#pricing_error2").addClass("show");
                    $("#pricing_error2").html('Please enter your address first!');
                    $("#address" ).focus();
                   $(this).prop('checked', false);
                    var err=1;
                }
                if(err == 0)
                {
                    $("#pricing_error2").removeClass("show");
                    $("#pricing_error2").addClass("hide");
                    $("#pricing_error2").html('');
                    var self_delivery = $("input[name='self_pickup']:checked").val();
                    var delivery_charge_hidden = $("#delivery-charge-hidden").val();
                    var final_total = $("#final-total").text();
                    final_total = parseFloat(final_total);
                    delivery_charge_hidden = parseFloat(delivery_charge_hidden);

                    if (self_delivery == "yes") {
                        // alert('in');
                        var finalPrice = final_total - delivery_charge_hidden;
                        finalPrice = finalPrice.toFixed(2);

                        $("#delivery-charge").text("0");
                        $("#final-total").text(finalPrice);
                        $("#order-total-final").val(finalPrice);
                    } else {
                        // alert('out');
                        // var finalPrice = final_total + delivery_charge_hidden;
                        // finalPrice = finalPrice.toFixed(2);
                        // $("#delivery-charge").text(delivery_charge_hidden);
                        // $("#final-total").text(finalPrice);
                        // $("#order-total-final").val(finalPrice);
                        var address =  document.getElementById('address').value;
                        var city =  document.getElementById('city').value;
                        var state = document.getElementById('state').value;
                        var country = document.getElementById('country').value;
                        $.ajax({
                            url: "{{ route('input.calculate.delivery.charge') }}",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                _token: '{{ csrf_token() }}',
                                data: {
                                user: {
                                    address : address,
                                    city : city,
                                    state : state,
                                    country : country
                                }
                            }  
                            },
                            success: function (response) {
                            console.log(response);
                            if (response.delivery_charge != 0 ) {
                                // alert('in');
                                $("#delivery-charge").text(response.delivery_charge);
                                $("#delivery-charge-hidden").val(response.delivery_charge);
                                var order = $('#order-total').val();
                                
                                var delivery_charge = response.delivery_charge;
                                
                                var tax = $("#tax").val();
                                
                                var finalTotal = parseFloat(order) + parseFloat(delivery_charge) + parseFloat(tax);
                            
                                $('#order-total-final').val(finalTotal.toFixed(2));
                                $('#final-total').text(finalTotal.toFixed(2));
                                
                            }
                            else if(response.message == 'Please Enter the Address'){
                                // alert(response.message);
                            
                                $('#delivery-charge-hidden').val(response.delivery_charge);
                                var order = $('#order-total').val();
                            
                                var delivery_charge = response.delivery_charge;
                                
                                var tax = $("#tax").val();
                                
                                var adddeliveryCharge = parseFloat(order) + parseFloat(delivery_charge) + parseFloat(tax);
                            
                                $('#order-total-final').val(adddeliveryCharge.toFixed(2));
                                $('#final-total').text(adddeliveryCharge.toFixed(2));
                                $('#delivery-charge').text(response.delivery_charge);
                            }
                            else if(response.message == 'This restraunt can not serve you at your location'){
                                // alert(response.message);
                                $('#delivery-charge-hidden').val(response.delivery_charge);
                                var order = $('#order-total').val();
                            
                                var delivery_charge = response.delivery_charge;
                            
                                var tax = $("#tax").val();
                            
                                var adddeliveryCharge = parseFloat(order) + parseFloat(delivery_charge) + parseFloat(tax);
                                
                                $('#order-total-final').val(adddeliveryCharge.toFixed(2));
                                $('#final-total').text(adddeliveryCharge.toFixed(2));
                                $('#delivery-charge').text(response.delivery_charge);
                            }
                        }
                        
                        });
                    }
                }
                
            });

            $("#submit-checkout-payment-form").on("click", function () {
                $("#place-order-form").submit();
            });
        });
    </script>
@endsection
@section('page_style')
    <style>

body {
		font-family: 'Varela Round', sans-serif;
	}
	.modal-confirm {		
		color: #434e65;
		width: 525px;
		margin: 30px auto;
	}
	.modal-confirm .modal-content {
		padding: 20px;
		font-size: 16px;
		border-radius: 5px;
		border: none;
	}
	.modal-confirm .modal-header {
		background: #e85e6c;
		border-bottom: none;   
        position: relative;
		text-align: center;
		margin: -20px -20px 0;
		border-radius: 5px 5px 0 0;
		padding: 35px;
	}
	.modal-confirm h4 {
		text-align: center;
		font-size: 36px;
		margin: 10px 0;
	}
	.modal-confirm .form-control, .modal-confirm .btn {
		min-height: 40px;
		border-radius: 3px; 
	}
	.modal-confirm .close {
        position: absolute;
		top: 15px;
		right: 15px;
		color: #fff;
		text-shadow: none;
		opacity: 0.5;
	}
	.modal-confirm .close:hover {
		opacity: 0.8;
	}
	.modal-confirm .icon-box {
		color: #fff;		
		width: 95px;
		height: 95px;
		display: inline-block;
		border-radius: 50%;
		z-index: 9;
		border: 5px solid #fff;
		padding: 15px;
		text-align: center;
	}
	.modal-confirm .icon-box i {
		font-size: 58px;
		margin: -2px 0 0 -2px;
	}
	.modal-confirm.modal-dialog {
		margin-top: 80px;
	}
    .modal-confirm .btn {
        color: #fff;
        border-radius: 4px;
		background: #eeb711;
		text-decoration: none;
		transition: all 0.4s;
        line-height: normal;
		border-radius: 30px;
		margin-top: 10px;
		padding: 6px 20px;
		min-width: 150px;
        border: none;
    }
	.modal-confirm .btn:hover, .modal-confirm .btn:focus {
		background: #eda645;
		outline: none;
	}
	.trigger-btn {
		display: inline-block;
		margin: 100px auto;
	}
        /*--thank you pop starts here--*/
        .thank-you-pop{
            width:100%;
            padding:20px;
            text-align:center;
        }
        .thank-you-pop img{
            width:76px;
            height:auto;
            margin:0 auto;
            display:block;
            margin-bottom:25px;
        }

        .thank-you-pop h1{
            font-size: 42px;
            margin-bottom: 25px;
            color:#5C5C5C;
        }
        .thank-you-pop p{
            font-size: 20px;
            margin-bottom: 27px;
            color:#5C5C5C;
        }
        .thank-you-pop h3.cupon-pop{
            font-size: 25px;
            margin-bottom: 40px;
            color:#222;
            display:inline-block;
            text-align:center;
            padding:10px 20px;
            border:2px dashed #222;
            clear:both;
            font-weight:normal;
        }
        .thank-you-pop h3.cupon-pop span{
            color:#03A9F4;
        }
        .thank-you-pop a{
            display: inline-block;
            margin: 0 auto;
            padding: 9px 20px;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
            background-color: #8BC34A;
            border-radius: 17px;
        }
        .thank-you-pop a i{
            margin-right:5px;
            color:#fff;
        }
        #ignismyModal .modal-header{
            border:0px;
        }
        /*--thank you pop ends here--*/

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
    <style>
        .payment-form-container .row {
            display: -ms-flexbox; /* IE10 */
            display: flex;
            -ms-flex-wrap: wrap; /* IE10 */
            flex-wrap: wrap;
            margin: 0 -16px;
        }

        .payment-form-container .col-25 {
            -ms-flex: 25%; /* IE10 */
            flex: 25%;
        }

        .payment-form-container .col-50 {
            -ms-flex: 50%; /* IE10 */
            flex: 50%;
        }

        .payment-form-container .col-50-my {
            width: 68%;
            padding: 0% 0% 0% 32%;
        }

        .payment-form-container .col-75 {
            -ms-flex: 75%; /* IE10 */
            flex: 75%;
        }

        .payment-form-container .col-100 {
            -ms-flex: 100%; /* IE10 */
            flex: 100%;
        }

        .payment-form-container .col-25,
        .col-50,
        .col-75 {
            padding: 0 16px;
        }

        .payment-form-container .container {
            background-color: #f2f2f2;
            padding: 5px 20px 15px 20px;
            border: 1px solid lightgrey;
            border-radius: 3px;
        }

        .payment-form-container input[type=text] {
            width: 100%;
            margin-bottom: 20px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .payment-form-container label {
            margin-bottom: 10px;
            display: block;
        }

        .payment-form-container .icon-container {
            margin-bottom: 20px;
            padding: 7px 0;
            font-size: 24px;
        }

        .payment-form-container .btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            margin: 10px 0;
            border: none;
            width: 25%;
            border-radius: 3px;
            cursor: pointer;
            font-size: 17px;
        }

        .payment-form-container .btn:hover {
            background-color: #45a049;
        }

        .payment-form-container span.price {
            float: right;
            color: grey;
        }

        /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (and change the direction - make the "cart" column go on top) */
        @media (max-width: 800px) {
            .payment-form-container .row {
                flex-direction: column-reverse;
            }

            .payment-form-container .col-25 {
                margin-bottom: 20px;
            }
        }

        .md-radio.md-radio-inline {
            width: 50%;
            float: left;
        }
    </style>
@endsection
