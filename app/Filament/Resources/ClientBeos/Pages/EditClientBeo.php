<?php

namespace App\Filament\Resources\ClientBeos\Pages;

use App\Filament\Resources\ClientBeos\ClientBeoResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditClientBeo extends EditRecord
{
    protected static string $resource = ClientBeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
