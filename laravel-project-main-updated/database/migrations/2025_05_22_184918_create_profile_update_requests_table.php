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
        Schema::create('profile_update_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id'); // FK to subu

            // Replace JSON column with individual fields
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('current_address_line1')->nullable();
            $table->string('current_address_line2')->nullable();
            $table->string('current_city')->nullable();
            $table->string('current_state')->nullable();
            $table->string('current_district')->nullable();
            $table->string('current_pin', 10)->nullable();
            $table->enum('admin_status', ['adminpending', 'adminapproved', 'adminrejected'])->default('adminpending');
            $table->enum('hr_status', ['hrpending', 'hrapproved', 'hrrejected'])->default('hrpending');
            $table->enum('m_status', ['mpending', 'mapproved', 'mrejected'])->default('mpending');
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('subu')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('profile_update_requests');
    }
};
