@extends("layouts.app")
@section('content')
<!-- Content Header (Page header) -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{-- <div class="row">
                    <div class="col-md-6 mb-3">
                        <input class="form-control" type="search" placeholder="Search with user id or wallet address" aria-label="Search" />
                    </div>
                    
                </div> --}}
                <div class="container-fluid">
                    <div class="mb-2">
                        <h1 class="m-0">Reward Setting</h1>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">

                <div class="row">
                    <div class="col-md-8">

                        <table class="table table-striped text-nowrap" id="rewards-table">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Minimum Amount</th>
                                    <th>Maximum Amount</th>
                                    <th>Percent</th>
                                    <th style="width: 40px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $key => $level)
                                <tr>
                                    <td>{{$key += 1}}</td>
                                    <td id="name_{{$level->id}}">{{$level->name}}</td>
                                    <td id="min_amount_{{$level->id}}">{{$level->min_amount}} </td>
                                    <td id="max_amount_{{$level->id}}">{{$level->max_amount}}</td>
                                    <td id="percentage_{{$level->id}}">{{$level->percentage}}</td>
                                    <input type="hidden" id="level-id" value="{{$level->id}}">
                                    <td><button class="btn btn-info btn-sm" onclick="editLevel({{$level->id}})"> Edit </button>
                                        <button class="btn btn-danger btn-sm"> Delete </button>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    <div class="col-md-4">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">New Reward</h3>
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
                                    <input type="hidden" id="level_id">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name">
                                    <label for="name">Minimum Amount</label>
                                    <input type="text" class="form-control" id="min_amount">
                                    <label for="name">Maximum Amount</label>
                                    <input type="text" class="form-control" id="max_amount">
                                    <label for="name">Percent</label>
                                    <input type="text" class="form-control" id="percent">
                                </div>

                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button class="btn btn-primary" id="level-store">Save</button>
                                    <button class="btn btn-primary d-none" id="level-edit">Update</button>
                                    <button class="btn btn-danger d-none" id="level-cancel">Cancel</button>

                                </div>
                            </form>

                                <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->

                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@section('scripts')

    <script src="{{asset('plugins/data-tables/dataTables.min.js')}}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#level-store").click(function(e){
    
            e.preventDefault();
        
            var name = $("#name").val();
            var min_amount = $("#min_amount").val();
            var max_amount = $("#max_amount").val();
            var percent = $("#percent").val();
        
            $.ajax({
            type:'POST',
            url:"{{ route('rewards.store') }}",
            data:{
                    name:name, 
                    min_amount:min_amount, 
                    max_amount:max_amount,
                    percentage:percent
                },
            success:function(data){
                if($.isEmptyObject(data.error)){
                    $("#rewards-table").load(window.location + " #rewards-table");
                }else{
                    printErrorMsg(data.error);
                    $('.print-error-msg').delay(5000).fadeOut('slow');

                }
            }
            });

        });

        $("#level-edit").click(function(e){

            alert("hello");

            e.preventDefault();
            
            var name = $("#name").val();
            var min_amount = $("#min_amount").val();
            var max_amount = $("#max_amount").val();
            var percent = $("#percent").val();
            var id = $("#level_id").val();

        
            $.ajax({
            type:'PUT',
            url:"{{ route('rewards.update',"+id+") }}",
            data:{
                    id:id,
                    name:name, 
                    min_amount:min_amount, 
                    max_amount:max_amount,
                    percentage:percent
                },
            success:function(data){
                if($.isEmptyObject(data.error)){
                    $("#rewards-table").load(window.location + " #rewards-table");
                }else{
                    printErrorMsg(data.error);
                    $('.print-error-msg').delay(5000).fadeOut('slow');

                }
            }
            });


        });

        $("#level-cancel").click(function(e){

            e.preventDefault();

            $(this).closest('form').find("input[type=text], textarea").val("");

            $("#level-edit").addClass('d-none');
            $("#level-cancel").addClass('d-none');
            $("#level-store").removeClass('d-none');

        });

        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }

        function editLevel(id)
        {
            var level_name = $("#name_"+id).text();
            var min_amount = $("#min_amount_"+id).text();
            var max_amount = $("#max_amount_"+id).text();
            var percentage = $("#percentage_"+id).text();

            $("#name").val(level_name);
            $("#min_amount").val(min_amount);
            $("#max_amount").val(max_amount);
            $("#percent").val(percentage);
            $("#level_id").val(id);

            $("#level-store").addClass('d-none');
            $("#level-edit").removeClass('d-none');
            $("#level-cancel").removeClass('d-none');

        }

        $('#rewards-table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });

        
    </script>
@endsection

