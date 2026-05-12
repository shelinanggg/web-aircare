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
        Schema::create('categories', function (Blueprint $table) {

            $table->id();

            // Nama kategori
            $table->string('name');

            // Untuk identifier unik
            // contoh: valuable, electronics, documents
            $table->string('slug')->unique();

            // Warna kategori untuk QR/frame/badge
            $table->string('color')->default('#3B82F6');

            // Status aktif/nonaktif
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};