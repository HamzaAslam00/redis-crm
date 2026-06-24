<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('client_name')->nullable();
            $table->enum('category', ['web', 'mobile', 'marketing', 'erp', 'ai', 'software'])->default('web');
            $table->string('short_desc', 255);
            $table->longText('description')->nullable();
            $table->json('tech_stack')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('project_url')->nullable();
            $table->json('results')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['active', 'draft'])->default('active');
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_items');
    }
};
