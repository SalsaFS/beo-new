@php
    $record = $getRecord();
@endphp

<div class="fi-prose w-full">
    <h4 class="font-bold text-sm" style="text-transform: uppercase;">MENU NOTE</h4>
    <div style="min-height: 75px; padding: 16px;">
        <div class="text-sm" style="text-align: center; line-height: 1.625;">
            @foreach ($record->beoFunctions as $function)
                <div class="font-bold">{{ $function->function->name }}</div>
                <div style="font-style: italic;">({{ $function->banquet }})</div>
                @if ($function->banquet === 'request')
                    @foreach ($function->beoMenus as $beoMenu)
                        <div>{{ $beoMenu->menu->name }} {{ $beoMenu->pax }} pax</div>
                    @endforeach
                    <div>{{ $function->menu_addon }}</div>
                @endif
                <br>
            @endforeach
            <div class="text-sm" style="text-align: left;">
                @if ($record->other_note)
                    <b>Other notes : </b>{!! $record->other_note !!}
                @endif
            </div>
        </div>
    </div>
</div>
