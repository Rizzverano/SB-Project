<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citizens_charters', function (Blueprint $table) {
            $table->boolean('is_archived')->default(false)->after('is_publish');
        });

        Schema::table('organizational_charts', function (Blueprint $table) {
            $table->boolean('is_archived')->default(false)->after('is_publish');
        });
    }

    public function down(): void
    {
        Schema::table('citizens_charters', function (Blueprint $table) {
            $table->dropColumn('is_archived');
        });

        Schema::table('organizational_charts', function (Blueprint $table) {
            $table->dropColumn('is_archived');
        });
    }
};
