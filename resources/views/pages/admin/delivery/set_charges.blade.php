@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 text-dark">Set Delivery Charges</h1>
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
				<form action="{{ route('postdeliverycharge') }}" method="POST" enctype="multipart/form-data">
				   @csrf
                    <div class="form-group">
                       
                        <label for="select_distance" class="radio-inline">Select Distance</label>
					    <select id="select_distance" name="select_distance" style="margin-right:10px;">
                            <option value="">--Please Select--</option>
                           
                            <option value="0-1">0-1</option>
                            <option value="1-2">1-2</option>
                            <option value="2-3">2-3</option>
                            <option value="3-4">3-4</option>
                            <option value="4-5">4-5</option>
                            <option value="5-6">5-6</option>
                            <option value="6-7">6-7</option>
                            <option value="7-8">7-8</option>
                            <option value="8-9">8-9</option>
                            <option value="9-10">9-10</option>
                            <option value="10-11">10-11</option>
                            <option value="11-12">11-12</option>
                            <option value="12-13">12-13</option>
                            <option value="13-14">13-14</option>
                            <option value="14-15">14-15</option>
                            <option value="15-16">15-16</option>
                            <option value="16-17">16-17</option>
                            <option value="17-18">17-18</option>
                            <option value="18-19">18-19</option>
                            <option value="19-20">19-20</option>
                         
                        </select>
                    </div>

                    <div class="form-group">
						<label for="name">Price</label>
						<input class="form-control" type="text" id="price" name="price" required>
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
