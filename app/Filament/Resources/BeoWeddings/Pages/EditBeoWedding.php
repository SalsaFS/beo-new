<?php

namespace App\Filament\Resources\BeoWeddings\Pages;

use App\Filament\Resources\BeoWeddings\BeoWeddingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBeoWedding extends EditRecord
{
    protected static string $resource = BeoWeddingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
