<?php

namespace App\Filament\Resources\BeoApprovals;

use App\Filament\Resources\BeoApprovals\Pages\EditBeoApproval;
use App\Filament\Resources\BeoApprovals\Pages\ListBeoApprovals;
use App\Filament\Resources\BeoApprovals\Schemas\BeoApprovalForm;
use App\Filament\Resources\BeoApprovals\Tables\BeoApprovalsTable;
use App\Models\Beo;
use BackedEnum;
use Filament\Resources\Resource;
use UnitEnum;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BeoApprovalResource extends Resource
{
    protected static ?string $model = Beo::class;

    protected static ?string $navigationLabel = 'Beo Approvals';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Core';

    protected static ?int $navigationSort = 8;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('admin') || auth()->user()?->hasRole('super-admin');
    }

    public static function form(Schema $schema): Schema
    {
        return BeoApprovalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BeoApprovalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBeoApprovals::route('/'),
            'edit' => EditBeoApproval::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount([
            'beoApprovals as total_approvals_count',
            'beoApprovals as verified_approvals_count' => fn (Builder $q) => $q->where('is_verify', 1),
        ]);
    }
}
