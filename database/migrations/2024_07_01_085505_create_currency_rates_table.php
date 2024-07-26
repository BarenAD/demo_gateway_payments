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
        Schema::create('currency_rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('value', 25,19);
            $table->unsignedBigInteger('currency_from_id');
            $table->unsignedBigInteger('currency_to_id');
            $table->foreign('currency_from_id')->references('id')->on('currencies')->cascadeOnDelete();
            $table->foreign('currency_to_id')->references('id')->on('currencies')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_rates');
    }
};
