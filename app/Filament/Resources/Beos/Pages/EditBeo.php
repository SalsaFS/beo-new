<?php

namespace App\Filament\Resources\Beos\Pages;

use App\Filament\Resources\Beos\BeoResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBeo extends EditRecord
{
    protected static string $resource = BeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
