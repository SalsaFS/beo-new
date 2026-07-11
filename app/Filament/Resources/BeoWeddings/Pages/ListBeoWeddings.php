<?php

namespace App\Filament\Resources\BeoWeddings\Pages;

use App\Filament\Resources\BeoWeddings\BeoWeddingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBeoWeddings extends ListRecords
{
    protected static string $resource = BeoWeddingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->createAnother(false),
        ];
    }
}
