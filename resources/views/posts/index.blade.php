@extends('layouts.app')
@section('content')
<style>
        .ck-editor__editable_inline {
            background-color: #2c2f36 !important;
            color: #fff;
            min-height: 200px; /* Increase height */
            padding: 15px;
            border: 1px solid #444;
            border-radius: 5px;
        }

        /* CKEditor toolbar dark mode styling */
        .ck-toolbar {
            background-color: grey !important;
            border: 1px solid #444;
        }

        /* CKEditor button dark mode styling */
        .ck-toolbar button {
            color: #fff;
        }

        /* Toolbar dropdown styling */
        .ck-toolbar__items .ck-dropdown__panel {
            background-color: #1e2024;
        }

      

</style>

<!-- Modal -->
<div class="modal fade w-100" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content" style="width:140% !important;">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Manage Post</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true" id="close-modal-btn">&times;</span>
</button>
</div>
<div class="modal-body">
<form method="post" id="formData">
@csrf
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label for="">Page</label>
{{-- <input type="text" name="title"  value="{{ old('title') }}" class="form-control" placeholder="Title Post"> --}}
<input type="hidden" name="" id="abt_content_value" value="{{$auContent}}">

<select name="page" class="form-control" id="page">
    <option value="" disabled>select</option>
    <option value="Support">Support</option>
    <option value="About">About Us</option>

</select>


<span class="text-danger error-text page_error"  style="font-size: 13px"></span>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
        <label for="" id="title">Title</label>
        <input type="text" name="title"  value="{{ old('title') }}" class="form-control" placeholder="Title" id="title">
        <span class="text-danger error-text title_error"  style="font-size: 13px"></span>
    </div>
    </div>
</div>
<div class="form-group">
    <div id="content"></div>

    <span class="text-danger error-text content_error"  style="font-size: 13px"></span>
</div>
<button type="submit" id="btn-create" class="btn btn-success btn-block">Save Change</button>
</form>
</div>
</div>
</div>
</div>
<section class="container p-2">
{{-- <h4 class="text-center mt-4">Laravel AJAX CRUD Real Time</h4> --}}
<div class="card mt-5">

<div class="card-body">
<button id="openModal" data-action="{{ route('post.store') }}" class="btn btn-success mb-3">+ Create Post</button>
<div class="table-responsive">
<table class="table table-striped table-inverse table-responsive d-table" id="posts-table">
<thead>
<tr>
<th>Page</th>
<th>Title</th>
<th>Content</th>
<th>Author</th>
<th>Order</th>
<th>Action</th>
</tr>
</thead>
<tbody id="tbody">
    {{-- @foreach($posts as $post)
    <tr>
        
            <td>{{$post->page}}</td>
            <td>{{$post->title}}</td>
            <td id="post_content">{!! Str::words(strip_tags($post->content), 11, '...') !!}
            </td>
            <td>{{$post->user->name}}</td>
            <td>
                <button id="editModal" data-action="http://localhost:8000/post/{{$post->uuid}}/update" data-id="{{$post->uuid}}" class="btn btn-warning btn-sm">Edit</button>
                <button id="btn-delete" data-id="{{$post->uuid}}" class="btn btn-danger btn-sm">Delete</button>
        </td>
    </tr>
    @endforeach --}}

</tbody>
</table>
</div>
</div>
</div>
</section>
@endsection
@push('scripts')
<script src="{{asset('plugins/data-tables/dataTables.min.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
    .create(document.querySelector('#content'))
    .then(editor => {
        editorInstance = editor;
    })
    .catch(error => {
        console.error(error);
    });
</script>

<script src="{{ asset('js/crud.js') }}"></script>


@endpush
