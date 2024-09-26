@extends("layouts.app")
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2"></div>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row flex justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Setting</h3><small><i class="fa fa-check-circle text-green" id="settings_icon_success" aria-hidden="true" style="display: none;"></i></small>
                        <div class="card-tools">
                            <i class="nav-icon fas fa-cogs"></i>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <form>
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="mb-3">
                                        <label>Eth to USDT Rate </label>
                                        <input type="text" class="form-control" name="eth_to_usdt" id="eth_to_usdt" value={{isset($data['exchange_rate']['usdt']) ? $data['exchange_rate']['usdt'] : ''}}>
                                        <small>1 eth = <span id="usdt">{{isset($data['exchange_rate']['usdt']) ? $data['exchange_rate']['usdt'] : ''}}</span></small>
                                    </div>
    
                                </div>

                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="address">Receiver address</label>
                                            <input type="text" class="form-control" id="receiver_address" name="receiver_address" value={{$data['setting'][0]['value']}}>
                                        </div>
                                    </div>

                                    <div class="col-md-4">

                                        <div class="mb-3">
                                            <label for="fees">Service Fees</label>
                                            <input type="text" class="form-control" name="fees" id="fees" value={{isset($data['setting'][1]['value']) ? $data['setting'][1]['value'] : ''}}>
                                            <br/>
                                            @if(isset($data['setting'][1]['action']))
                                                <span class="badge badge-info">{{\App\Models\User::find($data['setting'][1]['action'])->name}}</span>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-md-4">

                                        <div class="mb-3">
                                            <label for="nodes">Total Nodes</label>
                                            <input type="text" class="form-control" name="nodes" id="nodes" value={{isset($data['setting'][2]['value']) ? $data['setting'][2]['value'] : ''}}>
                                        </div>
                                    </div>
                                    
                            </div>
                           
                                    {{-- <div class="mb-3">
                                        <label for="address">Receiver address</label>
                                        <input type="text" class="form-control" id="address">
                                    </div> --}}



                            {{-- </div> --}}
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-primary" id="setting-store">Save</button>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-right"> <i class="fa fa-times-circle text-warning" id="empty_warning" style="display: none;"></i></small>

                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- /.card-footer -->
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

<script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"> </script>
<script src="{{ asset('contracts/contractABI.js') }}"></script>
<script src="{{ asset('contracts/contractAddress.js') }}"></script>

<script>
    const web3 = new Web3(window.ethereum)
    const contract = new web3.eth.Contract(contractABI, contractAddress)

    // Add Owner
    const addOwner = async (newOwner) => {
        const accounts = await window.ethereum.request({
            method: 'eth_requestAccounts'
        })
        const connectedUserAddress = accounts[0]

        if (wallet !== connectedUserAddress) {
            console.log('Please connect to your wallet!')
        } else {
            try {
                const transaction = await contract.methods.addOwner(newOwner).send({
                    from: wallet,
                })

                console.log('Owner added successfully:', transaction)
            } catch (error) {
                console.error('Error adding owner:', error)
            }
        }
    }

    $("#eth_to_usdt").keyup(function(){
        $("#usdt").text(this.value);
    })

    $("#setting-store").click(function(e) {

        e.preventDefault();

        var eth_to_usdt = $("#eth_to_usdt").val();
        var receiver_address = $("#receiver_address").val();
        var fees = $("#fees").val();
        var nodes = $("#nodes").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: "{{ route('settings.save') }}",
            data: {
                eth_to_usdt: eth_to_usdt,
                spender_wallet: receiver_address,
                fees: fees,
                nodes: nodes,
            },
            beforeSend: function() {
                $("#loader").removeClass('d-none');
            },
            success: function(data) {
               if(data.message == 'ok')
               {
                    $("#settings_icon_success").css('display','block');
                    $("#settings_icon_success").delay(3000).fadeOut('slow');

               }else if(data.message == 'no-data')
               {
                    $("#empty_warning").text('All fields cannot be empty');
                    $("#empty_warning").css('display','block');
                    $("#empty_warning").delay(3000).fadeOut('slow');
               }

               $("#loader").addClass('d-none');


            }
        });

    });
</script>
@endpush
