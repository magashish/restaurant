@if(!empty($cartData))
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
                    @if(!empty($cartData))
                        @foreach($cartData as $key => $menu)
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
                                    <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $key }}">
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
                    <li>Tax <span>$ 0</span></li>
                    <li>Delivery Charges <span>$ 0</span></li>
                    <li>Total <span>${{ $total }}</span></li>
                </ul>
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
                <a href="{{ route('restaurant') }}" class="btn btn-primary">Continue Shopping</a>
            </div>
        </div>
    </div>
@endif
