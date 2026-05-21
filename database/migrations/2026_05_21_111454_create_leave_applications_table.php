<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run Migration
     */
    public function up(): void
    {
        Schema::create('leave_applications', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Employee
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Leave Type
            |--------------------------------------------------------------------------
            */

            $table->foreignId('leave_type_id')
                  ->constrained()
                  ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Dates
            |--------------------------------------------------------------------------
            */

            $table->date('from_date');

            $table->date('to_date');

            $table->integer('total_days');

            /*
            |--------------------------------------------------------------------------
            | Reason
            |--------------------------------------------------------------------------
            */

            $table->longText('reason');

            /*
            |--------------------------------------------------------------------------
            | Approval
            |--------------------------------------------------------------------------
            */

            $table->enum(

                'status',

                [

                    'Pending',
                    'Approved',
                    'Rejected'

                ]

            )->default('Pending');

            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamp('approved_at')
                  ->nullable();

            $table->text('remarks')
                  ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse Migration
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'leave_applications'
        );
    }
};