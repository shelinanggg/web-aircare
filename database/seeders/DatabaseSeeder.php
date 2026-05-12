<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        $admin = User::firstOrCreate(
            ['email' => 'admin@aircare.unair.ac.id'],
            [
                'name'     => 'Admin AIRCARE',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'campus'   => null,
            ]
        );

        $staffA = User::firstOrCreate(
            ['email' => 'staff.a@aircare.unair.ac.id'],
            [
                'name'     => 'Staff Kampus A',
                'password' => Hash::make('password'),
                'role'     => 'staff',
                'campus'   => 'kampus-a',
            ]
        );

        $staffB = User::firstOrCreate(
            ['email' => 'staff.b@aircare.unair.ac.id'],
            [
                'name'     => 'Staff Kampus B',
                'password' => Hash::make('password'),
                'role'     => 'staff',
                'campus'   => 'kampus-b',
            ]
        );

        $staffC = User::firstOrCreate(
            ['email' => 'staff.c@aircare.unair.ac.id'],
            [
                'name'     => 'Staff Kampus C',
                'password' => Hash::make('password'),
                'role'     => 'staff',
                'campus'   => 'kampus-c',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */

        $categories = [

            [
                'name'  => 'Barang Berharga',
                'slug'  => 'valuable',
                'color' => '#EF4444',
            ],

            [
                'name'  => 'Dokumen Berharga',
                'slug'  => 'documents',
                'color' => '#8B5CF6',
            ],

            [
                'name'  => 'Barang Elektronik',
                'slug'  => 'electronics',
                'color' => '#3B82F6',
            ],

            [
                'name'  => 'Barang Pribadi Umum',
                'slug'  => 'personal',
                'color' => '#22C55E',
            ],

            [
                'name'  => 'Lainnya',
                'slug'  => 'other',
                'color' => '#6B7280',
            ],

        ];

        foreach ($categories as $categoryData) {

            Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                [
                    'name'      => $categoryData['name'],
                    'color'     => $categoryData['color'],
                    'is_active' => true,
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORY MAPPING
        |--------------------------------------------------------------------------
        */

        $valuableCategory   = Category::where('slug', 'valuable')->first();
        $documentsCategory  = Category::where('slug', 'documents')->first();
        $electronicsCategory = Category::where('slug', 'electronics')->first();
        $personalCategory   = Category::where('slug', 'personal')->first();
        $otherCategory      = Category::where('slug', 'other')->first();


        /*
        |--------------------------------------------------------------------------
        | SAMPLE ITEMS
        |--------------------------------------------------------------------------
        */

        $sampleItems = [

            [
                'name'            => 'Laptop Asus VivoBook',
                'category_id'     => $electronicsCategory->id,
                'campus'          => 'kampus-a',
                'status'          => 'found',
                'found_date'      => '2026-04-10',
                'location_detail' => 'Lantai 2, Meja 5',
            ],

            [
                'name'            => 'Dompet Coklat',
                'category_id'     => $valuableCategory->id,
                'campus'          => 'kampus-b',
                'status'          => 'found',
                'found_date'      => '2026-04-12',
                'location_detail' => 'Area Baca Utama',
            ],

            [
                'name'           => 'KTP Mahasiswa',
                'category_id'    => $documentsCategory->id,
                'campus'         => 'kampus-a',
                'status'         => 'claimed',
                'found_date'     => '2026-04-05',
                'claimed_date'   => '2026-04-08',
                'claimed_by'     => 'Budi Santoso',
                'claimer_nim'    => '042011133099',
            ],

            [
                'name'            => 'Charger iPhone',
                'category_id'     => $electronicsCategory->id,
                'campus'          => 'kampus-c',
                'status'          => 'found',
                'found_date'      => '2026-04-14',
                'location_detail' => 'Ruang Diskusi 3',
            ],

            [
                'name'            => 'Tas Ransel Hitam',
                'category_id'     => $personalCategory->id,
                'campus'          => 'kampus-a',
                'status'          => 'found',
                'found_date'      => '2026-04-13',
                'location_detail' => 'Lobby Utama',
            ],

            [
                'name'            => 'Kacamata Minus',
                'category_id'     => $personalCategory->id,
                'campus'          => 'kampus-b',
                'status'          => 'found',
                'found_date'      => '2026-04-11',
                'location_detail' => 'Rak Buku Lantai 1',
            ],

            [
                'name'         => 'Buku Catatan Merah',
                'category_id'  => $documentsCategory->id,
                'campus'       => 'kampus-c',
                'status'       => 'disposed',
                'found_date'   => '2026-03-20',
            ],

            [
                'name'            => 'Earphone Sony',
                'category_id'     => $electronicsCategory->id,
                'campus'          => 'kampus-a',
                'status'          => 'found',
                'found_date'      => '2026-04-15',
                'location_detail' => 'Meja Catalog',
            ],

            [
                'name'           => 'Payung Biru',
                'category_id'    => $otherCategory->id,
                'campus'         => 'kampus-b',
                'status'         => 'claimed',
                'found_date'     => '2026-04-09',
                'claimed_date'   => '2026-04-10',
                'claimed_by'     => 'Siti Aminah',
            ],

        ];


        /*
        |--------------------------------------------------------------------------
        | INSERT ITEMS
        |--------------------------------------------------------------------------
        */

        foreach ($sampleItems as $data) {

            $item = Item::create([

                'qr_code'        => Item::generateQrCode(),

                'name'           => $data['name'],

                'description'    => $data['description'] ?? null,

                'category_id'    => $data['category_id'],

                'campus'         => $data['campus'],

                'location_detail'=> $data['location_detail'] ?? null,

                'status'         => $data['status'],

                'found_by'       => $staffA->name,

                'found_date'     => $data['found_date'],

                'claimed_date'   => $data['claimed_date'] ?? null,

                'claimed_by'     => $data['claimed_by'] ?? null,

                'claimer_nim'    => $data['claimer_nim'] ?? null,

                'notes'          => null,

            ]);


            ActivityLog::create([

                'user_id'     => $staffA->id,

                'item_id'     => $item->id,

                'action'      => 'item_found',

                'description' => "Barang tercatat: {$item->name}",

            ]);
        }
    }
}