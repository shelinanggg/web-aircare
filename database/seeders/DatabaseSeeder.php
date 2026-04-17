<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Item;
use App\Models\ActivityLog;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin
        $admin = User::create([
            'name'     => 'Admin AIRCARE',
            'email'    => 'admin@aircare.unair.ac.id',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'campus'   => null,
        ]);

        // Staff per campus
        $staffA = User::create([
            'name'     => 'Staff Kampus A',
            'email'    => 'staff.a@aircare.unair.ac.id',
            'password' => Hash::make('password'),
            'role'     => 'staff',
            'campus'   => 'kampus-a',
        ]);

        User::create([
            'name'     => 'Staff Kampus B',
            'email'    => 'staff.b@aircare.unair.ac.id',
            'password' => Hash::make('password'),
            'role'     => 'staff',
            'campus'   => 'kampus-b',
        ]);

        User::create([
            'name'     => 'Staff Kampus C',
            'email'    => 'staff.c@aircare.unair.ac.id',
            'password' => Hash::make('password'),
            'role'     => 'staff',
            'campus'   => 'kampus-c',
        ]);

        // Seed sample items
        $sampleItems = [
            ['name' => 'Laptop Asus VivoBook', 'category' => 'electronics',  'campus' => 'kampus-a', 'status' => 'found',    'found_date' => '2026-04-10', 'location_detail' => 'Lantai 2, Meja 5'],
            ['name' => 'Dompet Coklat',        'category' => 'bags',         'campus' => 'kampus-b', 'status' => 'found',    'found_date' => '2026-04-12', 'location_detail' => 'Area Baca Utama'],
            ['name' => 'KTP Mahasiswa',         'category' => 'documents',    'campus' => 'kampus-a', 'status' => 'claimed',  'found_date' => '2026-04-05', 'claimed_date' => '2026-04-08', 'claimed_by' => 'Budi Santoso', 'claimer_nim' => '042011133099'],
            ['name' => 'Charger iPhone',        'category' => 'electronics',  'campus' => 'kampus-c', 'status' => 'found',    'found_date' => '2026-04-14', 'location_detail' => 'Ruang Diskusi 3'],
            ['name' => 'Tas Ransel Hitam',      'category' => 'bags',         'campus' => 'kampus-a', 'status' => 'found',    'found_date' => '2026-04-13', 'location_detail' => 'Lobby Utama'],
            ['name' => 'Kacamata Minus',        'category' => 'accessories',  'campus' => 'kampus-b', 'status' => 'found',    'found_date' => '2026-04-11', 'location_detail' => 'Rak Buku Lantai 1'],
            ['name' => 'Buku Catatan Merah',    'category' => 'documents',    'campus' => 'kampus-c', 'status' => 'disposed', 'found_date' => '2026-03-20'],
            ['name' => 'Earphone Sony',         'category' => 'electronics',  'campus' => 'kampus-a', 'status' => 'found',    'found_date' => '2026-04-15', 'location_detail' => 'Meja Catalog'],
            ['name' => 'Payung Biru',           'category' => 'other',        'campus' => 'kampus-b', 'status' => 'claimed',  'found_date' => '2026-04-09', 'claimed_date' => '2026-04-10', 'claimed_by' => 'Siti Aminah'],
        ];

        foreach ($sampleItems as $data) {
            $item = Item::create(array_merge($data, [
                'qr_code'  => Item::generateQrCode(),
                'found_by' => $staffA->name,
            ]));

            ActivityLog::create([
                'user_id'     => $staffA->id,
                'item_id'     => $item->id,
                'action'      => 'item_found',
                'description' => "Barang tercatat: {$item->name}",
            ]);
        }
    }
}
