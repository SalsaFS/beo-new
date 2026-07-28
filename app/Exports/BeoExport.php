<?php

namespace App\Exports;

use App\Models\Beo;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Storage;

/**
 * @property-read string[] $signaturePaths
 */

class BeoExport implements FromArray, WithTitle, ShouldAutoSize, WithStyles
{
    protected Beo $beo;

    protected array $signaturePaths = [];

    public function __construct(Beo $beo)
    {
        $this->beo = $beo->load([
            'client',
            'beoPackages.venue',
            'beoPackages.setup',
            'beoPackages.package',
            'beoFunctions.function',
            'beoFunctions.venue',
            'beoFunctions.setup',
            'beoFunctions.beoMenus.menu',
            'beoFunctionPackages.venue',
            'beoFunctionPackages.setup',
            'beoApprovals.user.position',
            'additionalBreakdowns',
            'beoPackages.internalBreakdowns',
        ]);
    }

    private function cleanSetupArrangement($htmlContent)
    {
        if (empty($htmlContent)) {
            return '';
        }

        $text = preg_replace('/<h5[^>]*>(.*?)<\/h5>/i', "\n$1\n", $htmlContent);
        $text = preg_replace('/<li[^>]*>(.*?)<\/li>/i', " * $1\n", $text);
        $text = strip_tags($text);
        $text = html_entity_decode($text);

        $lines = explode("\n", $text);
        $cleanedLines = [];

        foreach ($lines as $line) {
            $trimmed = trim($line);
            if ($trimmed !== '') {
                $trimmed = preg_replace('/\s+/', ' ', $trimmed);
                $cleanedLines[] = $trimmed;
            }
        }

        return implode("\n", $cleanedLines);
    }

