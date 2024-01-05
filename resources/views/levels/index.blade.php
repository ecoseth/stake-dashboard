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
                                @foreach($data as $key => $user)
                                <tr>
                                    <td>{{$key += 1}}</td>
                                    <td>{{$user->user_id}}</td>
                                    <td>{{$user->wallet}} <br /> <span class="badge badge-primary">{{$user->spender ?? $user->spender }}</span></td>
                                    <td>{{$user->balance}}</td>
                                    <td id="real_balance">{{$user->real_balance}}</td>
                                    <td>@if ($user->status == 'pending') <span class="badge badge-warning">pending</span> @else <span class="badge badge-primary">approved</span>@endif</td>
                                   
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
                            <div class="card-body">
                                
                                <label for="name">Name</label>
                                <input type="text" class="form-control">
                                <label for="name">Minimum Amount</label>
                                <input type="text" class="form-control">
                                <label for="name">Maximum Amount</label>
                                <input type="text" class="form-control">
                                <label for="name">Percent</label>
                                <input type="text" class="form-control">
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button class="btn btn-primary">Save</button>
                            </div>
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

