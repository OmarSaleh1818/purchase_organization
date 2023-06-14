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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('subcompany_id');
            $table->integer('subsubcomany_id');
            $table->string('teacher_name');
            $table->integer('number');
            $table->string('financial_provision')->nullable();
            $table->date('date');
            $table->string('applicant');
            $table->string('created_by')->nullable();
            $table->integer('status_id')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
