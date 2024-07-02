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
            $table->decimal('value', 9,3);
            $table->dateTime('datetime');
            $table->unsignedBigInteger('user_from_id');
            $table->unsignedBigInteger('user_to_id');
            $table->unsignedBigInteger('currency_from_id');
            $table->unsignedBigInteger('currency_to_id');
            $table->unsignedBigInteger('status_id');
            $table->foreign('user_from_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('user_to_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('currency_from_id')->references('id')->on('currencies')->cascadeOnDelete();
            $table->foreign('currency_to_id')->references('id')->on('currencies')->cascadeOnDelete();
            $table->foreign('status_id')->references('id')->on('transaction_statuses')->cascadeOnDelete();
            $table->timestamps();

            $table->index(['user_from_id', 'user_to_id', 'datetime', 'status_id']);
            $table->index(['datetime', 'status_id']);
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
