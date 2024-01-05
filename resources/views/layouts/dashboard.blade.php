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
                    <span class="info-box-number">38</span>
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
                    <span class="info-box-number">31</span>
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
                    <span class="info-box-text">Allowed USDT</span>
                    <span class="info-box-number">173.52</span>
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
                    <span class="info-box-number">173.52</span>
                </div>
                </div>
            </div>
            </div>

            <!-- CHART -->
            <div class="card card-primary">
            <div class="card-body">
                <p>This month registrations</p>

                <div class="chart">
                <canvas
                    id="areaChart"
                    style="
                    min-height: 250px;
                    height: 250px;
                    max-height: 250px;
                    max-width: 100%;
                    "
                ></canvas>
                </div>
            </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
@endsection