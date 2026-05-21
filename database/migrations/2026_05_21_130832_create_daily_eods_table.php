<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run Migrations
     */
    public function up(): void
    {
        Schema::create('daily_eods', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Employee
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            /*
            |--------------------------------------------------------------------------
            | Project
            |--------------------------------------------------------------------------
            */

            $table->foreignId('project_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            /*
            |--------------------------------------------------------------------------
            | EOD Date
            |--------------------------------------------------------------------------
            */

            $table->date('eod_date');

            /*
            |--------------------------------------------------------------------------
            | Work Status
            |--------------------------------------------------------------------------
            */

            $table->longText('work_done');

            $table->longText('blockers')
                ->nullable();

            $table->longText('tomorrow_plan')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum(

                'status',

                [

                    'Submitted',
                    'Reviewed'

                ]

            )->default('Submitted');

            $table->timestamps();
        });
    }

    /**
     * Reverse Migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_eods');
    }
};