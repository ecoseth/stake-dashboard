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

                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group" id="show_hide_password">
                                    <input class="form-control" type="password" id="password">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <a href="#" id="togglePassword">
                                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button class="btn btn-primary" id="update-password">Save</button>
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

    $(document).ready(function() {
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("fa-eye-slash");
                $('#show_hide_password i').removeClass("fa-eye");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("fa-eye-slash");
                $('#show_hide_password i').addClass("fa-eye");
            }
        });
    });

    $("#update-password").click(function(e) {

        e.preventDefault();

        var id = $("#user_id").val();
        var password = $("#password").val();

        $.ajax({
            type: 'PUT',
            url: "{{ route('password.update'," + id + ") }}",
            data: {
                id: id,
                password: password
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
