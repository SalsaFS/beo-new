@php
    $record = $getRecord();
    $colors = ['#e0f2fe', '#fef3c7', '#dcfce7', '#f3e8ff', '#ffe4e6', '#f1f5f9'];
@endphp

<style>
    .dark .breakdown-wrap table {
        border-color: #374151 !important;
    }
    .dark .breakdown-wrap td,
    .dark .breakdown-wrap th {
        border-color: #374151 !important;
    }
    .dark .breakdown-wrap h4 {
        color: #f3f4f6 !important;
    }
    .dark .breakdown-wrap .bd-c0 { background-color: #075985 !important; color: #e0f2fe !important; }
    .dark .breakdown-wrap .bd-c1 { background-color: #78350f !important; color: #fef3c7 !important; }
    .dark .breakdown-wrap .bd-c2 { background-color: #14532d !important; color: #dcfce7 !important; }
    .dark .breakdown-wrap .bd-c3 { background-color: #4c1d95 !important; color: #f3e8ff !important; }
    .dark .breakdown-wrap .bd-c4 { background-color: #831843 !important; color: #ffe4e6 !important; }
    .dark .breakdown-wrap .bd-c5 { background-color: #1e293b !important; color: #f1f5f9 !important; }
    .dark .breakdown-wrap .bd-header {
        background-color: #1f2937 !important;
        color: #e5e7eb !important;
    }
    .dark .breakdown-wrap .bd-header th {
        background-color: #1f2937 !important;
        color: #e5e7eb !important;
    }
    .dark .breakdown-wrap .bd-total {
        background-color: #111827 !important;
        color: #e5e7eb !important;
    }
    .dark .breakdown-wrap .bd-additional-header {
        background-color: #b45309 !important;
        color: #fff !important;
    }
    .dark .breakdown-wrap .bd-additional-header th {
        background-color: #b45309 !important;
        color: #fff !important;
    }
    .dark .breakdown-wrap tbody tr {
        color: #d1d5db !important;
    }
</style>

<div class="breakdown-wrap" style="display: flex; flex-direction: column; gap: 16px;">
    <h4 style="font-weight: 700; font-size: 14px; text-transform: uppercase;">Internal Breakdown</h4>

    @foreach ($record->beoPackages as $index => $package)
        @php
            $currentColor = $colors[$index % count($colors)];
            $totalPackage = 0;
        @endphp

        <div style="overflow: auto;">
        <table style="width: 100%; font-size: 13px; text-align: left; border-collapse: collapse; border: 1px solid #e5e7eb;">
            <thead>
                <tr>
                    <td class="bd-c{{ $index % count($colors) }}" colspan="5" style="padding: 8px 16px; font-weight: 700; font-style: italic; border: 1px solid #e5e7eb; background-color: {{ $currentColor }};">
                        {{ $package->package->name }}
                    </td>
                </tr>
                <tr class="bd-header" style="background-color: #f3f4f6;">
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
                <tr class="bd-total" style="background-color: #f3f4f6; font-weight: 700;">
                    <td colspan="4" style="padding: 8px 16px; border: 1px solid #e5e7eb;">Total</td>
                    <td style="padding: 8px 16px; border: 1px solid #e5e7eb;">Rp {{ number_format($totalPackage, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        </div>
    @endforeach

    @if ($record->additionalBreakdowns->count() > 0)
        <h4 style="font-weight: 700; font-size: 14px; text-transform: uppercase;">Additional Breakdown</h4>
        <div style="overflow: auto;">
        <table style="width: 100%; font-size: 13px; text-align: left; border-collapse: collapse; border: 1px solid #e5e7eb;">
            <thead>
                <tr class="bd-additional-header" style="background-color: #fbbf24;">
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
        </div>
    @endif
</div>
