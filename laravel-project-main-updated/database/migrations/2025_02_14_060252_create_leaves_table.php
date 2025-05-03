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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('name');
            $table->string('designation');
            $table->string('department');
            $table->string('leave_from');
            $table->string('leave_to');
            $table->string('total_days');
            // $table->string('reason')->nullable()->change();
            $table->enum('reason', ['PL', 'SL', 'LOP']);
            $table->string('remarks')->nullable();
            $table->string('upload')->nullable();
            // $table->string('status');
            $table->enum('rm_status', ['rmpending', 'rmapprove', 'rmreject'])->default('rmpending');
            $table->enum('m_status', ['mpending', 'mapprove', 'mreject'])->default('mpending');
            $table->enum('hr_status', ['hrpending', 'hrapprove', 'hrreject'])->default('hrpending');
            $table->enum('admin_status', ['adminpending', 'adminapprove', 'adminreject'])->default('adminpending');
            $table->string('PL')->nullable();
            $table->string('SL')->nullable();
            $table->string('LOP')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
