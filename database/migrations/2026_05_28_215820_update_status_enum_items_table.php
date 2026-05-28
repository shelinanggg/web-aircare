<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE items
            MODIFY COLUMN status ENUM(
                'found',
                'claimed',
                'disposed',
                'donated',
                'handed_over'
            ) NOT NULL DEFAULT 'found'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE items
            MODIFY COLUMN status ENUM(
                'found',
                'claimed',
                'disposed'
            ) NOT NULL DEFAULT 'found'
        ");
    }
};