<?php

namespace App\Filament\Resources\BeoWeddingApprovals;

use App\Filament\Resources\BeoWeddingApprovals\Pages\EditBeoWeddingApproval;
use App\Filament\Resources\BeoWeddingApprovals\Pages\ListBeoWeddingApprovals;
use App\Filament\Resources\BeoWeddingApprovals\Schemas\BeoWeddingApprovalForm;
use App\Filament\Resources\BeoWeddingApprovals\Tables\BeoWeddingApprovalsTable;
use App\Models\BeoWedding;
use BackedEnum;
use Filament\Resources\Resource;
use UnitEnum;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BeoWeddingApprovalResource extends Resource
{
    protected static ?string $model = BeoWedding::class;

    protected static ?string $navigationLabel = 'Wedding Approvals';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Core';

    protected static ?int $navigationSort = 9;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('admin') || auth()->user()?->hasRole('super-admin');
    }

    public static function form(Schema $schema): Schema
    {
        return BeoWeddingApprovalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BeoWeddingApprovalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBeoWeddingApprovals::route('/'),
            'edit' => EditBeoWeddingApproval::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount([
            'beoWeddingApprovals as total_approvals_count',
            'beoWeddingApprovals as verified_approvals_count' => fn (Builder $q) => $q->where('is_verify', 1),
        ]);
    }
}
