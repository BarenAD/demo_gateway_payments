<?php

use App\Enums\Langs;
use App\Enums\Transactions\TransactionTypes;
use App\Models\TransactionType;
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
        Schema::create('transaction_type_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('lang_id');
            $table->unsignedBigInteger('type_id');
            $table->foreign('lang_id')->references('id')->on('langs')->cascadeOnDelete();
            $table->foreign('type_id')->references('id')->on('transaction_types')->cascadeOnDelete();
            $table->timestamps();
        });
        TransactionType::query()->create(['id' => TransactionTypes::DEPOSIT->value, 'name' => 'Пополнение средств'])->addTranslation(['name' => 'Replenishment of funds'], Langs::en->value);
        TransactionType::query()->create(['id' => TransactionTypes::OUTPUT->value, 'name' => 'Вывод средств'])->addTranslation(['name' => 'Withdrawal of funds'], Langs::en->value);
        TransactionType::query()->create(['id' => TransactionTypes::TRANSFER->value, 'name' => 'Перевод средств'])->addTranslation(['name' => 'Transfer of funds'], Langs::en->value);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_type_translations');
    }
};
