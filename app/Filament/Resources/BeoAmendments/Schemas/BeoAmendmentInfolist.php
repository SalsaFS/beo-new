<?php

namespace App\Filament\Resources\BeoAmendments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BeoAmendmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('details')
                    ->columnSpanFull()
                    ->columns(2)
                    ->inlineLabel(true)
                    ->heading(false)
                    ->schema([
                        TextEntry::make('beo.event_number')
                            ->label('Beo Event Number'),
                        TextEntry::make('created_at')
                            ->label('Date Issued')
                            ->date('d F Y'),
                        TextEntry::make('name_of_event'),
                        TextEntry::make('date_change')
                            ->date('d F Y')
                            ->label('Date of Event'),
                        TextEntry::make('contact_person'),
                        TextEntry::make('contact'),
                        TextEntry::make('beoAmendmentPackages.package.name')
                            ->label('Package'),
                        TextEntry::make('beoAmendmentPackages.venue.name')
                            ->label('Venue'),
                    ]),
                Section::make('Before')
                    ->schema([
                        TextEntry::make('other_before')
                            ->hiddenLabel()
                            ->html()
                            ->extraAttributes(['class' => 'fi-prose'])
                    ]),
                Section::make('After')
                    ->schema([
                        TextEntry::make('other_after')
                            ->hiddenLabel()
                            ->html()
                            ->extraAttributes(['class' => 'fi-prose'])
                    ]),
            ]);
    }
}
