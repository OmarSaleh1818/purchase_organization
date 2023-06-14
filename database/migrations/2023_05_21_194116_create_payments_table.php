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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_purchase_id');
            $table->integer('number_order');
            $table->date('date');
            $table->string('project_name');
            $table->integer('project_number');
            $table->string('gentlemen');
            $table->string('supplier_name');
            $table->decimal('price');
            $table->string('price_name');
            $table->date('due_date');
            $table->string('purchase_name');
            $table->string('financial_provision');
            $table->integer('number');
            $table->string('bank_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
