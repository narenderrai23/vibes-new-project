<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_contents', function (Blueprint $table) {
            // How the content is sourced: an uploaded file on a private disk,
            // or an externally hosted Vimeo video referenced by id / url.
            $table->string('source', 20)->default('upload')->after('type')
                ->comment('upload|vimeo');

            // Vimeo identifier (numeric id) and the original link the admin pasted.
            $table->string('external_id', 100)->nullable()->after('source');
            $table->string('external_url')->nullable()->after('external_id');

            // Uploaded-file fields are not required for externally hosted content.
            $table->string('storage_path')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('course_contents', function (Blueprint $table) {
            $table->dropColumn(['source', 'external_id', 'external_url']);
            $table->string('storage_path')->nullable(false)->change();
        });
    }
};
