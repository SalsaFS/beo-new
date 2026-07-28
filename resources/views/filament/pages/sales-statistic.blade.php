<x-filament-panels::page>
    <style>
        .ss-sort {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            align-items: center;
        }
        .ss-sort label {
            font-size: 0.8125rem;
            font-weight: 500;
            color: #6b7280;
        }
        .dark .ss-sort label {
            color: #9ca3af;
        }
        .ss-sort select {
            padding: 0.375rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            background: #fff;
            color: #374151;
            outline: none;
        }
        .dark .ss-sort select {
            background: #1f2937;
            border-color: #4b5563;
            color: #d1d5db;
        }
        .ss-sort select:focus {
            border-color: #f59e0b;
        }

        .ss-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        @media (max-width: 1024px) {
            .ss-grid {
                grid-template-columns: 1fr;
            }
        }

        .ss-card {
            background: #fff;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        .dark .ss-card {
            background: #1f2937;
            border-color: #374151;
        }
        .ss-card-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.9375rem;
            font-weight: 600;
            color: #111827;
        }
        .dark .ss-card-header {
            border-color: #374151;
            color: #f3f4f6;
        }
        .ss-card-body {
            padding: 1rem;
        }

        .ss-rank {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }
        .ss-rank:last-child {
            margin-bottom: 0;
        }
        .ss-rank-num {
            width: 1.75rem;
            height: 1.75rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }
        .ss-rank-1 { background: #f59e0b; }
        .ss-rank-2 { background: #9ca3af; }
        .ss-rank-3 { background: #d97706; }
        .ss-rank-4, .ss-rank-5 { background: #6b7280; }

        .ss-rank-name {
            font-size: 0.8125rem;
            font-weight: 500;
            color: #111827;
            min-width: 7rem;
        }
        .dark .ss-rank-name {
            color: #f3f4f6;
        }
        .ss-bar-wrap {
            flex: 1;
            background: #f3f4f6;
            border-radius: 999px;
            height: 1.25rem;
            overflow: hidden;
            position: relative;
        }
        .dark .ss-bar-wrap {
            background: #374151;
        }
        .ss-bar {
            height: 100%;
            border-radius: 999px;
            transition: width 0.4s;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 0.5rem;
            font-size: 0.6875rem;
            font-weight: 600;
            color: #fff;
            min-width: 2rem;
        }
        .ss-bar-beo {
            background: #3b82f6;
        }
        .ss-bar-wedding {
            background: #ec4899;
        }
        .ss-bar-total {
            background: #8b5cf6;
        }

        .ss-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8125rem;
        }
        .ss-table th {
            padding: 0.5rem 0.75rem;
            text-align: left;
            font-weight: 600;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .dark .ss-table th {
            color: #9ca3af;
            border-color: #374151;
        }
        .ss-table td {
            padding: 0.5rem 0.75rem;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
        }
        .dark .ss-table td {
            border-color: #374151;
            color: #d1d5db;
        }
        .ss-table tr:hover td {
            background: #f9fafb;
        }
        .dark .ss-table tr:hover td {
            background: rgba(255,255,255,0.03);
        }
        .ss-badge {
            display: inline-block;
            padding: 0.125rem 0.5rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .ss-badge-beo {
            background: #dbeafe;
            color: #1d4ed8;
        }
        .dark .ss-badge-beo {
            background: rgba(59,130,246,0.2);
            color: #93c5fd;
        }
        .ss-badge-wedding {
            background: #fce7f3;
            color: #be185d;
        }
        .dark .ss-badge-wedding {
            background: rgba(236,72,153,0.2);
            color: #f9a8d4;
        }
        .ss-badge-total {
            background: #ede9fe;
            color: #6d28d9;
        }
        .dark .ss-badge-total {
            background: rgba(139,92,246,0.2);
            color: #c4b5fd;
        }
    </style>

    <div class="ss-sort">
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
        <label for="sortBy">Sort:</label>
        <select id="sortBy" wire:model.live="sortBy">
            <option value="total">Total</option>
            <option value="beo">Beo</option>
            <option value="wedding">Wedding</option>
        </select>
    </div>

    <div class="ss-grid">
        {{-- Top 5 Rank --}}
        <div class="ss-card">
            <div class="ss-card-header">Top 5 Sales</div>
            <div class="ss-card-body">
                @php $top = $this->topSales; @endphp
                @forelse ($top as $i => $s)
                    @php
                        $maxCount = $this->maxCount;
                        $pct = $maxCount > 0 ? round(($s[$this->sortBy] / $maxCount) * 100) : 0;
                        $barClass = 'ss-bar-' . $this->sortBy;
                    @endphp
                    <div class="ss-rank">
                        <div class="ss-rank-num ss-rank-{{ $i + 1 }}">{{ $i + 1 }}</div>
                        <div class="ss-rank-name">{{ $s['name'] }}</div>
                        <div class="ss-bar-wrap">
                            <div class="ss-bar {{ $barClass }}" style="width: {{ max($pct, 8) }}%;">
                                {{ $s[$this->sortBy] }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center;color:#9ca3af;padding:1rem;">No data.</div>
                @endforelse
            </div>
        </div>

        {{-- Sales List Table --}}
        <div class="ss-card">
            <div class="ss-card-header">All Sales</div>
            <div class="ss-card-body" style="padding:0;">
                @php $sales = $this->salesData; @endphp
                @if (count($sales) > 0)
                    <table class="ss-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th style="text-align:center;">Beo</th>
                                <th style="text-align:center;">Wedding</th>
                                <th style="text-align:center;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $s)
                                <tr>
                                    <td>{{ $s['name'] }}</td>
                                    <td style="text-align:center;"><span class="ss-badge ss-badge-beo">{{ $s['beo'] }}</span></td>
                                    <td style="text-align:center;"><span class="ss-badge ss-badge-wedding">{{ $s['wedding'] }}</span></td>
                                    <td style="text-align:center;"><span class="ss-badge ss-badge-total">{{ $s['total'] }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="text-align:center;color:#9ca3af;padding:1.5rem;">No sales users found.</div>
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>
