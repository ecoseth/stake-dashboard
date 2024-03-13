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
            <div class="card-body table-responsive p-2">
                <table class="table table-striped text-nowrap" id="user-table">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>User Wallet</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $trx)
                            <tr>
                                <td>{{$trx->id}}</td>
                                <td>{{$trx->wallet}}</td>
                                <td>{{$trx->amount}}</td>
                                
                                <td> 
                                    @if(str_contains($trx->status,'eth'))
                                        <span class="badge badge-info">{{$trx->status}}</span></td>
                                    @else
                                        <span class="badge badge-warning">{{$trx->status}}</span></td>
                                    @endif
                                <td>{{$trx->created_at->diffForhumans()}}</td>
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
@section('scripts')

<script src="{{asset('plugins/data-tables/dataTables.min.js')}}"></script>

<script>
    $('#user-table').DataTable({
       "paging": true,
       "lengthChange": false,
       "searching": true,
       "ordering": true,
       responsive: true
   });
</script>

@endsection