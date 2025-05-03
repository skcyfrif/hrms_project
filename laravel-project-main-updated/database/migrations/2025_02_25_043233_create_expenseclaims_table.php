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
        Schema::create('expenseclaims', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('name');
            $table->string('department')->nullable();
            $table->date('claim_date');
            $table->date('expense_date');
            $table->string('expense_category');
            $table->string('expense_description');
            $table->decimal('amount', 10, 2);
            $table->string('receipt_attached')->nullable();
            $table->string('manager_approval')->nullable();
            $table->string('hrhead_approval')->nullable();
            $table->string('admin_approval')->nullable();
            $table->date('approval_date');
            $table->string('reimbursed');
            // $table->date('processed_date');
            // $table->string('photo');
            $table->enum('status', ['pending', 'approve', 'reject'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenseclaims');
    }
};
