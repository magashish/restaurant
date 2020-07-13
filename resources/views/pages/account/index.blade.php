@extends('layouts.default')
@section('content')
    <div class="inner_banner title_banner" style="background-image: url(images/inner_banner.jpg);">
        <div class="container">
            <div class="row">
                <div class='col-md-12 col-sm-12'>
                    <div class="page-title"><h2>Account</h2></div>
                </div>
            </div>
        </div>
    </div>

    <div class="content_sec">
        <div class="container cart-items-container">
            <div class="row">
                <div class="col-lg-3 col-sm-12 profile-left-sidebar">
                    @include('pages.account.sidebar')
                </div>
                <div class="col-lg-9 col-sm-12">
                    @include('success-error')
                    <form action="{{ route('update.profile') }}" method="post">
                        @csrf
                        <div class="cart_table billingdetail">
                            <div class="col-half">
                                <label>First Name<span>*</span></label>
                                <input type="text" value="{{ \Auth::user()->first_name ?? '' }}"
                                       name="first_name">
                            </div>
                            <div class="col-half">
                                <label>Last Name<span>*</span></label>
                                <input type="text" value="{{ \Auth::user()->last_name ?? '' }}"
                                       name="last_name">
                            </div>
                            <div class="col-half">
                                <label>Email Address<span>*</span></label>
                                <input type="text" value="{{ \Auth::user()->email ?? '' }}"
                                       name="email">
                            </div>
                            <div class="col-half">
                                <label>Phone No.<span>*</span></label>
                                <input type="text" name="mobile" value="{{ \Auth::user()->mobile ?? '' }}" required>
                            </div>
                            <div class="col-full"> 
                                <label class="mb-2"><b>Address :</b></label>
                                <input type="text" class="form-control" id="search_address" name="address" value="{{ \Auth::user()->address ?? '' }}">
                                <input type="hidden" name="address_latitude" id="address_latitude"  value="{{ \Auth::user()->lat ?? '' }}">
                                <input type="hidden" name="address_longitude" id="address_longitude"  value="{{ \Auth::user()->lng ?? '' }}">
                                <input type="hidden" name="country" id="country"  value="{{ \Auth::user()->country ?? '' }}">
                                <input type="hidden" name="state" id="state"  value="{{ \Auth::user()->state ?? '' }}">
                                <input type="hidden" name="county" id="county" value="{{ \Auth::user()->county ?? '' }}">
                                <input type="hidden" name="city" id="city" value="{{ \Auth::user()->city ?? '' }}">
                                <input type="hidden" name="zip" id="postcode" value="{{ \Auth::user()->zip ?? '' }}">
                            </div>
                            <!-- <div class="col-full">
                                <label>Address<span>*</span></label>
                                <input type="text" name="address" value="{{ \Auth::user()->address ?? '' }}" required>
                            </div> -->
                            <!-- <div class="col-full">
                                <label>Town/City<span>*</span></label>
                                <input type="text" name="city" value="{{ \Auth::user()->city ?? '' }}" required>
                            </div>
                            <div class="col-half">
                                <label>State<span>*</span></label>
                                <input type="text" name="state" value="{{ \Auth::user()->state ?? '' }}" required>
                            </div>
                            <div class="col-half">
                                <label>Zip<span>*</span></label>
                                <input type="text" name="zip" class="zipCode" value="{{ \Auth::user()->zip ?? '' }}" required>
                            </div> -->
                            <div class="col-half">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_script')
<script>
   function initMap() {
   
       var input = document.getElementById('search_address');
       var autocomplete = new google.maps.places.Autocomplete(input);
       autocomplete.addListener('place_changed', function() {
           var place = autocomplete.getPlace();
          //  alert(place);
           console.log(place);
           if(place.length == 0)
           {
             return ;
           }
           
           for(var i = 0; i < place.address_components.length; i++) {
                  
                var current_loc =place.address_components[i];
                // alert(current_loc);
                if(current_loc.types[0] == 'locality'){
                    // alert(current_loc.long_name);
                document.getElementById('city').value = current_loc.long_name;
                }

                if(current_loc.types[0] == 'administrative_area_level_2'){
                    //  alert(current_loc.long_name);
                document.getElementById('county').value = current_loc.long_name;
                }

                if(current_loc.types[0] == 'administrative_area_level_1'){
                    // alert(current_loc.long_name);
                document.getElementById('state').value = current_loc.long_name;
                }

                if(current_loc.types[0] == 'country'){
                document.getElementById('country').value = current_loc.long_name;
                    // alert(current_loc.long_name);
                }

                if(current_loc.types[0] == 'postal_code'){
                document.getElementById('postcode').value = current_loc.long_name;
                    // alert(current_loc.long_name);
                }

            }

           document.getElementById('address_latitude').value = place.geometry.location.lat();
           document.getElementById('address_longitude').value = place.geometry.location.lng();
          
       });
       
   }
</script>
<script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initMap&key=AIzaSyDpavHXELJMJvIHifFPN6tBBiFSXKGpy2g"
   async defer></script>
@endsection
@section('page_style')
    <style>
        .empty-cart-container {
            text-align: center;
        }

        /* Style the tab */
        .profile-left-sidebar .tab {
            float: left;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
            width: 30%;
            height: 300px;
        }

        /* Style the buttons inside the tab */
        .profile-left-sidebar .tab button {
            display: block;
            background-color: inherit;
            color: black;
            padding: 22px 16px;
            width: 100%;
            border: none;
            outline: none;
            text-align: left;
            cursor: pointer;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .profile-left-sidebar .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current "tab button" class */
        .profile-left-sidebar .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .profile-left-sidebar .tabcontent {
            float: left;
            padding: 0px 12px;
            border: 1px solid #ccc;
            width: 70%;
            border-left: none;
            height: 300px;
        }
    </style>
@endsection
