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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('name');
            $table->string('department');
            $table->string('doj');
            $table->string('gender');
            $table->string('grade');
            $table->string('account_number');
            $table->string('ifsc_code');
            $table->string('bank_name');
            $table->string('branch_name');
            $table->string('basic_salary');
            $table->string('house_rent_allowance');
            $table->string('conveyance_allowance');
            $table->string('lunch_allowance');
            $table->string('medical_allowance');
            $table->string('other_allowance');
            $table->string('leave_travel_allowance');
            $table->string('total_ammount');
            $table->string('professional_tax');
            $table->string('esic');
            $table->string('net_salary_payable');
            $table->string('lop_days');
            $table->string('standard_days');
            $table->string('salary_for_the_month');
            $table->string('no_of_working_day');
            $table->string('total_leave_taken');
            $table->string('remarks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
