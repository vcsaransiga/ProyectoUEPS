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
        if (!Schema::hasTable('sale_details')) {
            Schema::create('sale_details', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('sale_id');
                $table->string('product_id');
                $table->integer('quantity');
                $table->decimal('unit_price', 10, 2);
                $table->decimal('subtotal', 10, 2);
                $table->timestamps();
    
                $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
                $table->foreign('product_id')->references('id_item')->on('items')->onDelete('cascade');
            });
        }
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
