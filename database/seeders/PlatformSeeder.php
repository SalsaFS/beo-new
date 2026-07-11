<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = [
            ['name' => 'Facebook'],
            ['name' => 'Instagram'],
            ['name' => 'Twitter'],
            ['name' => 'TikTok'],
            ['name' => 'YouTube'],
            ['name' => 'LinkedIn'],
            ['name' => 'WhatsApp'],
        ];

        foreach ($platforms as $platform) {
            Platform::create($platform);
        }
    }
}