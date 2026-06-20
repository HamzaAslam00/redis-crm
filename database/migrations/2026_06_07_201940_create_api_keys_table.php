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
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->string('provider_name');
            $table->string('key_label');
            $table->text('key_value'); // Laravel encrypt() — AES-256 via APP_KEY
            $table->string('key_type', 30)->default('api_key');
            $table->string('environment', 20)->default('production');
            $table->date('expires_at')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_keys');
    }
};
