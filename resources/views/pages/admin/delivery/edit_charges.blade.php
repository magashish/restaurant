@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 text-dark">Edit Delivery Charges</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Delivery Charges</li>
                  </ol>
                </div><!-- /.col -->
                @if(Session::has('success'))
                              <div style="width:100%" class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                              </div>
                @endif
                @if (count($errors) > 0)
                  <div style="width:100%" class = "alert alert-danger">
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
				<form action="{{ url('/admin/update-delivery-charges/'.$get_price_detail->id) }}" method="POST" enctype="multipart/form-data">
				   @csrf
                   
                    <div class="form-group">
						<label for="name">Price</label>
						<input class="form-control" type="text" id="price" name="price" value="{{$get_price_detail->price}}" required>
					</div>
                   
					<input type="submit" class="btn btn-primary">
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


	@stop
