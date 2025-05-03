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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('month');
            $table->string('year');
            $table->integer('working_days');
            $table->integer('total_days');
            $table->integer('holidays');
            $table->integer('sundays');
            $table->integer('days_present');
            $table->integer('lop_days');
            $table->integer('paid_leave_days');
            $table->integer('sick_leave_days');
            $table->decimal('gross_salary', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
