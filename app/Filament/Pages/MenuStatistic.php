<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use UnitEnum;

class MenuStatistic extends Page
{
    protected string $view = 'filament.pages.menu-statistic';
    protected static string|UnitEnum|null $navigationGroup = 'Statistic';
    protected static ?int $navigationSort = 2;
}
