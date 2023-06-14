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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('gentlemen');
            $table->string('professor_care');
            $table->integer('order_purchase_number');
            $table->unsignedBigInteger('order_material_id');
            $table->date('order_purchase_date');
            $table->string('project_name');
            $table->integer('project_number');
            $table->string('address');
            $table->string('phone_number');
            $table->string('email');
            $table->string('subject');
            $table->string('financial_provision');
            $table->integer('number');
            $table->decimal('total');
            $table->decimal('discount');
            $table->decimal('total_discount');
            $table->decimal('added_vat');
            $table->decimal('total_vat');
            $table->string('delivery_location');
            $table->date('delivery_date');
            $table->integer('status_id')->default(1);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
