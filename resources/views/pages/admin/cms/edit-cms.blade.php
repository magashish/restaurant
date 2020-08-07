@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Update</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Update Cms</li>
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
                            <form action="{{ url('cms/'.$cms->id) }}" id="edit_cms" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if($cms->title == null)
                                <div class="form-group">
                                    <label for="name">Page Title</label>
                                    <input class="form-control" readonly type="text" id="page_title" name="page_title"
                                           value="{{ $cms->title }} " required>
                                </div>
                                @else
                                <div class="form-group">
                                    <label for="name">Page Title</label>
                                    <input class="form-control" type="text" id="page_title" name="page_title"
                                           value="{{ $cms->title }} " required>
                                </div>
                               @endif
                                <div class="form-group">
                                    <label for="logo">Page Image</label>
                                    <input type="file" class="form-control-file" id="page_image" name="page_image">
                                    <br>
                                    @if($cms->page_image != null)
                                    <img src="{{asset('uploads/cms_images/'.$cms->page_image)}}" style="height:150px;">
                                    @endif

                                </div>
                                <div class="form-group">
                                    <label for="sdesc">Short Description</label>
                                    <textarea class="form-control"
                                              name="short_description">{{ $cms->short_description }}</textarea>
                                </div>
                                @if($cms->title != 'Contact Us')
                                <div class="form-group">
                                    <label for="sdesc">Description</label>
                                    <textarea class="form-control tinymce-editor" id="summaryckeditor" rows="5" cols="40"
                                              name="page_description">{{ $cms->description }}</textarea>
                                </div>
                               @endif
                                <input type="submit" class="btn btn-primary"  value="Save" >
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

<script src="//cdn.ckeditor.com/4.12.1/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'summaryckeditor' );
</script>

@stop
