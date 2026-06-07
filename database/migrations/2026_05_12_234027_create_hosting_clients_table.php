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
        Schema::create('hosting_clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('domain_name');
            $table->date('starting_date');
            $table->string('renew_duration', 20)->default('yearly');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('PKR');
            $table->string('server_usage', 30)->default('hosting_only');
            $table->string('hosting_provider')->nullable();
            $table->string('server_ip')->nullable();
            $table->boolean('auto_renew')->default(false);
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hosting_clients');
    }
};
