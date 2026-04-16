<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Student
            $table->string('file_path'); // Student's submission file
            $table->string('file_name')->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->text('feedback')->nullable();
            $table->string('grade')->nullable();
            $table->string('status')->default('pending'); // pending, reviewed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};
