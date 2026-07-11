<?php

namespace App\Filament\Resources\ClientBeos\Pages;

use App\Filament\Resources\ClientBeos\ClientBeoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewClientBeo extends ViewRecord
{
    protected static string $resource = ClientBeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
