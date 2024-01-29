@extends("layouts.app")
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2"></div>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row flex justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Profile</h3>
                        <div class="card-tools">
                            <!-- Buttons, labels, and many other things can be placed here! -->
                            <!-- Here is a label for example -->
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <form>
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="card-body">
                            <input type="hidden" class="form-control" id="user_id" value="{{ $user->id }}">

                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" value="{{ $user->name }}">
                            </div>

                            <div class="mb-3">
                                <label for="email">Email address</label>
                                <input type="text" class="form-control" id="email" value="{{ $user->email }}">
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button class="btn btn-primary" id="update-profile">Save</button>
                        </div>
                    </form>

                    <!-- /.card-footer -->
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
@section('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#update-profile").click(function(e) {

        e.preventDefault();

        var id = $("#user_id").val();
        var name = $("#name").val();
        var email = $("#email").val();

        $.ajax({
            type: 'PUT',
            url: "{{ route('profile.update'," + id + ") }}",
            data: {
                id: id,
                name: name,
                email: email
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    alert('success');
                } else {
                    printErrorMsg(data.error);
                    $('.print-error-msg').delay(5000).fadeOut('slow');
                }
            }
        });
    });
</script>
@endsection
