<?php

namespace App\Exports;

use App\Models\Beo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class BeoExport implements FromCollection, WithHeadings, WithTitle
{
    protected Beo $beo;

    public function __construct(Beo $beo)
    {
        $this->beo = $beo;
    }

    public function title(): string
    {
        return 'BEO ' . ($this->beo->event_number ?? $this->beo->id);
    }

    public function headings(): array
    {
        return [
            'Event Number',
            'Date of Function',
            'Client',
            'User',
            'Guaranteed',
            'Expected',
            'Approver',
            'Status',
        ];
    }

    public function collection()
    {
        $rows = [];

        foreach ($this->beo->beoApprovals as $approval) {
            $rows[] = [
                $this->beo->event_number,
                $this->beo->date_of_function,
                $this->beo->client?->company,
                $this->beo->user?->name,
                $this->beo->guaranteed,
                $this->beo->expected,
                $approval->user?->name,
                $approval->is_verify ? 'Verified' : 'Not Verified',
            ];
        }

        if (empty($rows)) {
            $rows[] = [
                $this->beo->event_number,
                $this->beo->date_of_function,
                $this->beo->client?->company,
                $this->beo->user?->name,
                $this->beo->guaranteed,
                $this->beo->expected,
                null,
                null,
            ];
        }

        return collect($rows);
    }
}
