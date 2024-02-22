<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $user_id;
    protected $wallet;
    protected $amount;
    protected $status;
    public function __construct($user_id, $wallet, $amount, $status)
    {
        $this->user_id = $user_id;
        $this->wallet = $wallet;
        $this->amount = $amount;
        $this->status = $status;
    }

    public function handle(): void
    {
        Transaction::create([
            'user_id' => $this->user_id,
            'wallet' => $this->wallet,
            'amount' => $this->amount,
            'status' => $this->status,
        ]);
    }
}
