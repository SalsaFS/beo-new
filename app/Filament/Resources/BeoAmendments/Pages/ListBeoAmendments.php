<?php

namespace App\Filament\Resources\BeoAmendments\Pages;

use App\Filament\Resources\BeoAmendments\BeoAmendmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBeoAmendments extends ListRecords
{
    protected static string $resource = BeoAmendmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->createAnother(false),
        ];
    }
}
