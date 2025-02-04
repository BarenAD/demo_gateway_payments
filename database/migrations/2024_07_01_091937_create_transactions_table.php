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
            $table->decimal('value_from', 30,19)->nullable();
            $table->decimal('value_to', 30,19)->nullable();
            $table->dateTime('datetime');
            $table->dateTime('datetime_completed')->nullable();
            $table->unsignedBigInteger('user_from_id')->nullable();
            $table->unsignedBigInteger('user_to_id')->nullable();
            $table->unsignedBigInteger('currency_from_id')->nullable();
            $table->unsignedBigInteger('currency_to_id')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('type_id');
            $table->foreign('user_from_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('user_to_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('currency_from_id')->references('id')->on('currencies')->cascadeOnDelete();
            $table->foreign('currency_to_id')->references('id')->on('currencies')->cascadeOnDelete();
            $table->foreign('status_id')->references('id')->on('transaction_statuses')->cascadeOnDelete();
            $table->foreign('type_id')->references('id')->on('transaction_types')->cascadeOnDelete();
            $table->timestamps();

            $table->index(['user_from_id', 'user_to_id', 'datetime', 'type_id', 'status_id'], 'transactions_users_date_type_status_index');
            $table->index(['datetime', 'type_id', 'status_id']);
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
