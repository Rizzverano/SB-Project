<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            // DROP problem columns
            $table->dropColumn(['status', 'is_locked', 'has_challenge']);
        });

        Schema::table('audit_logs', function (Blueprint $table) {
            // ✅ USE STRING INSTEAD OF ENUM (NO DBAL ISSUE)
            $table->string('status')->nullable()->index();

            // ✅ nullable booleans
            $table->boolean('is_locked')->nullable();
            $table->boolean('has_challenge')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropColumn(['status', 'is_locked', 'has_challenge']);
        });

        Schema::table('audit_logs', function (Blueprint $table) {
            $table->string('status')->index();
            $table->boolean('is_locked')->default(false);
            $table->boolean('has_challenge')->default(false);
        });
    }
};
