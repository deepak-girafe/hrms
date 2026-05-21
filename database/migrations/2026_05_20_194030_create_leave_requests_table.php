<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_requests', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id');

            $table->foreignId('leave_type_id');

            $table->date('from_date');

            $table->date('to_date');

            $table->decimal('total_days', 5, 1)
                  ->default(0);

            $table->text('reason')
                  ->nullable();

            $table->enum('status', [

                'Pending',
                'Approved',
                'Rejected'

            ])->default('Pending');

            $table->foreignId('approved_by')
                  ->nullable();

            $table->datetime('approved_at')
                  ->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};