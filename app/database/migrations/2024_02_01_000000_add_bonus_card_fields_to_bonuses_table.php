<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bonuses', function (Blueprint $table) {
            if (!Schema::hasColumn('bonuses', 'cta_label')) {
                $table->string('cta_label')->nullable()->after('free_spins');
            }
            if (!Schema::hasColumn('bonuses', 'back_text')) {
                $table->text('back_text')->nullable()->after('terms_url');
            }
            if (!Schema::hasColumn('bonuses', 'payment_methods')) {
                $table->text('payment_methods')->nullable()->after('back_text');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bonuses', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('bonuses', 'cta_label')) {
                $columns[] = 'cta_label';
            }
            if (Schema::hasColumn('bonuses', 'back_text')) {
                $columns[] = 'back_text';
            }
            if (Schema::hasColumn('bonuses', 'payment_methods')) {
                $columns[] = 'payment_methods';
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
