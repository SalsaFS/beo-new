<?php

namespace App\Filament\Resources\BeoAmendments\Pages;

use App\Filament\Resources\BeoAmendments\BeoAmendmentResource;
use App\Models\BeoAmendmentApproval;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class ViewBeoAmendment extends ViewRecord
{
    protected static string $resource = BeoAmendmentResource::class;

    protected function getHeaderActions(): array
    {
        $approval = BeoAmendmentApproval::where('beo_amendment_id', $this->getRecord()->id)
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
                $approvals = $record->beoAmendmentApprovals;

                return $approvals->isNotEmpty()
                    && $approvals->every(fn($a) => $a->is_verify != 0);
            })
            ->action(function ($record) {
                $filename = ($record->beo->event_number ?? '') . ' - Amendment ' . ($record->beo->client->company ?? '') . '.xlsx';

                return \Maatwebsite\Excel\Facades\Excel::download(
                    new \App\Exports\BeoAmendmentExport($record),
                    $filename
                );
            });

        $actions[] = EditAction::make();

        return $actions;
    }
}
