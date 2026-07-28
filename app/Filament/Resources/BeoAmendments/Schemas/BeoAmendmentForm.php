<?php

namespace App\Filament\Resources\BeoAmendments\Schemas;

use App\Models\Beo;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\ToolbarButtonGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class BeoAmendmentForm
{
    public static function configure(Schema $schema): Schema
    {
        $formData = fn(): array => (app('livewire')->current()->data ?? []);

        return $schema
            ->columns(1)
            ->components([
                Wizard::make([
                    Step::make('Details')
                        ->icon(Heroicon::Document)
                        ->schema([
                            Select::make('beo_id')
                                ->label('Event Number')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->noOptionsMessage('No beo available.')
                                ->noSearchResultsMessage('No beo found.')
                                ->relationship('beo', 'event_number')
                                ->afterStateUpdated(function (callable $set, ?string $state) {
                                    $beo = Beo::with(['beoPackages.internalBreakdowns', 'client', 'user'])->find($state);

                                    $breakdowns = $beo ? $beo->beoPackages
                                        ->map(function ($pkg) {
                                            $ibs = $pkg->internalBreakdowns->map(function ($i) {
                                                return [
                                                    'name' => $i->name ?? '',
                                                    'pax' => $i->pax ?? '',
                                                    'rate' => $i->rate ?? '',
                                                    'remark' => $i->remark ?? '',
                                                ];
                                            })->all();

                                            return [
                                                'package_id' => $pkg->package_id ?? null,
                                                'pax' => $pkg->pax ?? '',
                                                'venue_id' => $pkg->venue_id ?? null,
                                                'setup_id' => $pkg->setup_id ?? null,
                                                'billing_type' => $pkg->billing_type ?? null,
                                                'amendmentBreakdowns' => $ibs,
                                            ];
                                        })
                                        ->all()
                                        : [];

                                    $set('beoAmendmentPackages', $breakdowns);

                                    if ($beo) {
                                        $set('name_of_event', $beo->client->company);
                                        $set('contact_person', $beo->client->pic);
                                        $set('contact', $beo->client->mobile);
                                        $set('date_change', $beo->date_of_function);
                                    }
                                })
                                ->live(),
                            Action::make('detail_beo')
                                ->label('Detail Beo')
                                ->link()
                                ->icon(Heroicon::Eye)
                                ->modalHeading('Detail Beo')
                                ->disabled(fn(callable $get) => blank($get('beo_id')))
                                ->color(fn(callable $get) => blank($get('beo_id')) ? 'gray' : 'primary')
                                ->infolist(function (callable $get) {
                                    $beo = Beo::find($get('beo_id'));

                                    if (!$beo) {
                                        return [
                                            TextEntry::make('error')
                                                ->hiddenLabel()
                                                ->state('Choose beo first.')
                                        ];
                                    }
                                    return [
                                        Grid::make(2)
                                            ->inlineLabel(true)
                                            ->schema([
                                                TextEntry::make('event_number')
                                                    ->label('Event Number')
                                                    ->state($beo->event_number),
                                                TextEntry::make('company')
                                                    ->label('Company')
                                                    ->state($beo->client->company),
                                                TextEntry::make('pic')
                                                    ->label('PIC')
                                                    ->state($beo->client->pic),
                                                TextEntry::make('date_of_function')
                                                    ->label('Day/Date/Time of Function')
                                                    ->state($beo->date_of_function),
                                                TextEntry::make('package')
                                                    ->label('Package')
                                                    ->state($beo->beoPackages->pluck('package.name')->implode(' & ')),
                                                TextEntry::make('user_id')
                                                    ->label('In House Contact')
                                                    ->state($beo->user->name),
                                            ])
                                    ];
                                })
                                ->modalSubmitAction(false)
                                ->modalCancelActionLabel('Tutup'),
                            TextInput::make('name_of_event')
                                ->required(),
                            TextInput::make('contact_person')
                                ->required(),
                            TextInput::make('contact')
                                ->required(),
                            DatePicker::make('date_change')
                                ->displayFormat('d/m/Y')
                                ->native(false)
                                ->suffixIcon(Heroicon::Calendar)
                                ->closeOnDateSelection()
                                ->required(),
                        ]),
                    Step::make('Package')
                        ->icon(Heroicon::ArchiveBox)
                        ->schema([
                            Repeater::make('beoAmendmentPackages')
                                ->hiddenLabel()
                                ->columns(2)
                                ->relationship('beoAmendmentPackages')
                                ->schema([
                                    Select::make('package_id')
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->noOptionsMessage('No package available.')
                                        ->noSearchResultsMessage('No package found.')
                                        ->relationship(
                                            name: 'package',
                                            titleAttribute: 'name',
                                            modifyQueryUsing: function (Builder $query) {
                                                return $query->where('type', 'meeting');
                                            }
                                        )
                                        ->columnSpanFull(),
                                    Select::make('venue_id')
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->noOptionsMessage('No venue available.')
                                        ->noSearchResultsMessage('No venue found.')
                                        ->createOptionForm([
                                            TextInput::make('name')
                                                ->required(),
                                        ])
                                        ->relationship('venue', 'name'),
                                    Select::make('setup_id')
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->noOptionsMessage('No set up available.')
                                        ->noSearchResultsMessage('No set up found.')
                                        ->createOptionForm([
                                            TextInput::make('name')
                                                ->required(),
                                        ])
                                        ->relationship('setup', 'name'),
                                    TextInput::make('pax')
                                        ->numeric()
                                        ->required(),
                                    Select::make('billing_type')
                                        ->required()
                                        ->default('online')
                                        ->options([
                                            'online' => 'Online',
                                            'offline' => 'Offline'
                                        ]),
                                    Repeater::make('amendmentBreakdowns')
                                        ->relationship('amendmentBreakdowns')
                                        ->columnSpanFull()
                                        ->table([
                                            TableColumn::make('name'),
                                            TableColumn::make('pax'),
                                            TableColumn::make('rate'),
                                            TableColumn::make('remark'),
                                        ])
                                        ->schema([
                                            TextInput::make('name')
                                                ->required(),
                                            TextInput::make('pax')
                                                ->placeholder('0')
                                                ->required(),
                                            TextInput::make('rate')
                                                ->required()
                                                ->placeholder('0')
                                                ->numeric()
                                                ->prefix('Rp'),
                                            TextInput::make('remark'),
                                        ])
                                        ->reorderable(false)
                                        ->minItems(1)
                                        ->addActionLabel('Add Internal Breakdown')
                                        ->addActionAlignment(Alignment::End)
                                        ->reorderable(false),
                                ])
                                ->addActionLabel('Add Package')
                                ->minItems(1)
                                ->itemLabel('Package Item')
                                ->itemNumbers(),
                        ]),
                    Step::make('Amendment Detail')
                        ->icon(Heroicon::DocumentCheck)
                        ->columns(1)
                        ->schema([
                            Action::make('syncPackages')
                                ->label('Sync Data')
                                ->icon(Heroicon::ArrowPath)
                                ->color('primary')
                                ->action(function (Get $get, Set $set) {
                                    $packages = $get('beoAmendmentPackages')
                                        ?? (app('livewire')->current()->data['beoAmendmentPackages'] ?? []);

                                    if (!is_array($packages)) {
                                        $packages = [];
                                    }

                                    $hasPackage = false;

                                    foreach ($packages as $p) {
                                        if (filled($p['package_id'] ?? null)) {
                                            $hasPackage = true;
                                            break;
                                        }
                                    }

                                    if (!$hasPackage) {
                                        \Filament\Notifications\Notification::make()
                                            ->title('Package is empty.')
                                            ->warning()
                                            ->send();

                                        return;
                                    }

                                    $names = [];
                                    $functionItems = [];

                                    foreach ($packages as $p) {
                                        $packageId = $p['package_id'] ?? null;

                                        if (blank($packageId)) {
                                            continue;
                                        }

                                        $package = \App\Models\Package::find($packageId);

                                        if (!$package) {
                                            continue;
                                        }

                                        $names[] = $package->name;
                                        $pax = $p['pax'] ?? null;

                                        foreach ($package->packageBreakdowns()->with('function')->get() as $breakdown) {
                                            $functionItems[] = [
                                                'function_id' => $breakdown->function_id,
                                                'venue_id' => null,
                                                'setup_id' => null,
                                                'pax' => $pax,
                                                'banquet' => null,
                                                'time_start' => '00:00:00',
                                                'time_end' => '00:00:00',
                                            ];
                                        }
                                    }

                                    $mergedName = implode(' & ', $names);
                                    $functionPackageItems = [];

                                    foreach ($packages as $p) {
                                        if (blank($p['package_id'] ?? null)) {
                                            continue;
                                        }

                                        $functionPackageItems[] = [
                                            'name' => $mergedName,
                                            'venue_id' => $p['venue_id'] ?? null,
                                            'setup_id' => $p['setup_id'] ?? null,
                                            'pax' => $p['pax'] ?? null,
                                            'time_start' => '00:00:00',
                                            'time_end' => '00:00:00',
                                        ];
                                    }

                                    $set('beoFunctionPackages', $functionPackageItems);
                                    $set('beoFunctions', $functionItems);

                                    // Populate other_before from DB (original BEO packages)
                                    $beo = Beo::with('beoPackages.package', 'beoPackages.internalBreakdowns')->find($get('beo_id'));

                                    if ($beo && $beo->beoPackages->isNotEmpty()) {
                                        $grouped = $beo->beoPackages->groupBy('billing_type');
                                        $html = '';

                                        foreach (['online' => 'FB Online Billing', 'offline' => 'FB Offline Billing'] as $type => $label) {
                                            $items = $grouped->get($type);

                                            if (!$items || $items->isEmpty()) {
                                                continue;
                                            }

                                            $html .= '<h5><strong>' . e($label) . '</strong></h5>';

                                            foreach ($items as $pkg) {
                                                $totalInternal = 0;

                                                foreach ($pkg->internalBreakdowns as $i) {
                                                    $totalInternal += $i->rate;
                                                }

                                                $total = $totalInternal * $pkg->pax;
                                                $totalInternal = number_format($totalInternal, 0, ',', '.');
                                                $total = number_format($total, 0, ',', '.');

                                                $html .= '<p><i>';
                                                $html .= '<strong>' . e($pkg->package->name) . '</strong><br>';
                                                $html .= 'Rp ' . e($totalInternal) . ' x ' . e($pkg->pax) . ' = ' . 'Rp ' . e($total);
                                                $html .= '</i></p>';
                                            }
                                        }

                                        $set('other_before', $html);
                                    }

                                    // Populate other_after from form data (amendment packages)
                                    $groupedAfter = collect($packages)->groupBy('billing_type');
                                    $htmlAfter = '';

                                    foreach (['online' => 'FB Online Billing', 'offline' => 'FB Offline Billing'] as $type => $label) {
                                        $items = $groupedAfter->get($type);

                                        if (!$items || $items->isEmpty()) {
                                            continue;
                                        }

                                        $htmlAfter .= '<h5><strong>' . e($label) . '</strong></h5>';

                                        foreach ($items as $pkg) {
                                            $totalInternal = 0;

                                            foreach (($pkg['amendmentBreakdowns'] ?? []) as $i) {
                                                $totalInternal += $i['rate'] ?? 0;
                                            }

                                            $pax = $pkg['pax'] ?? 0;
                                            $total = $totalInternal * $pax;

                                            $packageModel = \App\Models\Package::find($pkg['package_id'] ?? null);
                                            $packageName = $packageModel ? $packageModel->name : 'Unknown';

                                            $htmlAfter .= '<p><i>';
                                            $htmlAfter .= '<strong>' . e($packageName) . '</strong><br>';
                                            $htmlAfter .= 'Rp ' . e(number_format($totalInternal, 0, ',', '.')) . ' x ' . e($pax) . ' = Rp ' . e(number_format($total, 0, ',', '.'));
                                            $htmlAfter .= '</i></p>';
                                        }
                                    }

                                    $set('other_after', $htmlAfter);
                                }),
                            Group::make([
                                RichEditor::make('other_before')
                                    ->label('Before')
                                    ->toolbarButtons([
                                        [ToolbarButtonGroup::make('Font', ['bold', 'italic', 'underline', 'strike'])],
                                        [ToolbarButtonGroup::make('Paragraph', ['paragraph', 'h1', 'h2', 'h3'])],
                                        [ToolbarButtonGroup::make('Alignment', ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'])],
                                        ['bulletList', 'orderedList'],
                                    ])
                                    ->default(''),
                                RichEditor::make('other_after')
                                    ->label('After')
                                    ->toolbarButtons([
                                        [ToolbarButtonGroup::make('Font', ['bold', 'italic', 'underline', 'strike'])],
                                        [ToolbarButtonGroup::make('Paragraph', ['paragraph', 'h1', 'h2', 'h3'])],
                                        [ToolbarButtonGroup::make('Alignment', ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'])],
                                        ['bulletList', 'orderedList'],
                                    ]),
                            ])
                                ->columns(2),

                        ]),
                ])
                    ->skippable(),
            ]);
    }
}
