<?php

namespace App\Filament\Resources\ClientWeddings\Pages;

use App\Filament\Resources\ClientWeddings\ClientWeddingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClientWeddings extends ListRecords
{
    protected static string $resource = ClientWeddingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->createAnother(false),
        ];
    }
}
