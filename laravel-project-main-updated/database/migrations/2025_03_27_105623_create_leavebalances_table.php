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
        Schema::create('leavebalances', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->year('year');
            $table->decimal('annual_leave_entitlement', 5, 2)->default(18);
            $table->decimal('pl_balance', 5, 2)->nullable();
            $table->decimal('total_leave_balance', 5, 2)->nullable();
            $table->decimal('sl_balance', 5, 2)->default(3);
            $table->integer('lop_days')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leavebalances');
    }
};
