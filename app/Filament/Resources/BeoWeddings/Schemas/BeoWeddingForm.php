<?php

namespace App\Filament\Resources\BeoWeddings\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\ToolbarButtonGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
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

class BeoWeddingForm
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
                            Select::make('client_wedding_id')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->noOptionsMessage('No client available.')
                                ->noSearchResultsMessage('No client found.')
                                ->relationship('client', 'pic')
                                ->createOptionForm([
                                    TextInput::make('guest_number')
                                        ->unique(ignoreRecord: true)
                                        ->default(function () {
                                            $total = \App\Models\ClientWedding::count() + 1;

                                            return str_pad($total, 6, '0', STR_PAD_LEFT);
                                        })
                                        ->required(),
                                    TextInput::make('pic')
                                        ->label('PIC')
                                        ->required(),
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
                            Select::make('makeUps')
                                ->label('Make Up Venues')
                                ->relationship('weddingMakeUps', 'name')
                                ->multiple()
                                ->preload()
                                ->required(),
                        ]),
                    Step::make('Package & Function')
                        ->icon(Heroicon::ArchiveBox)
                        ->schema([
                            Repeater::make('packages')
                                ->hiddenLabel()
                                ->columns(2)
                                ->relationship('beoWeddingPackages')
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
                                                return $query->where('type', 'wedding');
                                            }
                                        )
                                        ->live(),
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
                                ])
                                ->addActionLabel('Add Package')
                                ->minItems(1)
                                ->itemLabel('Package Item')
                                ->itemNumbers(),
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
                                                'venue_id' => $p['venue_id'] ?? null,
                                                'setup_id' => $p['setup_id'] ?? null,
                                                'pax' => $pax,
                                                'time_start' => '00:00:00',
                                                'time_end' => '00:00:00',
                                            ];
                                        }
                                    }

                                    $set('beoWeddingFunctions', $functionItems);
                                }),
                            Repeater::make('beoWeddingFunctions')
                                ->hiddenLabel()
                                ->columns(2)
                                ->relationship('beoWeddingFunctions')
                                ->schema([
                                    Select::make('function_id')
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->noOptionsMessage('No function available.')
                                        ->noSearchResultsMessage('No function found.')
                                        ->relationship(
                                            name: 'function',
                                            titleAttribute: 'name',
                                            modifyQueryUsing: function (Builder $query) {
                                                return $query->where('type', 'wedding');
                                            }
                                        ),
                                    TextInput::make('pax')
                                        ->numeric()
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
                                        ->native(false)
                                        ->default('00:00:00')
                                        ->timezone('Asia/Jakarta')
                                        ->required()
                                        ->before('time_end'),
                                    TimePicker::make('time_end')
                                        ->native(false)
                                        ->default('00:00:01')
                                        ->timezone('Asia/Jakarta')
                                        ->required()
                                        ->after('time_start')
                                        ->rule(new \App\Rules\NoScheduleConflict($formData)),
                                    Repeater::make('beoWeddingAdditionalMeals')
                                        ->columnSpanFull()
                                        ->table([
                                            TableColumn::make('Menu Name'),
                                            TableColumn::make('Pax'),
                                            TableColumn::make('Rate'),
                                            TableColumn::make('Remark')
                                        ])
                                        ->label('Additional Meal List')
                                        ->relationship('beoWeddingAdditionalMeals')
                                        ->reorderable(false)
                                        ->schema([
                                            TextInput::make('menu_name')
                                                ->required(),
                                            TextInput::make('pax')
                                                ->numeric()
                                                ->placeholder('0')
                                                ->required(),
                                            TextInput::make('rate')
                                                ->numeric()
                                                ->prefix('Rp')
                                                ->required(),
                                            TextInput::make('remark'),
                                        ])
                                        ->minItems(0)
                                        ->defaultItems(0)
                                        ->addActionLabel('Add Additional Meal')
                                        ->addActionAlignment(Alignment::Start),
                                    Textarea::make('free_meal')
                                        ->columnSpanFull()
                                        ->label('Free Meal List'),
                                ])
                                ->addActionLabel('Add Function')
                                ->minItems(1)
                                ->itemLabel('Function Item')
                                ->itemNumbers(),
                        ]),
                    Step::make('Wedding Main Menu')
                        ->icon(Heroicon::Cake)
                        ->columns(1)
                        ->schema([
                            Select::make('banquet')
                                ->required()
                                ->live()
                                ->options([
                                    'no meals' => 'No Meals',
                                    'request' => 'Request',
                                    'as per chef' => 'As Per Chef',
                                ]),
                            RichEditor::make('menu_list')
                                ->label('Menu List')
                                ->toolbarButtons([
                                    [ToolbarButtonGroup::make('Font', ['bold', 'italic', 'underline', 'strike'])],
                                    [ToolbarButtonGroup::make('Paragraph', ['paragraph', 'h1', 'h2', 'h3'])],
                                    [ToolbarButtonGroup::make('Alignment', ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'])],
                                    ['bulletList', 'orderedList'],
                                ]),
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
                                RichEditor::make('payment_note')
                                    ->toolbarButtons([
                                        [ToolbarButtonGroup::make('Font', ['bold', 'italic', 'underline', 'strike'])],
                                        [ToolbarButtonGroup::make('Paragraph', ['paragraph', 'h1', 'h2', 'h3'])],
                                        [ToolbarButtonGroup::make('Alignment', ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'])],
                                        ['bulletList', 'orderedList'],
                                    ]),
                            ])
                        ]),
                    Step::make('Posting Breakdown')
                        ->icon(Heroicon::Square3Stack3d)
                        ->columns(1)
                        ->schema([
                            TextInput::make('deposit')
                                ->placeholder('0')
                                ->numeric()
                                ->prefix('Rp'),
                            Repeater::make('hotelPostings')
                                ->label('Hotel Posting')
                                ->columns(2)
                                ->relationship('beoWeddingBreakdownPostings', function (\Illuminate\Database\Eloquent\Builder $query) {
                                    $query->where('revenue_type', 'hotel');
                                })
                                ->mutateRelationshipDataBeforeCreateUsing(function (array $data) {
                                    $data['revenue_type'] = 'hotel';

                                    return $data;
                                })
                                ->mutateRelationshipDataBeforeSaveUsing(function (array $data) {
                                    $data['revenue_type'] = 'hotel';

                                    return $data;
                                })
                                ->table([
                                    TableColumn::make('Name'),
                                    TableColumn::make('Amount'),
                                    TableColumn::make('Rate'),
                                    TableColumn::make('Remark'),
                                ])
                                ->schema([
                                    TextInput::make('name')
                                        ->required(),
                                    TextInput::make('amount')
                                        ->placeholder('0')
                                        ->numeric()
                                        ->required(),
                                    TextInput::make('rate')
                                        ->placeholder('0')
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->required(),
                                    TextInput::make('remark'),
                                ])
                                ->reorderable(false)
                                ->minItems(0)
                                ->defaultItems(0)
                                ->addActionLabel('Add Hotel Posting')
                                ->itemLabel('Hotel Posting Item')
                                ->itemNumbers(),
                            Repeater::make('roomPostings')
                                ->label('Room Posting')
                                ->columns(2)
                                ->relationship('beoWeddingBreakdownPostings', function (\Illuminate\Database\Eloquent\Builder $query) {
                                    $query->where('revenue_type', 'room');
                                })
                                ->mutateRelationshipDataBeforeCreateUsing(function (array $data) {
                                    $data['revenue_type'] = 'room';

                                    return $data;
                                })
                                ->mutateRelationshipDataBeforeSaveUsing(function (array $data) {
                                    $data['revenue_type'] = 'room';

                                    return $data;
                                })
                                ->table([
                                    \Filament\Forms\Components\Repeater\TableColumn::make('Name'),
                                    \Filament\Forms\Components\Repeater\TableColumn::make('Amount'),
                                    \Filament\Forms\Components\Repeater\TableColumn::make('Rate'),
                                    \Filament\Forms\Components\Repeater\TableColumn::make('Remark'),
                                ])
                                ->schema([
                                    TextInput::make('name')
                                        ->required(),
                                    TextInput::make('amount')
                                        ->placeholder('0')
                                        ->numeric()
                                        ->required(),
                                    TextInput::make('rate')
                                        ->placeholder('0')
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->required(),
                                    TextInput::make('remark'),
                                ])
                                ->reorderable(false)
                                ->minItems(0)
                                ->defaultItems(0)
                                ->addActionLabel('Add Room Posting')
                                ->itemLabel('Room Posting Item')
                                ->itemNumbers(),
                            Repeater::make('vendorPostings')
                                ->label('Vendor Posting')
                                ->columns(2)
                                ->relationship('beoWeddingBreakdownPostings', function (\Illuminate\Database\Eloquent\Builder $query) {
                                    $query->where('revenue_type', 'vendor');
                                })
                                ->mutateRelationshipDataBeforeCreateUsing(function (array $data) {
                                    $data['revenue_type'] = 'vendor';

                                    return $data;
                                })
                                ->mutateRelationshipDataBeforeSaveUsing(function (array $data) {
                                    $data['revenue_type'] = 'vendor';

                                    return $data;
                                })
                                ->table([
                                    \Filament\Forms\Components\Repeater\TableColumn::make('Name'),
                                    \Filament\Forms\Components\Repeater\TableColumn::make('Amount'),
                                    \Filament\Forms\Components\Repeater\TableColumn::make('Rate'),
                                    \Filament\Forms\Components\Repeater\TableColumn::make('Remark'),
                                ])
                                ->schema([
                                    TextInput::make('name')
                                        ->required(),
                                    TextInput::make('amount')
                                        ->placeholder('0')
                                        ->numeric()
                                        ->required(),
                                    TextInput::make('rate')
                                        ->placeholder('0')
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->required(),
                                    TextInput::make('remark'),
                                ])
                                ->reorderable(false)
                                ->minItems(0)
                                ->defaultItems(0)
                                ->addActionLabel('Add Vendor Posting')
                                ->itemLabel('Vendor Posting Item')
                                ->itemNumbers(),
                        ])
                ])
                    ->skippable(),
            ]);
    }
}
