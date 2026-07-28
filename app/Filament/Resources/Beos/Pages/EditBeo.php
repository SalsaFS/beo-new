<?php

namespace App\Filament\Resources\Beos\Pages;

use App\Filament\Resources\Beos\BeoResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBeo extends EditRecord
{
    protected static string $resource = BeoResource::class;

    public function hasDatabaseTransactions(): bool
    {
        return true;
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
