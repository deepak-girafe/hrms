<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {

            $table->string('punch_in_latitude')
                  ->nullable();

            $table->string('punch_in_longitude')
                  ->nullable();

            $table->string('punch_out_latitude')
                  ->nullable();

            $table->string('punch_out_longitude')
                  ->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {

            $table->dropColumn([

                'punch_in_latitude',
                'punch_in_longitude',
                'punch_out_latitude',
                'punch_out_longitude'

            ]);

        });
    }
};