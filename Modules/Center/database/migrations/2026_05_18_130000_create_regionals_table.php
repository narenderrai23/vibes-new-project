<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Timestamp 130000 — runs after centers (120000).
     *
     * NOTE: regional_id is already defined in the centers migration (120000).
     * This migration only creates the regionals table and adds the FK from
     * regionals.center_id → centers.id, plus the FK from centers.regional_id → regionals.id.
     */
    public function up(): void
    {
        Schema::create('regionals', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('code')->nullable()->comment('Short regional code, e.g. NORTH');

            $table->unsignedBigInteger('center_id')->nullable()->comment('Primary / head center for this region');

            $table->tinyInteger('status')->default(1);

            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // FK: regionals.center_id → centers.id (head center)
        Schema::table('regionals', function (Blueprint $table) {
            $table->foreign('center_id')
                  ->references('id')->on('centers')
                  ->nullOnDelete();
        });

        // FK: centers.regional_id → regionals.id
        // The column already exists (defined in 120000_create_centers_table).
        // We only add the FK constraint here after regionals table is created.
        Schema::table('centers', function (Blueprint $table) {
            $table->foreign('regional_id')
                  ->references('id')->on('regionals')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        // Drop FK on centers.regional_id first
        Schema::table('centers', function (Blueprint $table) {
            $table->dropForeign(['regional_id']);
        });

        // Drop FK on regionals.center_id, then drop the table
        Schema::table('regionals', function (Blueprint $table) {
            $table->dropForeign(['center_id']);
        });

        Schema::dropIfExists('regionals');
    }
};
