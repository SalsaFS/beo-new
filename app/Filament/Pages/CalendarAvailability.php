<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use UnitEnum;

class CalendarAvailability extends Page
{
    protected string $view = 'filament.pages.calendar-availability';
    protected static string|UnitEnum|null $navigationGroup = 'Core';
    protected static ?int $navigationSort = 1;
}
