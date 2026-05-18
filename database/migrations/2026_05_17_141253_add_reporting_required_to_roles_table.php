<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run migrations
     */
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {

            $table->enum('reporting_required', ['Yes', 'No'])
                  ->default('No')
                  ->after('description');

        });
    }

    /**
     * Reverse migrations
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {

            $table->dropColumn('reporting_required');

        });
    }
};