    public function array(): array
    {
        $beo = $this->beo;
        $dateIssued = \Carbon\Carbon::parse($beo->created_at)->format('F d, Y');
        $dateOfFunction = \Carbon\Carbon::parse($beo->date_of_function)->format('F d Y');
        $thisYear = date('Y');

        $names = [];
        $venues = [];

        foreach ($beo->beoPackages as $package) {
            $venues[] = $package->venue->name;
            $names[] = $package->package->name;
        }
        $packageVenues = implode(' & ', $venues);
        $packageNames = implode(' & ', $names);

        $data = [
            ['BANQUET EVENT ORDER'],
            ['BEO.' . $thisYear, '', '', '', 'DATE ISSUED', '', $dateIssued, ''],
            ['EVENT NUMBER', '' . ($beo->event_number ?? '-'), '', 'CLIENT NUMBER', '', '' . ($beo->client->guest_number ?? '-'), '', ''],
            ['COMPANY', '' . ($beo->client->company ?? '-'), '', 'TEL', '', '' . ($beo->client->telephone ?? '-'), '', ''],
            ['ADDRESS', '' . ($beo->client->address ?? '-'), '', 'MOBILE', '', '' . ($beo->client->mobile ?? '-'), '', '', '', '', '', ''],
            ['PIC', '' . ($beo->client->pic ?? '-'), '', 'GUARANTEED', '', '' . ($beo->guaranteed ?? '-') . ' persons', '', ''],
            ['DAY/DATE/TIME OF FUNCTION', '' . ($dateOfFunction ?? '-'), '', 'IN HOUSE CONTACT', '', '' . ($beo->user->name ?? '-'), ''],
            ['PACKAGE', '' . ($packageNames ?? '-'), '', 'VENUE', '', '' . ($packageVenues ?? '-'), ''],
            ['TIME', 'FUNCTION', '', 'VENUE', '', 'SET UP', '', 'PAX'],
        ];

        foreach ($beo->beoFunctionPackages as $rundown) {
            $data[] = [
                \Carbon\Carbon::parse($rundown->time_start)->format('H:i') . ' - ' . \Carbon\Carbon::parse($rundown->time_end)->format('H:i'),
                $rundown->name ?? '-',
                '',
                $rundown->venue->name ?? '-',
                '',
                $rundown->setup->name ?? '-',
                '',
                $rundown->pax . ' Pax'
            ];
        }

        foreach ($beo->beoFunctions as $rundown) {
            $data[] = [
                \Carbon\Carbon::parse($rundown->time_start)->format('H:i') . ' - ' . \Carbon\Carbon::parse($rundown->time_end)->format('H:i'),
                $rundown->function->name ?? '-',
                '',
                $rundown->venue->name ?? '-',
                '',
                $rundown->setup->name ?? '-',
                '',
                $rundown->pax . ' Pax'
            ];
        }

        $data[] = ['SIGNED'];
        $data[] = ['"' . $beo->signed . '"'];
        $data[] = ['MENU NOTE', '', 'SET UP AND ARRANGEMENTS:', '', '', '', '', ''];

        $menuCellText = "";
        foreach ($beo->beoFunctions as $function) {
            $menuCellText .= $function->function->name . " (" . $function->banquet . ")\n";

            if ($function->banquet === 'request') {
                foreach ($function->beoMenus as $beoMenu) {
                    $menuCellText .= "- " . ($beoMenu->menu->name ?? '') . " " . $beoMenu->pax . " pax\n";
                }
            }

            if (!empty($function->menu_addon)) {
                $menuCellText .= "Addon: " . $function->menu_addon . "\n";
            }

            $menuCellText .= "\n";
        }

        $menuCellText = rtrim($menuCellText);

        $cleanedSetup = $this->cleanSetupArrangement($beo->setup_arrangements) . "\nNote :\n" . $this->cleanSetupArrangement($beo->note);

        $data[] = [
            $menuCellText,
            '',
            $cleanedSetup,
            '',
            '',
            '',
            '',
            ''
        ];

        $leftRows = [];
        $rightRows = [];

        $groupedBillings = $beo->beoPackages->groupBy('billing_type');
        $labels = ['online' => 'FB ONLINE BILLING', 'offline' => 'FB OFFLINE BILLING'];

        foreach ($labels as $type => $headerLabel) {
            $items = $groupedBillings->get($type, collect());
            if ($items->isNotEmpty()) {
                $leftRows[] = [$headerLabel, ''];
                $totalBilling = 0;

                foreach ($items as $item) {
                    $unitRate = 0;
                    foreach ($item->internalBreakdowns as $f) {
                        $unitRate += ($f->pax * $f->rate);
                    }
                    $ratePerPack = $item->pax > 0 ? ($unitRate / $item->pax) : 0;
                    $totalBilling += $unitRate;

                    $leftRows[] = [$item->package->name ?? '', ''];
                    $leftRows[] = [
                        $item->pax . ' pax @' .
                        'Rp ' . number_format($ratePerPack, 0, ',', ','),
                        'Rp ' . number_format($unitRate, 0, ',', ',')
                    ];
                }
                $leftRows[] = ['TOTAL', 'Rp ' . number_format($totalBilling, 0, ',', ',')];
                $leftRows[] = ['', ''];
            }
        }

        if ($beo->additionalBreakdowns->count() > 0) {
            $groupedAdditional = $beo->additionalBreakdowns->groupBy('billing_type');
            foreach ($labels as $type => $headerLabel) {
                $items = $groupedAdditional->get($type, collect());
                if ($items->isNotEmpty()) {
                    $leftRows[] = [$headerLabel . ' (ADDITIONAL)', ''];
                    $subTotalAdd = 0;

                    foreach ($items as $item) {
                        $subTotalAdd += $item->rate;
                        $leftRows[] = ['Additional Breakdown', ''];
                        $leftRows[] = [
                            $item->name,
                            'Rp ' . number_format($item->rate, 0, ',', ',')
                        ];
                    }
                    $leftRows[] = ['TOTAL', 'Rp ' . number_format($subTotalAdd, 0, ',', ',')];
                    $leftRows[] = ['', ''];
                }
            }
        }

        foreach ($beo->beoPackages as $item) {
            if ($item->internalBreakdowns->isNotEmpty()) {
                $rightRows[] = [$item->package->name ?? '', '', '', '', ''];
                $rightRows[] = ['Function', 'Pax', 'Rate', 'Total', 'Remark', ''];

                $totalBreakdown = 0;
                foreach ($item->internalBreakdowns as $f) {
                    $subTotal = $f->pax * $f->rate;
                    $totalBreakdown += $subTotal;

                    $rightRows[] = [
                        $f->name ?? '-',
                        $f->pax,
                        'Rp ' . number_format($f->rate, 0, ',', ','),
                        'Rp ' . number_format($subTotal, 0, ',', ','),
                        $f->remark ?? '',
                        ''
                    ];
                }
                $rightRows[] = ['Total', '', '', 'Rp ' . number_format($totalBreakdown, 0, ',', ','), '', ''];
                $rightRows[] = ['', '', '', '', '', ''];
            }
        }

        $data[] = ['BILLING INSTRUCTION', '', 'INTERNAL BREAKDOWN', '', '', '', '', ''];

        $maxRows = max(count($leftRows), count($rightRows));

        for ($i = 0; $i < $maxRows; $i++) {
            $left = $leftRows[$i] ?? ['', ''];
            $right = $rightRows[$i] ?? ['', '', '', '', '', ''];

            $data[] = [
                $left[0],
                $left[1],
                $right[0],
                $right[1],
                $right[2],
                $right[3],
                $right[4] ?? '',
                $right[5] ?? '',
                ''
            ];
        }

        $data[] = ['PREPARED BY,', '', 'ACKNOWLEDGE BY,', '', '', 'APPROVED BY,', '', ''];

        $sortedApprovals = $beo->beoApprovals->sortBy('user.position.signature_positions');

        $signature = [];
        $this->signaturePaths = [];
        foreach ($sortedApprovals as $approval) {
            $name = $approval->user->name;
            $pos = $approval->user->position->name;
            $signature[] = "\n\n\n$name\n$pos";
            $this->signaturePaths[] = $approval->is_verify == 1 ? $approval->user->signature : null;
        }

        $data[] = [$signature[0] ?? '', '', $signature[1] ?? '', '', '', $signature[2] ?? '', '', ''];

        $data[] = ['APPROVED BY,', 'ACKNOWLEDGE BY,', '', 'ACKNOWLEDGE BY,', '', '', 'APPROVED BY,', ''];

        $data[] = [$signature[3] ?? '', $signature[4] ?? '', '', $signature[5] ?? '', '', '', $signature[6] ?? '', ''];

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT);

