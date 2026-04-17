<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('qr_code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category'); // electronics, documents, accessories, bags, clothing, other
            $table->string('campus');   // kampus-a, kampus-b, kampus-c
            $table->string('location_detail')->nullable();
            $table->enum('status', ['found', 'claimed', 'disposed'])->default('found');
            $table->string('image')->nullable();
            $table->string('found_by')->nullable(); // staff name
            $table->date('found_date');
            $table->date('claimed_date')->nullable();
            $table->string('claimed_by')->nullable();
            $table->string('claimer_nim')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
