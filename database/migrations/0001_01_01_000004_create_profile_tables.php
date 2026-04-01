<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->unique();
            $table->date('date_of_birth');
            $table->string('gender', 10);
            $table->string('blood_type', 5)->nullable();
            $table->text('address')->nullable();
            $table->string('emergency_contact_name', 200)->nullable();
            $table->string('emergency_contact_phone', 20)->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->unique();
            $table->string('speciality', 100);
            $table->string('license_number', 100)->unique();
            $table->smallInteger('years_experience')->default(0);
            $table->decimal('consultation_fee', 10, 2)->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::create('assistant_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->unique();
            $table->uuid('doctor_id')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assistant_profiles');
        Schema::dropIfExists('doctor_profiles');
        Schema::dropIfExists('patient_profiles');
    }
};
