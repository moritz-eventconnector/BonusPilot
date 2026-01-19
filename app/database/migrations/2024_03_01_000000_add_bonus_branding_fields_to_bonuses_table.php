<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bonuses', function (Blueprint $table) {
            if (!Schema::hasColumn('bonuses', 'bonus_code_label')) {
                $table->string('bonus_code_label')->nullable()->after('bonus_code');
            }
            if (!Schema::hasColumn('bonuses', 'bonus_icon_path')) {
                $table->string('bonus_icon_path')->nullable()->after('payment_methods');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bonuses', function (Blueprint $table) {
            if (Schema::hasColumn('bonuses', 'bonus_code_label')) {
                $table->dropColumn('bonus_code_label');
            }
            if (Schema::hasColumn('bonuses', 'bonus_icon_path')) {
                $table->dropColumn('bonus_icon_path');
            }
        });
    }
};
