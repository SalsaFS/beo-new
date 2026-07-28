<?php

namespace App\Filament\Resources\Menus\Tables;

use App\Models\Menu;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MenusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->heading(fn ($livewire) => 'Total Menu - ' . $livewire->getFilteredTableQuery()->count())
            ->contentGrid([
                'sm' => 1,
                'md' => 2,
                'lg' => 3,
                'xl' => 4,
            ])
            ->columns([
                Stack::make([
                    ImageColumn::make('picture_path')
                        ->imageHeight(150)
                        ->width(200)
                        ->defaultImageUrl(asset('images/no-image.jpg')),
                        TextColumn::make('menuCode.name')
                        ->formatStateUsing(function ($state, $record) {
                            return "{$state}-{$record->menu_code_number}";
                        })
                        ->searchable(),
                    TextColumn::make('menuType.name')
                        ->formatStateUsing(function ($state, $record) {
                            return "{$state} . {$record->menuSubType->name}";
                        })
                        ->searchable(),
                    TextColumn::make('name')
                        ->weight(FontWeight::Bold)
                        ->searchable(),
                    TextColumn::make('price')
                        ->searchable()
                        ->money('IDR'),
                ])
                    ->space(1)
            ])
            ->filters([
                SelectFilter::make('menu_code_id')
                    ->relationship('menuCode', 'name')
                    ->label('Menu Code'),
                SelectFilter::make('menu_type_id')
                    ->relationship('menuType', 'name')
                    ->label('Menu Type'),
                SelectFilter::make('menu_sub_type_id')
                    ->relationship('menuSubType', 'name')
                    ->label('Menu Sub Type'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->hiddenLabel()
                    ->tooltip('View'),
                EditAction::make()
                    ->modal()
                    ->hiddenLabel()
                    ->tooltip('Edit'),
                DeleteAction::make()
                    ->hiddenLabel()
                    ->before(function ($record) {
                        $record->recipes()->delete();
                    })
                    ->tooltip('Delete'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                $record->recipes()->delete();
                            }
                        }),
                ]),
            ]);
    }
}
