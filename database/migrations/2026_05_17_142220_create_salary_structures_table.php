<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_structures', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id');

            $table->decimal('basic_salary', 12, 2)
                  ->default(0);

            $table->decimal('hra', 12, 2)
                  ->default(0);

            $table->decimal('da', 12, 2)
                  ->default(0);

            $table->decimal('ta', 12, 2)
                  ->default(0);

            $table->decimal('medical_allowance', 12, 2)
                  ->default(0);

            $table->decimal('bonus', 12, 2)
                  ->default(0);

            $table->decimal('special_allowance', 12, 2)
                  ->default(0);

            $table->decimal('pf_deduction', 12, 2)
                  ->default(0);

            $table->decimal('esi_deduction', 12, 2)
                  ->default(0);

            $table->decimal('tds_deduction', 12, 2)
                  ->default(0);

            $table->decimal('loan_deduction', 12, 2)
                  ->default(0);

            $table->decimal('other_deduction', 12, 2)
                  ->default(0);

            $table->decimal('gross_salary', 12, 2)
                  ->default(0);

            $table->decimal('net_salary', 12, 2)
                  ->default(0);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_structures');
    }
};