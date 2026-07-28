<x-filament-panels::page>
    <style>
        .cal-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 1024px) {
            .cal-grid {
                grid-template-columns: 1fr;
            }
        }

        .cal-col-span-2 {
            grid-column: span 2;
        }

        .cal-card {
            background: #fff;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .dark .cal-card {
            background: #1f2937;
            border-color: #374151;
        }

        .cal-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .dark .cal-nav {
            border-color: #374151;
        }

        .cal-nav-btn {
            padding: 0.5rem;
            border-radius: 0.5rem;
            border: none;
            background: transparent;
            cursor: pointer;
            color: #374151;
        }

        .cal-nav-btn:hover {
            background: #f3f4f6;
        }

        .dark .cal-nav-btn {
            color: #d1d5db;
        }

        .dark .cal-nav-btn:hover {
            background: #374151;
        }

        .cal-nav-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
        }

        .dark .cal-nav-title {
            color: #f3f4f6;
        }

        .cal-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border-bottom: 1px solid #e5e7eb;
        }

        .dark .cal-weekdays {
            border-color: #374151;
        }

        .cal-weekday {
            padding: 0.5rem 0.25rem;
            text-align: center;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
        }

        .dark .cal-weekday {
            color: #9ca3af;
        }

        .cal-days-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .cal-day-empty {
            aspect-ratio: 1;
            padding: 0.25rem;
        }

        .cal-day {
            aspect-ratio: 1;
            padding: 0.25rem;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: background 0.15s;
            color: #374151;
            background: transparent;
        }

        .cal-day:hover {
            background: #f3f4f6;
        }

        .dark .cal-day {
            color: #d1d5db;
        }

        .dark .cal-day:hover {
            background: #374151;
        }

        .cal-day-today {
            background: #fef3c7;
            font-weight: 700;
            color: #d97706;
        }

        .dark .cal-day-today {
            background: rgba(217, 119, 6, 0.2);
            color: #fbbf24;
        }

        .cal-day-selected {
            background: #f59e0b;
            color: #fff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .cal-day-selected:hover {
            background: #d97706;
        }

        .cal-dot {
            position: absolute;
            bottom: 0.25rem;
            left: 50%;
            transform: translateX(-50%);
            width: 0.375rem;
            height: 0.375rem;
            border-radius: 50%;
            background: #f59e0b;
        }

        .cal-dot-white {
            background: #fff;
        }

        .cal-sidebar {
            grid-column: span 1;
        }

        .cal-sidebar-card {
            background: #fff;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .dark .cal-sidebar-card {
            background: #1f2937;
            border-color: #374151;
        }

        .cal-sidebar-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .dark .cal-sidebar-header {
            border-color: #374151;
        }

        .cal-sidebar-title {
            font-size: 0.875rem;
            color: #111827;
        }

        .dark .cal-sidebar-title {
            color: #f3f4f6;
        }

        .cal-sidebar-title span {
            font-weight: 600;
            color: #f59e0b;
        }

        .dark .cal-sidebar-title span {
            color: #fbbf24;
        }

        .cal-event-list {
            max-height: 500px;
            overflow-y: auto;
        }

        .cal-event-list>*+* {
            border-top: 1px solid #f3f4f6;
        }

        .dark .cal-event-list>*+* {
            border-color: #374151;
        }

        .cal-event-empty {
            padding: 2rem 1rem;
            text-align: center;
            font-size: 0.875rem;
            color: #9ca3af;
        }

        .dark .cal-event-empty {
            color: #6b7280;
        }

        .cal-event-group-header {
            padding: 0.5rem 1rem;
            background: #f9fafb;
        }

        .dark .cal-event-group-header {
            background: rgba(255, 255, 255, 0.05);
        }

        .cal-event-group-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
        }

        .dark .cal-event-group-label {
            color: #9ca3af;
        }

        .cal-event-group-count {
            margin-left: 0.25rem;
            font-size: 0.75rem;
            color: #9ca3af;
        }

        .cal-event-item {
            padding: 0.75rem 1rem;
        }

        .cal-event-item:hover {
            background: #f9fafb;
        }

        .dark .cal-event-item:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .cal-event-inner {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .cal-event-info {
            min-width: 0;
            flex: 1;
        }

        .cal-event-client {
            font-size: 0.875rem;
            font-weight: 500;
            color: #111827;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dark .cal-event-client {
            color: #f3f4f6;
        }

        .cal-event-number {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.125rem;
        }

        .dark .cal-event-number {
            color: #9ca3af;
        }

        .cal-event-link {
            margin-left: 0.5rem;
            font-size: 0.75rem;
            color: #f59e0b;
            white-space: nowrap;
            text-decoration: none;
        }

        .cal-event-link:hover {
            text-decoration: underline;
        }

        .dark .cal-event-link {
            color: #fbbf24;
        }

        /* ---- Section 3: Timetable ---- */
        .tt-wrapper {
            margin-top: 0.25rem;
            grid-column: 1 / -1;
        }

        .tt-card {
            background: #fff;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .dark .tt-card {
            background: #1f2937;
            border-color: #374151;
        }

        .tt-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.875rem;
            color: #111827;
        }

        .dark .tt-header {
            border-color: #374151;
            color: #f3f4f6;
        }

        .tt-scroll {
            overflow: auto;
            max-height: 600px;
        }

        .tt-table {
            border-collapse: collapse;
            font-size: 0.75rem;
            min-width: 100%;
        }

        .tt-table th {
            padding: 0.5rem 0.375rem;
            text-align: center;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
            background: #f9fafb;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .dark .tt-table th {
            color: #d1d5db;
            border-color: #374151;
            background: #111827;
        }

        .tt-table th.tt-hour-header {
            position: sticky;
            left: 0;
            z-index: 2;
            min-width: 3.5rem;
            background: #f3f4f6;
        }

        .dark .tt-table th.tt-hour-header {
            background: #1f2937;
        }

        .tt-table th.tt-loc-header {
            min-width: 7rem;
            max-width: 10rem;
        }

        .tt-table td {
            padding: 0.25rem;
            border: 1px solid #f3f4f6;
            vertical-align: top;
            height: 2.5rem;
        }

        .dark .tt-table td {
            border-color: #374151;
        }

        .tt-table td.tt-hour-cell {
            text-align: center;
            font-weight: 500;
            color: #6b7280;
            white-space: nowrap;
            background: #f9fafb;
            position: sticky;
            left: 0;
            z-index: 1;
            width: 3.5rem;
            min-width: 3.5rem;
            padding: 0.25rem 0.5rem;
        }

        .dark .tt-table td.tt-hour-cell {
            color: #9ca3af;
            background: #111827;
        }

        .tt-cell {
            display: flex;
            flex-wrap: wrap;
            gap: 0.125rem;
        }

        .tt-event-tag {
            display: block;
            font-size: 0.625rem;
            line-height: 1.1;
            padding: 0.125rem 0.25rem;
            border-radius: 0.25rem;
            color: #fff;
            text-decoration: none;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 8rem;
        }

        .tt-event-tag:hover {
            opacity: 0.85;
        }

        .tt-event-tag.tt-beo {
            background: #3b82f6;
        }

        .tt-event-tag.tt-wedding {
            background: #ec4899;
        }

        .tt-event-sub {
            font-weight: 300;
            opacity: 0.8;
        }

        .tt-table tr:nth-child(even) td {
            background: #fafafa;
        }

        .dark .tt-table tr:nth-child(even) td {
            background: rgba(255, 255, 255, 0.02);
        }

        .tt-table tr:nth-child(even) td.tt-hour-cell {
            background: #f3f4f6;
        }

        .dark .tt-table tr:nth-child(even) td.tt-hour-cell {
            background: #1a1a2e;
        }

        .dark .cal-nav select {
            border-color: #374151 !important;
            background: #1f2937 !important;
            color: #e5e7eb !important;
        }
    </style>

    <div class="cal-grid">
        {{-- Calendar Section (left 2/3) --}}
        <div class="cal-col-span-2">
            <div class="cal-card">
                {{-- Month/Year Navigation --}}
                <div class="cal-nav">
                    <button wire:click="goToPrevMonth" class="cal-nav-btn">
                        <x-filament::icon icon="heroicon-o-chevron-left" class="w-5 h-5" />
                    </button>
                    <div class="cal-nav-title" style="display:flex; gap:0.5rem; align-items:center;">
                        <select wire:change="setMonth($event.target.value)"
                            style="border:1px solid #d1d5db; border-radius:0.375rem; padding:0.25rem 0.5rem; font-size:0.875rem; font-weight:600; background:transparent; color:inherit;">
                            @foreach ($this->months as $val => $label)
                                <option value="{{ $val }}" @if((int) $val === $this->currentMonth) selected @endif>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <select wire:change="setYear($event.target.value)"
                            style="border:1px solid #d1d5db; border-radius:0.375rem; padding:0.25rem 0.5rem; font-size:0.875rem; font-weight:600; background:transparent; color:inherit;">
                            @foreach ($this->yearRange as $val)
                                <option value="{{ $val }}" @if((int) $val === $this->currentYear) selected @endif>{{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button wire:click="goToNextMonth" class="cal-nav-btn">
                        <x-filament::icon icon="heroicon-o-chevron-right" class="w-5 h-5" />
                    </button>
                </div>

                {{-- Day Names --}}
                <div class="cal-weekdays">
                    @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                        <div class="cal-weekday">{{ $dayName }}</div>
                    @endforeach
                </div>

                {{-- Calendar Grid --}}
                <div class="cal-days-grid">
                    @php
                        $today = \Carbon\Carbon::today()->format('Y-m-d');
                    @endphp
                    @foreach ($this->calendarDays as $index => $day)
                        @if ($day === null)
                            <div class="cal-day-empty"></div>
                        @else
                            @php
                                $dateStr = sprintf('%04d-%02d-%02d', $this->currentYear, $this->currentMonth, $day);
                                $isToday = $dateStr === $today;
                                $isSelected = $dateStr === $this->selectedDate;
                                $hasEvents = in_array($dateStr, $this->hasEventsOnDate);
                                $dayClass = $isSelected ? 'cal-day-selected' : ($isToday ? 'cal-day-today' : 'cal-day');
                            @endphp
                            <button wire:key="day-{{ $index }}" wire:click="selectDate('{{ $dateStr }}')"
                                class="{{ $dayClass }}">
                                <span>{{ $day }}</span>
                                @if ($hasEvents)
                                    <span class="cal-dot @if($isSelected) cal-dot-white @endif"></span>
                                @endif
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Events List Section (right 1/3) --}}
        <div class="cal-sidebar">
            <div class="cal-sidebar-card">
                <div class="cal-sidebar-header">
                    <h3 class="cal-sidebar-title">
                        Events on
                        <span>{{ \Carbon\Carbon::parse($this->selectedDate)->format('d F Y') }}</span>
                    </h3>
                </div>

                <div class="cal-event-list">
                    @php
                        $events = $this->events;
                        $eventCount = collect($events)->flatten(1)->count();
                    @endphp

                    @if ($eventCount === 0)
                        <div class="cal-event-empty">No events on this date.</div>
                    @else
                        @foreach (['Beo', 'Wedding'] as $type)
                            @if (isset($events[$type]))
                                <div class="cal-event-group-header">
                                    <span class="cal-event-group-label">{{ $type }}</span>
                                    <span class="cal-event-group-count">({{ count($events[$type]) }})</span>
                                </div>
                                @foreach ($events[$type] as $event)
                                    <div class="cal-event-item">
                                        <div class="cal-event-inner">
                                            <div class="cal-event-info">
                                                <p class="cal-event-client">{{ $event['client'] }}</p>
                                                <p class="cal-event-number">{{ $event['event_number'] }}</p>
                                            </div>
                                            <a href="{{ $type === 'Beo' ? url("/admin/beos/{$event['id']}") : ($type === 'Wedding' ? url("/admin/beo-weddings/{$event['id']}") : url("/admin/beo-amendments/{$event['id']}")) }}"
                                                class="cal-event-link">View</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Section 3: Venue / Hour Timetable --}}
    @php $timetable = $this->timetable; @endphp
    @if (count($timetable['locations']) > 0)
        <div class="tt-wrapper">
            <div class="tt-card">
                <div class="tt-header">
                    Venue Availability <strong
                        style="color:#f59e0b;">{{ \Carbon\Carbon::parse($this->selectedDate)->format('d F Y') }}</strong>
                </div>
                <div class="tt-scroll">
                    <table class="tt-table">
                        <thead>
                            <tr>
                                <th class="tt-hour-header"></th>
                                @foreach ($timetable['locations'] as $loc)
                                    <th class="tt-loc-header">{{ $loc['name'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timetable['hours'] as $hour)
                                @php $row = $timetable['grid'][$hour]; @endphp
                                <tr>
                                    <td class="tt-hour-cell">{{ $row['hour'] }}</td>
                                    @foreach ($timetable['locations'] as $loc)
                                        @php $events = $row[$loc['key']] ?? []; @endphp
                                        <td>
                                            @if (count($events) > 0)
                                                <div class="tt-cell">
                                                    @foreach ($events as $ev)
                                                        <a href="{{ $ev['url'] }}" class="tt-event-tag tt-{{ $ev['type'] }}"
                                                            title="{{ $ev['label'] }} - {{ $ev['sub'] }}">
                                                            {{ $ev['label'] }}
                                                            @if ($ev['sub'] !== '-')
                                                                <span class="tt-event-sub">({{ $ev['sub'] }})</span>
                                                            @endif
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</x-filament-panels::page>