<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_module_id')->constrained('course_modules')->cascadeOnDelete();
            $table->string('title');
            $table->text('summary')->nullable();
            $table->string('type', 20)->comment('video|reel|pdf|mindmap|ppt|audio|notes');
            $table->string('storage_disk', 30)->default('local');
            $table->string('storage_path');
            $table->string('mime', 100)->nullable();
            $table->unsignedBigInteger('size_bytes')->nullable();
            $table->unsignedSmallInteger('position')->default(1);
            $table->unsignedSmallInteger('release_day')->default(1)->comment('Day-wise visibility offset from enrollment start');
            $table->timestamp('release_at')->nullable()->comment('Optional absolute scheduled release');
            $table->boolean('downloadable')->default(false);
            $table->string('language', 10)->default('en');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['course_module_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_contents');
    }
};
