<?php

namespace Database\Seeders;

use App\Models\MenuType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuTypes = [
            ['name' => 'Food'],
            ['name' => 'Beverage'],
            ['name' => 'Dessert'],
            ['name' => 'Snack'],
        ];

        foreach ($menuTypes as $menuType) {
            MenuType::create($menuType);
        }
    }
}
