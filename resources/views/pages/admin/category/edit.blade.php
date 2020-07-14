@extends('layouts.admin')
@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Category Management</li>
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
				<form action="{{ url('/admin/category-update/'.$category_detail->id) }}" method="POST" enctype="multipart/form-data">
				   @csrf        
					<div class="form-group">
						<label for="name">Name</label>
						<input class="form-control" type="text" id="name" name="name" value="{{ $category_detail->name }}" required>
					</div>
					<div class="form-group">
						<label for="catimg">Category Image</label>
						<input type="file" class="form-control-file" id="catimg" value="{{ $category_detail->catimg }}" name="catimg" >
					</div>
					<div class="form-group">
						<label for="desc">Description</label>
						<textarea class="form-control" id="desc" rows="3" name="description">{{ $category_detail->description }}</textarea>
					</div>
						<div class="form-group">
						<label for="desc">Status</label>
						<select id="status" name="status" required  value="{{ $category_detail->status }}">
                              <option value="">--Please Select--</option>
							  <option value="1" {{ ($category_detail->status == 1 ? 'selected="selected"' : '') }}>Enabled</option>
							  <option value="0" {{ ($category_detail->status == 0 ? 'selected="selected"' : '') }}>Disabled</option>
					   </select>
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