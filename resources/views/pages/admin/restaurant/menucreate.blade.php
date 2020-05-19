@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Create Restaurants</h1>
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
                            <form action="{{ route('restaurantmenuadd') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input class="form-control" type="hidden" id="restaurant_id" value="{{$id}}"
                                           name="restaurant_id">
                                    <input class="form-control" type="text" id="name" name="dishname" required>
                                </div>
                                <div class="form-group">
                                    <label for="logo">Image</label>
                                    <input type="file" class="form-control-file" id="image" name="image" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Price</label>
                                    <input class="form-control" type="text" id="price" name="price" required>
                                </div>
                                <div class="form-group">
                                    <label for="title">Category</label>
                                    <select class="form-control" id="category" name="category">
                                        <option value="1">Hamburger</option>
                                        <option value="2">Kids Meal</option>
                                        <option value="3">Sweets</option>
                                        <option value="4">Beverages</option>
                                    </select>
                                </div>
                                <div class="table-responsive repeater">
                                    <table class="table table-bordered" id="dynamic_field" data-repeater-list="option">
                                        <tr data-repeater-item>
                                            <td width="35%">
                                                <input type="text" name="item[item][]"
                                                       placeholder="Option"
                                                       class="form-control name_list"/>
                                            </td>
                                            <td>
                                                <input type="text" name="item[price][]"
                                                       placeholder="Price"
                                                       class="form-control name_list"/>
                                            </td>
                                            <td>
                                                <input data-repeater-delete type="button" value="Delete"/>
                                            </td>
                                        </tr>
                                    </table>
                                    {{--<button type="button" name="add" id="add" class="btn btn-success">Add
                                        More
                                    </button>--}}
                                    <button data-repeater-create type="button" name="add" id="add-item" class="btn btn-success" style="float: right">Add
                                        More
                                    </button>
                                </div>
                                <input type="submit" class="btn btn-info">
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

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function () {
            var postURL = "/addmore.php";
            var i = 1;

            $('#add').click(function () {
                i++;
                $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><input type="text" name="itemoption[]" placeholder="Enter Option" class="form-control name_list" /><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
            });


            $(document).on('click', '.btn_remove', function () {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });

            $('.repeater').repeater()
        });
    </script>
@endsection
