<?php

namespace App\Exports;

use App\Models\BeoAmendment;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Storage;

class BeoAmendmentExport implements FromArray, WithTitle, ShouldAutoSize, WithStyles
{
    protected BeoAmendment $beo;

    /** @var string[] */
    protected array $signaturePaths = [];

    public function __construct(BeoAmendment $beo)
    {
        $this->beo = $beo->load([
            'beoAmendmentPackages.venue',
            'beoAmendmentPackages.setup',
            'beoAmendmentPackages.package',
            'beoAmendmentPackages.amendmentBreakdowns',
            'beoAmendmentApprovals.user.position',
            'beo.beoPackages.venue',
            'beo.beoPackages.setup',
            'beo.beoPackages.package',
            'beo.beoPackages.internalBreakdowns',
            'beo.client',
        ]);
    }

    public function array(): array
    {
        $beo = $this->beo;
        $dateIssued = \Carbon\Carbon::parse($beo->created_at)->format('F d, Y');
        $dateIssuedFirst = \Carbon\Carbon::parse($beo->beo->date_of_function)->format('F d, Y');
        $dateOfFunction = \Carbon\Carbon::parse($beo->date_change)->format('F d, Y');

        $venues = [];
        // Gunakan beoAmendmentPackages karena ini file export amendment
        foreach ($beo->beoAmendmentPackages as $package) {
            if ($package->venue) {
                $venues[] = $package->venue->name;
            }
        }
        $packageVenues = implode(' & ', array_unique($venues));

        $data = [
            ['BEO AMENDMENT'],
            ['DATE ISSUED : ' . $dateIssued],
            [''],
            ['COMPANY', ': ' . ($beo->name_of_event ?? '-')],
            ['DATE OF EVENT', ': ' . ($dateOfFunction ?? '-')],
            ['VENUE', ': ' . ($packageVenues ?? '-')],
            ['PIC', ': ' . ($beo->contact_person ?? '-')],
            ['MOBILE', ': ' . ($beo->contact ?? '-')],
            [''],
            ['BEFORE', '', 'AFTER', ''],
            [$dateIssuedFirst, '', $dateOfFunction, ''],
            [''],
        ];

        $leftRows = [];
        $rightRows = [];

        // ==========================================
        // A. PROSES DATA SISI KIRI (BEFORE / ORIGINAL BEO)
        // ==========================================
        if ($beo->beo && $beo->beo->beoPackages) {
            $groupedBillings = $beo->beo->beoPackages->groupBy('billing_type');
            $labels = ['online' => 'FB ONLINE BILLING', 'offline' => 'FB OFFLINE BILLING'];

            foreach ($labels as $type => $headerLabel) {
                $items = $groupedBillings->get($type, collect());
                if ($items->isNotEmpty()) {
                    $leftRows[] = $headerLabel;
                    $totalBilling = 0;

                    foreach ($items as $item) {
                        $unitRate = 0;
                        foreach ($item->internalBreakdowns as $f) {
                            $unitRate += ($f->pax * $f->rate);
                        }
                        $ratePerPack = $item->pax > 0 ? ($unitRate / $item->pax) : 0;
                        $totalBilling += $unitRate;

                        $leftRows[] = $item->package->name ?? '';
                        $leftRows[] = 'Rp ' . number_format($ratePerPack, 0, ',', ',') . ' x ' . $item->pax . ' pax = Rp ' . number_format($unitRate, 0, ',', ',');
                    }
                    $leftRows[] = '';
                }
            }
        }

        // ==========================================
        // B. PROSES DATA SISI KANAN (AFTER / AMENDMENT BEO)
        // ==========================================
        $groupedBillingsAmendment = $beo->beoAmendmentPackages->groupBy('billing_type');
        $labels = ['online' => 'FB ONLINE BILLING', 'offline' => 'FB OFFLINE BILLING'];

        foreach ($labels as $type => $headerLabel) {
            $itemsAmendment = $groupedBillingsAmendment->get($type, collect());
            if ($itemsAmendment->isNotEmpty()) {
                $rightRows[] = $headerLabel;
                $totalBilling = 0;

                foreach ($itemsAmendment as $item) {
                    $unitRate = 0;
                    foreach ($item->amendmentBreakdowns as $f) {
                        $unitRate += ($f->pax * $f->rate);
                    }
                    $ratePerPack = $item->pax > 0 ? ($unitRate / $item->pax) : 0;
                    $totalBilling += $unitRate;

                    $rightRows[] = $item->package->name ?? '';
                    $rightRows[] = 'Rp ' . number_format($ratePerPack, 0, ',', ',') . ' x ' . $item->pax . ' pax = Rp ' . number_format($unitRate, 0, ',', ',');
                }
                $rightRows[] = '';
            }
        }

        // ==========================================
        // C. GABUNGKAN DATA HORIZONTAL (KOLOM A-B vs C-D)
        // ==========================================
        $maxRows = max(count($leftRows), count($rightRows));
        for ($i = 0; $i < $maxRows; $i++) {
            $leftVal = $leftRows[$i] ?? '';
            $rightVal = $rightRows[$i] ?? '';

            // Kolom A & B untuk BEFORE, Kolom C & D untuk AFTER
            $data[] = [
                $leftVal,
                '',
                $rightVal,
                ''
            ];
        }

        // ==========================================
        // D. PROSES SIGNATURE / TANDA TANGAN
        // ==========================================
        $data[] = [''];
        $data[] = ['PREPARED BY,', 'ACKNOWLEDGE BY,', '', 'APPROVED BY,'];

        $sortedApprovals = $beo->beoAmendmentApprovals->sortBy('user.position.signature_positions');

        // Buat cetakan default aman (blueprint) untuk 7 slot TTD
        $signature = array_fill(0, 7, '');

        $idx = 0;
        $this->signaturePaths = [];
        foreach ($sortedApprovals as $approval) {
            if ($idx < 7) {
                $name = $approval->user->name ?? '';
                $pos = $approval->user->position->name ?? 'HoD';
                $signature[$idx] = "\n\n\n$name\n$pos";
                $this->signaturePaths[] = $approval->is_verify == 1 ? $approval->user->signature : null;
                $idx++;
            }
        }

        // Baris Konten TTD Atas
        $data[] = [$signature[0], $signature[1], '', $signature[2]];

        // Baris Header TTD Bawah
        $data[] = ['APPROVED BY,', 'ACKNOWLEDGE BY,', 'ACKNOWLEDGE BY,', 'APPROVED BY,'];

        // Baris Konten TTD Bawah
        $data[] = [$signature[3], $signature[4], $signature[5], $signature[6]];

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        // Setup Ukuran Kolom secara Manual & Seragam agar Kotak Seimbang
        foreach (range('A', 'D') as $column) {
            $sheet->getColumnDimension($column)->setWidth(24);
        }

        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);

