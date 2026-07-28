@php
    $record = $getRecord();
    $colors = ['#e0f2fe', '#fef3c7', '#dcfce7', '#f3e8ff', '#ffe4e6', '#f1f5f9'];
@endphp

<div style="display: flex; flex-direction: column; gap: 16px;">
    <h4 style="font-weight: 700; font-size: 14px; text-transform: uppercase;">Internal Breakdown</h4>

    @foreach ($record->beoPackages as $index => $package)
        @php
            $currentColor = $colors[$index % count($colors)];
            $totalPackage = 0;
        @endphp

        <table style="width: 100%; font-size: 13px; text-align: left; border-collapse: collapse; border: 1px solid #e5e7eb;">
            <thead>
                <tr>
                    <td colspan="5" style="padding: 8px 16px; font-weight: 700; font-style: italic; border: 1px solid #e5e7eb; background-color: {{ $currentColor }};">
                        {{ $package->package->name }}
                    </td>
                </tr>
                <tr style="background-color: #f3f4f6;">
                    <th style="padding: 8px 16px; border: 1px solid #e5e7eb;">Function</th>
                    <th style="padding: 8px 16px; border: 1px solid #e5e7eb;">Pax</th>
                    <th style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rate</th>
                    <th style="padding: 8px 16px; border: 1px solid #e5e7eb;">Total</th>
                    <th style="padding: 8px 16px; border: 1px solid #e5e7eb;">Remark</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($package->internalBreakdowns as $f)
                    @php
                        $total = $f->pax * $f->rate;
                        $totalPackage += $total;
                    @endphp
                    <tr>
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">{{ $f->name ?? 'N/A' }}</td>
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">{{ $f->pax }}</td>
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($f->rate, 0, ',', '.') }}</td>
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">{{ $f->remark }}</td>
                    </tr>
                @endforeach
                <tr style="background-color: #f3f4f6; font-weight: 700;">
                    <td colspan="4" style="padding: 8px 16px; border: 1px solid #e5e7eb;">Total</td>
                    <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($totalPackage, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    @endforeach

    @if ($record->additionalBreakdowns->count() > 0)
        <h4 style="font-weight: 700; font-size: 14px; text-transform: uppercase;">Additional Breakdown</h4>
        <table style="width: 100%; font-size: 13px; text-align: left; border-collapse: collapse; border: 1px solid #e5e7eb;">
            <thead>
                <tr style="background-color: #fbbf24;">
                    <th style="padding: 8px 16px; border: 1px solid #e5e7eb; width: 25%;">Additional Type</th>
                    <th style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rate</th>
                    <th style="padding: 8px 16px; border: 1px solid #e5e7eb;text-wrap:wrap;">Remark</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($record->additionalBreakdowns as $add)
                    <tr>
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">{{ $add->name }}</td>
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($add->rate, 0, ',', '.') }}</td>
                        <td style="padding: 8px 16px; border: 1px solid #e5e7eb; text-wrap:wrap;">{{ $add->remark }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
