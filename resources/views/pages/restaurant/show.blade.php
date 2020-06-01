@extends('layouts.default')
@section('content')

    @if($data->isopen  ===0)
        @php $status = 'Closed'; @endphp
    @else
        @php $status = 'Open'; @endphp
    @endif

    <div class="inner_banner" style="background-image: url({{ asset('images/inner_banner.jpg') }});">
        <div class="container">
            <div class="row">
                <div class='col-md-12 col-sm-12'>
                    <div class="restaurant_detail">
                        <div class="restaurant_img"><img src="{{$data->logo}}"></div>
                        <div class="restaurant_info">
                            <div class="resort_open">{{$status}}</div>
                            <h2>{{$data->name}}</h2>
                            <p>{{$data->shortdescription }}</p>
                            <!--<div class="min_order"><i class="fas fa-check"></i> Min $ 10.00</div>-->
                            <div class="time"><i class="far fa-clock"></i> {{$data->timings}}</div>
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
                                @foreach($data->menu as $proddata)
                                    <div class="product_info">
                                        <div class="product_left">
                                            <div class="product_img"><img
                                                    src="{{ $proddata->image }}">
                                            </div>
                                            <div class="rating"><img src="{{ asset('images/rating_img.png') }}"></div>
                                        </div>
                                        <div class="prodcut_cat">
                                            <h3>{{ $proddata->name }}</h3>
                                            <span>{{ $proddata->dishname }}</span>
                                            <span class="menu-item-price-span">$ <span
                                                    class="menu-item-price">{{ $proddata->price }}</span></span>
                                            <form method="POST" class="add-to-cart-form" name="addtocart"
                                                  action="{{ route('addtocart') }}">
                                                @csrf
                                                <input type="hidden" name="previous_url"
                                                       value="{{ \Request::fullUrl() }}">
                                                <input type="hidden" name="pid" value="{{ $proddata->id }}"/>
                                                <input type="hidden" name="pname" value="{{ $proddata->dishname }}"/>
                                                <input type="hidden" class="price" name="price"
                                                       value="{{ $proddata->price }}"/>
                                                <input type="hidden" name="pqty" value="1"/>
                                                <input type="hidden" name="image" value="{{ $proddata->image }}"/>
                                                <?php
                                                $options = json_decode($proddata->options);
                                                $id = 0;
                                                ?>
                                                @foreach($options as $option)
                                                    @php $new_str = str_replace(' ', '', $option->name); @endphp
                                                    <span>
                                                    <input type="checkbox" name="itemoption{{ $id }}"
                                                           id="{{$new_str.'-'.$proddata->id}}" value="{{ $new_str }}"
                                                           class="menu-option-checkbox">
    											<label for="{{ $new_str.'-'.$proddata->id }}">{{ $option->name }} $<span
                                                        class="menu-option-price">{{ $option->price }}</span></label>
                                            </span>
                                                   <?php $id++; ?>
                                                @endforeach
                                                <button type="button" class="addtocart add-to-cart-submit"
                                                        data-menu-id="{{ $proddata->id }}" name="Add To Cart"
                                                        value="Add To Cart">Add To Cart
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <!--<div class="tab-pane container fade" id="Reviews">
                                <h4>POPULAR ORDERS Delicious hot food!</h4>
                                <div class="tab_inner">
                                    <strong>What is Lorem Ipsum? </strong>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type and scrambled it to make a type specimen
                                        book. It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in the 1960s
                                        with the release of Letraset sheets containing Lorem Ipsum passages, and more
                                        recently with desktop publishing software like Aldus PageMaker including
                                        versions of Lorem Ipsum.</p>
                                </div>
                            </div>
                            <div class="tab-pane container fade" id="book_table">
                                <h4>POPULAR ORDERS Delicious hot food!</h4>
                                <div class="tab_inner">
                                    <strong>What is Lorem Ipsum? </strong>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type and scrambled it to make a type specimen
                                        book. It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in the 1960s
                                        with the release of Letraset sheets containing Lorem Ipsum passages, and more
                                        recently with desktop publishing software like Aldus PageMaker including
                                        versions of Lorem Ipsum.</p>
                                </div>
                            </div>-->
                            <div class="tab-pane container fade" id="restaurant_info">
                                <h4>POPULAR ORDERS Delicious hot food!</h4>
                                <div class="tab_inner">
                                    {{$data->description }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <div class="choose_menu">
                        <h2>Choose menu <i class="fas fa-utensils"></i></h2>
                        <ul>
                           <?php //$catData
                           ?>
                            @foreach($catData as $key => $cat)
                             <li><a href="{{Request::url().'?cat='.$key}}">{{$cat}}</a></li>
                            @endforeach
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
@section('page_script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".menu-option-checkbox").on("change", function () {
                var itemPriceObj = $(this).parents("form").siblings(".menu-item-price-span").find(".menu-item-price");
                var itemPrice = itemPriceObj.text();

                var optionPrice = $(this).siblings('label').find(".menu-option-price").text();
                if ($(this).is(":checked")) {
                    itemPrice = parseFloat(itemPrice) + parseFloat(optionPrice);
                } else {
                    itemPrice = parseFloat(itemPrice) - parseFloat(optionPrice);
                }
                itemPrice = itemPrice.toFixed(2);
                itemPriceObj.text(itemPrice);
                $(".price").val(itemPrice);
            });

            $(".add-to-cart-submit").on("click", function () {
                const menu_id = $(this).attr("data-menu-id");
                var $this = $(this);

                $.ajax({
                    url: "{{ route('check-same-restaurant') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        menu_id: menu_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if(response.success) {
                            $this.parents('form').submit();
                        } else {
                            swal("You can't add item from different restaurant. Please select item from same restaurant");
                        }
                    },
                    error: function (error) {
                        //alert(22)
                        //$this.parents('form').submit();
                        swal("Oops! some error occured");
                    }
                });
            });
        });
    </script>
@endsection
