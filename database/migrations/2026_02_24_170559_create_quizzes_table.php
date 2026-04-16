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
        Schema::create('quizzes', function (Blueprint $header) {
            $header->id();
            $header->foreignId('tutor_id')->constrained('users')->onDelete('cascade');
            $header->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $header->string('name');
            $header->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
