<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;

class MenuInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Grid::make(5)
                    ->schema([
                        Group::make()
                            ->columnSpan(2)
                            ->schema([
                                Section::make('Details')
                                    ->schema([
                                        TextEntry::make('menuCode.name')
                                            ->hiddenLabel()
                                            ->icon(Heroicon::Star)
                                            ->iconColor('primary')
                                            ->formatStateUsing(fn($state, $record) => "{$record->menuType->name} . {$record->menuSubType->name}"),
                                        TextEntry::make('name')
                                            ->hiddenLabel()
                                            ->weight(FontWeight::Bold)
                                            ->size(TextSize::Large),
                                        Group::make()
                                            ->columns(2)
                                            ->schema([
                                                TextEntry::make('menuCode.name')
                                                    ->label('Menu Code')
                                                    ->formatStateUsing(fn($state, $record) => "{$state}{$record->menu_code_number}"),
                                                TextEntry::make('price')
                                                    ->label('Price')
                                                    ->money('IDR'),
                                            ]),
                                    ]),
                                Section::make('Ingredients')
                                    ->schema([
                                        RepeatableEntry::make('recipes')
                                            ->hiddenLabel()
                                            ->contained(false)
                                            ->schema([
                                                TextEntry::make('ingredient.name')
                                                    ->formatStateUsing(fn($state, $record) => "{$state} {$record->quantity} {$record->unit->name}")
                                                    ->hiddenLabel(),
                                            ]),
                                    ]),
                            ]),
                        Section::make('How To Make')
                            ->columnSpan(3)
                            ->schema([
                                ImageEntry::make('picture_path')
                                    ->alignCenter()
                                    ->label('Picture')
                                    ->defaultImageUrl(asset('images/no-image.jpg'))
                                    ->action(
                                        \Filament\Actions\Action::make('viewImage')
                                            ->label('View Image')
                                            ->modalHeading('Picture')
                                            ->modalSubmitAction(false)
                                            ->modalCancelAction(false)
                                            ->modalContent(function ($record) {
                                                $src = $record->picture_path
                                                    ? asset('storage/' . ltrim($record->picture_path, '/'))
                                                    : asset('images/no-image.jpg');

                                                return new \Illuminate\Support\HtmlString('
                                                    <div class="flex justify-center">
                                                        <img src="' . e($src) . '" alt="Picture"
                                                            class="max-h-[80vh] max-w-full rounded-lg shadow-lg" />
                                                    </div>
                                                ');
                                            })
                                    ),
                                TextEntry::make('how_to_make')
                                    ->html()
                                    ->extraAttributes(['class' => 'fi-prose']),
                            ]),
                    ]),
            ]);
    }
}
