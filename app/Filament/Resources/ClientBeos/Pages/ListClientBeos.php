<?php

namespace App\Filament\Resources\ClientBeos\Pages;

use App\Filament\Resources\ClientBeos\ClientBeoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClientBeos extends ListRecords
{
    protected static string $resource = ClientBeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modal()
                ->createAnother(false),
        ];
    }
}
