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
        Schema::create('subus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('employee_id');
            $table->string('name');
            $table->string('photo');
            $table->string('email');
            $table->string('phone_number');
            $table->date('dob'); // Change from string to date if storing dates
            $table->string('gender');


            // Contact Information
            // $table->string('permanent_address');

            // Permanent Address fields
            $table->string('permanent_address_line1')->nullable();
            $table->string('permanent_address_line2')->nullable();
            $table->string('permanent_city')->nullable();
            $table->string('permanent_district')->nullable();
            $table->string('permanent_state')->nullable();
            $table->string('permanent_pin')->nullable();

             // Current Address fields
             $table->string('current_address_line1')->nullable();
             $table->string('current_address_line2')->nullable();
             $table->string('current_city')->nullable();
             $table->string('current_district')->nullable();
             $table->string('current_state')->nullable();
             $table->string('current_pin')->nullable();

            // $table->string('current_address');
            $table->string('emergency_contact');

            // Employment Details
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('work_location')->nullable();
            $table->date('doj'); // Change from string to date
            // $table->string('employment_type')->nullable();
            $table->enum('employment_type', ['non_permanent', 'permanent'])->default('non_permanent');
            $table->date('permanent_date')->nullable();
            $table->string('created_by');

            // Bank Details
            $table->string('account_number');
            $table->string('ifsc_code');
            $table->string('bank_name');
            $table->string('branch_name');

            // Compensation Details (Fixing incorrect column definitions)
            $table->string('types');
            $table->string('pay_cycle');
            $table->integer('total_leave_allowed');
            $table->decimal('basic_salary', 10, 2); // Fix: Define as decimal
            $table->decimal('house_rent_allowance', 10, 2);
            $table->decimal('conveyance_allowance', 10, 2);
            $table->decimal('lunch_allowance', 10, 2);
            $table->decimal('personal_pay', 10, 2);
            $table->decimal('medical_allowance', 10, 2);
            $table->decimal('other_allowance', 10, 2);
            $table->decimal('leave_travel_allowance', 10, 2);
            $table->decimal('total_ammount', 10, 2);
            $table->decimal('professional_tax', 10, 2);
            $table->decimal('esic', 10, 2);
            $table->decimal('net_salary_payable', 10, 2);

            // System Access
            $table->string('user_role');
            $table->string('username');
            $table->string('password');
            // Add the 'assigned_to' column to store the Report Manager's ID (foreign key)
            // $table->foreignId('assigned_to')->nullable()->constrained('subus')->onDelete('set null'); // Assuming report managers are stored in the same table
            $table->string('assigned_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subus');
    }
};
