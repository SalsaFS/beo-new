<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            ['name' => 'Gula Pasir', 'article_code' => 'ING-001'],
            ['name' => 'Garam', 'article_code' => 'ING-002'],
            ['name' => 'Tepung Terigu', 'article_code' => 'ING-003'],
            ['name' => 'Minyak Goreng', 'article_code' => 'ING-004'],
            ['name' => 'Mentega', 'article_code' => 'ING-005'],
            ['name' => 'Telur Ayam', 'article_code' => 'ING-006'],
            ['name' => 'Daging Sapi', 'article_code' => 'ING-007'],
            ['name' => 'Daging Ayam', 'article_code' => 'ING-008'],
            ['name' => 'Bawang Merah', 'article_code' => 'ING-009'],
            ['name' => 'Bawang Putih', 'article_code' => 'ING-010'],
            ['name' => 'Air Mineral', 'article_code' => 'ING-011'],
            ['name' => 'Susu Cair', 'article_code' => 'ING-012'],
            ['name' => 'Lada Bubuk', 'article_code' => 'ING-013'],
            ['name' => 'Kecap Manis', 'article_code' => 'ING-014'],
            ['name' => 'Saus Tomat', 'article_code' => 'ING-015'],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::firstOrCreate(['name' => $ingredient['name']], $ingredient);
        }
    }
}
