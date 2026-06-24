<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_keywords', function (Blueprint $table): void {
            $table->id();
            $table->string('keyword', 200);
            $table->string('target_url', 500)->nullable();
            $table->enum('priority', ['high', 'medium', 'low'])->default('medium');
            $table->unsignedSmallInteger('current_position')->nullable();
            $table->unsignedInteger('monthly_volume')->nullable();
            $table->unsignedTinyInteger('difficulty')->nullable(); // 0–100
            $table->text('notes')->nullable();
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_keywords');
    }
};
