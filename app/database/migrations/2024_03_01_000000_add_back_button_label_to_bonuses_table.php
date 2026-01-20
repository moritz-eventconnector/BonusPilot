<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bonuses', function (Blueprint $table) {
            if (!Schema::hasColumn('bonuses', 'go_back_label')) {
                $table->string('go_back_label')->nullable()->after('payment_methods');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bonuses', function (Blueprint $table) {
            if (Schema::hasColumn('bonuses', 'go_back_label')) {
                $table->dropColumn('go_back_label');
            }
        });
    }
};
