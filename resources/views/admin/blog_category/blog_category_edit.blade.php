@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Blog Category</h4>

                        <form method="POST" action="{{ route('update.blog.category',$blogCategory->id) }}"> <br>

                            @csrf

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Blog Category
                                    Name</label>
                                <div class="col-sm-10">
                                    <input name="blogCategory" value="{{$blogCategory->blogCategory}}"
                                        class="form-control" type="text" id="example-text-input">
                                    @error('blogCategory')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <input type="submit" class="btn btn-info waves-effect waves-light"
                                    value="Update Blog Category">
                            </div>

                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

@endsection