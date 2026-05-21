<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_policies', function (Blueprint $table) {

            $table->id();

            $table->foreignId('role_id')
                  ->nullable();

            $table->foreignId('leave_type_id');

            $table->enum('employment_type', [

                'Probation',
                'Permanent'

            ]);

            $table->integer('allowed_leaves')
                  ->default(0);

            $table->enum('leave_cycle', [

                'Monthly',
                'Yearly'

            ])->default('Yearly');

            $table->enum('carry_forward', [

                'Yes',
                'No'

            ])->default('No');

            $table->integer('max_carry_forward')
                  ->default(0);

            $table->enum('sandwich_policy', [

                'Yes',
                'No'

            ])->default('No');

            $table->enum('status', [

                'Active',
                'Inactive'

            ])->default('Active');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_policies');
    }
};