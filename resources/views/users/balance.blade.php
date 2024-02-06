@extends("layouts.app")
@section('content')
<div class="col-md-6 p-4">
    <h3>User {{ $data->user_id }}</h3>
    <div class="card">
        <div class="card-header">
            Manage Balance
        </div>

        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Statistics (ETH)</label>
                <input type="text" class="form-control" />
            </div>
            <div class="mb-3">
                <label class="form-label">Frozen (ETH)</label>
                <input type="text" class="form-control" />
            </div>
            <div class="mb-3">
                <label class="form-label">Statistics (USDT)</label>
                <input type="text" class="form-control" />
            </div>
            <div class="mb-3">
                <label class="form-label">Frozen (USDT)</label>
                <input type="text" class="form-control" />
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button class="btn btn-primary">Save</button>
        </div>
        <!-- /.card-footer -->
    </div>

    <div class="card">
        <div class="card-header">
            Manage Profits
        </div>

        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Balance (USDT)</label>
                <input type="text" class="form-control" />
            </div>
            <div class="mb-3">
                <label class="form-label">Auth Amount (USDT)</label>
                <input type="text" class="form-control" />
            </div>
            <div class="mb-3">
                <label class="form-label">Today (ETH)</label>
                <input type="text" class="form-control" />
            </div>
            <div class="mb-3">
                <label class="form-label">Total Profit (ETH)</label>
                <input type="text" class="form-control" />
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button class="btn btn-primary">Save</button>
        </div>
        <!-- /.card-footer -->
    </div>
</div>
@endsection
@section('scripts')

@endsection
