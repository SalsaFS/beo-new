<?php

namespace App\Filament\Pages;

use App\Models\Beo;
use App\Models\BeoAmendment;
use App\Models\BeoFunction;
use App\Models\BeoWedding;
use App\Models\BeoWeddingFunction;
use App\Models\MeetingRoom;
use App\Models\Venue;
use Carbon\Carbon;
use Filament\Pages\Page;
use UnitEnum;

class CalendarAvailability extends Page
{
    protected string $view = 'filament.pages.calendar-availability';
    protected static string|UnitEnum|null $navigationGroup = 'Core';
    protected static ?int $navigationSort = 1;

    public int $currentMonth;
    public int $currentYear;
    public string $selectedDate;

    public function mount(): void
    {
        $today = Carbon::today();
        $this->currentMonth = $today->month;
        $this->currentYear = $today->year;
        $this->selectedDate = $today->format('Y-m-d');
    }

    public function goToPrevMonth(): void
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function goToNextMonth(): void
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function selectDate(string $date): void
    {
        $this->selectedDate = $date;
    }

    public function setMonth(int $month): void
    {
        $this->currentMonth = $month;
    }

    public function setYear(int $year): void
    {
        $this->currentYear = $year;
    }

    public function getMonthsProperty(): array
    {
        return [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
        ];
    }

    public function getYearRangeProperty(): array
    {
        $currentYear = (int) now()->year;
        return range($currentYear - 5, $currentYear + 5);
    }

    public function getAmendmentOverrideProperty(): \Illuminate\Support\Collection
    {
        $latestPerBeo = BeoAmendment::query()
            ->whereNotNull('date_change')
            ->select('beo_id', 'date_change')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('beo_id');

        return $latestPerBeo->pluck('date_change', 'beo_id');
    }

    public function getCalendarDaysProperty(): array
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $daysInMonth = $date->daysInMonth;
        $startOfWeek = $date->dayOfWeek;