        $sheet->getPageMargins()->setTop(0.75 / 2.54);
        $sheet->getPageMargins()->setBottom(0.75 / 2.54);
        $sheet->getPageMargins()->setLeft(0.64 / 2.54);
        $sheet->getPageMargins()->setRight(0.64 / 2.54);

        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        $sheet->setShowGridlines(true);

        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');

        // Merge Header Atas Dokumen
        $rowData = 8;
        for ($i = 4; $i <= $rowData; $i++) {
            $sheet->mergeCells('B' . $i . ':D' . $i);
        }

        // Batas akhir baris konten paket dinamis sebelum TTD
        $contentHeader = 10;
        $contentDate = $contentHeader + 1;
        $contentStart = $contentDate + 2;

        $contentCount = $this->beo->beoAmendmentPackages->count();
        $content = $contentStart + ($contentCount * 2) + 1;


        $sheet->mergeCells("A{$contentHeader}:B{$contentHeader}");
        $sheet->mergeCells("C{$contentHeader}:D{$contentHeader}");
        $sheet->mergeCells("A{$contentDate}:B{$contentDate}");
        $sheet->mergeCells("C{$contentDate}:D{$contentDate}");

        // Jalankan Merge Cells secara Berpasangan (A-B dan C-D) ke Bawah
        for ($row = $contentStart; $row <= $content; $row++) {
            $sheet->mergeCells("A{$row}:B{$row}");
            $sheet->mergeCells("C{$row}:D{$row}");
        }

