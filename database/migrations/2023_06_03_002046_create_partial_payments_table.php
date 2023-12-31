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
        Schema::create('partial_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_purchase_id');
            $table->integer('number_order');
            $table->integer('company_id');
            $table->integer('subcompany_id');
            $table->integer('subsubcompany_id');
            $table->date('date');
            $table->integer('project_number');
            $table->string('gentlemen');
            $table->string('supplier_name');
            $table->decimal('price');
            $table->decimal('batch_payment');
            $table->string('price_name');
            $table->date('due_date');
            $table->string('purchase_name');
            $table->string('financial_provision');
            $table->integer('number');
            $table->integer('bank_id');
            $table->integer('status_id')->default(1);
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partial_payments');
    }
};
