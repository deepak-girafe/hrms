<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {

            $table->decimal('basic_salary', 12, 2)
                ->default(0);

            $table->decimal('hra', 12, 2)
                ->default(0);

            $table->decimal('da', 12, 2)
                ->default(0);

            $table->decimal('ta', 12, 2)
                ->default(0);

            $table->decimal('bonus', 12, 2)
                ->default(0);

            $table->decimal('incentive', 12, 2)
                ->default(0);

            $table->decimal('other_allowance', 12, 2)
                ->default(0);

            $table->decimal('pf', 12, 2)
                ->default(0);

            $table->decimal('esi', 12, 2)
                ->default(0);

            $table->decimal('tds', 12, 2)
                ->default(0);

            $table->decimal('professional_tax', 12, 2)
                ->default(0);

        });
    }

    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {

            $table->dropColumn([

                'basic_salary',

                'hra',

                'da',

                'ta',

                'bonus',

                'incentive',

                'other_allowance',

                'pf',

                'esi',

                'tds',

                'professional_tax'

            ]);

        });
    }
};