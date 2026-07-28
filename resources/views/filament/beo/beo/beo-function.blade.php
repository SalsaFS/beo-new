@php
    $record = $getRecord();
@endphp

<div style="width: 100%;  border-radius: 8px; overflow: hidden;">
    <table
        style="width: 100%; font-size: 14px; text-align: left; border-collapse: collapse; border: 1px solid #9ca3af;">
        <thead>
            <tr style="background-color: #f9fafb; border-bottom: 1px solid #9ca3af; text-transform: uppercase;">
                <th style="padding: 8px 16px; border: 1px solid #d1d5db; font-weight: 700;">
                    Time
                </th>
                <th style="padding: 8px 16px; border: 1px solid #d1d5db; font-weight: 700; width: 30%;">
                    Function
                </th>
                <th style="padding: 8px 16px; border: 1px solid #d1d5db; font-weight: 700;">
                    Venue
                </th>
                <th style="padding: 8px 16px; border: 1px solid #d1d5db; font-weight: 700;">
                    Setup
                </th>
                <th style="padding: 8px 16px; border: 1px solid #d1d5db; font-weight: 700;">
                    Pax
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($record->beoFunctionPackages as $package)
                <tr style="background-color: #ffffff; border-left; border-right; border: 1px solid #e5e7eb;">
                    <td style="padding: 8px 16px; ">
                        {{ \Carbon\Carbon::parse($package->time_start)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($package->time_end)->format('H:i') }}
                    </td>
                    <td style="padding: 8px 16px; ">
                        {{ $package->name }}
                    </td>
                    <td style="padding: 8px 16px; ">
                        {{ $package->venue->name }}
                    </td>
                    <td style="padding: 8px 16px; ">
                        {{ $package->setup->name }}
                    </td>
                    <td style="padding: 8px 16px; ">
                        {{ $package->pax }}
                    </td>
                </tr>
            @endforeach
            @foreach ($record->beoFunctions as $function)
                <tr style="background-color: #ffffff; border-left; border-right; border: 1px solid #e5e7eb;">
                    <td style="padding: 8px 16px; ">
                        {{ \Carbon\Carbon::parse($function->time_start)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($function->time_end)->format('H:i') }}
                    </td>
                    <td style="padding: 8px 16px; ">
                        {{ $function->function->name }}
                    </td>
                    <td style="padding: 8px 16px; ">
                        {{ $function->venue->name }}
                    </td>
                    <td style="padding: 8px 16px; ">
                        {{ $function->setup->name }}
                    </td>
                    <td style="padding: 8px 16px; ">
                        {{ $function->pax }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>