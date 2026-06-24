<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_backlinks', function (Blueprint $table): void {
            $table->id();
            $table->string('source_url', 1000);
            $table->string('source_domain', 200);
            $table->string('target_url', 500)->default('/');
            $table->string('anchor_text', 300)->nullable();
            $table->enum('link_type', ['dofollow', 'nofollow', 'sponsored', 'ugc'])->default('dofollow');
            $table->unsignedTinyInteger('domain_authority')->nullable(); // 0–100
            $table->enum('status', ['active', 'broken', 'pending', 'lost'])->default('pending');
            $table->date('discovered_at');
            $table->date('last_checked_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_backlinks');
    }
};
