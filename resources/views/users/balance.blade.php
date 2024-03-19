@extends("layouts.app")
@section('content')
<div class="col-md-6 p-4">
    <h3>User <span id="user_id">{{  $user_id }}</span></h3>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Manage Balance</h3> <i class="fa fa-check-circle text-green" id="balance_icon_success" aria-hidden="true" style="display: none;"></i>
        </div>

        <div class="card-body">
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

            <div class="mb-3">
                <label class="form-label">Statistics (ETH)</label>
                <input type="text" class="form-control" id="stats_eth" value={{$balance->statistics_eth ?? ''}}>
            </div>
            <div class="mb-3">
                <label class="form-label">Frozen (ETH)</label>
                <input type="text" class="form-control" id="frozen_eth" value={{$balance->frozen_eth ?? ''}}>
            </div>
            <div class="mb-3">
                <label class="form-label">Statistics (USDT)</label>
                <input type="text" class="form-control" id="stats_usdt" value={{$balance->statistics_usdt ?? ''}}>
            </div>
            <div class="mb-3">
                <label class="form-label">Frozen (USDT)</label>
                <input type="text" class="form-control" id="frozen_usdt" value={{$balance->frozen_usdt ?? ''}}>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button class="btn btn-primary" id="balance_update">Save</button>
        </div>
        <!-- /.card-footer -->
    </div>
</div>

<div class="col-md-12 p-4">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Manage Profits</h3><i class="fa fa-check-circle text-green" id="profit_icon_success" aria-hidden="true" style="display: none;"></i>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Balance (USDT)</label>
                        <input type="text" class="form-control" id="balance_usdt" value="{{$usdt_balance ?? '0.0'}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Auth Amount (USDT)</label>
                        <input type="text" class="form-control" id="amount_usdt" value="{{$usdt_real_balance ?? '0.0'}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Balance (ETH)</label>
                        <input type="text" class="form-control" id="balance_eth" value="{{$eth_balance ?? '0.0'}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Auth Amount (ETH)</label>
                        <input type="text" class="form-control" id="amount_eth" value="{{$eth_real_balance ?? '0.0'}}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Today (ETH)</label>
                        <input type="text" class="form-control eth" id="today_eth" value="">
                        <input type="hidden" class="form-control eth" id="old_today_eth" value="{{$profit->total_profit_eth ?? '0.0'}}">

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Profit (ETH)</label>
                        <input type="text" class="form-control" id="total_profit_eth" value="{{$profit->total_profit_eth ?? ''}}" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Today (USDT)</label>
                        <input type="text" class="form-control usdt" id="today_usdt" value="">
                        <input type="hidden" class="form-control usdt" id="old_today_usdt" value="{{$profit->total_profit_usdt ?? '0.0'}}">

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Profit (USDT)</label>
                        <input type="text" class="form-control" id="total_profit_usdt" value="{{$profit->total_profit_usdt ?? ''}}">
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button class="btn btn-primary" id="profit_update">Save</button>
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
                        $("#balance_icon_success").css('display','block');
                        $("#balance_icon_success").delay(3000).fadeOut('slow');

                    } else {
                        printErrorMsg(data.error);
                        $('.print-error-msg').delay(5000).fadeOut('slow');

                    }
                    $("#loader").addClass('d-none');

                }
            });

    });

    $("#profit_update").click(function(e) {

        e.preventDefault();

        var balance_usdt = $("#balance_usdt").val();
        var amount_usdt = $("#amount_usdt").val();
        var balance_eth = $('#balance_eth').val();
        var amount_eth = $('#amount_eth').val();
        var today_eth = $("#today_eth").val();
        var total_profit_eth = $("#total_profit_eth").val();
        var today_usdt = $('#today_usdt').val();
        var total_profit_usdt = $('#total_profit_usdt').val();
        var user_id = $("#user_id").text();



        $.ajax({
            type: 'POST',
            url: "{{ route('users.update.profit') }}",
            data: {
                id: user_id,
                balance_usdt: balance_usdt,
                amount_usdt: amount_usdt,
                balance_eth: balance_eth,
                amount_eth: amount_eth,
                today_eth: today_eth,
                total_profit_eth: total_profit_eth,
                today_usdt: today_usdt,
                total_profit_usdt: total_profit_usdt
            },
            beforeSend: function() {
                $("#loader").removeClass('d-none');
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    // $("#rewards-table").load(window.location + " #rewards-table");
                    $("#profit_icon_success").css('display','block');
                    $("#profit_icon_success").delay(3000).fadeOut('slow');

                    $("#old_today_eth").val(total_profit_eth);
                    $("#old_today_usdt").val(total_profit_usdt);


                } else {
                    printErrorMsg(data.error);
                    $('.print-error-msg').delay(5000).fadeOut('slow');

                }
                $("#loader").addClass('d-none');

            }
        });

    });

    $("input[type=text]").keyup(function() {
        var $this = $(this);
        $this.val($this.val().replace(/[^\d.]/g, ''));        
    });

    $(".eth").on('keyup',function(){

        calculateEthSum();

    })

    $(".usdt").on('keyup',function(){

        calculateUsdtSum();

    })

    function calculateEthSum() {

        var sum = 0;
        //iterate through each textboxes and add the values
        $(".eth").each(function() {
            //add only if the value is number
            if (!isNaN(this.value) && this.value.length != 0) {
                sum += parseFloat(this.value);
            }
            else if (this.value.length != 0){
                $(this).css("background-color", "red");
            }
        });
    
        $("#total_profit_eth").val(sum.toFixed(4));

    }

    function calculateUsdtSum() {

        var sum = 0;
        //iterate through each textboxes and add the values
        $(".usdt").each(function() {
            //add only if the value is number
            if (!isNaN(this.value) && this.value.length != 0) {
                sum += parseFloat(this.value);
            }
            else if (this.value.length != 0){
                $(this).css("background-color", "red");
            }
        });

        $("#total_profit_usdt").val(sum.toFixed(2));

    }


    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function(key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }
</script>

@endsection
