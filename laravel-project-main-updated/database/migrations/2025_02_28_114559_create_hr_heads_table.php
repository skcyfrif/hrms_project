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
        Schema::create('hr_heads', function (Blueprint $table) {
            $table->id();
            $table->string('hr_id');
            $table->string('name');
            $table->string('email');
            $table->string('photo');
            // System Access
            $table->string('user_role');
            $table->string('username');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_heads');
    }
};
