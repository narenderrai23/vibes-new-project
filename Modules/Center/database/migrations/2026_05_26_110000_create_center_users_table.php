<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('center_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('center_id')->nullable()->comment('Linked center');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile', 20)->nullable();
            $table->string('role', 50)->default('staff')->comment('manager|receptionist|staff');
            $table->string('avatar')->nullable()->default('img/default-avatar.jpg');
            $table->tinyInteger('status')->default(1)->unsigned()->comment('1=Active 0=Inactive 2=Pending');
            $table->string('last_ip', 45)->nullable();
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('center_id')
                ->references('id')->on('centers')
                ->nullOnDelete();
        });

        Schema::create('center_password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('center_password_reset_tokens');
        Schema::table('center_users', fn ($t) => $t->dropForeign(['center_id']));
        Schema::dropIfExists('center_users');
    }
};
