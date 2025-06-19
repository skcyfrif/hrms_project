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
        Schema::create('account_update_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('bank_name');
            $table->string('branch_name');
            $table->string('account_number');
            $table->string('ifsc_code');
            $table->enum('admin_status', ['adminpending', 'adminapproved', 'adminrejected'])->default('adminpending');
            $table->enum('hr_status', ['hrpending', 'hrapproved', 'hrrejected'])->default('hrpending');
            $table->enum('m_status', ['mpending', 'mapproved', 'mrejected'])->default('mpending');
            
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('subu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_update_requests');
    }
};
