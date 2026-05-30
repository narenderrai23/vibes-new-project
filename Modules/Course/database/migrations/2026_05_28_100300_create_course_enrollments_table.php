<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->tinyInteger('status')->default(1)->unsigned()->comment('1=Active 0=Inactive 2=Pending 3=Completed');
            $table->timestamps();
            $table->unique(['student_id', 'course_id']);
        });

        Schema::create('module_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_enrollment_id')->constrained('course_enrollments')->cascadeOnDelete();
            $table->foreignId('course_module_id')->constrained('course_modules')->cascadeOnDelete();
            $table->timestamp('completed_at')->nullable();
            $table->boolean('trainer_approved')->default(false);
            $table->timestamps();
            $table->unique(['course_enrollment_id', 'course_module_id'], 'mod_completion_unique');
        });

        Schema::create('content_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_enrollment_id')->constrained('course_enrollments')->cascadeOnDelete();
            $table->foreignId('course_content_id')->constrained('course_contents')->cascadeOnDelete();
            $table->unsignedTinyInteger('watch_percent')->default(0);
            $table->timestamp('first_viewed_at')->nullable();
            $table->timestamp('last_viewed_at')->nullable();
            $table->timestamps();
            $table->unique(['course_enrollment_id', 'course_content_id'], 'content_view_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_views');
        Schema::dropIfExists('module_completions');
        Schema::dropIfExists('course_enrollments');
    }
};
