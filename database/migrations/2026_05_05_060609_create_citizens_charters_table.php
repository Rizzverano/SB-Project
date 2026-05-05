<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citizens_charters', function (Blueprint $table) {
            $table->id();
            $table->string('file')->nullable();
            $table->boolean('is_publish')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citizens_charters');
    }
};
