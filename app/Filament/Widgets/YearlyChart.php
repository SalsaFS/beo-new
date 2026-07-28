<?php

namespace App\Filament\Widgets;

use App\Models\Beo;
use App\Models\BeoWedding;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class YearlyChart extends ChartWidget
{
    protected ?string $heading = 'Chart Beo';

    protected function getData(): array
    {
        $year = now()->year;
        $labels = [];
        $beo = [];
        $wedding = [];

        foreach (range(1, 12) as $m) {
            $labels[] = Carbon::create()->month($m)->format('M');
            $beo[] = Beo::whereYear('date_of_function', $year)
                ->whereMonth('date_of_function', $m)
                ->count();
            $wedding[] = BeoWedding::whereYear('date_of_function', $year)
                ->whereMonth('date_of_function', $m)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Beo',
                    'data' => $beo,
                    'backgroundColor' => '#2563eb',
                    'borderColor' => '#2563eb',
                ],
                [
                    'label' => 'Wedding',
                    'data' => $wedding,
                    'backgroundColor' => '#db2777',
                    'borderColor' => '#db2777',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'title' => [
                    'display' => true,
                    'position' => 'top', // Posisi: top, bottom, left, right
                    'align' => 'start',  // Perataan: start (kiri), center (tengah), end (kanan)
                    'color' => '#000000',
                    'font' => [
                        'size' => 14,      // Mengubah ukuran font (dalam pixel)
                        'weight' => 'bold', // Ketebalan font
                        'family' => 'Inter, sans-serif',
                    ],
                    'padding' => [
                        'top' => 10,
                        'bottom' => 20
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0, // Ini yang akan memaksa jadi angka bulat
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

}
