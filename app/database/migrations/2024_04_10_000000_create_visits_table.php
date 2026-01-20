<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->timestamp('visited_at');
            $table->string('path', 255);
            $table->string('referrer_host', 255)->nullable();
            $table->text('referrer_url')->nullable();
            $table->string('utm_source', 100)->nullable();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 100)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index('visited_at');
            $table->index('referrer_host');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
