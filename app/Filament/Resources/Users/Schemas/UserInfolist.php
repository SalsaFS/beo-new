<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Details')
                    ->columns(1)
                    ->schema([
                        ImageEntry::make('picture_path')
                            ->hiddenLabel()
                            ->visible(function (User $record) {
                                return $record->picture_path;
                            }),
                        Group::make([
                            TextEntry::make('name'),
                            TextEntry::make('username'),
                            TextEntry::make('position.name')
                                ->label('Position')
                                ->visible(function (User $record) {
                                    $roleId = $record->roles->pluck('id')->toArray();

                                    return Role::whereIn('id', (array) $roleId)
                                        ->whereIn('name', ['sales', 'approver'])
                                        ->exists();
                                })
                                ->placeholder('-'),
                            TextEntry::make('is_active')
                                ->label('Active State')
                                ->badge()
                                ->color(function (User $record) {
                                    return $record->is_active === 1 ? 'success' : 'danger';
                                })
                                ->formatStateUsing(function (User $record) {
                                    if ($record->is_active === 1) {
                                        return 'Active';
                                    } else
                                        return 'Inactive';
                                })
                                ->extraAttributes([
                                    'style' => 'display: table;', // Memaksa element menciut pas seukuran teks badge
                                ]),
                        ])
                            ->columns(4),
                        TextEntry::make('signature')
                            ->hiddenLabel()
                            ->visible(function (User $record) {
                                return $record->picture_path;
                            }),
                    ]),
            ]);
    }
}
