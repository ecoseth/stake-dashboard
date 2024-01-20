<div class="modal fade" id="fetchForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Fetch Usdt</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- <form action="{{route('fetch.tokens')}}" method="POST"> --}}
                {{-- @csrf --}}
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <label data-error="wrong" data-success="right" for="modal-wallet">User Wallet</label>
                        <input type="text" id="modal-wallet" class="form-control validate" name="wallet">
                    </div>
                    <div class="md-form mb-5">
                        <label data-error="wrong" data-success="right" for="modal-spender">Spender</label>
                        <input type="text" id="modal-spender" class="form-control validate" name="spender" required>
                    </div>

                    <div class="md-form mb-4">
                        <label data-error="wrong" data-success="right" for="modal-amount">Amount</label>
                        <input type="text" id="modal-amount" class="form-control validate" onkeyup="checkBalance()" name="amount" required>
                        <span class="text-primary">Available balance: </span><span class="text-info" id="modal-balance"></span>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <button class="btn btn-primary" id="btn-fetch" onClick="withdrawUSDT()">Fetch</button>
                </div>
            {{-- </form> --}}
        </div>
    </div>
</div>
