<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            [
                'name' => 'Sales Manager',
                'signature_positions' => rand(1, 7),
            ],
            [
                'name' => 'Director of Sales',
                'signature_positions' => rand(1, 7),
            ],
            [
                'name' => 'Sales Executive',
                'signature_positions' => rand(1, 7),
            ],
            [
                'name' => 'Banquet Manager',
                'signature_positions' => rand(1, 7),
            ],
            [
                'name' => 'General Manager',
                'signature_positions' => rand(1, 7),
            ],
            [
                'name' => 'Front Office Manager',
                'signature_positions' => rand(1, 7),
            ],
            [
                'name' => 'Housekeeping Manager',
                'signature_positions' => rand(1, 7),
            ],
            [
                'name' => 'Food & Beverage Manager',
                'signature_positions' => rand(1, 7),
            ],
            [
                'name' => 'Marketing Manager',
                'signature_positions' => rand(1, 7),
            ],
            [
                'name' => 'Reservation Manager',
                'signature_positions' => rand(1, 7),
            ],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}