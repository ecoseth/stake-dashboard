@extends('layouts.app')
@section('content')
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Manage Post</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<form   method="post" id="formData">
@csrf
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label for="">Page</label>
{{-- <input type="text" name="title"  value="{{ old('title') }}" class="form-control" placeholder="Title Post"> --}}
<div class="form-group">
<select name="page" class="form-control">
    <option value="" disabled>select</option>
    <option value="Support">Support</option>
</select>
</div>
<span class="text-danger error-text page_error"  style="font-size: 13px"></span>
</div>
</div>
<div class="form-group">
<label for="">Title</label>
<input type="text" name="title"  value="{{ old('title') }}" class="form-control" placeholder="Title Post">
<span class="text-danger error-text title_error"  style="font-size: 13px"></span>
</div>
</div>
<div class="form-group">
<label for="">Post Content</label>
<textarea name="content" value="{{ old('content') }}" class="form-control" placeholder="Content" rows="10"></textarea>
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

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{ asset('js/crud.js') }}"></script>
<script>
    //  $('#posts-table').DataTable({
    //     "paging": true,
    //     "lengthChange": false,
    //     "searching": true,
    //     "ordering": true,
    //     "info": true,
    //     "autoWidth": false,
    // });
</script>
@endpush
