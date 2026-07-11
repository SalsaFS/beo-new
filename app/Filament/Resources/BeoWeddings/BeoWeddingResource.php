<?php

namespace App\Filament\Resources\BeoWeddings;

use App\Filament\Resources\BeoWeddings\Pages\CreateBeoWedding;
use App\Filament\Resources\BeoWeddings\Pages\EditBeoWedding;
use App\Filament\Resources\BeoWeddings\Pages\ListBeoWeddings;
use App\Filament\Resources\BeoWeddings\Pages\ViewBeoWedding;
use App\Filament\Resources\BeoWeddings\Schemas\BeoWeddingForm;
use App\Filament\Resources\BeoWeddings\Schemas\BeoWeddingInfolist;
use App\Filament\Resources\BeoWeddings\Tables\BeoWeddingsTable;
use App\Models\BeoWedding;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BeoWeddingResource extends Resource
{
    protected static ?string $model = BeoWedding::class;
    protected static ?string $recordTitleAttribute = 'event_number';
    protected static ?string $modelLabel = 'Beo Wedding';
    protected static ?string $pluralModelLabel = 'Beo Weddings';
    protected static string|UnitEnum|null $navigationGroup = 'Core';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return BeoWeddingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BeoWeddingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BeoWeddingsTable::configure($table);
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
            'index' => ListBeoWeddings::route('/'),
            'create' => CreateBeoWedding::route('/create'),
            'view' => ViewBeoWedding::route('/{record}'),
            'edit' => EditBeoWedding::route('/{record}/edit'),
        ];
    }
}
