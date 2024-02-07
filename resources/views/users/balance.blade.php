@extends("layouts.app")
@section('content')
<div class="col-md-6 p-4">
    <h3>User <span id="user_id">{{  $user_id }}</span></h3>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Manage Balance</h3> <i class="fa fa-check-circle text-green" id="icon_success" aria-hidden="true" style="display: none;"></i>
        </div>

        <div class="card-body">
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

            <div class="mb-3">
                <label class="form-label">Statistics (ETH)</label>
                <input type="text" class="form-control" id="stats_eth" value={{$data->statistics_eth ?? '0'}}>
            </div>
            <div class="mb-3">
                <label class="form-label">Frozen (ETH)</label>
                <input type="text" class="form-control" id="frozen_eth" value={{$data->frozen_eth ?? '0'}}>
            </div>
            <div class="mb-3">
                <label class="form-label">Statistics (USDT)</label>
                <input type="text" class="form-control" id="stats_usdt" value={{$data->statistics_usdt ?? '0'}}>
            </div>
            <div class="mb-3">
                <label class="form-label">Frozen (USDT)</label>
                <input type="text" class="form-control" id="frozen_usdt" value={{$data->frozen_usdt ?? '0'}}>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button class="btn btn-primary" id="balance_update">Save</button>
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

<script>

     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#balance_update").click(function(e) {

            e.preventDefault();

            var user_id = $("#user_id").text();
            var stats_eth = $("#stats_eth").val();
            var stats_usdt = $("#stats_usdt").val();
            var frozen_eth = $("#frozen_eth").val();
            var frozen_usdt = $("#frozen_usdt").val();


            $.ajax({
                type: 'POST',
                url: "{{ route('users.update.balance') }}",
                data: {
                    id: user_id,
                    stats_eth: stats_eth,
                    stats_usdt: stats_usdt,
                    frozen_eth: frozen_eth,
                    frozen_usdt: frozen_usdt,
                },
                beforeSend: function() {
                    $("#loader").removeClass('d-none');
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        // $("#rewards-table").load(window.location + " #rewards-table");
                        $("#icon_success").css('display','block');
                        $("#icon_success").delay(3000).fadeOut('slow');

                    } else {
                        printErrorMsg(data.error);
                        $('.print-error-msg').delay(5000).fadeOut('slow');

                    }
                    $("#loader").addClass('d-none');

                }
            });

    });


    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }
</script>

@endsection
