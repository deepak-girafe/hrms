<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run migrations
     */
    public function up(): void
    {
        Schema::create('holidays', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->date('holiday_date');

            $table->enum('holiday_type', [

                'Gazetted',
                'Restricted',
                'Optional',
                'Weekend'

            ])->default('Gazetted');

            $table->text('description')
                  ->nullable();

            $table->enum('status', [

                'Active',
                'Inactive'

            ])->default('Active');

            $table->timestamps();

        });
    }

    /**
     * Reverse migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};