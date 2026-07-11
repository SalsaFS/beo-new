<?php

namespace App\Filament\Resources\Beos\Pages;

use App\Filament\Resources\Beos\BeoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBeos extends ListRecords
{
    protected static string $resource = BeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->createAnother(false),
        ];
    }
}
