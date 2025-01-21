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
        if (!Schema::hasTable('sales')) { 
            Schema::create('sales', function (Blueprint $table) {
                $table->id();
                $table->dateTime('sale_date');
                $table->decimal('total', 10, 2);
                $table->string('payment_method');
                $table->unsignedBigInteger('customer_id');
                $table->unsignedBigInteger('employee_id');
                $table->text('comments')->nullable();
                $table->timestamps();
    
                $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
                $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
