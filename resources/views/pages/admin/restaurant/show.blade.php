@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Update Restaurant</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Restaurants</li>
                    </ol>
                </div><!-- /.col -->
                @if(Session::has('success'))
                    <div style="width:100%" class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div style="width:100%" class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="container">
                        <div class="content_inner">
                            <form action="{{ route('restaurant.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="restaurant_id" value="{{ $data['id'] }}">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                           value="{{ $data['name'] }} " required>
                                </div>
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="file" class="form-control-file" id="logo" name="logo">
                                </div>
                                <div class="form-group">
                                    <label for="openinghour" class="radio-inline">Opening Hour</label>
                                    <select id="openinghour" name="openinghour" style="margin-right:10px;">
                                        <?php for($i = 0; $i < 24; $i++): ?>
                                        <option
                                            value="<?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?>"><?= $i % 12 ? $i % 12 : 12 ?>
                                            :00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
                                        <?php endfor ?>
                                    </select>
                                    <label for="closinghour" class="radio-inline">Closing Hour</label>
                                    <select id="closinghour" name="closinghour">
                                        <?php for($i = 0; $i < 24; $i++): ?>
                                        <option
                                            value="<?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?>"><?= $i % 12 ? $i % 12 : 12 ?>
                                            :00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
                                        <?php endfor ?>
                                    </select>
                                </div>
                                <div class="form-check">
                                    <label class="radio-inline" style="margin-right: 25px;">
                                        <input type="radio" class="form-check-input" name="isopen" value="1" checked>Open
                                    </label>
                                    <label class="form-check-label radio-inline">
                                        <input type="radio" class="form-check-input" name="isopen" value="0">Close
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="sdesc">Short Description</label>
                                    <textarea class="form-control" id="sdesc" rows="3"
                                              name="shortdescription">{{$data['shortdescription']}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="desc">Description</label>
                                    <textarea class="form-control" id="desc" rows="3"
                                              name="description">{{$data['description']}}</textarea>
                                </div>

                                <div class="form-group"> 
                                    <label class="mb-2"><b>Address :</b></label>
                                    <input type="text" class="form-control" id="search_address" name="addr1" placeholder="Enter Full Address" value="{{ $data['addr1'] }}">
                                    <input type="hidden" name="address_latitude" id="address_latitude" value="{{ $data['lat'] }}">
                                    <input type="hidden" name="address_longitude" id="address_longitude" value="{{ $data['lng'] }}">
                                    <input type="hidden" name="country" id="country" value="{{ $data['country'] }}">
                                    <input type="hidden" name="state" id="state" value="{{ $data['state'] }}">
                                    <input type="hidden" name="county" id="county" value="{{ $data['county'] }}">
                                    <input type="hidden" name="city" id="city" value="{{ $data['city'] }}">
                                    <input type="hidden" name="postcode" id="postcode" value="{{ $data['postcode'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="seller" class="radio-inline">Select Seller</label>
                                    <select id="seller" name="seller" style="margin-right:10px;" value="{{ $data['seller_id'] }}">
                                        <option value="">--Please Select--</option>
                                        @foreach($seller_data as $key => $s_data)
                                        <option value="{{$s_data->id}}" {{ ($s_data->id == $data->seller_id ? 'selected="selected"' : '') }}>{{$s_data->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="name">Address 1</label>
                                    <input class="form-control" type="text" id="addr1" name="addr1" value="{{ $data['addr1'] }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Address 2</label>
                                    <input class="form-control" type="text" id="addr2" name="addr2" value="{{ $data['addr2'] }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">City</label>
                                    <input class="form-control" type="text" id="city" name="city" value="{{ $data['city'] }}" required>

                                    <label for="state" class="radio-inline">State</label>
                                    <select id="state" name="state" style="margin-right:10px;">
                                        <option value="">--Please Select--</option>
                                        <option value="california" {{ $data['state'] == "california" ? "selected" : "" }}>California</option>
                                        <option value="florida" {{ $data['state'] == "florida" ? "selected" : "" }}>Florida</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">ZipCode</label>
                                    <input class="form-control" type="text" id="postcode" name="postcode" value="{{ $data['postcode'] }}" required>

                                    <label for="country" class="radio-inline">Country</label>
                                    <select id="country" name="country" style="margin-right:10px;">
                                        <option value="US" {{ $data['country'] == "US" ? "selected" : "" }}>US</option>
                                    </select>
                                </div> -->
                                <div class="form-group">
                                    <label for="name">Phone</label>
                                    <input class="form-control" type="text" id="phone" name="phone" value="{{ $data['phone'] }}" required>
                                    <label for="isfeatured" class="radio-inline">Featured</label>
                                    <select id="isfeatured" name="isfeatured" style="margin-right:10px;">
                                        <option value="0" {{ $data['isfeatured'] == "0" ? "selected" : "" }}>No</option>
                                        <option value="1" {{ $data['isfeatured'] == "1" ? "selected" : "" }}>Yes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Categories</label>
                                    <select id='categories' name='categories[]' class="custom-select" multiple>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Email</label>
                                    <input class="form-control" type="email" id="email" name="email" value="{{ $data['email'] }}" required>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="desc">Google Map</label>
                                    <textarea class="form-control" id="gmap" rows="3" name="gmap">{{ $data['gmap'] }}</textarea>
                                </div> -->
                                <input type="submit" class="btn btn-primary" name="update">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
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
@stop
