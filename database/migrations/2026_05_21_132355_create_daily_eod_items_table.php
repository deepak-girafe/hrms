<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_eod_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('daily_eod_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('project_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->longText('work_done');

            $table->longText('blockers')
                ->nullable();

            $table->longText('tomorrow_plan')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_eod_items');
    }
};