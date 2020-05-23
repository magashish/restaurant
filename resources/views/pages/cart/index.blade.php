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
    <div class="container">
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
                         @if(session('cart'))
                          @foreach(session('cart') as $id => $details)
                          <?php $total += $details['price'] * $details['quantity'] ?>
                          <tr>
                          <td class="cart_img">
                            <div class="productimg"><img width="80px" src="{{asset('uploads').'/'.$details['photo'] }}"></div>
                            <div class="productname">{{ $details['name'] }}</div>
                          </td>
                          <td class="cartprice">$ {{ $details['price']}}</td>
                          <td class="cart_qty"><input type="number" id="quantity" name="quantity" value="{{ $details['quantity'] }}" min="1" max="10"></td>
                          <td class="carttotal">$ {{$details['price'] * $details['quantity']}}</td>
                          <td class="cartremove">
                            <button class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="far fa-sync-alt"></i></button>
                            <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="far fa-trash-alt"></i></button>
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
                        <li>Tax <span>$ 0</span></li>
                        <li>Delivery Charges <span>$ 0</span></li>
                        <li>Total <span>${{ $total }}</span></li>
                    </ul>
                    <!--<div class="updatecrt">
                       <a href="{{ route('updatecart') }}">Update Cart</a>
                    </div>-->
                    <div class="checkout_btn">
                        <a href="#">Checkout</a>
                    </div>
                </div>
                <div class="special_img">
                    <img src="images/special_img.png">
                </div>
            </div>

        </div>
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
               data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val()},
               success: function (response) {
                   window.location.reload();
               }
            });
        });

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            if(confirm("Are you sure")) {
                $.ajax({
                    url: '{{ url('remove-from-cart') }}',
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
    });
    </script>
@endsection
