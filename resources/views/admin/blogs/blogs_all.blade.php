@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Blogs All</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Blogs All Data</h4>

                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Blog Category</th>
                                    <th>Blog Title</th>
                                    <th>Blog Tags</th>
                                    <th>Blog Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php($i = 1)
                                @foreach ($blogs as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item['category']['blogCategory'] }}</td>
                                    <td>{{ $item->blogTitle  }}</td>
                                    <td>{{ $item->blogTags }}</td>
                                    <td><img src="{{ asset($item->blogImage) }}" style="width: 60px; height:50px;">
                                    </td>
                                    <td>
                                        <a href="{{ route('edit.blog',$item->id) }}" class="btn btn-info sm"
                                            title="Edit Blog"> <i class="fas fa-edit"></i></a>

                                        <a href="{{ route('delete.blog',$item->id) }}" id="delete"
                                            class="btn btn-danger sm" title="Delete Blog"> <i
                                                class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>
                document.write(new Date().getFullYear())
                </script> © Upcube.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign
                </div>
            </div>
        </div>
    </div>
</footer>


@endsection