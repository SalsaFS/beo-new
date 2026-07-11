<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $venues = [
            [
                'name' => 'Grand Ballroom',
                'description' => 'Ballroom utama dengan kapasitas besar, cocok untuk acara gala dinner, resepsi pernikahan, dan konferensi besar.',
            ],
            [
                'name' => 'Crystal Ballroom',
                'description' => 'Ballroom mewah dengan dekorasi kristal dan pencahayaan elegan, ideal untuk acara formal dan pesta eksklusif.',
            ],
            [
                'name' => 'Meeting Room A',
                'description' => 'Ruang pertemuan standar dengan fasilitas lengkap untuk rapat bisnis dan diskusi kelompok kecil.',
            ],
            [
                'name' => 'Meeting Room B',
                'description' => 'Ruang pertemuan dengan kapasitas sedang, dilengkapi proyektor dan sound system untuk presentasi.',
            ],
            [
                'name' => 'Poolside Terrace',
                'description' => 'Area terbuka di tepi kolam renang, cocok untuk acara cocktail party, BBQ, dan gathering santai.',
            ],
            [
                'name' => 'Garden Pavilion',
                'description' => 'Area taman dengan pemandangan hijau yang asri, ideal untuk acara outdoor seperti garden party dan wedding.',
            ],
            [
                'name' => 'Executive Lounge',
                'description' => 'Lounge eksklusif dengan suasana premium, cocok untuk pertemuan bisnis tingkat tinggi dan acara VIP.',
            ],
        ];

        foreach ($venues as $venue) {
            Venue::create($venue);
        }
    }
}