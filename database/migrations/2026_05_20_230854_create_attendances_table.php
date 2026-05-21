<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id');

            $table->date('attendance_date');

            $table->time('punch_in')
                  ->nullable();

            $table->time('punch_out')
                  ->nullable();

            $table->string('punch_in_image')
                  ->nullable();

            $table->string('punch_out_image')
                  ->nullable();

            $table->decimal('working_hours', 5, 2)
                  ->nullable();

            $table->enum('status', [

                'Present',
                'Absent',
                'Half Day',
                'Leave',
                'Weekly Off',
                'Holiday'

            ])->default('Present');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};