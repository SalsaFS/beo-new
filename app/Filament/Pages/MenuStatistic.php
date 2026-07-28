<?php

namespace App\Filament\Pages;

use App\Models\BeoMenu;
use App\Models\Menu;
use App\Models\MenuSubType;
use App\Models\MenuType;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class MenuStatistic extends Page
{
    protected string $view = 'filament.pages.menu-statistic';
    protected static string|UnitEnum|null $navigationGroup = 'Statistic';
    protected static ?int $navigationSort = 2;

    public string $filterMenuType = '';
    public string $filterMenuSubType = '';
    public string $filterMonth = '';
    public string $filterYear = '';

    public function getMenuTypesProperty()
    {
        return MenuType::orderBy('name')->pluck('name', 'id');
    }

    public function getMenuSubTypesProperty()
    {
        return MenuSubType::orderBy('name')->pluck('name', 'id');
    }

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

    public function getMenuStatsProperty(): array
    {
        $query = BeoMenu::query()
            ->select('menu_id', DB::raw('count(*) as total_ordered'), DB::raw('sum(pax) as total_pax'))
            ->with('menu.menuType', 'menu.menuSubType')
            ->groupBy('menu_id');

        if ($this->filterYear || $this->filterMonth) {
            $query->whereHas('beoFunction.beo', function ($q) {
                if ($this->filterYear) {
                    $q->whereYear('date_of_function', $this->filterYear);
                }
                if ($this->filterMonth) {
                    $q->whereMonth('date_of_function', $this->filterMonth);
                }
            });
        }

        if ($this->filterMenuType) {
            $query->whereHas('menu', fn($q) => $q->where('menu_type_id', $this->filterMenuType));
        }
        if ($this->filterMenuSubType) {
            $query->whereHas('menu', fn($q) => $q->where('menu_sub_type_id', $this->filterMenuSubType));
        }

        $stats = $query->get()->map(fn($bm) => [
            'id' => $bm->menu_id,
            'name' => $bm->menu->name ?? '-',
            'type' => $bm->menu->menuType?->name ?? '-',
            'sub_type' => $bm->menu->menuSubType?->name ?? '-',
            'ordered' => (int) $bm->total_ordered,
            'pax' => (int) ($bm->total_pax ?? 0),
        ])->sortByDesc('ordered')->values()->toArray();

        return $stats;
    }

    public function getTopMenusProperty(): array
    {
        return array_slice($this->menuStats, 0, 10);
    }

    public function getMaxOrderedProperty(): int
    {
        $counts = array_column($this->menuStats, 'ordered');
        return max($counts ?: [1]);
    }
}
