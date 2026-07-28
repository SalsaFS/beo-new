<?php

namespace App\Filament\Pages;

use App\Models\Beo;
use App\Models\BeoAmendment;
use App\Models\BeoWedding;
use App\Models\Menu;
use Carbon\Carbon;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home';

    protected string $view = 'filament.pages.dashboard';

    public ?string $selectedDate = null;
    public int $calendarMonth;
    public int $calendarYear;

    public function mount(): void
    {
        $this->selectedDate = Carbon::today()->format('Y-m-d');
        $this->calendarMonth = (int) Carbon::today()->format('m');
        $this->calendarYear = (int) Carbon::today()->format('Y');
    }

    public function goToPrevMonth(): void
    {
        $date = Carbon::create($this->calendarYear, $this->calendarMonth, 1)->subMonth();
        $this->calendarMonth = (int) $date->format('m');
        $this->calendarYear = (int) $date->format('Y');
    }

    public function goToNextMonth(): void
    {
        $date = Carbon::create($this->calendarYear, $this->calendarMonth, 1)->addMonth();
        $this->calendarMonth = (int) $date->format('m');
        $this->calendarYear = (int) $date->format('Y');
    }

    public function selectDate(string $date): void
    {
        $this->selectedDate = $date;
    }

    public function getCalendarDaysProperty(): array
    {
        $firstDay = Carbon::create($this->calendarYear, $this->calendarMonth, 1);
        $daysInMonth = $firstDay->daysInMonth;
        $startDayOfWeek = $firstDay->dayOfWeek; // 0=Sun, 1=Mon, ...

        $days = [];

        // Previous month's trailing days
        $prevMonth = $firstDay->copy()->subMonth();
        $prevDaysInMonth = $prevMonth->daysInMonth;
        for ($i = $startDayOfWeek - 1; $i >= 0; $i--) {
            $day = $prevDaysInMonth - $i;
            $days[] = [
                'day' => $day,
                'date' => $prevMonth->format('Y-m') . '-' . str_pad($day, 2, '0', STR_PAD_LEFT),
                'isCurrentMonth' => false,
                'isToday' => false,
            ];
        }

        // Current month days
        $today = Carbon::today();
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $dateStr = $firstDay->format('Y-m') . '-' . str_pad($d, 2, '0', STR_PAD_LEFT);
            $days[] = [
                'day' => $d,
                'date' => $dateStr,
                'isCurrentMonth' => true,
                'isToday' => $today->format('Y-m-d') === $dateStr,
            ];
        }

        // Next month's leading days
        $remaining = 7 - (count($days) % 7);
        if ($remaining < 7) {
            $nextMonth = $firstDay->copy()->addMonth();
            for ($d = 1; $d <= $remaining; $d++) {
                $days[] = [
                    'day' => $d,
                    'date' => $nextMonth->format('Y-m') . '-' . str_pad($d, 2, '0', STR_PAD_LEFT),
                    'isCurrentMonth' => false,
                    'isToday' => false,
                ];
            }
        }

        return $days;
    }

    public function getCalendarMonthNameProperty(): string
    {
        return Carbon::create($this->calendarYear, $this->calendarMonth, 1)->format('F Y');
    }

    /**
     * Get Beo IDs that have amendments (to exclude them from date_of_function queries).
     */
    private function getBeoIdsWithAmendments(): array
    {
        return BeoAmendment::pluck('beo_id')->unique()->toArray();
    }

    public function getSelectedDateEventsProperty(): array
    {
        if (!$this->selectedDate) {
            return [];
        }

        $date = Carbon::parse($this->selectedDate);

        // Get Beo IDs that have amendments - these should NOT show under their original date_of_function
        $beoIdsWithAmendments = $this->getBeoIdsWithAmendments();

        // Beos WITHOUT amendments that have date_of_function matching the selected date
        $beos = Beo::where('date_of_function', $date)
            ->whereNotIn('id', $beoIdsWithAmendments)
            ->with('client')
            ->get()
            ->map(function ($b) {
                return [
                    'type' => 'Beo',
                    'name' => $b->client?->company ?? '-',
                    'number' => $b->event_number,
                    'url' => url("/admin/beos/{$b->id}"),
                ];
            });

        // Beos WITH amendments - show them under the amendment's date_change instead
        $amendedBeos = BeoAmendment::where('date_change', $date)
            ->with('beo.client')
            ->get()
            ->map(function ($a) {
                return [
                    'type' => 'Beo',
                    'name' => $a->beo?->client?->company ?? '-',
                    'number' => $a->beo?->event_number ?? '-',
                    'url' => url("/admin/beos/{$a->beo_id}"),
                ];
            });

        $weddings = BeoWedding::where('date_of_function', $date)->with('client')->get()->map(function ($w) {
            return [
                'type' => 'Wedding',
                'name' => $w->client?->pic ?? '-',
                'number' => $w->event_number,
                'url' => url("/admin/beo-weddings/{$w->id}"),
            ];
        });

        return $beos->concat($amendedBeos)->concat($weddings)->toArray();
    }

    public function getTodayBeosProperty()
    {
        $beoIdsWithAmendments = $this->getBeoIdsWithAmendments();

        return Beo::where('date_of_function', Carbon::today())
            ->whereNotIn('id', $beoIdsWithAmendments)
            ->with('client')
            ->get();
    }

    public function getTodayWeddingsProperty()
    {
        return BeoWedding::where('date_of_function', Carbon::today())->with('client')->get();
    }

    public function getTodayAmendmentsProperty()
    {
        return BeoAmendment::where('date_change', Carbon::today())->with('beo.client')->get();
    }

    public function getThisMonthBeoCountProperty(): int
    {
        $beoIdsWithAmendments = $this->getBeoIdsWithAmendments();

        // Count Beos WITHOUT amendments that have date_of_function this month
        $countFromBeos = Beo::whereYear('date_of_function', now()->year)
            ->whereMonth('date_of_function', now()->month)
            ->whereNotIn('id', $beoIdsWithAmendments)
            ->count();

        // Count Beos WITH amendments that have date_change this month
        $countFromAmendments = BeoAmendment::whereYear('date_change', now()->year)
            ->whereMonth('date_change', now()->month)
            ->whereIn('beo_id', $beoIdsWithAmendments)
            ->distinct('beo_id')
            ->count('beo_id');

        return $countFromBeos + $countFromAmendments;
    }

    public function getThisMonthWeddingCountProperty(): int
    {
        return BeoWedding::whereYear('date_of_function', now()->year)
            ->whereMonth('date_of_function', now()->month)
            ->count();
    }

    public function getTotalBeoProperty(): int
    {
        return Beo::count();
    }

    public function getTotalWeddingProperty(): int
    {
        return BeoWedding::count();
    }

    public function getTotalMenuProperty(): int
    {
        return Menu::count();
    }

    public function getRecentEventsProperty()
    {
        $beos = Beo::with('client')->orderBy('created_at', 'desc')->take(10)->get();
        $weddings = BeoWedding::with('client')->orderBy('created_at', 'desc')->take(10)->get();
        return $beos->concat($weddings)->sortByDesc('created_at')->take(10);
    }

    public function getUpcomingBeosProperty()
    {
        $beoIdsWithAmendments = $this->getBeoIdsWithAmendments();

        // Beos WITHOUT amendments - use date_of_function
        $beosWithoutAmendments = Beo::where('date_of_function', '>=', Carbon::today())
            ->whereNotIn('id', $beoIdsWithAmendments)
            ->orderBy('date_of_function')
            ->with('client')
            ->take(5)
            ->get()
            ->map(function ($b) {
                $b->display_date = Carbon::parse($b->date_of_function);
                return $b;
            });

        // Beos WITH amendments - use the amendment's date_change
        $beosWithAmendments = BeoAmendment::where('date_change', '>=', Carbon::today())
            ->whereIn('beo_id', $beoIdsWithAmendments)
            ->orderBy('date_change')
            ->with('beo.client')
            ->take(5)
            ->get()
            ->map(function ($a) {
                $a->beo->display_date = Carbon::parse($a->date_change);
                return $a->beo;
            });

        return $beosWithoutAmendments
            ->concat($beosWithAmendments)
            ->sortBy('display_date')
            ->take(5)
            ->values();
    }

    public function getUpcomingWeddingsProperty()
    {
        return BeoWedding::where('date_of_function', '>=', Carbon::today())
            ->orderBy('date_of_function')
            ->with('client')
            ->take(5)
            ->get();
    }
}