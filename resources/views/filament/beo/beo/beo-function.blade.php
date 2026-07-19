@php
    $record = $getRecord();

    $pkgNames = [];
    $venueNames = [];
    foreach ($record->beoPackages as $package) {
        if ($package->package) {
            $pkgNames[] = $package->package->name;
        }
        if ($package->venue) {
            $venueNames[] = $package->venue->name;
        }
    }
    $pkgCombined = implode(' & ', $pkgNames);
    $venueCombined = implode(' & ', $venueNames);
@endphp

<div style="width: 100%;  border-radius: 8px; overflow: hidden;">
    <table style="width: 100%; font-size: 14px; text-align: left; border-collapse: collapse; border: 1px solid #9ca3af;">
        <thead>
            <tr style="background-color: #f9fafb; border-bottom: 1px solid #9ca3af; text-transform: uppercase;">
                <th colspan="3" style="padding: 8px 16px; border: 1px solid #d1d5db; font-weight: 700; width: 50%;">
                    BEO.{{ \Carbon\Carbon::parse($record->date_of_function)->format('Y') }}
                </th>
                <th colspan="3" style="padding: 8px 16px; border: 1px solid #d1d5db; font-weight: 700; width: 50%;">
                    {{ \Carbon\Carbon::parse($record->created_at)->format('l, d F Y') }}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: #ffffff; border-left; border-right; border: 1px solid #e5e7eb;">
                <td style="padding: 8px 16px; ">Event Number</td>
                <td style="padding: 8px 16px; ">:</td>
                <td style="padding: 8px 16px; ">{{ $record->event_number }}</td>
                <td style="padding: 8px 16px; ">Client Number</td>
                <td style="padding: 8px 16px; ">:</td>
                <td style="padding: 8px 16px; ">{{ $record->client->guest_number }}</td>
            </tr>
            <tr style="background-color: #ffffff; border-left; border-right; border: 1px solid #e5e7eb;">
                <td style="padding: 8px 16px; ">Company</td>
                <td style="padding: 8px 16px; ">:</td>
                <td style="padding: 8px 16px; ">{{ $record->client->company }}</td>
                <td style="padding: 8px 16px; ">Tel</td>
                <td style="padding: 8px 16px; ">:</td>
                <td style="padding: 8px 16px; ">{{ $record->client->telephone }}</td>
            </tr>
            <tr style="background-color: #ffffff; border-left; border-right; border: 1px solid #e5e7eb;">
                <td style="padding: 8px 16px; ">Address</td>
                <td style="padding: 8px 16px; ">:</td>
                <td style="padding: 8px 16px; ">{{ $record->client->address }}</td>
                <td style="padding: 8px 16px; ">Mobile</td>
                <td style="padding: 8px 16px; ">:</td>
                <td style="padding: 8px 16px; ">{{ $record->client->mobile }}</td>
            </tr>
            <tr style="background-color: #ffffff; border-left; border-right; border: 1px solid #e5e7eb;">
                <td style="padding: 8px 16px; ">PIC</td>
                <td style="padding: 8px 16px; ">:</td>
                <td style="padding: 8px 16px; ">{{ $record->client->pic }}</td>
                <td style="padding: 8px 16px; ">Guaranteed</td>
                <td style="padding: 8px 16px; ">:</td>
                <td style="padding: 8px 16px; ">{{ $record->guaranteed }}</td>
            </tr>
            <tr style="background-color: #ffffff; border-left; border-right; border: 1px solid #e5e7eb;">
                <td style="padding: 8px 16px; ">Day/Date/Time of Function</td>
                <td style="padding: 8px 16px; ">:</td>
                <td style="padding: 8px 16px; ">{{ \Carbon\Carbon::parse($record->date_of_function)->format('l, d F Y') }}</td>
                <td style="padding: 8px 16px; ">In House Contact</td>
                <td style="padding: 8px 16px; ">:</td>
                <td style="padding: 8px 16px; ">{{ $record->user->name }}</td>
            </tr>
            <tr style="background-color: #ffffff; border-left; border-right; border: 1px solid #e5e7eb;">
                <td style="padding: 8px 16px; ">Package</td>
                <td style="padding: 8px 16px; ">:</td>
                <td style="padding: 8px 16px; ">{{ $pkgCombined }}</td>
                <td style="padding: 8px 16px; ">Venue</td>
                <td style="padding: 8px 16px; ">:</td>
                <td style="padding: 8px 16px; ">{{ $venueCombined }}</td>
            </tr>
        </tbody>
    </table>
</div>
