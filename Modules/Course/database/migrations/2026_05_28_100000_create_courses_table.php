<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->unsignedSmallInteger('duration_weeks')->default(4);
            $table->decimal('fee_min', 12, 2)->nullable();
            $table->decimal('fee_max', 12, 2)->nullable();
            $table->string('language_default', 10)->default('en');
            $table->json('languages_supported')->nullable();
            $table->tinyInteger('status')->default(1)->unsigned()->comment('1=Active 0=Inactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
