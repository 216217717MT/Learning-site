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
        Schema::disableForeignKeyConstraints();

        Schema::create('guide_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guide_id')->constrained();
            $table->enum('provider', ["youtube","vimeo","upload"])->default('youtube');
            $table->string('video_url', 500);
            $table->integer('duration_seconds')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guide_videos');
    }
};
