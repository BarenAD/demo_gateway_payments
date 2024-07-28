<?php

use App\Enums\Langs;
use App\Enums\Transactions\TransactionStatues;
use App\Models\TransactionStatus;
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
        Schema::create('transaction_status_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('lang_id');
            $table->unsignedBigInteger('status_id');
            $table->foreign('lang_id')->references('id')->on('langs')->cascadeOnDelete();
            $table->foreign('status_id')->references('id')->on('transaction_statuses')->cascadeOnDelete();
            $table->timestamps();
        });
        TransactionStatus::query()->create(['id' => TransactionStatues::NEW->value, 'name' => 'Новая'])->addTranslation(['name' => 'NEW'], Langs::en->value);
        TransactionStatus::query()->create(['id' => TransactionStatues::IN_QUEUE->value, 'name' => 'В очереди'])->addTranslation(['name' => 'IN QUEUE'], Langs::en->value);
        TransactionStatus::query()->create(['id' => TransactionStatues::IN_PROGRESS->value, 'name' => 'Выполняется'])->addTranslation(['name' => 'IN PROGRESS'], Langs::en->value);
        TransactionStatus::query()->create(['id' => TransactionStatues::SUCCESSFULLY->value, 'name' => 'Выполнена'])->addTranslation(['name' => 'SUCCESSFULLY'], Langs::en->value);
        TransactionStatus::query()->create(['id' => TransactionStatues::ERROR->value, 'name' => 'Ошибка'])->addTranslation(['name' => 'ERROR'], Langs::en->value);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_status_translations');
    }
};
