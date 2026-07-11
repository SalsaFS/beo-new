<?php

namespace App\Filament\Resources\ClientWeddings\Pages;

use App\Filament\Resources\ClientWeddings\ClientWeddingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditClientWedding extends EditRecord
{
    protected static string $resource = ClientWeddingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
