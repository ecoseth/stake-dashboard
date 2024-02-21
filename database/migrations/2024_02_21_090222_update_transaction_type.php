<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {

            $table->enum('status',array('Deposit Usdt','Staked Usdt','Deposit Eth','Staked Eth', 'Statistics Usdt','Statistics Eth','Frozen Eth','Frozen Usdt','Today Usdt','Total Profit Usdt','Today Eth','Total Profit Eth','Swap Eth'))->change();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
