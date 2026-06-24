<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_pages', function (Blueprint $table): void {
            $table->id();
            $table->string('route_name', 100)->unique();
            $table->string('page_label', 100);

            // Core meta
            $table->string('meta_title', 70)->nullable();
            $table->string('meta_description', 170)->nullable();
            $table->text('meta_keywords')->nullable();

            // Open Graph
            $table->string('og_title', 100)->nullable();
            $table->string('og_description', 200)->nullable();
            $table->string('og_image', 500)->nullable();
            $table->string('og_type', 30)->default('website');

            // Twitter Card
            $table->string('twitter_card', 50)->default('summary_large_image');
            $table->string('twitter_title', 100)->nullable();
            $table->string('twitter_description', 200)->nullable();

            // Technical SEO
            $table->string('canonical_url', 500)->nullable();
            $table->boolean('noindex')->default(false);
            $table->boolean('nofollow')->default(false);

            // Schema / Structured Data (JSON-LD)
            $table->text('schema_json')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_pages');
    }
};
