<?php

namespace Database\Seeders;

use App\Models\FunctionModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FunctionModelSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $functions = [
            // Wedding Functions
            [
                'name' => 'Akad Nikah',
                'type' => 'wedding',
                'description' => 'Prosesi akad nikah sebagai inti acara pernikahan.',
            ],
            [
                'name' => 'Resepsi',
                'type' => 'wedding',
                'description' => 'Acara resepsi penerimaan tamu undangan pernikahan.',
            ],
            [
                'name' => 'Suguhan',
                'type' => 'wedding',
                'description' => 'Penyajian makanan ringan dan minuman untuk tamu sebelum acara utama.',
            ],

            // Meeting Functions
            [
                'name' => 'CB 1',
                'type' => 'meeting',
                'description' => 'Coffee break pertama untuk peserta meeting di sesi pagi.',
            ],
            [
                'name' => 'Lunch',
                'type' => 'meeting',
                'description' => 'Istirahat makan siang untuk peserta meeting.',
            ],
            [
                'name' => 'CB 2',
                'type' => 'meeting',
                'description' => 'Coffee break kedua untuk peserta meeting di sesi siang.',
            ],
            [
                'name' => 'Dinner',
                'type' => 'meeting',
                'description' => 'Makan malam bersama setelah rangkaian acara meeting selesai.',
            ],
        ];

        foreach ($functions as $function) {
            FunctionModel::create($function);
        }
    }
}