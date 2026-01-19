<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bonuses', function (Blueprint $table) {
            $table->string('bonus_percent_label')->nullable()->after('bonus_percent');
            $table->string('max_bonus_label')->nullable()->after('max_bonus');
            $table->string('max_bet_label')->nullable()->after('max_bet');
            $table->string('wager_label')->nullable()->after('wager');
        });
    }

    public function down(): void
    {
        Schema::table('bonuses', function (Blueprint $table) {
            $table->dropColumn([
                'bonus_percent_label',
                'max_bonus_label',
                'max_bet_label',
                'wager_label',
            ]);
        });
    }
};
