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
        Schema::create('multi_purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('purchaseOrder_id');
            $table->string('purchase_name');
            $table->integer('quantity');
            $table->string('unit')->nullable();
            $table->decimal('price');
            $table->integer('model_number')->nullable();
            $table->decimal('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multi_purchase_orders');
    }
};
