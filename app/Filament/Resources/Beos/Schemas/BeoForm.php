<?php

namespace App\Filament\Resources\Beos\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\ToolbarButtonGroup;
use Filament\Forms\Components\TimePicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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
use function Laravel\Prompts\textarea;

class BeoForm
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
                            Select::make('client_beo_id')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->noOptionsMessage('No client available.')
                                ->noSearchResultsMessage('No client found.')
                                ->relationship('client', 'company')
                                ->createOptionForm([
                                    TextInput::make('guest_number')
                                        ->unique(ignoreRecord: true)
                                        ->required(),
                                    Group::make([
                                        TextInput::make('company')
                                            ->required(),
                                        TextInput::make('pic')
                                            ->label('PIC')
                                            ->required(),
                                    ])
                                        ->columns(2),
                                    Textarea::make('address')
                                        ->columnSpanFull(),
                                    Group::make([
                                        TextInput::make('mobile'),
                                        TextInput::make('telephone')
                                            ->tel(),
                                    ])
                                        ->columns(2),
                                ])
                                ->live(),
                            Action::make('detail_client')
                                ->label('Detail Client')
                                ->link()
                                ->icon(Heroicon::Eye)
                                ->modalHeading('Detail Client')
                                ->disabled(fn(callable $get) => blank($get('client_beo_id')))
                                ->color(fn(callable $get) => blank($get('client_beo_id')) ? 'gray' : 'primary')
                                ->infolist(function (callable $get) {
                                    $client = \App\Models\ClientBeo::find($get('client_beo_id'));

                                    if (!$client) {
                                        return [
                                            TextEntry::make('error')
                                                ->hiddenLabel()
                                                ->state('Choose client first.')
                                        ];
                                    }
                                    return [
                                        Grid::make(2)
                                            ->inlineLabel(true)
                                            ->schema([
                                                TextEntry::make('guest_number')
                                                    ->label('Guest Number')
                                                    ->state($client->guest_number),

                                                TextEntry::make('company')
                                                    ->label('Company')
                                                    ->state($client->company),

                                                TextEntry::make('pic')
                                                    ->label('PIC')
                                                    ->state($client->pic),

                                                TextEntry::make('address')
                                                    ->label('Address')
                                                    ->state($client->address),

                                                TextEntry::make('mobile')
                                                    ->label('Mobile')
                                                    ->state($client->mobile),

                                                TextEntry::make('telephone')
                                                    ->label('Telephone')
                                                    ->state($client->telephone),
                                            ])
                                    ];
                                })
                                ->modalSubmitAction(false)
                                ->modalCancelActionLabel('Tutup'),
                            TextInput::make('event_number')
                                ->unique(ignoreRecord: true)
                                ->required(),
                            DatePicker::make('date_of_function')
                                ->displayFormat('d/m/Y')
                                ->native(false)
                                ->suffixIcon(Heroicon::Calendar)
                                ->closeOnDateSelection()
                                ->required(),
                            Select::make('user_id')
                                ->label('In House Contact')
                                ->searchable()
                                ->preload()
                                ->noOptionsMessage('No sales available.')
                                ->noSearchResultsMessage('No sales found.')
                                ->required()
                                ->relationship(
                                    name: 'user',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: function (Builder $query) {
                                        $query->whereHas('roles', function (Builder $q) {
                                            $q->where('name', 'sales');
                                        });
                                    }
                                ),
                            TextInput::make('guaranteed')
                                ->required()
                                ->live()
                                ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                    $packages = $get('packages') ?? [];

                                    foreach (array_keys($packages) as $i) {
                                        $set("packages.{$i}.pax", $state);
                                    }
                                }),
                        ]),
                    Step::make('Package')
                        ->icon(Heroicon::ArchiveBox)
                        ->schema([
                            Repeater::make('packages')
                                ->hiddenLabel()
                                ->columns(2)
                                ->relationship('beoPackages')
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
                                        ->live()
                                        ->afterStateUpdated(function (callable $set, ?string $state) {
                                            $package = \App\Models\Package::find($state);

                                            $breakdowns = $package
                                                ? $package->packageBreakdowns()
                                                    ->with('function')
                                                    ->get()
                                                    ->map(function ($breakdown) {
                                                        return [
                                                            'name' => $breakdown->function?->name ?? '',
                                                            'pax' => 1,
                                                            'rate' => null,
                                                            'remark' => null,
                                                        ];
                                                    })
                                                    ->all()
                                                : [];

                                            $set('internalBreakdowns', $breakdowns);
                                        })
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
                                        ->default(function () {
                                            return app('livewire')->current()->data['guaranteed'] ?? null;
                                        })
                                        ->numeric()
                                        ->required(),
                                    Select::make('billing_type')
                                        ->required()
                                        ->default('online')
                                        ->options([
                                            'online' => 'Online',
                                            'offline' => 'Offline'
                                        ]),
                                    Repeater::make('internalBreakdowns')
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
                    Step::make('Function')
                        ->icon(Heroicon::TableCells)
                        ->schema([
                            Action::make('syncPackages')
                                ->label('Sync from Packages')
                                ->icon(Heroicon::ArrowPath)
                                ->color('primary')
                                ->action(function (Get $get, Set $set) {
                                    $packages = $get('packages')
                                        ?? (app('livewire')->current()->data['packages'] ?? []);

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
                                                'time_end' => '00:00:01',
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
                                            'time_end' => '00:00:01',
                                        ];
                                    }

                                    $set('beoFunctionPackages', $functionPackageItems);
                                    $set('beoFunctions', $functionItems);
                                }),
                            Repeater::make('beoFunctionPackages')
                                ->hiddenLabel()
                                ->columns(2)
                                ->relationship('beoFunctionPackages')
                                ->schema([
                                    TextInput::make('name')
                                        ->required(),
                                    TextInput::make('pax')
                                        ->placeholder('0')
                                        ->required(),
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
                                    TimePicker::make('time_start')
                                        ->default('00:00:00')
                                        ->timezone('Asia/Jakarta')
                                        ->required()
                                        ->before('time_end'),
                                    TimePicker::make('time_end')
                                        ->default('00:00:01')
                                        ->timezone('Asia/Jakarta')
                                        ->required()
                                        ->after('time_start')
                                        ->rule(new \App\Rules\NoScheduleConflict($formData)),
                                ])
                                ->addActionLabel('Add Function Package')
                                ->minItems(1)
                                ->itemLabel('Function Package Item')
                                ->itemNumbers(),
                            Repeater::make('beoFunctions')
                                ->hiddenLabel()
                                ->columns(2)
                                ->relationship('beoFunctions')
                                ->schema([
                                    Select::make('function_id')
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->noOptionsMessage('No function available.')
                                        ->noSearchResultsMessage('No function found.')
                                        ->columnSpanFull()
                                        ->relationship(
                                            name: 'function',
                                            titleAttribute: 'name',
                                            modifyQueryUsing: function (Builder $query) {
                                                return $query->where('type', 'meeting');
                                            }
                                        ),
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
                                    TimePicker::make('time_start')
                                        ->default('00:00:00')
                                        ->timezone('Asia/Jakarta')
                                        ->required()
                                        ->before('time_end'),
                                    TimePicker::make('time_end')
                                        ->default('00:00:01')
                                        ->timezone('Asia/Jakarta')
                                        ->required()
                                        ->after('time_start')
                                        ->rule(new \App\Rules\NoScheduleConflict($formData)),
                                    TextInput::make('pax')
                                        ->numeric()
                                        ->required(),
                                    Select::make('banquet')
                                        ->required()
                                        ->live()
                                        ->options([
                                            'no meals' => 'No Meals',
                                            'request' => 'Request',
                                            'as per chef' => 'As Per Chef',
                                        ]),
                                    Textarea::make('addon')
                                        ->label('Menu Addon')
                                        ->columnSpanFull()
                                        ->visible(function (Get $get) {
                                            return $get('banquet') == 'request';
                                        }),
                                    Repeater::make('beoMenus')
                                        ->columnSpanFull()
                                        ->table([
                                            TableColumn::make('Menu Name'),
                                            TableColumn::make('Pax')
                                        ])
                                        ->label('Menu List')
                                        ->relationship('beoMenus')
                                        ->columns(2)
                                        ->reorderable(false)
                                        ->visible(function (Get $get) {
                                            return $get('banquet') == 'request';
                                        })
                                        ->schema([
                                            Select::make('menu_id')
                                                ->label('Menu')
                                                ->relationship('menu', 'name')
                                                ->required()
                                                ->createOptionForm([
                                                    TextInput::make('name')
                                                        ->required(),
                                                    Grid::make(2)
                                                        ->schema([
                                                            Select::make('menu_code_id')
                                                                ->relationship('menuCode', 'name')
                                                                ->createOptionForm([
                                                                    TextInput::make('name')
                                                                        ->required(),
                                                                ])
                                                                ->preload()
                                                                ->searchable()
                                                                ->required(),
                                                            TextInput::make('menu_code_number')
                                                                ->unique(ignoreRecord: true)
                                                                ->required(),
                                                        ]),
                                                    Grid::make(2)
                                                        ->schema([
                                                            Select::make('menu_type_id')
                                                                ->relationship('menuType', 'name')
                                                                ->createOptionForm([
                                                                    TextInput::make('name')
                                                                        ->required(),
                                                                ])
                                                                ->preload()
                                                                ->searchable()
                                                                ->required(),
                                                            Select::make('menu_sub_type_id')
                                                                ->relationship('menuSubType', 'name')
                                                                ->createOptionForm([
                                                                    TextInput::make('name')
                                                                        ->required(),
                                                                ])
                                                                ->preload()
                                                                ->searchable()
                                                                ->required(),
                                                        ]),
                                                ]),
                                            TextInput::make('pax')
                                                ->numeric()
                                                ->placeholder('0')
                                                ->required(),
                                        ])
                                        ->minItems(0)
                                        ->defaultItems(0)
                                        ->addActionLabel('Add Menu')
                                        ->addActionAlignment(Alignment::Start),

                                ])
                                ->addActionLabel('Add Function')
                                ->minItems(1)
                                ->itemLabel('Function Item')
                                ->itemNumbers(),
                        ]),
                    Step::make('Note')
                        ->icon(Heroicon::DocumentCheck)
                        ->columns(2)
                        ->schema([
                            TextInput::make('signed')
                                ->columnSpanFull(),
                            RichEditor::make('setup_arrangements')
                                ->label('Set Up & Arrangements')
                                ->toolbarButtons([
                                    [ToolbarButtonGroup::make('Font', ['bold', 'italic', 'underline', 'strike'])],
                                    [ToolbarButtonGroup::make('Paragraph', ['paragraph', 'h1', 'h2', 'h3'])],
                                    [ToolbarButtonGroup::make('Alignment', ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'])],
                                    ['bulletList', 'orderedList'],
                                ])
                                ->default('
                                    <p><strong>BANQUET &amp; FB DEPARTMENT</strong></p>
                                    <ul>
                                        <li>Please set up Roundtable</li>
                                        <li>Please set up Headtable (3pax)</li>
                                        <li>Please test first all equipment before the meeting begin</li>
                                        <li>Please prepare cable extention and make sure WIFI connection stable</li>
                                        <li>Please arrange staff incharge during the event</li>
                                        <li>Please set up Registration Desk</li>
                                        <li>Set up LCD and proyektor, flipchart</li>
                                        <li>Please setup notepad, pencil, candy</li>
                                    </ul>
                                    <p><strong>FOOD &amp; BEVERAGE PRODUCT</strong></p>
                                    <ul>
                                        <li>Please prepare equipment as necessary</li>
                                        <li>Please make sure all the items ready 30 minutes before the event</li>
                                        <li>Please arrange staff incharge during the event</li>
                                    </ul>
                                    <p><strong>FRONT OFFICE</strong></p>
                                    <ul>
                                        <li>Please assist the guest/participants if they need information</li>
                                    </ul>
                                    <p><strong>HOUSEKEEPING</strong></p>
                                    <ul>
                                        <li>Please make sure the cleanliness the venue</li>
                                        <li>Please make sure the cleanliness for rest room</li>
                                    </ul>
                                    <p><strong>ENGINEERING</strong></p>
                                    <ul>
                                        <li>Please make sure AC and electricity running well and proper</li>
                                        <li>Please do test first for all equipment</li>
                                        <li>Please setup 2 Mic Wireless + 2 Cable Mic &#10003;</li>
                                    </ul>
                                    <p><strong>SECURITY</strong></p>
                                    <ul>
                                        <li>Please prepare parking space</li>
                                    </ul>
                                '),
                            Group::make([
                                RichEditor::make('note')
                                    ->toolbarButtons([
                                        [ToolbarButtonGroup::make('Font', ['bold', 'italic', 'underline', 'strike'])],
                                        [ToolbarButtonGroup::make('Paragraph', ['paragraph', 'h1', 'h2', 'h3'])],
                                        [ToolbarButtonGroup::make('Alignment', ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'])],
                                        ['bulletList', 'orderedList'],
                                    ]),
                                RichEditor::make('other_note')
                                    ->toolbarButtons([
                                        [ToolbarButtonGroup::make('Font', ['bold', 'italic', 'underline', 'strike'])],
                                        [ToolbarButtonGroup::make('Paragraph', ['paragraph', 'h1', 'h2', 'h3'])],
                                        [ToolbarButtonGroup::make('Alignment', ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'])],
                                        ['bulletList', 'orderedList'],
                                    ]),
                            ])
                        ]),
                    Step::make('Additional')
                        ->icon(Heroicon::Plus)
                        ->columns(1)
                        ->schema([
                            Repeater::make('additionalBreakdowns')
                                ->table([
                                    TableColumn::make('Item Name'),
                                    TableColumn::make('Billing Type'),
                                    TableColumn::make('Rate'),
                                    TableColumn::make('Remark'),
                                ])
                                ->schema([
                                    TextInput::make('name')
                                        ->required(),
                                    Select::make('billing_type')
                                        ->required()
                                        ->default('online')
                                        ->options([
                                            'online' => 'Online',
                                            'offline' => 'Offline'
                                        ]),
                                    TextInput::make('rate')
                                        ->placeholder('0')
                                        ->numeric()
                                        ->prefix('Rp'),
                                    TextInput::make('remark'),
                                ])
                                ->reorderable(false)
                                ->minItems(0)
                                ->defaultItems(0)
                                ->addActionLabel('Add')
                                ->itemLabel('Additional Item')
                                ->itemNumbers()
                        ])
                ])
                    ->skippable(),
            ]);
    }
}
