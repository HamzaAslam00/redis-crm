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
        Schema::table('proposal_items', function (Blueprint $table) {
            $table->string('delivery_days', 50)->nullable()->after('description');
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->boolean('milestone_mode')->default(false)->after('notes');
            $table->json('milestones')->nullable()->after('milestone_mode');
        });
    }

    public function down(): void
    {
        Schema::table('proposal_items', function (Blueprint $table) {
            $table->dropColumn('delivery_days');
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn(['milestone_mode', 'milestones']);
        });
    }
};
