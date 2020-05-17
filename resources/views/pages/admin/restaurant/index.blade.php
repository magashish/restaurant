@extends('layouts.admin')
@section('content')
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">View Restaurants</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Restaurants</li>
            </ol>
          </div><!-- /.col -->
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
				<h1></h1>
				<table class="table table-bordered data-table">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Logo</th>
							<th>Timing</th>
							<th>Isopen</th>						
							<th width="100px">Action</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<script type="text/javascript">
			  $(document).ready(function() {
				
				var table = $('.data-table').DataTable({
					processing: true,
					serverSide: true,
					ajax: "{{ route('restaurant.index') }}",
					columns: [
						{data: 'DT_RowIndex', name: 'DT_RowIndex'},
						{data: 'name', name: 'name'},
						{data: 'logo', name: 'logo', orderable: false},
						{data: 'timings', name: 'timings', orderable: false},
						{data: 'isopen', name: 'isopen'},					
						{data: 'action', name: 'action', orderable: false, searchable: false},
					]
				});
				
			  });
			</script>      
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
	@stop