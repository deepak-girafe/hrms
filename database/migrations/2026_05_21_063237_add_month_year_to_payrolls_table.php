<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {

            $table->integer('month')
                  ->after('user_id');

            $table->integer('year')
                  ->after('month');
        });
    }

    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {

            $table->dropColumn([

                'month',
                'year'

            ]);
        });
    }
};