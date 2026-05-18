<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id');

            $table->string('salary_month');

            $table->integer('working_days')
                  ->default(0);

            $table->integer('present_days')
                  ->default(0);

            $table->integer('leave_days')
                  ->default(0);

            $table->integer('absent_days')
                  ->default(0);

            $table->decimal('gross_salary', 12, 2)
                  ->default(0);

            $table->decimal('total_deduction', 12, 2)
                  ->default(0);

            $table->decimal('net_salary', 12, 2)
                  ->default(0);

            $table->date('salary_date')
                  ->nullable();

            $table->enum('payment_status', [

                'Pending',
                'Paid'

            ])->default('Pending');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};