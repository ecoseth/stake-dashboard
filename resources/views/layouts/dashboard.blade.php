@extends("layouts.app")
@section('content')

        <!-- Content Header (Page header) -->
        <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2">
            <h1 class="m-0">Dashboard</h1>
            </div>
        </div>
        </div>

        <!-- Main content -->
        <div class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"
                    ><i class="fas fa-users"></i
                ></span>

                <div class="info-box-content">
                    <span class="info-box-text">Registered Users</span>
                    <span class="info-box-number">{{$total_users}}</span>
                </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"
                    ><i class="fas fa-user-check"></i
                ></span>

                <div class="info-box-content">
                    <span class="info-box-text">Joined Users</span>
                    <span class="info-box-number">{{$total_confirmed_users}}</span>
                </div>
                </div>
            </div>

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"
                    ><i class="fas fa-dollar-sign"></i
                ></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Eth</span>
                    <span class="info-box-number">{{$eth_sum}}</span>
                </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"
                    ><i class="fas fa-dollar-sign"></i
                ></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total USDT</span>
                    <span class="info-box-number">{{$usdt_sum}}</span>
                </div>
                </div>
            </div>
            </div>

            <!-- CHART -->
            <div class="card card-primary">
            <div class="card-body">
                <p>This month registrations</p>

                <div class="chart">
                    <div style="width: 80%; margin: auto;">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
@endsection
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // var ctx = document.getElementById('lineChart').getContext('2d');
    const data = {
        labels: @json($data->map(fn ($data) => $data->date)),
        datasets: [{
            label: 'Registered users in the last 30 days',
            backgroundColor: 'rgba(255, 99, 132, 0.3)',
            borderColor: 'rgb(255, 99, 132)',
            data: @json($data->map(fn ($data) => $data->aggregate)),
        }]
    };
    const config = {
        type: 'bar',
        data: data
    };
    const myChart = new Chart(
        document.getElementById('lineChart'),
        config
    );
</script>

@endpush