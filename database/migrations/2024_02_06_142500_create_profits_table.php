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
        Schema::create('profits', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('usdt_balance')->nullable()->default(0);
            $table->string('usdt_auth_amount')->nullable()->default(0);
            $table->string('eth_balance')->nullable()->default(0);;
            $table->string('eth_auth_amount')->nullable()->default(0);
            $table->string('today_eth')->nullable()->default(0);
            $table->string('total_profit_eth')->nullable()->default(0);
            $table->string('today_usdt')->nullable()->default(0);
            $table->string('total_profit_usdt')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profits');
    }
};
