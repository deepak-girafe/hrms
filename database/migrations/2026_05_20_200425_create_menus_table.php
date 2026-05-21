<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {

            $table->id();

            $table->string('menu_name');

            $table->string('route_name')
                  ->nullable();

            $table->string('icon')
                  ->nullable();

            $table->integer('sort_order')
                  ->default(0);

            $table->enum('status', [

                'Active',
                'Inactive'

            ])->default('Active');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};