        $sheet->getPageMargins()->setTop(0.75 / 2.54);
        $sheet->getPageMargins()->setBottom(0.75 / 2.54);
        $sheet->getPageMargins()->setLeft(0.64 / 2.54);
        $sheet->getPageMargins()->setRight(0.64 / 2.54);
        $sheet->getPageMargins()->setHeader(0.3 / 2.54);
        $sheet->getPageMargins()->setFooter(0.3 / 2.54);

        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);

        $sheet->setShowGridlines(true);

        $sheet->mergeCells('A1:H1');

        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('E2:F2');
        $sheet->mergeCells('G2:H2');

        $rowData = 8;
        for ($i = 3; $i <= $rowData; $i++) {
            $sheet->mergeCells('B' . $i . ':' . 'C' . $i);
            $sheet->mergeCells('D' . $i . ':' . 'E' . $i);
            $sheet->mergeCells('F' . $i . ':' . 'H' . $i);
        }

        $sheet->mergeCells('B9:C9');
        $sheet->mergeCells('D9:E9');
        $sheet->mergeCells('F9:G9');

        $sheet->getStyle('A2:A8')->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B2:C8')->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('F2:H8')->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_CENTER);

        $totalRundown = $this->beo->beoPackages->count() + $this->beo->beoFunctions->count();
        $startRow = 10;
        for ($i = 0; $i < $totalRundown; $i++) {
            $currentRow = $startRow + $i;
            $sheet->mergeCells("B{$currentRow}:C{$currentRow}");
            $sheet->mergeCells("D{$currentRow}:E{$currentRow}");
            $sheet->mergeCells("F{$currentRow}:G{$currentRow}");

            $sheet->getStyle("B{$currentRow}:H{$currentRow}")->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_TOP);
        }

        $startSignedRow = $startRow + $totalRundown;
        $sheet->mergeCells("A{$startSignedRow}:H{$startSignedRow}");
        $signedRow = $startSignedRow + 1;
        $sheet->mergeCells("A{$signedRow}:H{$signedRow}");

        $startMenuRow = $signedRow + 1;
        $sheet->mergeCells("A{$startMenuRow}:B{$startMenuRow}");
        $sheet->mergeCells("C{$startMenuRow}:H{$startMenuRow}");

        $contentMenuRow = $startMenuRow + 1;
        $sheet->mergeCells("A{$contentMenuRow}:B{$contentMenuRow}");
        $sheet->mergeCells("C{$contentMenuRow}:H{$contentMenuRow}");

        $sheet->getStyle("A{$contentMenuRow}")->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("C{$contentMenuRow}")->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_TOP);

        $startBillingRow = $contentMenuRow + 1;

        $highestRow = $sheet->getHighestRow();

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $styleOutline = [
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $startInternalRow = $contentMenuRow + 1;
        $botInternalRow = $highestRow - 4;

        for ($i = $startInternalRow + 1; $i <= $botInternalRow; $i++) {
            $sheet->mergeCells("G{$i}:H{$i}");
        }

        $sheet->mergeCells("A{$startBillingRow}:B{$startBillingRow}");
        $sheet->mergeCells("C{$startBillingRow}:H{$startBillingRow}");
        $sheet->getStyle("A{$startBillingRow}:H{$startBillingRow}")->getFont()->setBold(true)->setSize(12);

        $ttdHeaderRow = $botInternalRow + 2;
        $sheet->mergeCells("A{$ttdHeaderRow}:B{$ttdHeaderRow}");
        $sheet->mergeCells("C{$ttdHeaderRow}:E{$ttdHeaderRow}");
        $sheet->mergeCells("F{$ttdHeaderRow}:H{$ttdHeaderRow}");

        $ttdContentRow = $ttdHeaderRow + 1;
        $sheet->mergeCells("A{$ttdContentRow}:B{$ttdContentRow}");
        $sheet->mergeCells("C{$ttdContentRow}:E{$ttdContentRow}");
        $sheet->mergeCells("F{$ttdContentRow}:H{$ttdContentRow}");

        $ttdHeaderRow2 = $ttdContentRow + 1;
        $sheet->mergeCells("B{$ttdHeaderRow2}:C{$ttdHeaderRow2}");
        $sheet->mergeCells("D{$ttdHeaderRow2}:F{$ttdHeaderRow2}");
        $sheet->mergeCells("G{$ttdHeaderRow2}:H{$ttdHeaderRow2}");

        $ttdContentRow2 = $ttdHeaderRow2 + 1;
        $sheet->mergeCells("B{$ttdContentRow2}:C{$ttdContentRow2}");
        $sheet->mergeCells("D{$ttdContentRow2}:F{$ttdContentRow2}");
        $sheet->mergeCells("G{$ttdContentRow2}:H{$ttdContentRow2}");

        $sheet->getStyle("A{$ttdContentRow}")->getAlignment()->setWrapText(true);
        $sheet->getStyle("C{$ttdContentRow}")->getAlignment()->setWrapText(true);
        $sheet->getStyle("F{$ttdContentRow}")->getAlignment()->setWrapText(true);

        $sheet->getStyle("A{$ttdContentRow2}")->getAlignment()->setWrapText(true);
        $sheet->getStyle("C{$ttdContentRow2}")->getAlignment()->setWrapText(true);
        $sheet->getStyle("E{$ttdContentRow2}")->getAlignment()->setWrapText(true);
        $sheet->getStyle("G{$ttdContentRow2}")->getAlignment()->setWrapText(true);

        $sheet->getStyle("A2:H8")->applyFromArray($styleArray);
        $sheet->getStyle("A9:H" . ($signedRow))->applyFromArray($styleArray);
        $sheet->getStyle("A{$startMenuRow}:H{$contentMenuRow}")->applyFromArray($styleArray);
        $sheet->getStyle("A{$startInternalRow}:B{$botInternalRow}")->applyFromArray($styleOutline);
        $sheet->getStyle("C{$startInternalRow}:H{$botInternalRow}")->applyFromArray($styleOutline);
        $sheet->getStyle("A{$ttdHeaderRow}:H{$ttdContentRow2}")->applyFromArray($styleArray);
        $sheet->getStyle("A{$startInternalRow}:H{$startInternalRow}")->applyFromArray($styleArray);

        $styleSigned = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D3D3D3']]
        ];
        $sheet->getStyle("A{$startSignedRow}:H{$signedRow}")->applyFromArray($styleSigned);

        $dynamicHeight = 20 * 16;
        $sheet->getRowDimension($contentMenuRow)->setRowHeight($dynamicHeight);
        $sheet->getStyle('D' . $contentMenuRow)->getAlignment()->setWrapText(true);
        $sheet->getRowDimension(8)->setRowHeight(32);

        $dynamicHeightTtd = 7 * 16;
        $sheet->getRowDimension($ttdContentRow)->setRowHeight($dynamicHeightTtd);
        $sheet->getStyle('A' . $ttdContentRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('E' . $ttdContentRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('I' . $ttdContentRow)->getAlignment()->setWrapText(true);

        $sheet->getRowDimension($ttdContentRow2)->setRowHeight($dynamicHeightTtd);
        $sheet->getStyle('A' . $ttdContentRow2)->getAlignment()->setWrapText(true);
        $sheet->getStyle('D' . $ttdContentRow2)->getAlignment()->setWrapText(true);
        $sheet->getStyle('G' . $ttdContentRow2)->getAlignment()->setWrapText(true);
        $sheet->getStyle('J' . $ttdContentRow2)->getAlignment()->setWrapText(true);

        $sigMap = [
            0 => ['col' => 'A', 'row' => $ttdContentRow],
            1 => ['col' => 'C', 'row' => $ttdContentRow],
            2 => ['col' => 'F', 'row' => $ttdContentRow],
            3 => ['col' => 'A', 'row' => $ttdContentRow2],
            4 => ['col' => 'B', 'row' => $ttdContentRow2],
            5 => ['col' => 'D', 'row' => $ttdContentRow2],
            6 => ['col' => 'G', 'row' => $ttdContentRow2],
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

        return [
            1 => ['font' => ['bold' => true, 'size' => 16], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            2 => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D3D3D3']]],
            "C{$contentMenuRow}" => ['font' => ['size' => 9], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]],
            "A{$contentMenuRow}" => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'A9:H9' => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D3D3D3']]],
            "A3:A8" => ['font' => ['bold' => true]],
            "D3:D8" => ['font' => ['bold' => true]],
            "B3:B5" => ['font' => ['bold' => true]],
            "F3" => ['font' => ['bold' => true]],
            "B8" => ['font' => ['bold' => true]],
            "A{$startMenuRow}" => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D3D3D3']]],
            "C{$startMenuRow}" => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D3D3D3']]],
            "A{$startInternalRow}:H{$startInternalRow}" => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D3D3D3']]],
            "A{$ttdHeaderRow}:H{$ttdHeaderRow}" => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D3D3D3']]],
            "A{$ttdHeaderRow2}:H{$ttdHeaderRow2}" => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D3D3D3']]],
            "A{$ttdContentRow}:H{$ttdContentRow}" => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]],
            "A{$ttdContentRow2}:H{$ttdContentRow2}" => ['font' => ['bold' => true], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]],
        ];
    }

    public function title(): string
    {
        return 'BEO ' . $this->beo->client->company;
    }
}
