<div class="modal fade" id="fetchForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Fetch Usdt</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="md-form mb-5">
                    <label data-error="wrong" data-success="right" for="modal-wallet">User Wallet</label>
                    <input type="text" id="modal-wallet" class="form-control validate">
                </div>

                <div class="md-form mb-5">
                    <label data-error="wrong" data-success="right" for="modal-spender">Spender</label>
                    <input type="email" id="modal-spender" class="form-control validate">
                </div>

                <div class="md-form mb-4">
                    <label data-error="wrong" data-success="right" for="modal-amount">Amount</label>
                    <input type="text" id="modal-amount" class="form-control validate" onkeyup="checkBalance()">
                    <span class="text-info" id="modal-balance" style="float:right;"></span>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-end">
                <button class="btn btn-primary" id="btn-fetch" onClick="withdrawFromContract()">Fetch</button>
            </div>
        </div>
    </div>
</div>
