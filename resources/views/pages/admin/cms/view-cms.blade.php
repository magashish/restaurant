@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">View CMS</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">CMS Management</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
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
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="container">
                        <h1></h1>
                        <table class="table table-bordered data-table init-data-table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Page Title</th>
                                <th>Short Description</th>
                                <th>Page Image</th>
                                <th>Date</th>
                                <th width="100px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($cms))
                                @foreach($cms as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->title }}</td>
                                        <td>{{ $row->short_description }}</td>
                                        @if($row->page_image == null)
                                        <td>No Image</td>
                                        @else
                                        <td>{{ $row->page_image }}</td>
                                        @endif
                                        <td>{{ $row->updated_at }}</td>
                                        <td>
                                        <a href="{{ route('cms.edit', $row->id) }}"
                                            class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="text-right my-float-right">
                       
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
@section('page_script')
    <script type="text/javascript">
        $(document).ready(function () {
            /*var table = $('.data-table').DataTable({
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
            });*/
        });
    </script>
@endsection
@section('page_style')
    <style>
        .my-float-right {
            float: right;
        }
    </style>
@endsection
