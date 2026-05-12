<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([

            [
                'name'       => 'Barang Berharga',
                'slug'       => 'valuable',
                'color'      => '#EF4444',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name'       => 'Dokumen Berharga',
                'slug'       => 'documents',
                'color'      => '#8B5CF6',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name'       => 'Barang Elektronik',
                'slug'       => 'electronics',
                'color'      => '#3B82F6',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name'       => 'Barang Pribadi Umum',
                'slug'       => 'personal',
                'color'      => '#22C55E',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name'       => 'Lainnya',
                'slug'       => 'other',
                'color'      => '#6B7280',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}