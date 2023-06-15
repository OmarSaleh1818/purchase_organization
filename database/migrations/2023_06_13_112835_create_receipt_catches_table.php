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
        Schema::create('receipt_catches', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('company_id');
            $table->integer('subcompany_id');
            $table->integer('subsubcompany_id');
            $table->string('gentlemen');
            $table->decimal('price');
            $table->string('currency_type');
            $table->string('just');
            $table->integer('bank_id');
            $table->string('check_number');
            $table->integer('project_number');
            $table->string('financial_provision');
            $table->integer('number_financial');
            $table->string('purchase_name');
            $table->integer('status_id')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_catches');
    }
};
