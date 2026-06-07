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
        Schema::create('budget_incomes', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('PKR');
            $table->dateTime('date')->useCurrent();
            $table->string('note')->nullable();
            $table->string('proof')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_incomes');
    }
};
