<?php

namespace App\Filament\Pages;

use App\Models\MeetingRoom;
use App\Models\Menu;
use App\Models\MenuSubType;
use App\Models\MenuType;
use App\Models\Package;
use Filament\Pages\Page;
use UnitEnum;

class Catalog extends Page
{
    protected string $view = 'filament.pages.catalog';
    protected static string|UnitEnum|null $navigationGroup = 'Core';
    protected static ?int $navigationSort = 1;

    public string $activeTab = 'rooms';
    public string $menuSearch = '';
    public string $menuTypeFilter = '';
    public string $menuSubTypeFilter = '';

    public function getMeetingRoomsProperty()
    {
        return MeetingRoom::with('roomCapacities.setup')->orderBy('name')->get();
    }

    public function getPackagesProperty()
    {
        $all = Package::with('packageBreakdowns.function')->orderBy('name')->get();
        return [
            'meeting' => $all->where('type', 'meeting')->values(),
            'wedding' => $all->where('type', 'wedding')->values(),
        ];
    }

    public function getMenusProperty()
    {
        return Menu::with(['menuType', 'menuSubType'])
            ->when($this->menuSearch, fn($q) => $q->where('name', 'like', "%{$this->menuSearch}%"))
            ->when($this->menuTypeFilter, fn($q) => $q->where('menu_type_id', $this->menuTypeFilter))
            ->when($this->menuSubTypeFilter, fn($q) => $q->where('menu_sub_type_id', $this->menuSubTypeFilter))
            ->orderBy('menu_type_id')
            ->orderBy('name')
            ->get();
    }

    public function getMenuTypesProperty()
    {
        return MenuType::orderBy('name')->pluck('name', 'id');
    }

    public function getMenuSubTypesProperty()
    {
        return MenuSubType::orderBy('name')->pluck('name', 'id');
    }
}
