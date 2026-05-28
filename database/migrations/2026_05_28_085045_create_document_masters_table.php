<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('document_masters', function (Blueprint $table) {

            $table->id();
        
            $table->string('document_name');
        
            $table->text('description')
                ->nullable();
        
            $table->enum(
        
                'is_required',
        
                [
        
                    'Yes',
        
                    'No'
        
                ]
        
            )->default('No');
        
            $table->enum(
        
                'status',
        
                [
        
                    'Active',
        
                    'Inactive'
        
                ]
        
            )->default('Active');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_masters');
    }
};
