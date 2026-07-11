<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\FunctionModelSeeder;
use Database\Seeders\PlatformSeeder;
use Database\Seeders\ReviewSeeder;
use Database\Seeders\PositionSeeder;
use Database\Seeders\VenueSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            FunctionModelSeeder::class,
            PlatformSeeder::class,
            ReviewSeeder::class,
            PositionSeeder::class,
            VenueSeeder::class,
        ]);
    }
}
