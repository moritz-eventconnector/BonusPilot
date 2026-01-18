<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bonuses', function (Blueprint $table) {
            $table->string('cta_label')->nullable()->after('free_spins');
            $table->text('back_text')->nullable()->after('terms_url');
            $table->text('payment_methods')->nullable()->after('back_text');
        });
    }

    public function down(): void
    {
        Schema::table('bonuses', function (Blueprint $table) {
            $table->dropColumn(['cta_label', 'back_text', 'payment_methods']);
        });
    }
};
