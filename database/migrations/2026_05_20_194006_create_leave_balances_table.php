<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_balances', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id');

            $table->foreignId('leave_type_id');

            $table->integer('total_leaves')
                  ->default(0);

            $table->integer('used_leaves')
                  ->default(0);

            $table->integer('remaining_leaves')
                  ->default(0);

            $table->year('leave_year');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};