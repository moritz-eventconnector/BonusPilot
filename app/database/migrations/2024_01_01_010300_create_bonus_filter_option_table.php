<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bonus_filter_option', function (Blueprint $table) {
            $table->foreignId('bonus_id')->constrained()->cascadeOnDelete();
            $table->foreignId('filter_option_id')->constrained()->cascadeOnDelete();
            $table->unique(['bonus_id', 'filter_option_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bonus_filter_option');
    }
};
