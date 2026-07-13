<?php

namespace Database\Seeders;

use App\Models\MenuSubType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSubTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuSubTypes = [
            ['name' => 'Ala Carte'],
            ['name' => 'Main Buffet/Banquet'],
            ['name' => 'Promo of the Month'],
            ['name' => 'Set Menu'],
            ['name' => 'Coffee Break'],
        ];

        foreach ($menuSubTypes as $menuSubType) {
            MenuSubType::create($menuSubType);
        }
    }
}
