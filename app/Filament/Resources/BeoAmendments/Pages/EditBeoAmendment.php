<?php

namespace App\Filament\Resources\BeoAmendments\Pages;

use App\Filament\Resources\BeoAmendments\BeoAmendmentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBeoAmendment extends EditRecord
{
    protected static string $resource = BeoAmendmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
