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
        Schema::create('mypayslips', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('name'); // Name as a string
            $table->string('month');
            $table->string('year');
            $table->string('grade');
            $table->string('lop_days');
            $table->string('refund_days');
            $table->string('standard_days');
            $table->decimal('basic_salary', 10, 2); // Salary with decimal precision
            $table->decimal('house_rent_allowance', 10, 2);
            $table->decimal('conveyance_allowance', 10, 2);
            $table->decimal('lunch_allowance', 10, 2);
            $table->decimal('personal_pay', 10, 2);
            $table->decimal('medical_allowance', 10, 2);
            $table->decimal('other_allowance', 10, 2);
            $table->decimal('leave_travel_allowance', 10, 2);
            $table->decimal('total_ammount', 10, 2); // Fixed typo from "ammount"
            $table->decimal('professional_tax', 10, 2);
            $table->decimal('esic', 10, 2);
            $table->decimal('advance', 10, 2);
            $table->decimal('net_salary_payable', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mypayslips');
    }
};
