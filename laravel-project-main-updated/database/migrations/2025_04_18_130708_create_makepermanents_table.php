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
        Schema::create('makepermanents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('employee_id');
            $table->string('request_type');
            $table->string('check_in_status');
            $table->enum('rmstatus', ['rmpending', 'rmapprove', 'rmreject'])->default('rmpending');
            $table->enum('mstatus', ['mpending', 'mapprove', 'mreject'])->default('mpending');
            $table->text('m_rejection_reason')->nullable();
            $table->text('rm_rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('makepermanents');
    }
};
