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

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actor_id')->nullable()->constrained('users');
            $table->string('action', 50);
            $table->string('entity_type', 50);
            $table->uuid('entity_id')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }
};
