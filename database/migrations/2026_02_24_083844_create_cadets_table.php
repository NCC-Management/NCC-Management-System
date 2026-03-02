<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cadets', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relationship
            |--------------------------------------------------------------------------
            */
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | NCC Information
            |--------------------------------------------------------------------------
            */
            $table->string('enrollment_no')->unique();

            /*
            |--------------------------------------------------------------------------
            | Academic Information
            |--------------------------------------------------------------------------
            */
            $table->string('student_id')->nullable();
            $table->string('course')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Personal Information
            |--------------------------------------------------------------------------
            */
            $table->string('phone', 15)->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->text('address')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Profile Status
            |--------------------------------------------------------------------------
            */
            $table->boolean('profile_completed')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cadets');
    }
};