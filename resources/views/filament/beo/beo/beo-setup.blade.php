@php
    $record = $getRecord();
@endphp

<div class="fi-prose w-full">
    <span style="font-weight: bold; text-transform: uppercase;">Setup & Arrangements</span>
    <div style="min-height: 75px; padding: 16px;">
        <div>
            @if($record->setup_arrangements != '<p></p>')
                {!! strip_tags($record->setup_arrangements) !!}
            @else
                <span>No arrangement notes...</span>
            @endif
            @if($record->note != '<p></p>')
                <br><b>Notes : </b>{!! strip_tags($record->note) !!}
            @endif
        </div>
    </div>
</div>
