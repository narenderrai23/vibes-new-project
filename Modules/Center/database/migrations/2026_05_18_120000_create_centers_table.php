<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Timestamp 120000 — runs AFTER countries (112735) and states (112739).
     */
    public function up(): void
    {
        Schema::create('centers', function (Blueprint $table) {
            $table->id();

            $table->string('code')->nullable()->unique()->comment('Center code e.g. IDEWE');
            $table->string('name')->comment('Center Name');

            $table->string('mobile')->nullable()->comment('Primary mobile number');
            $table->string('mobile_alt')->nullable()->comment('Alternative mobile number');
            $table->string('email')->nullable();

            $table->text('address')->nullable();
            $table->string('google_link')->nullable()->comment('Google Maps link');
            $table->string('city')->nullable();

            $table->string('gst_no')->nullable()->comment('GST number');

            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('regional_id')->nullable();

            $table->tinyInteger('status')->default(1)->comment('1=Active 0=Inactive 2=Pending');

            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('centers', function (Blueprint $table) {
            $table->foreign('state_id')->references('id')->on('states')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('centers', function (Blueprint $table) {
            $table->dropForeign(['state_id']);
        });
        Schema::dropIfExists('centers');
    }
};
