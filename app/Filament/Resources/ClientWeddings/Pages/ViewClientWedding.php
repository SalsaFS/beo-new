<?php

namespace App\Filament\Resources\ClientWeddings\Pages;

use App\Filament\Resources\ClientWeddings\ClientWeddingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewClientWedding extends ViewRecord
{
    protected static string $resource = ClientWeddingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
