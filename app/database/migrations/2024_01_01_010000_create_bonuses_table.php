<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bonuses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('casino_name')->nullable();
            $table->string('short_text')->nullable();
            $table->text('content')->nullable();
            $table->string('bonus_code')->nullable();
            $table->integer('bonus_percent')->nullable();
            $table->string('max_bonus')->nullable();
            $table->string('max_bet')->nullable();
            $table->string('wager')->nullable();
            $table->string('free_spins')->nullable();
            $table->string('cta_label')->nullable();
            $table->text('play_url')->nullable();
            $table->text('terms_url')->nullable();
            $table->text('back_text')->nullable();
            $table->text('payment_methods')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bonuses');
    }
};
