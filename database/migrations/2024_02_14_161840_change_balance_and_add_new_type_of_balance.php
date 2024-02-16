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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('balance','eth_balance')->nullable();
            $table->string('usdt_balance')->nullable();
            $table->renameColumn('real_balance','eth_real_balance')->nullable();
            $table->string('usdt_real_balance')->nullable();
            $table->renameColumn('balance_updated_at','eth_balance_updated_at');
            $table->timestamp('usdt_balance_updated_at')->nullable();
            $table->renameColumn('real_balance_updated_at','eth_real_balance_updated_at');
            $table->timestamp('usdt_real_balance_updated_at')->nullable();

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
