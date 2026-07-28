@php
    $record = $getRecord();
    $colors = ['#e0f2fe', '#fef3c7', '#dcfce7', '#f3e8ff', '#ffe4e6', '#f1f5f9'];
@endphp

<div style="display: flex; flex-direction: column; gap: 16px;">
    <h4 style="font-weight: 700; font-size: 14px; text-transform: uppercase;">Billing Instruction</h4>

    <table style="width: 100%; font-size: 13px; text-align: left; border-collapse: collapse; border: 1px solid #e5e7eb;">
        <tbody>
            @php
                $groupedBillings = $record->beoPackages->groupBy('billing_type');
                $labels = [
                    'online' => 'FB ONLINE BILLING',
                    'offline' => 'FB OFFLINE BILLING',
                ];
                $index = 0;
            @endphp

            @foreach ($labels as $type => $headerLabel)
                @php
                    $items = $groupedBillings->get($type, collect());
                    $total = 0;
                @endphp

                @if ($items->isNotEmpty())
                    <tr style="background-color: #38bdf8;">
                        <td colspan="3" style="padding: 8px 16px; font-weight: 700; border: 1px solid #e5e7eb;">{{ $headerLabel }}</td>
                    </tr>

                    @foreach ($items as $item)
                        @php
                            $unitRate = 0;
                            foreach ($item->internalBreakdowns as $f) {
                                $unitRate += $f->pax * $f->rate;
                            }
                            $ratePerPack = $item->pax > 0 ? $unitRate / $item->pax : 0;
                            $currentColor = $colors[$index % count($colors)];
                            $index += 1;
                            $total += $unitRate;
                        @endphp

                        <tr style="background-color: {{ $currentColor }};">
                            <td colspan="3" style="padding: 8px 16px; font-style: italic; border: 1px solid #e5e7eb;">{{ $item->package->name }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">{{ $item->pax }} pax</td>
                            <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($ratePerPack, 0, ',', '.') }}</td>
                            <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($unitRate, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach

                    <tr style="background-color: #f3f4f6; font-weight: 700;">
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">TOTAL</td>
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb;"></td>
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    @if ($record->additionalBreakdowns->count() > 0)
        <table style="width: 100%; font-size: 13px; text-align: left; border-collapse: collapse; border: 1px solid #e5e7eb;">
            <tbody>
                @php
                    $groupedAdditionalBilling = $record->additionalBreakdowns->groupBy('billing_type');
                    $labels = [
                        'online' => 'FB ONLINE BILLING',
                        'offline' => 'FB OFFLINE BILLING',
                    ];
                    $index = 0;
                @endphp

                @foreach ($labels as $type => $headerLabel)
                    @php
                        $items = $groupedAdditionalBilling->get($type, collect());
                        $subTotalType = 0;
                        $currentColor = $colors[$index % count($colors)];
                        $index += 1;
                    @endphp

                    @if ($items->isNotEmpty())
                        <tr style="background-color: {{ $currentColor }};">
                            <td colspan="3" style="padding: 8px 16px; font-weight: 700; border: 1px solid #e5e7eb;">{{ $headerLabel }}</td>
                        </tr>

                        @foreach ($items as $item)
                            @php
                                $unitRate = $item->rate;
                                $subTotalType += $unitRate;
                            @endphp

                            <tr>
                                <td colspan="3" style="padding: 8px 16px; font-style: italic; border: 1px solid #e5e7eb;">Additional Breakdown</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">{{ $item->name }}</td>
                                <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">{{ number_format($unitRate, 0, ',', '.') }}</td>
                                <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($unitRate, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach

                        <tr style="background-color: #f3f4f6; font-weight: 700;">
                            <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">TOTAL</td>
                            <td style="padding: 8px 16px; border: 1px solid #e5e7eb;"></td>
                            <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($subTotalType, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif
</div>
