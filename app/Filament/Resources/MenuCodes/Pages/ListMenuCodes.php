<?php

namespace App\Filament\Resources\MenuCodes\Pages;

use App\Filament\Resources\MenuCodes\MenuCodeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMenuCodes extends ListRecords
{
    protected static string $resource = MenuCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modal()
                ->createAnother(false),
        ];
    }
}
