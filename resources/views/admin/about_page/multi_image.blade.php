@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Multi Image</h4> <br> <br>

                        <form method="POST" action="{{ route('store.multi.image') }}" enctype="multipart/form-data">
                            @csrf

                            <div class=" row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">About Multi
                                    Image</label>
                                <div class="col-sm-10">
                                    <input name="multiImage[]" class="form-control" type="file" id="image" multiple="">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"> </label>
                                <img class="rounded avatar-lg" id="showImage" src="{{ url('upload/no_image.jpg') }}">
                            </div>
                            <div class="d-flex justify-content-end">
                                <input type="submit" class="btn btn-info waves-effect waves-light"
                                    value="Add Multi Image">
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