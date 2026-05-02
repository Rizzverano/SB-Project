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
        Schema::table('ordinances', function (Blueprint $table) {
            $table->longText('description')->nullable();
            $table->string('sponsor')->nullable();
            $table->string('action')->nullable();
            $table->string('publish_through')->nullable();
            $table->date('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordinances', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'sponsor',
                'action',
                'publish_through',
                'date',
            ]);
        });
    }
};
