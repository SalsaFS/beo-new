<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use UnitEnum;

class Catalog extends Page
{
    protected string $view = 'filament.pages.catalog';
    protected static string|UnitEnum|null $navigationGroup = 'Core';
    protected static ?int $navigationSort = 1;

}
