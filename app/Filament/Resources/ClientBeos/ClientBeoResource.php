<?php

namespace App\Filament\Resources\ClientBeos;

use App\Filament\Resources\ClientBeos\Pages\CreateClientBeo;
use App\Filament\Resources\ClientBeos\Pages\EditClientBeo;
use App\Filament\Resources\ClientBeos\Pages\ListClientBeos;
use App\Filament\Resources\ClientBeos\Pages\ViewClientBeo;
use App\Filament\Resources\ClientBeos\Schemas\ClientBeoForm;
use App\Filament\Resources\ClientBeos\Schemas\ClientBeoInfolist;
use App\Filament\Resources\ClientBeos\Tables\ClientBeosTable;
use App\Models\ClientBeo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ClientBeoResource extends Resource
{
    protected static ?string $model = ClientBeo::class;
    protected static ?string $recordTitleAttribute = 'company';
    protected static ?string $modelLabel = 'Client Beo';
    protected static ?string $pluralModelLabel = 'Client Beos';
    protected static string|UnitEnum|null $navigationGroup = 'Core';
    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return ClientBeoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientBeosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClientBeos::route('/'),
        ];
    }
}
