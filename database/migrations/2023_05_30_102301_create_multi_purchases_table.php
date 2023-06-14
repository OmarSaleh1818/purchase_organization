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
        Schema::create('multi_purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_id');
            $table->string('purchase_name');
            $table->integer('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->integer('model_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multi_purchases');
    }
};
