@extends("layouts.app")
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2">
            <h1 class="m-0">Transactions</h1>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card">
            
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-nowrap">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>User Wallet</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->wallet}}</td>
                                <td>{{$user->amount}}</td>
                                <td>@if ($user->status == 'deposit') <span class="badge badge-info">deposit</span> @else <span class="badge badge-primary">approved</span>@endif</td>
                                <td>
                                
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection