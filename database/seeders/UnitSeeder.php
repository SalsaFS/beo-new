<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'kg'],
            ['name' => 'g'],
            ['name' => 'L'],
            ['name' => 'ml'],
            ['name' => 'pcs'],
            ['name' => 'pack'],
            ['name' => 'bottle'],
            ['name' => 'can'],
            ['name' => 'box'],
            ['name' => 'tbsp'],
            ['name' => 'tsp'],
        ];

        foreach ($units as $unit) {
            Unit::firstOrCreate(['name' => $unit['name']], $unit);
        }
    }
}
