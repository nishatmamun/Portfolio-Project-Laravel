@extends('admin.admin_master')
@section('admin')

<style type="text/css">
.bootstrap-tagsinput .tag {
    margin: 2px;
    color: #FFFFFF;
    font-weight: 700;
    padding: 4px;
    background-color: #888B8D;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Blog Page</h4>

                        <form method="POST" action="{{ route('store.blog') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Blog Category
                                    Name</label>
                                <div class="col-sm-10">
                                    <select name="blog_category_id" class="form-select"
                                        aria-label="Default select example">
                                        <option selected="">Open this select menu</option>
                                        @foreach ($categories as $item)
                                        <option value="{{$item->id}}">{{$item-> blogCategory}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Blog Title</label>
                                <div class="col-sm-10">
                                    <input name="blogTitle" class="form-control" type="text" id="example-text-input">
                                    @error('blogTitle')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Blog Tags</label>
                                <div class="col-sm-10">
                                    <input name="blogTags" value="home,tech" class="form-control" type="text"
                                        id="example-text-input" data-role="tagsinput">
                                    @error('blogTags')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Blog
                                    Description</label>
                                <div class="col-sm-10">
                                    <textarea name="blogDescription" id="elm1"></textarea>
                                </div>
                            </div>

                            <div class=" row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Blog Image</label>
                                <div class="col-sm-10">
                                    <input name="blogImage" class="form-control" type="file" id="image">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"> </label>
                                <img class="rounded avatar-lg" id="showImage" src="{{ url('upload/no_image.jpg') }}">
                            </div>
                            <div class="d-flex justify-content-end">
                                <input type="submit" class="btn btn-info waves-effect waves-light"
                                    value="Insert Blog Data">
                            </div>

                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<script type="text/javascript">
$(document).ready(function() {
    $('#image').change(function(e) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#showImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    })
})
</script>

@endsection