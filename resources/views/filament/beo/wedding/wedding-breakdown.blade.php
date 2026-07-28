@php
    $record = $getRecord();
    $colors = ['#e0f2fe', '#fef3c7', '#dcfce7', '#f3e8ff', '#ffe4e6', '#f1f5f9'];
@endphp

<style>
    .dark .wbd-wrap table { border-color: #374151 !important; }
    .dark .wbd-wrap td, .dark .wbd-wrap th { border-color: #374151 !important; }
    .dark .wbd-wrap h4 { color: #f3f4f6 !important; }
    .dark .wbd-wrap tbody tr { color: #d1d5db !important; }
    .dark .wbd-wrap .wbd-total { background-color: #1f2937 !important; color: #e5e7eb !important; }
    .dark .wbd-wrap .wbd-additional-header { background-color: #b45309 !important; color: #fff !important; }
    .dark .wbd-wrap .wbd-additional-header th { background-color: #b45309 !important; color: #fff !important; }
    .dark .wbd-wrap .wbd-c0 { background-color: #075985 !important; color: #e0f2fe !important; }
    .dark .wbd-wrap .wbd-c1 { background-color: #78350f !important; color: #fef3c7 !important; }
    .dark .wbd-wrap .wbd-c2 { background-color: #14532d !important; color: #dcfce7 !important; }
    .dark .wbd-wrap .wbd-c3 { background-color: #4c1d95 !important; color: #f3e8ff !important; }
    .dark .wbd-wrap .wbd-c4 { background-color: #831843 !important; color: #ffe4e6 !important; }
    .dark .wbd-wrap .wbd-c5 { background-color: #1e293b !important; color: #f1f5f9 !important; }
</style>

<div class="wbd-wrap" style="display: flex; flex-direction: column; gap: 16px;">
    @php
        $groupedBillings = $record->beoWeddingBreakdownPostings->groupBy('revenue_type');
        $labels = [
            'hotel' => 'FB POSTING',
            'vendor' => 'VENDOR POSTING',
            'room' => 'Room POSTING',
        ];
        $index = 0;
    @endphp

    @foreach ($labels as $type => $headerLabel)
        @php
            $items = $groupedBillings->get($type, collect());
            $totalPackage = 0;
            $currentColor = $colors[$index % count($colors)];
        @endphp

        <h4 style="font-weight: 700; font-size: 14px; text-transform: uppercase;">{{ $headerLabel }}</h4>

        <div style="overflow: auto;">
        <table style="width: 100%; font-size: 13px; text-align: left; border-collapse: collapse; border: 1px solid #e5e7eb;">
            <thead>
                <tr class="wbd-c{{ $index % count($colors) }}" style="background-color: {{ $currentColor }};">
                    <th style="padding: 8px 16px; border: 1px solid #e5e7eb;">Item</th>
                    <th style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rate</th>
                    <th style="padding: 8px 16px; border: 1px solid #e5e7eb;">Amount</th>
                    <th style="padding: 8px 16px; border: 1px solid #e5e7eb;">Total</th>
                    <th style="padding: 8px 16px; border: 1px solid #e5e7eb;">Remark</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    @php
                        $total = $item->amount * $item->rate;
                        $totalPackage += $total;
                    @endphp
                    <tr>
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">{{ $item->name ?? 'N/A' }}</td>
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($item->rate, 0, ',', '.') }}</td>
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">{{ $item->amount }}</td>
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">{{ $item->remark }}</td>
                    </tr>
                @endforeach
                <tr class="wbd-total" style="background-color: #f3f4f6; font-weight: 700;">
                    <td colspan="3" style="padding: 8px 16px; border: 1px solid #e5e7eb;">Total</td>
                    <td colspan="2" style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($totalPackage, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        </div>

        @if ($type === 'hotel')
            @php
                $totalAdditional = 0;
            @endphp

            <h4 style="font-weight: 700; font-size: 14px; text-transform: uppercase;">Additional Meal</h4>
            <div style="overflow: auto;">
            <table style="width: 100%; font-size: 13px; text-align: left; border-collapse: collapse; border: 1px solid #e5e7eb;">
                <thead>
                    <tr class="wbd-additional-header" style="background-color: #fbbf24;">
                        <th style="padding: 8px 16px; border: 1px solid #e5e7eb; width: 25%;">Item</th>
                        <th style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rate</th>
                        <th style="padding: 8px 16px; border: 1px solid #e5e7eb;">Pax</th>
                        <th style="padding: 8px 16px; border: 1px solid #e5e7eb;">Total</th>
                        <th style="padding: 8px 16px; border: 1px solid #e5e7eb;">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($record->beoWeddingFunctions as $f)
                        @foreach ($f->beoWeddingAdditionalMeals as $add)
                            @php
                                $total = $add->pax * $add->rate;
                                $totalAdditional += $total;
                            @endphp
                            <tr>
                                <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">{{ $add->beoWeddingFunction?->function?->name }} {{ $add->menu_name }}</td>
                                <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($add->rate, 0, ',', '.') }}</td>
                                <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">{{ $add->pax }}</td>
                                <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">{{ $add->remark }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                    <tr class="wbd-total" style="background-color: #f3f4f6; font-weight: 700;">
                        <td colspan="3" style="padding: 8px 16px; border: 1px solid #e5e7eb;">Total</td>
                        <td colspan="2" style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($totalAdditional, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
            </div>
        @endif

        @php
            $index++;
        @endphp
    @endforeach
</div>
