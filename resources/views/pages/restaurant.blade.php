@extends('layouts.default')
@section('content')
  <div class="inner_banner" style="background-image: url(images/inner_banner.jpg);">
    	<div class="container">
            <div class="row">
                <div class='col-md-12 col-sm-12'>
					<div class="restaurant_detail">
						<div class="restaurant_img"><img src="images/restaurant_logo_inner.jpg"></div>
						<div class="restaurant_info">
							<div class="resort_open">Open</div>
							<h2>Red Onion Restaurant</h2>
							<p>Burgers, American, Sandwiches, Fast Food, BBQ</p>
							<div class="min_order"><i class="fas fa-check"></i> Min $ 10.00</div>
							<div class="time"><i class="far fa-clock"></i> 5:30 pm - 10:30 pm</div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>

    <div class="content_sec">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-8 col-sm-12">
    				<div class="menu_tabs">

    					<ul class="nav nav-tabs">
    						<li class="nav-item">
    							<a class="nav-link active" data-toggle="tab" href="#Menu">Menu</a>
    						</li>
    						<li class="nav-item">
    							<a class="nav-link" data-toggle="tab" href="#Reviews">Reviews</a>
    						</li>
    						<li class="nav-item">
    							<a class="nav-link" data-toggle="tab" href="#book_table">Book a Table</a>
    						</li>
    						<li class="nav-item">
    							<a class="nav-link" data-toggle="tab" href="#restaurant_info">Restaurant info</a>
    						</li>
    					</ul>

    					<div class="tab-content">
    						<div class="tab-pane container active" id="Menu">
    							<h4>POPULAR ORDERS Delicious hot food!</h4>
                                @foreach($restaurants as $restaurant)
    							<div class="product_info">
    								<div class="product_left">
    									<div class="product_img">
                                            <a href="{{ route('restaurantfront.show', [$restaurant->id]) }}"><img src="{{ $restaurant->logo }}"></a>
                                        </div>
    									<div class="rating"><img src="images/rating_img.png"></div>
    								</div>
    								<div class="prodcut_cat">
                                        <a href="{{ route('restaurantfront.show', [$restaurant->id]) }}"><h3>{{ $restaurant->name }}</h3></a>
    									<span>Super Burger</span>
    									<form>
    										<span>
    											<input type="checkbox" name="" id="lettuce" checked>
    											<label for="lettuce">Minus Lettuce</label>
    										</span>
    										<span>
    											<input type="checkbox" name="" id="mayo" checked>
    											<label for="mayo">Minus Mayo</label>
    										</span>
    										<span>
    											<input type="checkbox" name="" id="tomati" checked>
    											<label for="tomati">Minus Tomati</label>
    										</span>
    										<span>
    											<input type="checkbox" name="" id="mustard">
    											<label for="mustard">Minus Mustard Sauce</label>
    										</span>
    										<span>
    											<input type="checkbox" name="" id="cheese">
    											<label for="cheese">Minus Cheese Slice</label>
    										</span>
    										<a href="#" class="addtocart">Add to cart</a>
    									</form>
    								</div>
    							</div>
                                @endforeach
    						</div>
    						<div class="tab-pane container fade" id="Reviews">
    							<h4>POPULAR ORDERS Delicious hot food!</h4>
    							<div class="tab_inner">
    								<strong>What is Lorem Ipsum? </strong>
    								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    							</div>
    						</div>
    						<div class="tab-pane container fade" id="book_table">
    							<h4>POPULAR ORDERS Delicious hot food!</h4>
    							<div class="tab_inner">
    								<strong>What is Lorem Ipsum? </strong>
    								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    							</div>
    						</div>
    						<div class="tab-pane container fade" id="restaurant_info">
    							<h4>POPULAR ORDERS Delicious hot food!</h4>
    							<div class="tab_inner">
    								<strong>What is Lorem Ipsum? </strong>
    								<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    							</div>
    						</div>
    					</div>
    				</div>
    			</div>

    			<div class="col-md-4 col-sm-12">
    				<div class="choose_menu">
    					<h2>Choose menu <i class="fas fa-utensils"></i></h2>
    					<ul>
    						<li><a href="#">Hamburger</a></li>
    						<li><a href="#">Kids Meal</a></li>
    						<li><a href="#">Sweets</a></li>
    						<li><a href="#">Baskets</a></li>
    						<li><a href="#">Fresh Salads</a></li>
    						<li><a href="#">Appetizers</a></li>
    						<li><a href="#">Beverages</a></li>
    						<li><a href="#">Desserts & Beverages</a></li>
    					</ul>
    				</div>
    				<div class="special_img">
    					<img src="images/special_img.png">
    				</div>
    			</div>

    		</div>
    	</div>
    </div>
@stop
