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
        Schema::create('credentials', function (Blueprint $table) {
            $table->id();
            $table->string('system_name');
            $table->string('url')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->text('password'); // Laravel encrypt()
            $table->string('ip_address')->nullable();
            $table->string('port')->nullable();
            $table->text('command')->nullable();
            $table->string('owner_type', 20)->default('personal');
            $table->string('owner_name')->nullable();
            $table->string('cred_type', 30)->default('web_panel');
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
        Schema::dropIfExists('credentials');
    }
};
