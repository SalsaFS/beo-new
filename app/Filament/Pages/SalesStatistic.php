<?php

namespace App\Filament\Pages;

use App\Models\Beo;
use App\Models\BeoWedding;
use App\Models\User;
use Filament\Pages\Page;
use UnitEnum;

class SalesStatistic extends Page
{
    protected string $view = 'filament.pages.sales-statistic';
    protected static string|UnitEnum|null $navigationGroup = 'Statistic';
    protected static ?int $navigationSort = 1;

    public string $sortBy = 'total';
    public string $filterMonth = '';
    public string $filterYear = '';

    public function getMonthsProperty(): array
    {
        return [
            '' => 'All Months',
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
        ];
    }

    public function getYearsProperty(): array
    {
        $years = ['' => 'All Years'];
        foreach (range(now()->year - 5, now()->year + 1) as $y) {
            $years[$y] = (string) $y;
        }
        return $years;
    }

    public function getSalesDataProperty(): array
    {
        $salesUsers = User::role('sales')->get();

        $data = [];
        foreach ($salesUsers as $user) {
            $beoQuery = Beo::where('user_id', $user->id);
            $weddingQuery = BeoWedding::where('user_id', $user->id);

            if ($this->filterYear) {
                $beoQuery->whereYear('date_of_function', $this->filterYear);
                $weddingQuery->whereYear('date_of_function', $this->filterYear);
            }
            if ($this->filterMonth) {
                $beoQuery->whereMonth('date_of_function', $this->filterMonth);
                $weddingQuery->whereMonth('date_of_function', $this->filterMonth);
            }

            $beoCount = $beoQuery->count();
            $weddingCount = $weddingQuery->count();
            $data[] = [
                'id' => $user->id,
                'name' => $user->name,
                'beo' => $beoCount,
                'wedding' => $weddingCount,
                'total' => $beoCount + $weddingCount,
            ];
        }

        $sortField = match ($this->sortBy) {
            'beo' => 'beo',
            'wedding' => 'wedding',
            default => 'total',
        };

        usort($data, fn($a, $b) => $b[$sortField] <=> $a[$sortField]);

        return $data;
    }

    public function getTopSalesProperty(): array
    {
        return array_slice($this->salesData, 0, 5);
    }

    public function getMaxCountProperty(): int
    {
        $counts = array_column($this->salesData, match ($this->sortBy) {
            'beo' => 'beo',
            'wedding' => 'wedding',
            default => 'total',
        });
        return max($counts ?: [1]);
    }
}
