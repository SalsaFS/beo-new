@php
    $record = $getRecord();
    $colors = ['#e0f2fe', '#fef3c7', '#dcfce7', '#f3e8ff', '#ffe4e6', '#f1f5f9'];
@endphp

<style>
    .dark .billing-wrap table {
        border-color: #374151 !important;
    }
    .dark .billing-wrap td,
    .dark .billing-wrap th {
        border-color: #374151 !important;
    }
    .dark .billing-wrap .billing-header {
        background-color: #0284c7 !important;
        color: #fff !important;
    }
    .dark .billing-wrap .billing-total {
        background-color: #1f2937 !important;
        color: #e5e7eb !important;
    }
    .dark .billing-wrap h4 {
        color: #f3f4f6 !important;
    }
    .dark .billing-wrap .billing-row {
        color: #d1d5db !important;
    }
    .dark .billing-wrap .bl-c0 { background-color: #075985 !important; color: #e0f2fe !important; }
    .dark .billing-wrap .bl-c1 { background-color: #78350f !important; color: #fef3c7 !important; }
    .dark .billing-wrap .bl-c2 { background-color: #14532d !important; color: #dcfce7 !important; }
    .dark .billing-wrap .bl-c3 { background-color: #4c1d95 !important; color: #f3e8ff !important; }
    .dark .billing-wrap .bl-c4 { background-color: #831843 !important; color: #ffe4e6 !important; }
    .dark .billing-wrap .bl-c5 { background-color: #1e293b !important; color: #f1f5f9 !important; }
</style>

<div class="billing-wrap" style="display: flex; flex-direction: column; gap: 16px;">
    <h4 style="font-weight: 700; font-size: 14px; text-transform: uppercase;">Billing Instruction</h4>

    <table style="width: 100%; font-size: 13px; text-align: left; border-collapse: collapse; border: 1px solid #e5e7eb;">
        <tbody>
            @php
                $packagesList = $record->beoPackages->values();
                $groupedBillings = $packagesList->groupBy('billing_type');
                $labels = [
                    'online' => 'FB ONLINE BILLING',
                    'offline' => 'FB OFFLINE BILLING',
                ];
            @endphp

            @foreach ($labels as $type => $headerLabel)
                @php
                    $items = $groupedBillings->get($type, collect());
                    $total = 0;
                @endphp

                @if ($items->isNotEmpty())
                    <tr class="billing-header" style="background-color: #38bdf8;">
                        <td colspan="3" style="padding: 8px 16px; font-weight: 700; border: 1px solid #e5e7eb;">{{ $headerLabel }}</td>
                    </tr>

                    @foreach ($items as $item)
                        @php
                            $unitRate = 0;
                            foreach ($item->internalBreakdowns as $f) {
                                $unitRate += $f->pax * $f->rate;
                            }
                            $ratePerPack = $item->pax > 0 ? $unitRate / $item->pax : 0;
                            $pkgIndex = $packagesList->search($item);
                            $total += $unitRate;
                        @endphp

                        <tr class="billing-row bl-c{{ $pkgIndex % count($colors) }}" style="background-color: {{ $colors[$pkgIndex % count($colors)] }};">
                            <td colspan="3" style="padding: 8px 16px; font-style: italic; border: 1px solid #e5e7eb;">{{ $item->package->name }}</td>
                        </tr>
                        <tr class="billing-row">
                            <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">{{ $item->pax }} pax</td>
                            <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($ratePerPack, 0, ',', '.') }}</td>
                            <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($unitRate, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach

                    <tr class="billing-total" style="background-color: #f3f4f6; font-weight: 700;">
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
                        <tr class="billing-row bl-c{{ ($index - 1) % count($colors) }}" style="background-color: {{ $currentColor }};">
                            <td colspan="3" style="padding: 8px 16px; font-weight: 700; border: 1px solid #e5e7eb;">{{ $headerLabel }}</td>
                        </tr>

                        @foreach ($items as $item)
                            @php
                                $unitRate = $item->rate;
                                $subTotalType += $unitRate;
                            @endphp

                            <tr class="billing-row">
                                <td colspan="3" style="padding: 8px 16px; font-style: italic; border: 1px solid #e5e7eb;">Additional Breakdown</td>
                            </tr>
                            <tr class="billing-row">
                                <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">{{ $item->name }}</td>
                                <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">{{ number_format($unitRate, 0, ',', '.') }}</td>
                                <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($unitRate, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach

                        <tr class="billing-total" style="background-color: #f3f4f6; font-weight: 700;">
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
