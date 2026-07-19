<?php

namespace App\Filament\Resources\ClientWeddings;

use App\Filament\Resources\ClientWeddings\Pages\CreateClientWedding;
use App\Filament\Resources\ClientWeddings\Pages\EditClientWedding;
use App\Filament\Resources\ClientWeddings\Pages\ListClientWeddings;
use App\Filament\Resources\ClientWeddings\Pages\ViewClientWedding;
use App\Filament\Resources\ClientWeddings\Schemas\ClientWeddingForm;
use App\Filament\Resources\ClientWeddings\Schemas\ClientWeddingInfolist;
use App\Filament\Resources\ClientWeddings\Tables\ClientWeddingsTable;
use App\Models\ClientWedding;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ClientWeddingResource extends Resource
{
    protected static ?string $model = ClientWedding::class;
    protected static ?string $recordTitleAttribute = 'pic';
    protected static ?string $modelLabel = 'Client Wedding';
    protected static ?string $pluralModelLabel = 'Client Weddings';
    protected static string|UnitEnum|null $navigationGroup = 'Core';
    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return ClientWeddingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientWeddingsTable::configure($table);
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
            'index' => ListClientWeddings::route('/'),
        ];
    }
}
