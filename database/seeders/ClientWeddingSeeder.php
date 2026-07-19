<?php

namespace Database\Seeders;

use App\Models\ClientWedding;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientWeddingSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $clients = [
            [
                'guest_number' => 'CW-001',
                'pic' => 'Andi Wijaya',
                'address' => 'Jl. Merdeka No. 2, Jakarta',
                'mobile' => '081234568001',
                'telephone' => '0211238001',
            ],
            [
                'guest_number' => 'CW-002',
                'pic' => 'Rina Maharani',
                'address' => 'Jl. Asia Afrika No. 12, Bandung',
                'mobile' => '081234568002',
                'telephone' => '0221238002',
            ],
            [
                'guest_number' => 'CW-003',
                'pic' => 'Fajar Nugroho',
                'address' => 'Jl. Pemuda No. 30, Surabaya',
                'mobile' => '081234568003',
                'telephone' => '0311238003',
            ],
            [
                'guest_number' => 'CW-004',
                'pic' => 'Maya Sari',
                'address' => 'Jl. Malioboro No. 5, Yogyakarta',
                'mobile' => '081234568004',
                'telephone' => '02741238004',
            ],
            [
                'guest_number' => 'CW-005',
                'pic' => 'Hendra Kusuma',
                'address' => 'Jl. Hayam Wuruk No. 18, Semarang',
                'mobile' => '081234568005',
                'telephone' => '0241238005',
            ],
        ];

        foreach ($clients as $client) {
            ClientWedding::firstOrCreate(['guest_number' => $client['guest_number']], $client);
        }
    }
}
