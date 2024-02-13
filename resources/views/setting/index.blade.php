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
                        <h3 class="card-title">Setting</h3>
                        <div class="card-tools">
                            <!-- Buttons, labels, and many other things can be placed here! -->
                            <!-- Here is a label for example -->
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

                                <div class="col-md-3">

                                    <div class="mb-3">
                                        <label>Eth to USDT Rate </label>
                                        <input type="text" class="form-control">
                                        <small>1 eth = <span id="usdt"></span></small>
                                    </div>
    
                                </div>

                                <div class="col-md-5">

                                    <div class="mb-3">
                                        <label for="address">Receiver address</label>
                                        <input type="text" class="form-control" id="address">
                                    </div>
                                </div>

                                <div class="col-md-2">

                                    <div class="mb-3">
                                        <label for="fees">Service Fees</label>
                                        <input type="text" class="form-control" id="fees">
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
                            <button class="btn btn-primary" id="level-store">Save</button>
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
@section('scripts')

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
</script>
@endsection
