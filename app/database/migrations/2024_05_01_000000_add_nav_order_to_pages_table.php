<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->unsignedInteger('nav_order')->default(0)->index();
        });

        $pages = DB::table('pages')->orderBy('id')->pluck('id');
        foreach ($pages as $index => $pageId) {
            DB::table('pages')->where('id', $pageId)->update(['nav_order' => $index]);
        }
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropIndex(['nav_order']);
            $table->dropColumn('nav_order');
        });
    }
};
