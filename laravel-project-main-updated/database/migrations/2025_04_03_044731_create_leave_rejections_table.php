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
        Schema::create('leave_rejections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leave_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('rejected_by'); // Auth user (HR)
            $table->string('status')->default('reject');
            $table->text('reason');
            $table->timestamps();

            // $table->foreign('leave_id')->references('id')->on('leaves')->onDelete('cascade');
            // $table->foreign('employee_id')->references('id')->on('subus')->onDelete('cascade');
            // $table->foreign('rejected_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_rejections');
    }
};
