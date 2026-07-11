<?php

namespace Database\Seeders;

use App\Models\Platform;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = Platform::pluck('id', 'name');

        $reviews = [
            [
                'platform_id' => $platforms['Facebook'],
                'guest'       => 'Budi Santoso',
                'date_issued' => '2026-06-15',
                'review'      => 'Acara pernikahan anak saya sangat luar biasa! Pelayanan dari tim sangat profesional dan memuaskan. Venue yang disediakan sangat indah dan nyaman.',
            ],
            [
                'platform_id' => $platforms['Instagram'],
                'guest'       => 'Siti Rahmawati',
                'date_issued' => '2026-06-20',
                'review'      => 'Tempatnya bagus banget untuk foto-foto. Dekorasi pernikahannya cantik dan sesuai dengan tema yang kami inginkan. Recommended!',
            ],
            [
                'platform_id' => $platforms['Twitter'],
                'guest'       => 'Ahmad Hidayat',
                'date_issued' => '2026-07-01',
                'review'      => 'Makanan yang disajikan sangat enak dan variatif. Pelayanan staf sangat ramah dan tanggap. Pasti akan kembali untuk acara keluarga lainnya.',
            ],
            [
                'platform_id' => $platforms['TikTok'],
                'guest'       => 'Dewi Lestari',
                'date_issued' => '2026-07-05',
                'review'      => 'Viral banget tempatnya! Banyak konten kreator yang datang untuk membuat konten di sini. Suasananya aesthetic banget.',
            ],
            [
                'platform_id' => $platforms['YouTube'],
                'guest'       => 'Rudi Hermawan',
                'date_issued' => '2026-07-08',
                'review'      => 'Proses booking dan koordinasi acara sangat mudah. Tim marketing sangat membantu dalam menentukan paket yang sesuai dengan budget kami.',
            ],
            [
                'platform_id' => $platforms['WhatsApp'],
                'guest'       => 'Maya Anggraini',
                'date_issued' => '2026-07-10',
                'review'      => 'Respon cepat melalui WhatsApp! Semua pertanyaan kami dijawab dengan jelas. Acara berjalan lancar tanpa kendala. Terima kasih!',
            ],
            [
                'platform_id' => $platforms['LinkedIn'],
                'guest'       => 'Dimas Prasetyo',
                'date_issued' => '2026-07-12',
                'review'      => 'Tempat yang cocok untuk corporate event. Fasilitas meeting room lengkap dengan peralatan presentasi modern. Parkir luas dan aman.',
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}