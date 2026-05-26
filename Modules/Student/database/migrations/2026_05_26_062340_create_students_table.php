<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile', 20)->nullable();
            $table->string('gender', 10)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->string('avatar')->nullable()->default('img/default-avatar.jpg');
            $table->string('enrollment_number')->nullable()->unique();
            $table->string('course')->nullable();
            $table->string('batch')->nullable();
            $table->tinyInteger('status')->default(1)->unsigned()->comment('1=Active 0=Inactive 2=Pending');
            $table->string('last_ip', 45)->nullable();
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('student_password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_password_reset_tokens');
        Schema::dropIfExists('students');
    }
};
