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
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('title', 100);
            $table->text('description');
            $table->enum('type', ['full-time', 'part-time', 'internship']);
            $table->text('requirements');
            $table->string('location');
            $table->string('salary')->nullable();
            $table->string('working_hours')->nullable();
            $table->json('required_skills');
            $table->string('duration')->nullable(); // For internships
            $table->boolean('academic_credit')->nullable(); // For internships
            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();
            $table->text('benefits')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
