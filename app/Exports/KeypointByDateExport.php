<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class KeypointMeteringExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithEvents
{
    protected $fromDate;
    protected $toDate;
    protected $keypoints;

    public function __construct($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->loadData();
    }

    private function loadData()
    {
        $this->keypoints = DB::table('tb_formkp')
            ->whereDate('tgl_komisioning', '>=', $this->fromDate)
            ->whereDate('tgl_komisioning', '<=', $this->toDate)
            ->orderBy('tgl_komisioning', 'asc')
            ->get();
    }

    private function getMeteringStatus($value)
    {
        if (empty($value)) return '-';

        if (strpos($value, ',') !== false) {
            $items = array_map('trim', explode(',', $value));
            $statuses = [];
            foreach ($items as $item) {
                if (preg_match('/_(\d+)$/', $item, $matches)) {
                    $code = (int)$matches[1];
                    if ($code == 1) $statuses[] = 'OK';
                    elseif ($code == 2) $statuses[] = 'NOK';
                    elseif ($code == 5) $statuses[] = 'SLD';
                }
            }
            return implode(', ', array_unique($statuses)) ?: '-';
        }

        if (preg_match('/_(\d+)$/', $value, $matches)) {
            $code = (int)$matches[1];
            if ($code == 1) return 'OK';
            elseif ($code == 2) return 'NOK';
            elseif ($code == 5) return 'SLD';
        }

        return '-';
    }

    public function collection()
    {
        $data = collect();
        $no = 1;

        foreach ($this->keypoints as $row) {
            $data->push([
                'no' => $no++,
                'tgl' => Carbon::parse($row->tgl_komisioning)->format('d-m-Y'),
                'nama' => $row->nama_lbs,
                'penyulang' => $row->nama_peny,
                // Metering values
                'hz' => $this->getMeteringStatus($row->t_hz ?? ''),
                'iavg' => $this->getMeteringStatus($row->t_iavg ?? ''),
                'ir' => $this->getMeteringStatus($row->t_ir ?? ''),
                'is' => $this->getMeteringStatus($row->t_is ?? ''),
                'it' => $this->getMeteringStatus($row->t_it ?? ''),
                'in' => $this->getMeteringStatus($row->t_in ?? ''),
                'pf' => $this->getMeteringStatus($row->t_pf ?? ''),
                'vavg' => $this->getMeteringStatus($row->t_vavg ?? ''),
                'vrin' => $this->getMeteringStatus($row->t_vrin ?? ''),
                'vsin' => $this->getMeteringStatus($row->t_vsin ?? ''),
                'vtin' => $this->getMeteringStatus($row->t_vtin ?? ''),
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Keypoint',
            'Penyulang',
            'HZ',
            'I AVG',
            'IR',
            'IS',
            'IT',
            'IN',
            'PF',
            'V AVG',
            'V-R IN',
            'V-S IN',
            'V-T IN',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E65100'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Metering Detail';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $this->keypoints->count() + 1;
                $lastColumn = 'O';

                // Apply borders
                $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Auto-size columns
                foreach (range('A', 'O') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Center align
                $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Freeze header
                $sheet->freezePane('A2');
            },
        ];
    }
}
