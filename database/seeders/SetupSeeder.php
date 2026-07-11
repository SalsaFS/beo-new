<?php

namespace Database\Seeders;

use App\Models\Setup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SetupSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setups = [
            [
                'name' => 'Buffet',
                'description' => 'Makanan disajikan di meja buffet dan tamu mengambil sendiri sesuai keinginan. Cocok untuk acara dengan jumlah tamu yang banyak.',
            ],
            [
                'name' => 'Round Table',
                'description' => 'Meja bundar dengan kapasitas 8-10 orang per meja. Cocok untuk acara formal seperti resepsi pernikahan dan gala dinner.',
            ],
            [
                'name' => 'Family Style',
                'description' => 'Makanan disajikan di tengah meja dan tamu saling berbagi. Suasana lebih hangat dan akrab seperti makan keluarga.',
            ],
            [
                'name' => 'Classroom',
                'description' => 'Meja dan kursi berjejer menghadap ke depan. Cocok untuk acara seminar, workshop, dan pelatihan.',
            ],
            [
                'name' => 'Theater',
                'description' => 'Kursi berjejer tanpa meja menghadap ke panggung. Cocok untuk presentasi, pertunjukan, dan acara dengan kapasitas maksimal.',
            ],
            [
                'name' => 'U-Shape',
                'description' => 'Meja disusun membentuk huruf U dengan kursi di sisi luar. Cocok untuk rapat dan diskusi interaktif.',
            ],
            [
                'name' => 'Cocktail',
                'description' => 'Meja tinggi kecil tersebar di ruangan tanpa kursi. Cocok untuk acara networking dan standing party.',
            ],
        ];

        foreach ($setups as $setup) {
            Setup::create($setup);
        }
    }
}