        // TTD Bawah berada di 2 baris paling akhir
        $ttdContentRow2 = $content + 5;
        $ttdHeaderRow2 = $ttdContentRow2 - 1;
        $ttdContentRow = $ttdHeaderRow2 - 1;
        $ttdHeaderRow = $ttdContentRow - 1;


        // Jalankan Merge TTD
        $sheet->mergeCells("B{$ttdHeaderRow}:C{$ttdHeaderRow}");
        $sheet->mergeCells("B{$ttdContentRow}:C{$ttdContentRow}");

        // Format perataan text
        $sheet->getStyle('A1:D2')->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A{$contentHeader}:D{$content}")->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("A{$ttdContentRow}:D{$ttdContentRow}")->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_BOTTOM);
        $sheet->getStyle("A{$ttdContentRow2}:D{$ttdContentRow2}")->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_BOTTOM);

        // Styling Borders
        $styleArray = [
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
        ];
        $styleOutline = [

            'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],

        ];
        $styleOutlineRL = [
            'borders' => [
                'left' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']],
                'right' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']],
            ],
        ];
        $styleOutlineRLB = [
            'borders' => [
                'left' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']],
                'right' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']],
                'bottom' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']],
            ],
        ];

        $sheet->getStyle("A{$contentHeader}:D{$contentHeader}")->applyFromArray($styleArray);

        // Loop pasang outline border per baris agar tidak tumpang tindih pembatas tengahnya
        for ($r = $contentDate; $r < $content; $r++) {
            $sheet->getStyle("A{$r}:B{$r}")->applyFromArray($styleOutlineRL);
            $sheet->getStyle("C{$r}:D{$r}")->applyFromArray($styleOutlineRL);
        }

        $sheet->getStyle("A{$content}:B{$content}")->applyFromArray($styleOutlineRLB);
        $sheet->getStyle("C{$content}:D{$content}")->applyFromArray($styleOutlineRLB);
        $sheet->getStyle("A{$ttdHeaderRow}:D{$ttdContentRow2}")->applyFromArray($styleArray);

        $sheet->getRowDimension($ttdContentRow)->setRowHeight(7 * 16);
        $sheet->getRowDimension($ttdContentRow2)->setRowHeight(7 * 16);

        $sigMap = [
            0 => ['col' => 'A', 'row' => $ttdContentRow],
            1 => ['col' => 'B', 'row' => $ttdContentRow],
            2 => ['col' => 'D', 'row' => $ttdContentRow],
            3 => ['col' => 'A', 'row' => $ttdContentRow2],
            4 => ['col' => 'B', 'row' => $ttdContentRow2],
            5 => ['col' => 'C', 'row' => $ttdContentRow2],
            6 => ['col' => 'D', 'row' => $ttdContentRow2],
        ];
        foreach ($this->signaturePaths as $idx => $path) {
            if (!$path || !isset($sigMap[$idx])) continue;
            $fullPath = Storage::disk('local')->path($path);
            if (!file_exists($fullPath)) continue;
            $drawing = new Drawing();
            $drawing->setName('Signature');
            $drawing->setPath($fullPath);
            $drawing->setHeight(70);
            $drawing->setCoordinates($sigMap[$idx]['col'] . $sigMap[$idx]['row']);
            $drawing->setOffsetX(5);
            $drawing->setOffsetY(5);
            $drawing->setWorksheet($sheet);
        }

        // Perbaikan Array Range Matrix Styling (Maksimal Kolom D)
        return [
            1 => ['font' => ['bold' => true, 'size' => 16], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            2 => ['font' => ['italic' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            "A4:A8" => ['font' => ['bold' => true]],
            "A{$contentStart}:D{$content}" => ['font' => ['bold' => true]],
            "A{$contentHeader}:D{$contentHeader}" => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D3D3D3']]],
            "A{$contentDate}:D{$contentDate}" => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            "A{$ttdHeaderRow}:D{$ttdHeaderRow}" => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D3D3D3']]],
            "A{$ttdHeaderRow2}:D{$ttdHeaderRow2}" => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D3D3D3']]],
            "A{$ttdContentRow}:D{$ttdContentRow}" => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]],
            "A{$ttdContentRow2}:D{$ttdContentRow2}" => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]],
        ];
    }

    public function title(): string
    {
        return 'BEO AMENDMENT ' . ($this->beo->beo->client->company ?? '');
    }

}
