@extends("layouts.app")
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2">
            <h1 class="m-0">Withdraws</h1>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table text-nowrap" id="withdrawTable">
                    <thead>
                        <tr>
                            {{-- style="width: 10px" --}}
                            <th style="width: 10px">#</th>
                            <th class="col-1">User</th>
                            <th class="col-3">Wallet Address</th>
                            <th class="col-1">Type</th>
                            <th class="col-2">Amount</th>
                            <th  class="col-1">Status</th>
                            <th class="col-2">Submitted At</th>
                            <th class="col-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $withdraw)
                        <tr>
                            <td>{{$key += 1}}</td>
                            <td>{{$withdraw->user_id}}</td>
                            <td>{{$withdraw->withdraw_wallet}} <br />
                                {{-- <span class="badge badge-primary">{{$user->spender ?? $user->spender }}</span> --}}
                            </td>
                            <td></td>
                            <td>{{$withdraw->amount}}</td>
                            <td>
                                @if($withdraw->status == 'pending')
                                    <span class="badge badge-warning">{{$withdraw->status}}</span> </td>
                                @elseif ($withdraw->status == 'approved')
                                    <span class="badge badge-success">{{$withdraw->status}}</span> </td>
                                @elseif ($withdraw->status == 'rejected')
                                    <span class="badge badge-danger">{{$withdraw->status}}</span> </td>
                                @endif
                            </td>

                            <td>{{$withdraw->created_at}}</td>

                            <td>
                                @if($withdraw->status == 'pending')
                                    <button class="btn btn-sm btn-primary mr-2" onclick="approveStatus('{{$withdraw->id}}')">Approve</button>
                                    <button class="btn btn-sm btn-danger" onclick="rejectStatus('{{$withdraw->id}}')">Reject</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @include('partials._modal')
            <!-- /.card-body -->
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

    function approveStatus(id){
        $.ajax({
            url: '{{ route('users.withdraws.approveStatus') }}',
            type: 'POST',
            data: {
                'withdraw_id' : id
            },
        }).done(function(response) {

            if (response == 'ok') {

                $("#withdrawTable").load(window.location + " #withdrawTable");

            }
        }).fail(function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('An error occurred while processing your request.');
        });
    }

    function rejectStatus(id){
        $.ajax({
            url: '{{ route('users.withdraws.rejectStatus') }}',
            type: 'POST',
            data: {
                'withdraw_id' : id
            },
        }).done(function(response) {

            if (response == 'ok') {

                $("#withdrawTable").load(window.location + " #withdrawTable");

            }
        }).fail(function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('An error occurred while processing your request.');
        });
    }

</script>
@endsection
