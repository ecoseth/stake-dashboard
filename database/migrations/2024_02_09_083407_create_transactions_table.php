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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('wallet');
            $table->string('amount');
            $table->enum('status',array('Deposit Usdt','Staked Usdt','Deposit Eth','Staked Eth', 'Statistics Usdt','Statistics Eth','Frozen Eth','Frozen Usdt','Auth Amount Usdt','Today Eth','Total Profit Eth'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
