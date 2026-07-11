<?php

namespace App\Filament\Resources\MeetingRooms\Schemas;

use App\Models\Setup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class MeetingRoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->required(),
                Group::make([
                    TextInput::make('dimension_p')
                        ->label('Dimension P (m)')
                        ->required()
                        ->numeric(),
                    TextInput::make('dimension_l')
                        ->label('Dimension L (m)')
                        ->required()
                        ->numeric(),
                    TextInput::make('ceiling_height')
                        ->label('Ceiling Height (m)')
                        ->required()
                        ->numeric(),
                ])
                    ->columns(3),
                Repeater::make('roomCapacities')
                    ->relationship('roomCapacities')
                    ->table([
                        \Filament\Forms\Components\Repeater\TableColumn::make('Setup'),
                        \Filament\Forms\Components\Repeater\TableColumn::make('Capacity'),
                    ])
                    ->schema([
                        Select::make('setup_id')
                            ->relationship('setup', 'name')
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                        TextInput::make('capacity')
                            ->numeric(),
                    ])
                    ->default(function () {
                        return Setup::all()->map(function ($setup) {
                            return [
                                'setup_id' => $setup->id,
                                'capacity' => null, // Biarkan kosong agar diisi user
                            ];
                        })->toArray();
                    })
                    ->addable(false)
                    ->deletable(false)
                    ->columns(2)
                    ->addActionLabel('Add Capacity')
                    ->minItems(1)
                    ->addActionAlignment(\Filament\Support\Enums\Alignment::Start),
                FileUpload::make('picture_path')
                    ->label('Picture')
                    ->directory('meeting-room')
                    ->mimeTypeMap([
                        'jpg' => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'png' => 'image/png',
                    ])
                    ->maxSize(2048)
                    ->helperText('Max size: 2MB. Allowed types: jpg, jpeg, png.')
                    ->image(),
                Textarea::make('description'),
            ]);
    }
}