        $days = [];
        for ($i = 0; $i < $startOfWeek; $i++) {
            $days[] = null;
        }
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $days[] = $day;
        }
        while (count($days) % 7 !== 0) {
            $days[] = null;
        }

        return $days;
    }

    public function getMonthNameProperty(): string
    {
        return Carbon::create($this->currentYear, $this->currentMonth, 1)->translatedFormat('F');
    }

    public function getEventsProperty(): array
    {
        $date = $this->selectedDate;
        $amendmentOverride = $this->amendmentOverride;

        $beoIdsFromDate = Beo::query()
            ->where('date_of_function', $date)
            ->whereNotIn('id', $amendmentOverride->keys())
            ->pluck('id');

        $beoIdsFromAmendment = $amendmentOverride->filter(fn($d) => $d == $date)->keys();
        $activeBeoIds = $beoIdsFromDate->merge($beoIdsFromAmendment)->unique()->toArray();

        $beos = Beo::query()
            ->whereIn('id', $activeBeoIds)
            ->with('client')
            ->get()
            ->map(fn($b) => [
                'type' => 'Beo',
                'id' => $b->id,
                'event_number' => $b->event_number,
                'client' => $b->client?->company ?? $b->client?->pic ?? '-',
            ]);

        $weddings = BeoWedding::query()
            ->where('date_of_function', $date)
            ->with('client')
            ->get()
            ->map(fn($b) => [
                'type' => 'Wedding',
                'id' => $b->id,
                'event_number' => $b->event_number,
                'client' => $b->client?->pic ?? '-',
            ]);

        $events = collect()
            ->merge($beos)
            ->merge($weddings)
            ->groupBy('type');

        return $events->toArray();
    }

    public function getHasEventsOnDateProperty(): array
    {
        $amendmentOverride = $this->amendmentOverride;

        $originalBeoDates = Beo::query()
            ->whereYear('date_of_function', $this->currentYear)
            ->whereMonth('date_of_function', $this->currentMonth)
            ->whereNotIn('id', $amendmentOverride->keys())
            ->pluck('date_of_function');

        $amendmentDates = $amendmentOverride
            ->filter(fn($d) => $d && (int) substr($d, 0, 4) === $this->currentYear && (int) substr($d, 5, 2) === $this->currentMonth)
            ->values();

        $weddingDates = BeoWedding::query()
            ->whereYear('date_of_function', $this->currentYear)
            ->whereMonth('date_of_function', $this->currentMonth)
            ->pluck('date_of_function');

        return $originalBeoDates
            ->merge($amendmentDates)
            ->merge($weddingDates)
            ->unique()
            ->values()
            ->toArray();
    }

    public function getTimetableProperty(): array
    {
        $date = $this->selectedDate;

        $locations = collect();
        foreach (Venue::orderBy('name')->get() as $v) {
            $locations->push(['key' => 'v_' . $v->id, 'name' => $v->name]);
        }
        foreach (MeetingRoom::orderBy('name')->get() as $m) {
            $locations->push(['key' => 'm_' . $m->id, 'name' => $m->name]);
        }
        $locations = $locations->values()->all();

        $amendmentOverride = $this->amendmentOverride;

        $beoIdsFromDate = Beo::query()
            ->where('date_of_function', $date)
            ->whereNotIn('id', $amendmentOverride->keys())
            ->pluck('id');

        $beoIdsFromAmendment = $amendmentOverride->filter(fn($d) => $d == $date)->keys();

        $activeBeoIds = $beoIdsFromDate->merge($beoIdsFromAmendment)->unique()->toArray();
        $activeWeddingIds = BeoWedding::query()
            ->where('date_of_function', $date)
            ->pluck('id')
            ->toArray();

        $beoFunctions = BeoFunction::query()
            ->whereIn('beo_id', $activeBeoIds)
            ->with('beo.client', 'function')
            ->get();

        $weddingFunctions = BeoWeddingFunction::query()
            ->whereIn('beo_wedding_id', $activeWeddingIds)
            ->with('beoWedding.client', 'function')
            ->get();

        $hours = range(0, 23);
        $grid = [];
        foreach ($hours as $hour) {
            $row = ['hour' => sprintf('%02d:00', $hour)];
            foreach ($locations as $loc) {
                $row[$loc['key']] = [];
            }
            $grid[$hour] = $row;
        }

        foreach ($beoFunctions as $bf) {
            if (!$bf->venue_id) continue;
            $key = 'v_' . $bf->venue_id;
            if (!isset($grid[0][$key])) continue;
            $startH = (int) substr($bf->time_start, 0, 2);
            $endH = (int) substr($bf->time_end, 0, 2);
            for ($h = $startH; $h <= $endH && $h <= 23; $h++) {
                $grid[$h][$key][] = [
                    'type' => 'beo',
                    'label' => $bf->beo?->client?->company ?? $bf->beo?->client?->pic ?? '-',
                    'sub' => $bf->function?->name ?? '-',
                    'url' => url("/admin/beos/{$bf->beo_id}"),
                ];
            }
        }

        foreach ($weddingFunctions as $wf) {
            if (!$wf->venue_id) continue;
            $key = 'v_' . $wf->venue_id;
            if (!isset($grid[0][$key])) continue;
            $startH = (int) substr($wf->time_start, 0, 2);
            $endH = (int) substr($wf->time_end, 0, 2);
            for ($h = $startH; $h <= $endH && $h <= 23; $h++) {
                $grid[$h][$key][] = [
                    'type' => 'wedding',
                    'label' => $wf->beoWedding?->client?->pic ?? '-',
                    'sub' => $wf->function?->name ?? '-',
                    'url' => url("/admin/beo-weddings/{$wf->beo_wedding_id}"),
                ];
            }
        }

        return [
            'locations' => $locations,
            'hours' => $hours,
            'grid' => $grid,
        ];
    }
}
