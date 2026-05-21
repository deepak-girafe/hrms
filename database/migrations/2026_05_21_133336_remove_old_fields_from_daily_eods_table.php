<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_eods', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Drop Foreign Key First
            |--------------------------------------------------------------------------
            */

            $table->dropForeign([

                'project_id'

            ]);

            /*
            |--------------------------------------------------------------------------
            | Drop Columns
            |--------------------------------------------------------------------------
            */

            $table->dropColumn([

                'project_id',

                'work_done',

                'blockers',

                'tomorrow_plan'

            ]);
        });
    }

    public function down(): void
    {

    }
};