<?php

namespace Database\Seeders;

use App\Models\ClientBeo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientBeoSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $clients = [
            [
                'guest_number' => 'CB-001',
                'company' => 'PT Maju Bersama',
                'pic' => 'Budi Santoso',
                'address' => 'Jl. Sudirman No. 1, Jakarta',
                'mobile' => '081234567001',
                'telephone' => '0211234001',
            ],
            [
                'guest_number' => 'CB-002',
                'company' => 'CV Bahagia Abadi',
                'pic' => 'Siti Nurhaliza',
                'address' => 'Jl. Thamrin No. 25, Jakarta',
                'mobile' => '081234567002',
                'telephone' => '0211234002',
            ],
            [
                'guest_number' => 'CB-003',
                'company' => 'PT Cahaya Timur',
                'pic' => 'Agus Pratama',
                'address' => 'Jl. Gatot Subroto No. 10, Bandung',
                'mobile' => '081234567003',
                'telephone' => '0221234003',
            ],
            [
                'guest_number' => 'CB-004',
                'company' => 'PT Sinar Terang',
                'pic' => 'Dewi Lestari',
                'address' => 'Jl. Pahlawan No. 50, Surabaya',
                'mobile' => '081234567004',
                'telephone' => '0311234004',
            ],
            [
                'guest_number' => 'CB-005',
                'company' => 'CV Karya Mandiri',
                'pic' => 'Rizki Ramadhan',
                'address' => 'Jl. Diponegoro No. 8, Yogyakarta',
                'mobile' => '081234567005',
                'telephone' => '02741234005',
            ],
        ];

        foreach ($clients as $client) {
            ClientBeo::firstOrCreate(['guest_number' => $client['guest_number']], $client);
        }
    }
}
