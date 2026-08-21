<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('video_progress', function (Blueprint $table) {
            $table->id();
            $table->string('student_number');
            $table->foreignId('guide_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guide_video_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('started');
            $table->unsignedTinyInteger('percent_watched')->default(0);
            $table->timestamp('last_watched_at')->nullable();
            $table->timestamps();

            $table->unique(['student_number', 'guide_video_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video_progress');
    }
};
