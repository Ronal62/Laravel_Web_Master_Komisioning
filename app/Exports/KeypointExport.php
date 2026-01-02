<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class KeypointExport implements FromView, WithTitle, WithEvents
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
     * Register events untuk styling manual setelah sheet dibuat
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // 1. Set Default Font ke Arial (Mirip gambar)
                $sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial');
                $sheet->getParent()->getDefaultStyle()->getFont()->setSize(10);

                // 2. Set Vertical Alignment Center untuk semua cell
                $sheet->getDefaultRowDimension()->setRowHeight(-1); // Auto height
                $sheet->getParent()->getDefaultStyle()->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

                // 3. Loop untuk mencari area tabel dan memberi Border
                // Karena kita menggunakan View, kita tidak tahu pasti baris mana berakhir,
                // tapi kita bisa menargetkan range luas atau menargetkan cell yang punya value.

                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $range = 'A1:' . $highestColumn . $highestRow;

                // Set Wrap Text untuk seluruh dokumen agar text panjang turun ke bawah
                $sheet->getStyle($range)->getAlignment()->setWrapText(true);
            },
        ];
    }
}
