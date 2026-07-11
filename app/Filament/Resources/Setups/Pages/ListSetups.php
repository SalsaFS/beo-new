<?php

namespace App\Filament\Resources\Setups\Pages;

use App\Filament\Resources\Setups\SetupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSetups extends ListRecords
{
    protected static string $resource = SetupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modal()
                ->createAnother(false),
        ];
    }
}
