@php
    $record = $getRecord();
    $colors = ['#e0f2fe', '#fef3c7', '#dcfce7', '#f3e8ff', '#ffe4e6', '#f1f5f9'];
@endphp

<style>
    .dark .wb-wrap table { border-color: #374151 !important; }
    .dark .wb-wrap td, .dark .wb-wrap th { border-color: #374151 !important; }
    .dark .wb-wrap h4 { color: #f3f4f6 !important; }
    .dark .wb-wrap tbody tr { color: #d1d5db !important; }
    .dark .wb-wrap .wb-total { background-color: #1f2937 !important; color: #e5e7eb !important; }
    .dark .wb-wrap .wb-deposit { color: #fca5a5 !important; }
    .dark .wb-wrap .wb-note { color: #d1d5db !important; }
    .dark .wb-wrap .wb-c0 { background-color: #075985 !important; color: #e0f2fe !important; }
    .dark .wb-wrap .wb-c1 { background-color: #78350f !important; color: #fef3c7 !important; }
    .dark .wb-wrap .wb-c2 { background-color: #14532d !important; color: #dcfce7 !important; }
    .dark .wb-wrap .wb-c3 { background-color: #4c1d95 !important; color: #f3e8ff !important; }
    .dark .wb-wrap .wb-c4 { background-color: #831843 !important; color: #ffe4e6 !important; }
    .dark .wb-wrap .wb-c5 { background-color: #1e293b !important; color: #f1f5f9 !important; }
</style>

<div class="wb-wrap" style="display: flex; flex-direction: column; gap: 16px;">
    <h4 style="font-weight: 700; font-size: 14px; text-transform: uppercase;">Billing Instruction</h4>

    <table style="width: 100%; font-size: 13px; text-align: left; border-collapse: collapse; border: 1px solid #e5e7eb;">
        <tbody>
            @php
                $groupedBillings = $record->beoWeddingBreakdownPostings->groupBy('revenue_type');
                $labels = [
                    'hotel' => 'Revenue Hotel',
                    'vendor' => 'Revenue Vendor',
                    'room' => 'Revenue Room',
                ];
                $index = 0;
                $totalAll = 0;
            @endphp

            @foreach ($labels as $type => $headerLabel)
                @php
                    $items = $groupedBillings->get($type, collect());
                    $totalPackage = 0;
                    $totalFunction = 0;
                    $currentColor = $colors[$index % count($colors)];

                    foreach ($items as $item) {
                        $totalPackage += ($item->amount * $item->rate);
                    }

                    if ($type === 'hotel') {
                        foreach ($record->beoWeddingFunctions as $f) {
                            foreach ($f->beoWeddingAdditionalMeals as $add) {
                                $totalFunction += ($add->pax * $add->rate);
                            }
                        }
                        $totalPackage += $totalFunction;
                    }

                    $totalAll += $totalPackage;
                    $index++;
                @endphp

                @if ($items->isNotEmpty())
                    <tr class="wb-c{{ ($index - 1) % count($colors) }}" style="background-color: {{ $currentColor }};">
                        <td style="padding: 8px 16px; font-weight: 700; border: 1px solid #e5e7eb;">{{ $headerLabel }}</td>
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($totalPackage, 0, ',', '.') }}</td>
                    </tr>
                @endif
            @endforeach

            <tr>
                <td style="padding: 8px 16px; font-weight: 700; border: 1px solid #e5e7eb;">Deposit</td>
                <td class="wb-deposit" style="padding: 8px 16px; border: 1px solid #e5e7eb; color: #dc2626;">Rp {{ number_format($record->deposit, 0, ',', '.') }}</td>
            </tr>

            @php
                $totalAll = $totalAll - $record->deposit;
            @endphp

            <tr class="wb-total" style="background-color: #f3f4f6; font-weight: 700;">
                <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Must Be Paid</td>
                <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($totalAll, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    @if ($record->payment_note)
        <div class="wb-note" style="font-size: 13px;"><b>Payment notes : </b>{!! $record->payment_note !!}</div>
    @endif
    @if ($record->payment_information)
        <div class="wb-note" style="font-size: 13px;"><b>Payment Information : </b>{!! $record->payment_information !!}</div>
    @endif
</div>
