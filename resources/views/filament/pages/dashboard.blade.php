<x-filament-panels::page>
    <style>
        .d2-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            align-items: start;
        }
        @media (max-width: 1024px) {
            .d2-grid { grid-template-columns: 1fr; }
        }

        .d2-left-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }
        @media (max-width: 768px) {
            .d2-left-row { grid-template-columns: 1fr; }
        }

        .d2-col {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .d2-card {
            background: #fff;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        .dark .d2-card {
            background: #1f2937;
            border-color: #374151;
        }

        .d2-stat {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .d2-stat-top {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .d2-stat-icon {
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .d2-stat-icon-blue {
            background: #dbeafe;
            color: #2563eb;
        }
        .dark .d2-stat-icon-blue {
            background: rgba(37,99,235,0.2);
            color: #93c5fd;
        }
        .d2-stat-icon-pink {
            background: #fce7f3;
            color: #db2777;
        }
        .dark .d2-stat-icon-pink {
            background: rgba(219,39,119,0.2);
            color: #f9a8d4;
        }
        .d2-stat-icon-amber {
            background: #fef3c7;
            color: #d97706;
        }
        .dark .d2-stat-icon-amber {
            background: rgba(217,119,6,0.2);
            color: #fcd34d;
        }
        .d2-stat-num {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            line-height: 1;
        }
        .dark .d2-stat-num {
            color: #f3f4f6;
        }
        .d2-stat-label {
            font-size: 0.8125rem;
            color: #6b7280;
            margin-top: 0.125rem;
        }
        .dark .d2-stat-label {
            color: #9ca3af;
        }

        .d2-right-card {
            background: #fff;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .dark .d2-right-card {
            background: #1f2937;
            border-color: #374151;
        }
        .d2-right-card:last-child {
            margin-bottom: 0;
        }

        .d2-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.9375rem;
            font-weight: 600;
            color: #111827;
        }
        .dark .d2-header {
            border-color: #374151;
            color: #f3f4f6;
        }
        .d2-body {
            padding: 0.75rem 1rem;
        }

        .d2-event {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.8125rem;
        }
        .dark .d2-event {
            border-color: #374151;
        }
        .d2-event:last-child {
            border-bottom: none;
        }
        .d2-event-name {
            font-weight: 500;
            color: #111827;
        }
        .dark .d2-event-name {
            color: #f3f4f6;
        }
        .d2-event-sub {
            font-size: 0.75rem;
            color: #9ca3af;
        }
        .d2-event-link {
            font-size: 0.75rem;
            color: #f59e0b;
            text-decoration: none;
        }
        .d2-event-link:hover {
            text-decoration: underline;
        }
        .d2-empty {
            font-size: 0.8125rem;
            color: #9ca3af;
            padding: 0.5rem 0;
        }

        /* Mini Calendar Styles */
        .d2-calendar {
            width: 100%;
        }
        .d2-cal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .dark .d2-cal-header {
            border-color: #374151;
        }
        .d2-cal-title {
            font-size: 0.9375rem;
            font-weight: 600;
            color: #111827;
        }
        .dark .d2-cal-title {
            color: #f3f4f6;
        }
        .d2-cal-nav {
            display: flex;
            gap: 0.25rem;
        }
        .d2-cal-nav-btn {
            background: none;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
            cursor: pointer;
            color: #6b7280;
            font-size: 0.8125rem;
            line-height: 1;
            transition: all 0.15s;
        }
        .d2-cal-nav-btn:hover {
            background: #f3f4f6;
            color: #111827;
        }
        .dark .d2-cal-nav-btn {
            border-color: #374151;
            color: #9ca3af;
        }
        .dark .d2-cal-nav-btn:hover {
            background: #374151;
            color: #f3f4f6;
        }
        .d2-cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
        }
        .d2-cal-day-header {
            padding: 0.5rem 0;
            font-size: 0.6875rem;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
        }
        .d2-cal-day {
            padding: 0.375rem 0;
            font-size: 0.8125rem;
            color: #374151;
            cursor: pointer;
            border-radius: 0.375rem;
            transition: all 0.15s;
            position: relative;
        }
        .d2-cal-day:hover {
            background: #f3f4f6;
        }
        .dark .d2-cal-day {
            color: #d1d5db;
        }
        .dark .d2-cal-day:hover {
            background: #374151;
        }
        .d2-cal-day-other {
            color: #d1d5db;
        }
        .dark .d2-cal-day-other {
            color: #4b5563;
        }
        .d2-cal-day-today {
            font-weight: 700;
            color: #2563eb;
        }
        .dark .d2-cal-day-today {
            color: #60a5fa;
        }
        .d2-cal-day-selected {
            background: #2563eb !important;
            color: #fff !important;
            font-weight: 600;
        }
        .dark .d2-cal-day-selected {
            background: #3b82f6 !important;
            color: #fff !important;
        }
        .d2-cal-day.has-events::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: #f59e0b;
        }
        .d2-cal-day-selected.has-events::after {
            background: #fff;
        }
    </style>

    <div class="d2-grid">
        {{-- Left Column --}}
        <div class="d2-col">
            {{-- Row 1: Stat Cards --}}
            <div class="d2-left-row">
                {{-- Total Menu --}}
                <div class="d2-card">
                    <div class="d2-stat">
                        <div class="d2-stat-top">
                            <div class="d2-stat-icon d2-stat-icon-amber">
                                <x-filament::icon icon="heroicon-o-cake" class="w-6 h-6" />
                            </div>
                            <div class="d2-stat-label">Total Menu</div>
                        </div>
                        <div class="d2-stat-num">{{ number_format($this->totalMenu) }}</div>
                    </div>
                </div>

                {{-- Total Beo --}}
                <div class="d2-card">
                    <div class="d2-stat">
                        <div class="d2-stat-top">
                            <div class="d2-stat-icon d2-stat-icon-blue">
                                <x-filament::icon icon="heroicon-o-document-text" class="w-6 h-6" />
                            </div>
                            <div class="d2-stat-label">Total Beo</div>
                        </div>
                        <div class="d2-stat-num">{{ number_format($this->totalBeo) }}</div>
                    </div>
                </div>

                {{-- Total Wedding --}}
                <div class="d2-card">
                    <div class="d2-stat">
                        <div class="d2-stat-top">
                            <div class="d2-stat-icon d2-stat-icon-pink">
                                <x-filament::icon icon="heroicon-o-heart" class="w-6 h-6" />
                            </div>
                            <div class="d2-stat-label">Total Wedding</div>
                        </div>
                        <div class="d2-stat-num">{{ number_format($this->totalWedding) }}</div>
                    </div>
                </div>
            </div>

            {{-- Row 2: Yearly Chart Widget --}}
            @livewire(\App\Filament\Widgets\YearlyChart::class)

            {{-- Row 3: Recent Events --}}
            <div class="d2-card">
                <div class="d2-header">Recently Added</div>
                <div class="d2-body">
                    @php $recent = $this->recentEvents; @endphp
                    @if ($recent->isEmpty())
                        <div class="d2-empty">No recent events.</div>
                    @else
                        @foreach ($recent as $ev)
                            @php $isWedding = $ev instanceof \App\Models\BeoWedding; @endphp
                            <div class="d2-event">
                                <div>
                                    <div class="d2-event-name">{{ $isWedding ? ($ev->client?->pic ?? '-') : ($ev->client?->company ?? '-') }}</div>
                                    <div class="d2-event-sub">{{ $isWedding ? 'Wedding' : 'Beo' }} &middot; {{ $ev->event_number }} &middot; {{ $ev->created_at->diffForHumans() }}</div>
                                </div>
                                <a href="{{ $isWedding ? url("/admin/beo-weddings/{$ev->id}") : url("/admin/beos/{$ev->id}") }}" class="d2-event-link">View</a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="d2-col">
            {{-- Mini Calendar --}}
            <div class="d2-right-card">
                <div class="d2-calendar">
                    <div class="d2-cal-header">
                        <span class="d2-cal-title">{{ $this->calendarMonthName }}</span>
                        <div class="d2-cal-nav">
                            <button type="button" class="d2-cal-nav-btn" wire:click="goToPrevMonth">&larr;</button>
                            <button type="button" class="d2-cal-nav-btn" wire:click="goToNextMonth">&rarr;</button>
                        </div>
                    </div>
                    <div class="d2-body" style="padding: 0.5rem 1rem 0.75rem;">
                        <div class="d2-cal-grid">
                            <div class="d2-cal-day-header">Sun</div>
                            <div class="d2-cal-day-header">Mon</div>
                            <div class="d2-cal-day-header">Tue</div>
                            <div class="d2-cal-day-header">Wed</div>
                            <div class="d2-cal-day-header">Thu</div>
                            <div class="d2-cal-day-header">Fri</div>
                            <div class="d2-cal-day-header">Sat</div>

                            @php
                                $selected = $this->selectedDate;
                                // Collect all events for the month to show dots
                                $monthStart = \Carbon\Carbon::create($this->calendarYear, $this->calendarMonth, 1);
                                $monthEnd = $monthStart->copy()->endOfMonth();
                                $beoIdsWithAmendments = \App\Models\BeoAmendment::pluck('beo_id')->unique()->toArray();
                                // Beos WITHOUT amendments - use date_of_function
                                $monthBeos = \App\Models\Beo::whereBetween('date_of_function', [$monthStart, $monthEnd])
                                    ->whereNotIn('id', $beoIdsWithAmendments)
                                    ->get()->pluck('date_of_function')->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))->toArray();
                                // Beos WITH amendments - use amendment's date_change
                                $monthAmendedBeos = \App\Models\BeoAmendment::whereBetween('date_change', [$monthStart, $monthEnd])
                                    ->whereIn('beo_id', $beoIdsWithAmendments)
                                    ->get()->pluck('date_change')->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))->toArray();
                                $monthWeddings = \App\Models\BeoWedding::whereBetween('date_of_function', [$monthStart, $monthEnd])->get()->pluck('date_of_function')->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))->toArray();
                                $allDates = array_unique(array_merge($monthBeos, $monthAmendedBeos, $monthWeddings));
                            @endphp

                            @foreach ($this->calendarDays as $day)
                                @php
                                    $classes = 'd2-cal-day';
                                    if (!$day['isCurrentMonth']) $classes .= ' d2-cal-day-other';
                                    if ($day['isToday']) $classes .= ' d2-cal-day-today';
                                    if ($day['date'] === $selected) $classes .= ' d2-cal-day-selected';
                                    if (in_array($day['date'], $allDates)) $classes .= ' has-events';
                                @endphp
                                <div class="{{ $classes }}" wire:click="selectDate('{{ $day['date'] }}')" title="{{ $day['date'] }}">
                                    {{ $day['day'] }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Events for Selected Date --}}
            <div class="d2-right-card">
                <div class="d2-header">
                    Events &middot; {{ \Carbon\Carbon::parse($this->selectedDate)->format('d F Y') }}
                </div>
                <div class="d2-body">
                    @php $events = $this->selectedDateEvents; @endphp
                    @if (empty($events))
                        <div class="d2-empty">No events on this date.</div>
                    @else
                        @foreach ($events as $ev)
                            <div class="d2-event">
                                <div>
                                    <div class="d2-event-name">{{ $ev['name'] }}</div>
                                    <div class="d2-event-sub">{{ $ev['type'] }} &middot; {{ $ev['number'] }}</div>
                                </div>
                                <a href="{{ $ev['url'] }}" class="d2-event-link">View</a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Upcoming Events --}}
            <div class="d2-right-card">
                <div class="d2-header">Upcoming Events</div>
                <div class="d2-body">
                    @php
                        $upBeos = $this->upcomingBeos;
                        $upWeddings = $this->upcomingWeddings;
                    @endphp
                    @if ($upBeos->isEmpty() && $upWeddings->isEmpty())
                        <div class="d2-empty">No upcoming events.</div>
                    @else
                        @foreach ($upBeos as $b)
                            <div class="d2-event">
                                <div>
                                    <div class="d2-event-name">{{ $b->client?->company ?? '-' }}</div>
                                    <div class="d2-event-sub">{{ $b->display_date->format('d M') }} &middot; {{ $b->event_number }}</div>
                                </div>
                                <a href="{{ url("/admin/beos/{$b->id}") }}" class="d2-event-link">View</a>
                            </div>
                        @endforeach
                        @foreach ($upWeddings as $w)
                            <div class="d2-event">
                                <div>
                                    <div class="d2-event-name">{{ $w->client?->pic ?? '-' }}</div>
                                    <div class="d2-event-sub">{{ \Carbon\Carbon::parse($w->date_of_function)->format('d M') }} &middot; {{ $w->event_number }}</div>
                                </div>
                                <a href="{{ url("/admin/beo-weddings/{$w->id}") }}" class="d2-event-link">View</a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
