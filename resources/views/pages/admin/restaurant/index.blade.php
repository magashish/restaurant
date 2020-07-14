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
                        <table class="table table-bordered data-table init-data-table">
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
                            @if(!empty($restaurantData))
                                @foreach($restaurantData as $key => $restaurant)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $restaurant->name }}</td>
                                        <td>{{ $restaurant->logo }}</td>
                                        <td>{{ $restaurant->timings }}</td>
                                        <td>{{ $restaurant->isopen }}</td>
                                        <td>
                                            <a href="{{ route('restaurant.show', $restaurant->id) }}"
                                               class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('restaurantmenu', $restaurant->id) }}"
                                               class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('restaurant.delete', $restaurant->id) }}"
                                            class="btn btn-xs btn-primary"><i class="fa fa-trash"></i></a>
                                            <!-- <button class="btn btn-xs btn-delete" data-remote="javascript:void(0)"><i
                                                    class="fa fa-trash"></i></button> -->
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="text-right my-float-right">
                            {{ $restaurantData->links() }}
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
