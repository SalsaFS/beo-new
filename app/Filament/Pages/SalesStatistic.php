<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use UnitEnum;

class SalesStatistic extends Page
{
    protected string $view = 'filament.pages.sales-statistic';
    protected static string|UnitEnum|null $navigationGroup = 'Statistic';
    protected static ?int $navigationSort = 1;
}
