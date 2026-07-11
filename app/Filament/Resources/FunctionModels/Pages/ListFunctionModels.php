<?php

namespace App\Filament\Resources\FunctionModels\Pages;

use App\Filament\Resources\FunctionModels\FunctionModelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFunctionModels extends ListRecords
{
    protected static string $resource = FunctionModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modal()
                ->createAnother(false),
        ];
    }
}
