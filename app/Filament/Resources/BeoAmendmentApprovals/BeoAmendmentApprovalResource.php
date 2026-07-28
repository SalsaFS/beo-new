<?php

namespace App\Filament\Resources\BeoAmendmentApprovals;

use App\Filament\Resources\BeoAmendmentApprovals\Pages\EditBeoAmendmentApproval;
use App\Filament\Resources\BeoAmendmentApprovals\Pages\ListBeoAmendmentApprovals;
use App\Filament\Resources\BeoAmendmentApprovals\Schemas\BeoAmendmentApprovalForm;
use App\Filament\Resources\BeoAmendmentApprovals\Tables\BeoAmendmentApprovalsTable;
use App\Models\BeoAmendment;
use BackedEnum;
use Filament\Resources\Resource;
use UnitEnum;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BeoAmendmentApprovalResource extends Resource
{
    protected static ?string $model = BeoAmendment::class;

    protected static ?string $navigationLabel = 'Amendment Approvals';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Core';

    protected static ?int $navigationSort = 10;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('admin') || auth()->user()?->hasRole('super-admin');
    }

    public static function form(Schema $schema): Schema
    {
        return BeoAmendmentApprovalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BeoAmendmentApprovalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBeoAmendmentApprovals::route('/'),
            'edit' => EditBeoAmendmentApproval::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount([
            'beoAmendmentApprovals as total_approvals_count',
            'beoAmendmentApprovals as verified_approvals_count' => fn (Builder $q) => $q->where('is_verify', 1),
        ]);
    }
}
