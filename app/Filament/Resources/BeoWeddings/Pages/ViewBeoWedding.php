<?php

namespace App\Filament\Resources\BeoWeddings\Pages;

use App\Filament\Resources\BeoWeddings\BeoWeddingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBeoWedding extends ViewRecord
{
    protected static string $resource = BeoWeddingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
