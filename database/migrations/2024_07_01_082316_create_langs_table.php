<?php

use App\Enums\Langs;
use App\Models\Lang;
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
        Schema::create('langs', function (Blueprint $table) {
            $table->id();
            $table->string('identify')->unique();
            $table->string('name');
            $table->timestamps();
        });
        Lang::query()->updateOrCreate(['id' => Langs::en->value], ['identify' => Langs::en->name, 'name' => 'English']);
        Lang::query()->updateOrCreate(['id' => Langs::ru->value], ['identify' => Langs::ru->name, 'name' => 'Русский']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('langs');
    }
};
