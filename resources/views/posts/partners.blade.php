@extends('layouts.app')
@section('content')
<style>
     .image-upload {
            position: relative;
            cursor: pointer;
        }

        #file-input {
            display: none;
        }

        #preview {
            width: 60px;
            height: 67px;
            object-fit: cover;
            border: 2px solid grey;
            border-radius: 10px;
        }
</style>
<div class="modal fade w-100" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:140% !important;">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Manage</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true" id="close-modal-btn">&times;</span>
    </button>
    </div>
    <div class="modal-body">
    <form method="post" id="formData" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
        <div class="form-group">
        {{-- <input type="text" name="title"  value="{{ old('title') }}" class="form-control" placeholder="Title Post"> --}}
        <label for="name" id="name">Name</label>
        <input type="text" name="name"  value="{{ old('title') }}" class="form-control" placeholder="Title" id="name">
        <input type="hidden" name="id"  class="form-control">

        <span class="text-danger error-text name_error"  style="font-size: 13px"></span>
        </div>
        </div>
        <div class="col-md-6">
        {{-- <div class="form-group">
        <label for="logo" id="logo">Logo</label>
        <input type="file" name="logo"  value="{{ old('logo') }}" class="form-control" placeholder="Title" id="logo">
        <span class="text-danger error-text title_error"  style="font-size: 13px"></span>
        </div> --}}
            <div class="form-group">
                <label for="name" id="name">Logo</label>

                <div class="image-upload">
                    <label for="file-input">
                        <img id="preview" src="https://via.placeholder.com/150" alt="Placeholder Image" />
                    </label>
                    <input id="file-input" type="file" name="logo" accept="image/*" onchange="previewImage(event)" />
                </div>
                <span class="text-danger error-text logo_error"  style="font-size: 13px"></span>

            </div>
        
        </div>
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
<div class="table-responsive">
<table class="table table-striped table-inverse table-responsive d-table" id="partners-table">
<thead>
<tr>
<th>Name</th>
<th>Logo</th>

<th>Action</th>
</tr>
</thead>
<tbody id="tbody">
  
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

<script>
        const baseUrl = 'http://localhost:8000';

        $('#partners-table').DataTable({
            processing: true,
            createdRow: function(row, data) {

                let id = data[0]; // amend 'data[0]' here to be the correct column for your dataset
                $(row).prop('id', id).data('id', id); 

            },
            serverSide: true,
            ajax: "/partners",
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'logo',
                    name: 'logo'
                },
               
             
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });

        $('#formData').submit(function(e) {

            e.preventDefault();

            let formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                data : formData,
                contentType: false,
                processData: false,
                url: '{{ route('partners.update') }} ',
                beforeSend:function(){
                    $('#btn-create').addClass("disabled").html("Processing...").attr('disabled',true);
                    $(document).find('span.error-text').text('');
        },
            complete: function(){
            $('#btn-create').removeClass("disabled").html("Save Change").attr('disabled',false);
            },
            success: function(res){
            // to reload
            
                if(res.success == true){
                $('#formData').trigger("reset");
                $('#exampleModal').modal('hide');
                
                $("#partners-table").DataTable().ajax.reload();


                Swal.fire(
                'Success!',
                res.message,
                'success'
                )
            }
            },
                error(err){
                $.each(err.responseJSON,function(prefix,val) {
                $('.'+prefix+'_error').text(val[0]);
                })
                console.log(err);
            }
        })
        })

        $('#partners-table').on('click', '#editModal', function() {

            let dataAction = $(this).data('action');
            $('#formData').attr('action',dataAction);

            let id = $(this).data('id');   

            $.ajax({
                type: 'GET',
                url : baseUrl+`/partners/${id}/edit`,
                dataType: "json",
                success: function(res) {
                $('.error-text').text(' ');

                $('input[name=name]').val(res.post.name);
                $('input[name=id]').val(res.post.id);
                $('#preview').attr('src','http://localhost:8000/storage/images/'+ res.post.logo);
                
                $('#exampleModal').modal('show');
                    console.log(res);
                },
                error:function(error) {
                    console.log(error)
                }
            })

        });

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        
</script>

@endpush
