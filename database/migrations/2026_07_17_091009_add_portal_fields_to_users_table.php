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
        Schema::table('users', function (Blueprint $table) {
            $table->string('sso_subject_id')->nullable()->unique()->after('id');
            $table->string('student_number')->nullable()->unique();
            $table->string('staff_number')->nullable()->unique();
            $table->string('role')->default('student'); // student | staff | admin
            $table->timestamp('last_login_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['sso_subject_id', 'student_number', 'staff_number', 'role', 'last_login_at']);
        });
    }
};
