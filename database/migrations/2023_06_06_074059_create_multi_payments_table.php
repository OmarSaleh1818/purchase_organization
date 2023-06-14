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
        Schema::create('multi_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('payment_id');
            $table->decimal('payment_price');
            $table->date('payment_date');
            $table->boolean('payment_date')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multi_payments');
    }
};
