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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_code', 20)->unique();
            $table->string('client_name');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('requirements_note')->nullable();
            $table->string('requirements_doc')->nullable();
            $table->decimal('cost', 12, 2)->nullable();
            $table->string('currency', 10)->default('PKR');
            $table->date('deadline')->nullable();
            $table->string('developer_name')->nullable();
            $table->string('status', 30)->default('pending');
            $table->string('live_url')->nullable();
            $table->string('testing_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
