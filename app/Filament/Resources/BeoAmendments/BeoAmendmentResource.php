<?php

namespace App\Filament\Resources\BeoAmendments;

use App\Filament\Resources\BeoAmendments\Pages\CreateBeoAmendment;
use App\Filament\Resources\BeoAmendments\Pages\EditBeoAmendment;
use App\Filament\Resources\BeoAmendments\Pages\ListBeoAmendments;
use App\Filament\Resources\BeoAmendments\Pages\ViewBeoAmendment;
use App\Filament\Resources\BeoAmendments\Schemas\BeoAmendmentForm;
use App\Filament\Resources\BeoAmendments\Schemas\BeoAmendmentInfolist;
use App\Filament\Resources\BeoAmendments\Tables\BeoAmendmentsTable;
use App\Models\BeoAmendment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BeoAmendmentResource extends Resource
{
    protected static ?string $model = BeoAmendment::class;
    protected static ?string $modelLabel = 'Beo Amendment';
    protected static ?string $pluralModelLabel = 'Beo Amendments';
    protected static string|UnitEnum|null $navigationGroup = 'Core';
    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return BeoAmendmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BeoAmendmentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BeoAmendmentsTable::configure($table);
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
            'index' => ListBeoAmendments::route('/'),
            'create' => CreateBeoAmendment::route('/create'),
            'view' => ViewBeoAmendment::route('/{record}'),
            'edit' => EditBeoAmendment::route('/{record}/edit'),
        ];
    }
}
