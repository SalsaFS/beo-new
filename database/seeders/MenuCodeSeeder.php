<?php

namespace Database\Seeders;

use App\Models\MenuCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuCodeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuCodes = [
            ['name' => 'Appetizer'],
            ['name' => 'Soup'],
            ['name' => 'Main Course'],
            ['name' => 'Dessert'],
            ['name' => 'Beverage'],
            ['name' => 'Snack'],
            ['name' => 'Salad'],
        ];

        foreach ($menuCodes as $menuCode) {
            MenuCode::create($menuCode);
        }
    }
}
