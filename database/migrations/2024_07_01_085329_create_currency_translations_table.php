<?php

use App\Enums\Langs;
use App\Models\Currency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currency_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('lang_id');
            $table->unsignedBigInteger('currency_id');
            $table->foreign('lang_id')->references('id')->on('langs')->cascadeOnDelete();
            $table->foreign('currency_id')->references('id')->on('currencies')->cascadeOnDelete();
            $table->timestamps();
        });
        Currency::query()->create([
            'identify' => config('app.main_currency_identify'),
            'name' => 'Российский рубль',
        ])
            ->addTranslation(['name' => 'Russian Ruble'], Langs::en->value);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_translations');
    }
};
