@php
    $record = $getRecord();
    $colors = ['#e0f2fe', '#fef3c7', '#dcfce7', '#f3e8ff', '#ffe4e6', '#f1f5f9'];
@endphp

<div style="display: flex; flex-direction: column; gap: 16px;">
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

        <table style="width: 100%; font-size: 13px; text-align: left; border-collapse: collapse; border: 1px solid #e5e7eb;">
            <thead>
                <tr style="background-color: {{ $currentColor }};">
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
                <tr style="background-color: #f3f4f6; font-weight: 700;">
                    <td colspan="3" style="padding: 8px 16px; border: 1px solid #e5e7eb;">Total</td>
                    <td colspan="2" style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($totalPackage, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        @if ($type === 'hotel')
            @php
                $totalAdditional = 0;
            @endphp

            <h4 style="font-weight: 700; font-size: 14px; text-transform: uppercase;">Additional Meal</h4>
            <table style="width: 100%; font-size: 13px; text-align: left; border-collapse: collapse; border: 1px solid #e5e7eb;">
                <thead>
                    <tr style="background-color: #fbbf24;">
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
                    <tr style="background-color: #f3f4f6; font-weight: 700;">
                        <td colspan="3" style="padding: 8px 16px; border: 1px solid #e5e7eb;">Total</td>
                        <td colspan="2" style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($totalAdditional, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        @endif

        @php
            $index++;
        @endphp
    @endforeach
</div>
