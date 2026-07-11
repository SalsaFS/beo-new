<?php

namespace App\Filament\Resources\BeoAmendments\Pages;

use App\Filament\Resources\BeoAmendments\BeoAmendmentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBeoAmendment extends ViewRecord
{
    protected static string $resource = BeoAmendmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
