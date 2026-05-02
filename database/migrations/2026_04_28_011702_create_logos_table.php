<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logos', function (Blueprint $table) {
            $table->id();

            // 🖼 Image paths (stored in storage)
            $table->string('pres_gov')->nullable();
            $table->string('lgu_hilongos')->nullable();

            // ✅ Publish toggle
            $table->boolean('is_published')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logos');
    }
};
