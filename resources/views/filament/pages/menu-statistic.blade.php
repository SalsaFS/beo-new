<x-filament-panels::page>
    <style>
        .ms-filters {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            align-items: center;
        }
        .ms-filters label {
            font-size: 0.8125rem;
            font-weight: 500;
            color: #6b7280;
        }
        .dark .ms-filters label {
            color: #9ca3af;
        }
        .ms-filters select {
            padding: 0.375rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            background: #fff;
            color: #374151;
            outline: none;
        }
        .dark .ms-filters select {
            background: #1f2937;
            border-color: #4b5563;
            color: #d1d5db;
        }
        .ms-filters select:focus {
            border-color: #f59e0b;
        }

        .ms-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        @media (max-width: 1024px) {
            .ms-grid {
                grid-template-columns: 1fr;
            }
        }

        .ms-card {
            background: #fff;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        .dark .ms-card {
            background: #1f2937;
            border-color: #374151;
        }
        .ms-card-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.9375rem;
            font-weight: 600;
            color: #111827;
        }
        .dark .ms-card-header {
            border-color: #374151;
            color: #f3f4f6;
        }
        .ms-card-body {
            padding: 1rem;
        }

        .ms-rank {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.625rem;
        }
        .ms-rank:last-child {
            margin-bottom: 0;
        }
        .ms-rank-num {
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6875rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            background: #6b7280;
        }
        .ms-rank-1 { background: #f59e0b; }
        .ms-rank-2 { background: #9ca3af; }
        .ms-rank-3 { background: #d97706; }

        .ms-rank-info {
            min-width: 0;
            flex: 1;
        }
        .ms-rank-name {
            font-size: 0.8125rem;
            font-weight: 500;
            color: #111827;
        }
        .dark .ms-rank-name {
            color: #f3f4f6;
        }
        .ms-rank-sub {
            font-size: 0.6875rem;
            color: #9ca3af;
        }
        .ms-bar-wrap {
            flex: 1;
            background: #f3f4f6;
            border-radius: 999px;
            height: 1.25rem;
            overflow: hidden;
            min-width: 6rem;
        }
        .dark .ms-bar-wrap {
            background: #374151;
        }
        .ms-bar {
            height: 100%;
            border-radius: 999px;
            background: #f59e0b;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 0.5rem;
            font-size: 0.6875rem;
            font-weight: 600;
            color: #fff;
            min-width: 2rem;
        }

        .ms-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8125rem;
        }
        .ms-table th {
            padding: 0.5rem 0.75rem;
            text-align: left;
            font-weight: 600;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .dark .ms-table th {
            color: #9ca3af;
            border-color: #374151;
        }
        .ms-table td {
            padding: 0.5rem 0.75rem;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
        }
        .dark .ms-table td {
            border-color: #374151;
            color: #d1d5db;
        }
        .ms-table tr:hover td {
            background: #f9fafb;
        }
        .dark .ms-table tr:hover td {
            background: rgba(255,255,255,0.03);
        }
        .ms-badge {
            display: inline-block;
            padding: 0.125rem 0.5rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .ms-badge-order {
            background: #fef3c7;
            color: #b45309;
        }
        .dark .ms-badge-order {
            background: rgba(245,158,11,0.2);
            color: #fbbf24;
        }
        .ms-badge-pax {
            background: #dbeafe;
            color: #1d4ed8;
        }
        .dark .ms-badge-pax {
            background: rgba(59,130,246,0.2);
            color: #93c5fd;
        }
    </style>

    <div class="ms-filters">
        <label for="filterMonth">Month:</label>
        <select id="filterMonth" wire:model.live="filterMonth">
            @foreach ($this->months as $val => $label)
                <option value="{{ $val }}">{{ $label }}</option>
            @endforeach
        </select>
        <label for="filterYear">Year:</label>
        <select id="filterYear" wire:model.live="filterYear">
            @foreach ($this->years as $val => $label)
                <option value="{{ $val }}">{{ $label }}</option>
            @endforeach
        </select>
        <label for="filterMenuType">Menu Type:</label>
        <select id="filterMenuType" wire:model.live="filterMenuType">
            <option value="">All Types</option>
            @foreach ($this->menuTypes as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
        <label for="filterMenuSubType">Sub Type:</label>
        <select id="filterMenuSubType" wire:model.live="filterMenuSubType">
            <option value="">All Sub Types</option>
            @foreach ($this->menuSubTypes as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <div class="ms-grid">
        {{-- Top 10 Rank --}}
        <div class="ms-card">
            <div class="ms-card-header">Top 10 Most Ordered</div>
            <div class="ms-card-body">
                @php $top = $this->topMenus; @endphp
                @forelse ($top as $i => $m)
                    @php $pct = $this->maxOrdered > 0 ? round(($m['ordered'] / $this->maxOrdered) * 100) : 0; @endphp
                    <div class="ms-rank">
                        <div class="ms-rank-num ms-rank-{{ min($i + 1, 3) }}">{{ $i + 1 }}</div>
                        <div class="ms-rank-info">
                            <div class="ms-rank-name">{{ $m['name'] }}</div>
                            <div class="ms-rank-sub">{{ $m['type'] }} . {{ $m['sub_type'] }}</div>
                        </div>
                        <div class="ms-bar-wrap">
                            <div class="ms-bar" style="width:{{ max($pct, 6) }}%;">{{ $m['ordered'] }}</div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center;color:#9ca3af;padding:1rem;">No data.</div>
                @endforelse
            </div>
        </div>

        {{-- All Menu Stats Table --}}
        <div class="ms-card">
            <div class="ms-card-header">All Menu Orders</div>
            <div class="ms-card-body" style="padding:0;">
                @php $stats = $this->menuStats; @endphp
                @if (count($stats) > 0)
                    <table class="ms-table">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th>Type</th>
                                <th style="text-align:center;">Ordered</th>
                                <th style="text-align:center;">Total Pax</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stats as $m)
                                <tr>
                                    <td>{{ $m['name'] }}</td>
                                    <td style="font-size:0.75rem;color:#9ca3af;">{{ $m['type'] }} . {{ $m['sub_type'] }}</td>
                                    <td style="text-align:center;"><span class="ms-badge ms-badge-order">{{ $m['ordered'] }}x</span></td>
                                    <td style="text-align:center;"><span class="ms-badge ms-badge-pax">{{ number_format($m['pax']) }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="text-align:center;color:#9ca3af;padding:1.5rem;">No menu orders found.</div>
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>
