<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class KeypointExport implements FromView, WithTitle, WithEvents, WithColumnWidths, WithDefaultStyles
{
    protected $data;
    protected $fromDate;
    protected $toDate;

    public function __construct($data, $fromDate, $toDate)
    {
        $this->data = $data;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function view(): View
    {
        return view('excel.keypoint_excel', [
            'keypoints' => $this->data,
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
            'totalRecords' => count($this->data)
        ]);
    }

    public function title(): string
    {
        return 'Data Keypoint';
    }

    /**
     * Define column widths
     */
    public function columnWidths(): array
    {
        return [
            'A' => 12,  // ADD-MS
            'B' => 12,  // ADD-RTU
            'C' => 18,  // STATUS/CONTROL/METER
            'D' => 15,  // VALUE
            'E' => 8,   // OK
            'F' => 8,   // NOK
            'G' => 12,  // KET
            'H' => 18,  // HARDWARE/SYSTEM
            'I' => 10,  // OK/NOK
            'J' => 12,  // VALUE
        ];
    }

    /**
     * Default styles for the entire sheet
     */
    public function defaultStyles(\PhpOffice\PhpSpreadsheet\Style\Style $defaultStyle)
    {
        return [
            'font' => [
                'name' => 'Arial',
                'size' => 10,
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
    }

    /**
     * Register events untuk styling setelah sheet dibuat
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                // Page Setup - Portrait, A4
                $sheet->getPageSetup()
                    ->setOrientation(PageSetup::ORIENTATION_PORTRAIT)
                    ->setPaperSize(PageSetup::PAPERSIZE_A4)
                    ->setFitToWidth(1)
                    ->setFitToHeight(0);

                // Set print margins
                $sheet->getPageMargins()
                    ->setTop(0.5)
                    ->setRight(0.3)
                    ->setLeft(0.3)
                    ->setBottom(0.5);

                // Wrap text untuk semua cell
                $sheet->getStyle('A1:' . $highestColumn . $highestRow)
                    ->getAlignment()
                    ->setWrapText(true);

                // Style khusus untuk header rows (setiap halaman)
                $this->applyHeaderStyles($sheet, $highestRow);

                // Freeze pane on first row (optional)
                // $sheet->freezePane('A4');
            },
        ];
    }

    /**
     * Apply styling untuk header di setiap page
     */
    private function applyHeaderStyles(Worksheet $sheet, int $highestRow)
    {
        // Iterate through cells dan apply styling berdasarkan content/position
        $rowsPerPage = 50; // Perkiraan rows per page

        for ($row = 1; $row <= $highestRow; $row++) {
            // Cek jika ini adalah header row (biasanya ada background color)
            $cellA = $sheet->getCell('A' . $row)->getValue();

            // Header table detection
            if (in_array($cellA, ['ADD-MS', 'NO. DOKUMEN'])) {
                // Apply header style
                $sheet->getStyle('A' . $row . ':J' . $row)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['rgb' => 'CCCCCC'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);
            }

            // Set row height untuk data rows
            $sheet->getRowDimension($row)->setRowHeight(-1); // Auto
        }
    }
}