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
        Schema::create('employeeattendances', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('name');
            $table->string('date');
            $table->string('check_in_time');
            // $table->time('check_out_time')->nullable();
            // $table->integer('work_hours')->nullable();
            $table->string('status');
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('approve_by_manager')->nullable();
            $table->string('manager_approval_status')->nullable();
            $table->unsignedBigInteger('approve_by_rm')->nullable();
            $table->string('rm_approval_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employeeattendances');
    }
};
