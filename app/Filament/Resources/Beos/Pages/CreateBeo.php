<?php

namespace App\Filament\Resources\Beos\Pages;

use App\Filament\Resources\Beos\BeoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBeo extends CreateRecord
{
    protected static string $resource = BeoResource::class;
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
