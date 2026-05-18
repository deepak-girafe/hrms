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
        Schema::table('users', function (Blueprint $table) {

            $table->foreignId('role_id')
                  ->nullable()
                  ->after('id');

            $table->foreignId('reporting_to')
                  ->nullable()
                  ->after('role_id');

            $table->string('designation')
                  ->nullable()
                  ->after('reporting_to');

            $table->string('mobile_number')
                  ->nullable()
                  ->after('designation');

            $table->date('joining_date')
                  ->nullable()
                  ->after('mobile_number');

            $table->enum('status', ['Active', 'Inactive'])
                  ->default('Active')
                  ->after('joining_date');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([

                'role_id',
                'reporting_to',
                'designation',
                'mobile_number',
                'joining_date',
                'status'

            ]);

        });
    }
};