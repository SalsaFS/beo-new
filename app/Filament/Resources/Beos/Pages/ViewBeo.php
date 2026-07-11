<?php

namespace App\Filament\Resources\Beos\Pages;

use App\Filament\Resources\Beos\BeoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBeo extends ViewRecord
{
    protected static string $resource = BeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
