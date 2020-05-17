@extends('layouts.default')
@section('content')

@if($maindata->isopen  ===0)     
  @php $status = 'Closed'; @endphp      
@else
    @php $status = 'Open'; @endphp      
@endif

<div class="inner_banner" style="background-image: url({{ asset('images/inner_banner.jpg') }});">
    	<div class="container">
            <div class="row">
                <div class='col-md-12 col-sm-12'>
					<div class="restaurant_detail">
						<div class="restaurant_img"><img src="{{asset('uploads').'/'.$maindata->logo}}"></div>
						<div class="restaurant_info">
							<div class="resort_open">{{$status}}</div>
							<h2>{{$maindata->name}}</h2>
							<p>{{$maindata->shortdescription }}</p>
							<!--<div class="min_order"><i class="fas fa-check"></i> Min $ 10.00</div>-->
							<div class="time"><i class="far fa-clock"></i> {{$maindata->timings}}</div>
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
								@foreach($data as $proddata)
    							<div class="product_info">
    								<div class="product_left">
    									<div class="product_img"><img src="{{asset('uploads').'/'.$proddata->image}}"></div>
    									<div class="rating"><img src="{{ asset('images/rating_img.png') }}"></div>
    								</div>
    								<div class="prodcut_cat">
    									<h3>{{ $proddata->name }}</h3>
    									<span>{{ $proddata->dishname }}</span>
										<span>$ {{ $proddata->price }}</span>
    									<form>
									      <?php 
										    $options = json_decode($proddata->itemoption );
										   ?>
										    @foreach($options as $option)
											@php $new_str = str_replace(' ', '', $option); @endphp      
    										<span>
    											<input type="checkbox" name="itemoption" id="{{ $new_str }}" >
    											<label for="{{ $new_str }}"> {{ $option }}</label>
    										</span>
											@endforeach    										
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
							     	{{$maindata->description }}    								
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
    					<img src="{{ asset('images/special_img.png') }}">
    				</div>
    			</div>

    		</div>
    	</div>
    </div>
@stop