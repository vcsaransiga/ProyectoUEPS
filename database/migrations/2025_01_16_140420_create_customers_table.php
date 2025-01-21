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
        if (!Schema::hasTable('customers')) { 
            Schema::create('customers', function (Blueprint $table) {
                $table->id(); 
                $table->string('national_id', 20)->unique()->nullable(); 
                $table->string('name', 255);
                $table->string('phone', 20)->nullable(); 
                $table->string('email', 255)->unique()->nullable(); 
                $table->text('address')->nullable(); 
                $table->timestamps(); 
            });
        }
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
