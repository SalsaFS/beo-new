<x-filament-panels::page>
    <style>
        .cat-tabs {
            display: flex;
            gap: 0;
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 1.5rem;
        }
        .dark .cat-tabs {
            border-color: #374151;
        }
        .cat-tab {
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #6b7280;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all 0.15s;
            background: none;
            border-top: none;
            border-left: none;
            border-right: none;
        }
        .cat-tab:hover {
            color: #374151;
        }
        .dark .cat-tab {
            color: #9ca3af;
        }
        .dark .cat-tab:hover {
            color: #d1d5db;
        }
        .cat-tab-active {
            color: #f59e0b;
            border-bottom-color: #f59e0b;
        }
        .dark .cat-tab-active {
            color: #fbbf24;
            border-bottom-color: #fbbf24;
        }

        .cat-card {
            background: #fff;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        .dark .cat-card {
            background: #1f2937;
            border-color: #374151;
        }

        .cat-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8125rem;
        }
        .cat-table th {
            padding: 0.625rem 0.75rem;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
            white-space: nowrap;
        }
        .dark .cat-table th {
            color: #d1d5db;
            border-color: #374151;
            background: #111827;
        }
        .cat-table td {
            padding: 0.5rem 0.75rem;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
        }
        .dark .cat-table td {
            border-color: #374151;
            color: #d1d5db;
        }
        .cat-table tr:hover td {
            background: #f9fafb;
        }
        .dark .cat-table tr:hover td {
            background: rgba(255,255,255,0.03);
        }
        .cat-table .dim-label {
            font-size: 0.6875rem;
            color: #9ca3af;
        }
        .cat-empty {
            padding: 2rem;
            text-align: center;
            color: #9ca3af;
        }

        .pkg-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
        }
        .pkg-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
        }
        .dark .pkg-card {
            background: #1f2937;
            border-color: #374151;
        }
        .pkg-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.5rem;
        }
        .dark .pkg-name {
            color: #f3f4f6;
        }
        .pkg-fn-list {
            margin: 0;
            padding: 0 0 0 1rem;
            font-size: 0.75rem;
            color: #6b7280;
            list-style: disc;
        }
        .dark .pkg-fn-list {
            color: #9ca3af;
        }
        .pkg-fn-list li {
            margin-bottom: 0.125rem;
        }
        .pkg-fn-note {
            color: #9ca3af;
        }
        .pkg-empty {
            font-size: 0.75rem;
            color: #9ca3af;
        }
        .pkg-group-title {
            font-size: 0.9375rem;
            font-weight: 600;
            color: #111827;
            margin: 0 0 0.75rem 0;
        }
        .dark .pkg-group-title {
            color: #f3f4f6;
        }
        .pkg-group-title-mt {
            margin-top: 1.5rem;
        }

        .cat-menu-filters {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
        .cat-menu-input {
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            background: #fff;
            color: #374151;
            outline: none;
            min-width: 160px;
        }
        .dark .cat-menu-input {
            background: #1f2937;
            border-color: #4b5563;
            color: #d1d5db;
        }
        .cat-menu-input:focus {
            border-color: #f59e0b;
        }

        .cat-menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            padding: 1rem;
        }
        .cat-menu-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .dark .cat-menu-card {
            background: #1f2937;
            border-color: #374151;
        }
        .cat-menu-img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            display: block;
            background: #f3f4f6;
        }
        .dark .cat-menu-img {
            background: #374151;
        }
        .cat-menu-body {
            padding: 0.625rem;
        }
        .cat-menu-type {
            font-size: 0.6875rem;
            color: #9ca3af;
            margin-bottom: 0.125rem;
        }
        .cat-menu-name {
            font-size: 0.8125rem;
            font-weight: 600;
            color: #111827;
        }
        .dark .cat-menu-name {
            color: #f3f4f6;
        }
        .cat-menu-price {
            font-size: 0.75rem;
            color: #f59e0b;
            margin-top: 0.25rem;
        }
        .dark .cat-menu-price {
            color: #fbbf24;
        }
    </style>

    {{-- Tabs --}}
    <div class="cat-tabs">
        <button wire:click="$set('activeTab', 'rooms')" class="cat-tab @if($activeTab === 'rooms') cat-tab-active @endif">Meeting Rooms</button>
        <button wire:click="$set('activeTab', 'packages')" class="cat-tab @if($activeTab === 'packages') cat-tab-active @endif">Packages</button>
        <button wire:click="$set('activeTab', 'menus')" class="cat-tab @if($activeTab === 'menus') cat-tab-active @endif">Menus</button>
    </div>

    {{-- Tab 1: Meeting Rooms --}}
    @if ($activeTab === 'rooms')
        @php $rooms = $this->meetingRooms; @endphp
        <div class="cat-card">
            <table class="cat-table">
                <thead>
                    <tr>
                        <th>Room</th>
                        <th>Dimensions</th>
                        @php $setups = $rooms->pluck('roomCapacities')->flatten()->pluck('setup')->unique('id')->filter(); @endphp
                        @foreach ($setups as $setup)
                            <th>{{ $setup->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rooms as $room)
                        <tr>
                            <td style="font-weight:500;">{{ $room->name }}</td>
                            <td>
                                @if ($room->dimension_p && $room->dimension_l)
                                    {{ $room->dimension_p }}m x {{ $room->dimension_l }}m = {{ $room->dimension_p * $room->dimension_l }}m&sup2;
                                    <br><span class="dim-label">H: {{ $room->ceiling_height }}m</span>
                                @elseif ($room->dimension_p || $room->dimension_l)
                                    {{ $room->dimension_p ?: $room->dimension_l }}
                                    <br><span class="dim-label">H: {{ $room->ceiling_height ?? '-' }}</span>
                                @else
                                    <span style="color:#9ca3af;">-</span>
                                @endif
                            </td>
                            @foreach ($setups as $setup)
                                @php
                                    $cap = $room->roomCapacities->where('setup_id', $setup->id)->first();
                                @endphp
                                <td>{{ $cap ? $cap->capacity : '-' }}</td>
                            @endforeach
                        </tr>
                    @empty
                        <tr><td colspan="{{ 2 + $setups->count() }}" class="cat-empty">No meeting rooms available.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    {{-- Tab 2: Packages --}}
    @if ($activeTab === 'packages')
        @php
            $pkgs = $this->packages;
            $groups = [
                'meeting' => ['label' => 'Beo', 'items' => $pkgs['meeting']],
                'wedding' => ['label' => 'Wedding', 'items' => $pkgs['wedding']],
            ];
        @endphp
        <div class="cat-card" style="padding:1rem;">
            @foreach ($groups as $key => $group)
                @if ($group['items']->isNotEmpty())
                    <h3 class="pkg-group-title @if(!$loop->first) pkg-group-title-mt @endif">{{ $group['label'] }}</h3>
                    <div class="pkg-grid">
                        @foreach ($group['items'] as $package)
                            <div class="pkg-card">
                                <div class="pkg-name">{{ $package->name }}</div>
                                @if ($package->packageBreakdowns->isNotEmpty())
                                    <ul class="pkg-fn-list">
                                        @foreach ($package->packageBreakdowns as $bd)
                                            <li>{{ $bd->function?->name ?? '-' }}@if ($bd->note) <span class="pkg-fn-note">{{ $bd->note }}</span>@endif</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="pkg-empty">No functions</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
            @php $total = $pkgs['meeting']->count() + $pkgs['wedding']->count(); @endphp
            @if ($total === 0)
                <div class="cat-empty">No packages available.</div>
            @endif
        </div>
    @endif

    {{-- Tab 3: Menus --}}
    @if ($activeTab === 'menus')
        @php $menus = $this->menus; @endphp
        <div class="cat-menu-filters">
            <input type="text" wire:model.live="menuSearch" placeholder="Search menu..." class="cat-menu-input">
            <select wire:model.live="menuTypeFilter" class="cat-menu-input">
                <option value="">All Types</option>
                @foreach ($this->menuTypes as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            <select wire:model.live="menuSubTypeFilter" class="cat-menu-input">
                <option value="">All Sub Types</option>
                @foreach ($this->menuSubTypes as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="cat-card">
            @if ($menus->isNotEmpty())
                <div class="cat-menu-grid">
                    @foreach ($menus as $menu)
                        <div class="cat-menu-card">
                            <img src="{{ $menu->picture_path ? asset('storage/' . ltrim($menu->picture_path, '/')) : asset('images/no-image.jpg') }}" alt="{{ $menu->name }}" class="cat-menu-img">
                            <div class="cat-menu-body">
                                <div class="cat-menu-type">{{ $menu->menuType?->name ?? '-' }} . {{ $menu->menuSubType?->name ?? '-' }}</div>
                                <div class="cat-menu-name">{{ $menu->name }}</div>
                                @if ($menu->price)
                                    <div class="cat-menu-price">IDR {{ number_format($menu->price, 0, ',', '.') }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="cat-empty">No menus available.</div>
            @endif
        </div>
    @endif
</x-filament-panels::page>
