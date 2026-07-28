<?php

namespace App\Filament\Resources\Beos\Pages;

use App\Filament\Resources\Beos\BeoResource;
use App\Models\BeoApproval;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class ViewBeo extends ViewRecord
{
    protected static string $resource = BeoResource::class;

    protected function getHeaderActions(): array
    {
        $approval = BeoApproval::where('beo_id', $this->getRecord()->id)
            ->where('user_id', Auth::id())
            ->first();

        $actions = [];

        if ($approval) {
            if ($approval->is_verify == 1) {
                $actions[] = Action::make('verified')
                    ->label('Verified')
                    ->color('gray')
                    ->disabled();
            } else {
                $redirectUrl = $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);

                $actions[] = Action::make('verify')
                    ->label('Verify')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->action(function () use ($approval, $redirectUrl) {
                        $approval->update(['is_verify' => 1]);
                        $this->redirect($redirectUrl);
                    });
            }
        }

        $actions[] = Action::make('printBeo')
            ->label('Print')
            ->icon(Heroicon::Printer)
            ->visible(function ($record) {
                $approvals = $record->beoApprovals;

                return $approvals->isNotEmpty()
                    && $approvals->every(fn($a) => $a->is_verify != 0);
            })
            ->action(function ($record) {
                $filename = ($record->event_number ?? '') . ' - ' . ($record->client->company ?? '') . '.xlsx';

                return \Maatwebsite\Excel\Facades\Excel::download(
                    new \App\Exports\BeoExport($record),
                    $filename
                );
            });

        $actions[] = EditAction::make();

        return $actions;
    }
}
