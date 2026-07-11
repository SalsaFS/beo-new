<?php

namespace App\Filament\Resources\MenuSubTypes\Pages;

use App\Filament\Resources\MenuSubTypes\MenuSubTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMenuSubTypes extends ListRecords
{
    protected static string $resource = MenuSubTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modal()
                ->createAnother(false),
        ];
    }
}
