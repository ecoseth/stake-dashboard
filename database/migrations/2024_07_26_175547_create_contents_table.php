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
        Schema::create('contents', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->string('page');
            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->tinyInteger('author');
            $table->enum('sort',['1','2','3','4','5','6','7','8','9','10','11']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
