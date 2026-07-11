<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Position;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Group::make()
                    ->columns(2)
                    ->schema([
                        Group::make()
                            ->columns(1)
                            ->schema([
                                TextInput::make('name')
                                    ->required(),
                                TextInput::make('username')
                                    ->unique(ignoreRecord: true)
                                    ->required(),
                            ]),
                        Group::make()
                            ->columns(1)
                            ->schema([
                                TextInput::make('password_hash')
                                    ->label('Password')
                                    ->password()
                                    ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                                    ->dehydrated(fn(?string $state): bool => filled($state))
                                    ->required(fn(string $operation): bool => $operation === 'create'),
                                TextInput::make('password_confirmation')
                                    ->label('Confirm Password')
                                    ->password()
                                    ->same('password_hash')
                                    ->required(fn(string $operation): bool => $operation === 'create')
                                    ->dehydrated(false),
                            ])
                    ]),
                Select::make('roles')
                    ->relationship(
                        name: 'roles',
                        titleAttribute: 'name',
                        modifyQueryUsing: function (Builder $query) {
                            if (!auth()->user()->hasRole('super-admin')) {
                                $query->where('name', '!=', 'super-admin');
                            }

                            return $query;
                        }
                    )
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required()
                    ->disabled(function (?Model $record) {
                        if (!$record) {
                            return false;
                        }

                        return $record->roles()
                            ->whereIn('name', ['sales', 'approver'])
                            ->exists();
                    }),
                Select::make('position_id')
                    ->relationship(
                        name: 'position',
                        titleAttribute: 'name',
                        modifyQueryUsing: function (Builder $query, Get $get) {
                            $roleId = $get('roles');
                            $roleName = Role::whereKey((array) $roleId)->value('name');

                            if ($roleName === 'sales') {
                                return $query->where('signature_positions', 1);
                            }

                            return $query->where('signature_positions', '!=', 1);
                        }
                    )
                    ->visible(function (?Model $record, Get $get) {
                        $roleId = $get('roles');

                        if (!$roleId) {
                            return false;
                        }
                        return Role::whereIn('id', (array) $roleId)
                            ->whereIn('name', ['sales', 'approver'])
                            ->exists();
                    })
                    ->required(),
                FileUpload::make('picture_path')
                    ->label('Profile Picture')
                    ->image()
                    ->mimeTypeMap([
                        'jpg' => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'png' => 'image/png',
                    ])
                    ->maxSize(2048) // 2MB in kilobytes
                    ->helperText('Max file size: 2MB | Allowed file types: jpg, jpeg, png')
                    ->directory('user'),
                FileUpload::make('signature')
                    ->label('Signature')
                    ->image()
                    ->directory('user/signature')
                    ->maxSize(2048)
                    ->helperText('Max file size: 2MB | Allowed file types: jpg, jpeg, png')
                    ->mimeTypeMap([
                        'jpg' => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'png' => 'image/png',
                    ])
                    ->visible(function (?Model $record, Get $get) {
                        $roleId = $get('roles');

                        if (!$roleId) {
                            return false;
                        }
                        return Role::whereIn('id', (array) $roleId)
                            ->whereIn('name', ['sales', 'approver'])
                            ->exists();
                    }),
                Toggle::make('is_active')
                    ->label('Active State')
                    ->required()
                    ->inline(false)
                    ->default(1),
            ]);
    }
}
