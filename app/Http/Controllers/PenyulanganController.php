<?php

namespace App\Http\Controllers;

use App\Models\Penyulangan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use TCPDF;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class PenyulanganController extends Controller
{
    public function index()
    {
        return view('pages.penyulangan.index');
    }


    public function data(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $searchValue = $request->search['value'];
        $orderColumnIndex = $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $columns = $request->columns;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        // ✅ NEW: Category filter from dashboard
        $category = $request->category;

        $pelrtuMap = DB::table('tb_pelaksana_rtu')->pluck('nama_pelrtu', 'id_pelrtu')->toArray();

        $query = DB::table('tb_formpeny')
            ->select(
                'tb_formpeny.id_peny',
                'tb_formpeny.tgl_kom',
                'tb_formpeny.nama_peny',
                'tb_formpeny.id_gi',
                'tb_formpeny.id_rtugi',
                'tb_formpeny.catatanpeny',
                'tb_formpeny.nama_user',
                'tb_formpeny.id_pelrtu'
            );

        // Date filter
        if ($fromDate && $toDate) {
            $query->whereDate('tb_formpeny.tgl_kom', '>=', $fromDate)
                ->whereDate('tb_formpeny.tgl_kom', '<=', $toDate);
        } elseif ($fromDate) {
            $query->whereDate('tb_formpeny.tgl_kom', '>=', $fromDate);
        } elseif ($toDate) {
            $query->whereDate('tb_formpeny.tgl_kom', '<=', $toDate);
        }

        // ✅ NEW: Category filter from dashboard
        if (!empty($category)) {
            switch ($category) {
                case 'gardu_induk':
                    $query->whereNotNull('tb_formpeny.id_gi')
                        ->where('tb_formpeny.id_gi', '!=', '');
                    break;
                case 'rtu_gi':
                    $query->whereNotNull('tb_formpeny.id_rtugi')
                        ->where('tb_formpeny.id_rtugi', '>', 0);
                    break;
            }
        }

        $records = $query->get();

        $records = $records->map(function ($row) use ($pelrtuMap) {
            $ids = json_decode($row->id_pelrtu, true) ?? [];
            $names = [];
            foreach ($ids as $id) {
                $id = trim($id, '"');
                if (isset($pelrtuMap[$id])) {
                    $names[] = $pelrtuMap[$id];
                }
            }
            $row->pic_rtu_names = implode(', ', $names);
            return $row;
        });

        if (!empty($searchValue)) {
            $records = $records->filter(function ($row) use ($searchValue) {
                return stripos($row->nama_peny, $searchValue) !== false ||
                    stripos($row->id_gi, $searchValue) !== false ||
                    stripos($row->id_rtugi, $searchValue) !== false ||
                    stripos($row->catatanpeny, $searchValue) !== false ||
                    stripos($row->nama_user, $searchValue) !== false ||
                    stripos($row->pic_rtu_names, $searchValue) !== false;
            });
        }

        foreach ($columns as $index => $col) {
            $colSearchValue = $col['search']['value'];
            if (!empty($colSearchValue) && $col['searchable'] == 'true') {
                $records = $records->filter(function ($row) use ($index, $colSearchValue) {
                    switch ($index) {
                        case 0:
                            return $row->tgl_kom && stripos(Carbon::parse($row->tgl_kom)->format('l, d-m-Y'), $colSearchValue) !== false;
                        case 1:
                            return stripos($row->nama_peny, $colSearchValue) !== false;
                        case 2:
                            return stripos($row->id_gi, $colSearchValue) !== false;
                        case 3:
                            return stripos($row->id_rtugi, $colSearchValue) !== false;
                        case 4:
                            return stripos($row->catatanpeny, $colSearchValue) !== false;
                        case 5:
                            return stripos($row->nama_user, $colSearchValue) !== false;
                        case 6:
                            return stripos($row->pic_rtu_names, $colSearchValue) !== false;
                    }
                    return true;
                });
            }
        }

        $orderFieldMap = [
            0 => 'tgl_kom',
            1 => 'nama_peny',
            2 => 'id_gi',
            3 => 'id_rtugi',
            4 => 'catatanpeny',
            5 => 'nama_user',
            6 => 'pic_rtu_names',
        ];
        $orderField = $orderFieldMap[$orderColumnIndex] ?? 'tgl_kom';

        if ($orderDir === 'desc') {
            $records = $records->sortByDesc($orderField);
        } else {
            $records = $records->sortBy($orderField);
        }

        $totalRecords = DB::table('tb_formpeny')->count();
        $totalFiltered = $records->count();

        $data = $records->slice($start, $length)->map(function ($row) {
            $row->tgl_kom = $row->tgl_kom ? Carbon::parse($row->tgl_kom)->format('l, d-m-Y') : '';
            $row->id_pelrtu = $row->pic_rtu_names;
            $row->action = '
            <a href="' . route('penyulangan.clone', $row->id_peny) . '" class="btn btn-icon btn-round btn-primary">
                <i class="far fa-clone"></i>
            </a>
            <a href="' . route('penyulangan.edit', $row->id_peny) . '" class="btn btn-icon btn-round btn-warning">
                <i class="fa fa-pen"></i>
            </a>
            <a href="' . route('penyulangan.exportsinglepdf', $row->id_peny) . '" target="_blank" class="btn btn-icon btn-round btn-danger">
                <i class="fas fa-file-pdf"></i>
            </a>
            <a href="' . route('penyulangan.exportsingleexcel', $row->id_peny) . '" class="btn btn-icon btn-round btn-success" title="Export Excel">
                <i class="fas fa-file-excel"></i>
            </a>

            <form action="' . route('penyulangan.destroy', $row->id_peny) . '" method="POST" style="display:inline;">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="submit" class="btn btn-icon btn-round btn-secondary" onclick="return confirm(\'Are you sure you want to delete this penyulangan?\')">
                    <i class="fa fa-trash"></i>
                </button>
            </form>
        ';
            unset($row->pic_rtu_names);
            return $row;
        })->values()->toArray();

        return response()->json([
            'draw' => (int)$draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }


    public function getData(Request $request)
    {
        $query = DB::table('tb_formpeny')
            ->leftJoin('tb_merkrtugi', 'tb_formpeny.id_rtugi', '=', 'tb_merkrtugi.id_rtugi')
            ->select([
                'tb_formpeny.id_peny',
                'tb_formpeny.tgl_kom',
                'tb_formpeny.nama_peny',
                'tb_formpeny.id_gi',
                DB::raw("COALESCE(tb_merkrtugi.nama_rtugi, '') as id_rtugi"),
                'tb_formpeny.catatanpeny',
                'tb_formpeny.nama_user',
                'tb_formpeny.id_pelrtu'
            ]);

        // Date filter
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('tb_formpeny.tgl_kom', [$request->from_date, $request->to_date]);
        }

        // Category filter
        if ($request->filled('category')) {
            switch ($request->category) {
                case 'gardu_induk':
                    $query->whereNotNull('tb_formpeny.id_gi')
                        ->where('tb_formpeny.id_gi', '!=', '');
                    break;
                case 'rtu_gi':
                    $query->whereNotNull('tb_formpeny.id_rtugi')
                        ->where('tb_formpeny.id_rtugi', '>', 0);
                    break;
            }
        }

        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group">';
                $btn .= '<a href="' . route('penyulangan.show', $row->id_peny) . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>';
                $btn .= '<a href="' . route('penyulangan.edit', $row->id_peny) . '" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>';
                $btn .= '<button class="btn btn-sm btn-danger" onclick="deleteData(' . $row->id_peny . ')"><i class="fas fa-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function exportSinglePdf($id)
    {
        // 1. Get Main Data - tanpa JOIN ke tabel yang tidak ada
        $penyulangan = DB::table('tb_formpeny')
            ->where('id_peny', $id)
            ->first();

        if (!$penyulangan) {
            abort(404, 'Data Penyulangan tidak ditemukan');
        }

        // 2. Format tanggal
        $penyulangan->tgl_kom = $penyulangan->tgl_kom ? Carbon::parse($penyulangan->tgl_kom)->format('d-m-Y') : '-';

        // 3. Set default values untuk field yang tidak ada di tabel
        $penyulangan->nama_rtugi = $penyulangan->id_rtugi ?? '-';
        $penyulangan->nama_medkom = $penyulangan->id_medkom ?? '-';
        $penyulangan->jenis_komkp = $penyulangan->id_komkp ?? '-';

        // 4. Get Pelaksana MS (PIC Master)
        $pelMsIds = json_decode($penyulangan->id_pelms ?? '[]', true) ?? [];
        $pelaksanaMs = collect();
        if (!empty($pelMsIds)) {
            $pelaksanaMs = DB::table('tb_picmaster')
                ->whereIn('id_picmaster', $pelMsIds)
                ->get();
        }

        // 5. Get Pelaksana RTU (Field Engineer)
        $pelRtuIds = json_decode($penyulangan->id_pelrtu ?? '[]', true) ?? [];
        $pelaksanaRtu = collect();
        if (!empty($pelRtuIds)) {
            $pelaksanaRtu = DB::table('tb_pelaksana_rtu')
                ->whereIn('id_pelrtu', $pelRtuIds)
                ->get();
        }

        // 6. Parse Status Data
        $statusData = $this->parseStatusDataPeny($penyulangan);

        // 7. Parse Control Data
        $controlData = $this->parseControlDataPeny($penyulangan);

        // 8. Parse Metering Data
        $meteringData = $this->parseMeteringDataPeny($penyulangan);

        // 9. Load View dengan semua data
        $pdf = Pdf::loadView('pdf.singlepenyulangan_dompdf', [
            'row' => $penyulangan,
            'pelaksanaMs' => $pelaksanaMs,
            'pelaksanaRtu' => $pelaksanaRtu,
            'statusData' => $statusData,
            'controlData' => $controlData,
            'meteringData' => $meteringData,
        ]);

        // 10. Settings
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'Arial',
            'dpi' => 150,
        ]);

        // 11. Generate filename
        $filename = 'Penyulangan_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $penyulangan->nama_peny ?? 'Export') . '_' . $id . '.pdf';

        // 12. Download
        return $pdf->download($filename);
    }

    /**
     * Parse checkbox value string menjadi array
     */
    private function parseCheckboxValue($value)
    {
        if (empty($value)) {
            return [];
        }
        return array_map('trim', explode(',', $value));
    }

    /**
     * Get check value (1=OK, 2=NOK, 3=LOG, 4=SLD) dari status array
     */
    private function getCheckValue($statusArray, $prefix)
    {
        $checks = [];

        foreach ($statusArray as $item) {
            if (strpos($item, $prefix) === 0) {
                preg_match('/_(\d+)$/', $item, $matches);
                if (isset($matches[1])) {
                    $checks[] = (int)$matches[1];
                }
            }
        }

        return $checks;
    }

    /**
     * Parse Status Data untuk Penyulangan
     */
    private function parseStatusDataPeny($penyulangan)
    {
        $statuses = [];

        $s_cb = $this->parseCheckboxValue($penyulangan->s_cb ?? '');
        $s_lr = $this->parseCheckboxValue($penyulangan->s_lr ?? '');
        $s_ocr = $this->parseCheckboxValue($penyulangan->s_ocr ?? '');
        $s_ocri = $this->parseCheckboxValue($penyulangan->s_ocri ?? '');
        $s_dgr = $this->parseCheckboxValue($penyulangan->s_dgr ?? '');
        $s_cbtr = $this->parseCheckboxValue($penyulangan->s_cbtr ?? '');
        $s_ar = $this->parseCheckboxValue($penyulangan->s_ar ?? '');
        $s_aru = $this->parseCheckboxValue($penyulangan->s_aru ?? '');
        $s_tc = $this->parseCheckboxValue($penyulangan->s_tc ?? '');

        // CB Status
        $statuses[] = [
            'name' => 'CB',
            'row1' => [
                'label' => 'Open',
                'address' => $penyulangan->scb_open_address ?? '',
                'obj' => $penyulangan->scb_open_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_cb, 'open'),
            ],
            'row2' => [
                'label' => 'Close',
                'address' => $penyulangan->scb_close_address ?? '',
                'obj' => $penyulangan->scb_close_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_cb, 'close'),
            ],
        ];

        // L/R Status
        $statuses[] = [
            'name' => 'L/R',
            'row1' => [
                'label' => 'Local',
                'address' => $penyulangan->slocal_address ?? '',
                'obj' => $penyulangan->slocal_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_lr, 'local'),
            ],
            'row2' => [
                'label' => 'Remote',
                'address' => $penyulangan->sremote_address ?? '',
                'obj' => $penyulangan->sremote_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_lr, 'remote'),
            ],
        ];

        // OCR Status
        $statuses[] = [
            'name' => 'OCR',
            'row1' => [
                'label' => 'Disable',
                'address' => $penyulangan->socr_dis_address ?? '',
                'obj' => $penyulangan->socr_dis_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_ocr, 'ocrd'),
            ],
            'row2' => [
                'label' => 'Appear',
                'address' => $penyulangan->socr_app_address ?? '',
                'obj' => $penyulangan->socr_app_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_ocr, 'ocra'),
            ],
        ];

        // OCRI Status
        $statuses[] = [
            'name' => 'OCRI',
            'row1' => [
                'label' => 'Disable',
                'address' => $penyulangan->socri_dis_address ?? '',
                'obj' => $penyulangan->socri_dis_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_ocri, 'ocrid'),
            ],
            'row2' => [
                'label' => 'Appear',
                'address' => $penyulangan->socri_app_address ?? '',
                'obj' => $penyulangan->socri_app_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_ocri, 'ocria'),
            ],
        ];

        // DGR Status
        $statuses[] = [
            'name' => 'DGR',
            'row1' => [
                'label' => 'Disable',
                'address' => $penyulangan->sdgr_dis_address ?? '',
                'obj' => $penyulangan->sdgr_dis_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_dgr, 'dgrd'),
            ],
            'row2' => [
                'label' => 'Appear',
                'address' => $penyulangan->sdgr_app_address ?? '',
                'obj' => $penyulangan->sdgr_app_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_dgr, 'dgra'),
            ],
        ];

        // CBTR Status
        $statuses[] = [
            'name' => 'CBTR',
            'row1' => [
                'label' => 'Disable',
                'address' => $penyulangan->scbtr_dis_address ?? '',
                'obj' => $penyulangan->scbtr_dis_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_cbtr, 'cbtrd'),
            ],
            'row2' => [
                'label' => 'Appear',
                'address' => $penyulangan->scbtr_app_address ?? '',
                'obj' => $penyulangan->scbtr_app_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_cbtr, 'cbtra'),
            ],
        ];

        // AR Status
        $statuses[] = [
            'name' => 'AR',
            'row1' => [
                'label' => 'Disable',
                'address' => $penyulangan->sar_dis_address ?? '',
                'obj' => $penyulangan->sar_dis_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_ar, 'ard'),
            ],
            'row2' => [
                'label' => 'Appear',
                'address' => $penyulangan->sar_app_address ?? '',
                'obj' => $penyulangan->sar_app_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_ar, 'ara'),
            ],
        ];

        // ARU Status
        $statuses[] = [
            'name' => 'ARU',
            'row1' => [
                'label' => 'Disable',
                'address' => $penyulangan->saru_dis_address ?? '',
                'obj' => $penyulangan->saru_dis_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_aru, 'arud'),
            ],
            'row2' => [
                'label' => 'Appear',
                'address' => $penyulangan->saru_app_address ?? '',
                'obj' => $penyulangan->saru_app_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_aru, 'arua'),
            ],
        ];

        // TC Status
        $statuses[] = [
            'name' => 'TC',
            'row1' => [
                'label' => 'Disable',
                'address' => $penyulangan->stc_dis_address ?? '',
                'obj' => $penyulangan->stc_dis_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_tc, 'tcd'),
            ],
            'row2' => [
                'label' => 'Appear',
                'address' => $penyulangan->stc_app_address ?? '',
                'obj' => $penyulangan->stc_app_objfrmt ?? '',
                'checks' => $this->getCheckValue($s_tc, 'tca'),
            ],
        ];

        return $statuses;
    }

    /**
     * Parse Control Data untuk Penyulangan
     */
    private function parseControlDataPeny($penyulangan)
    {
        $controls = [];

        $c_cb = $this->parseCheckboxValue($penyulangan->c_cb ?? '');
        $c_aru = $this->parseCheckboxValue($penyulangan->c_aru ?? '');
        $c_rst = $this->parseCheckboxValue($penyulangan->c_rst ?? '');
        $c_tc = $this->parseCheckboxValue($penyulangan->c_tc ?? '');

        // CB Control
        $controls[] = [
            'name' => 'CB',
            'row1' => [
                'label' => 'Open',
                'address' => $penyulangan->ccb_open_address ?? '',
                'obj' => $penyulangan->ccb_open_objfrmt ?? '',
                'checks' => $this->getCheckValue($c_cb, 'ccb_open'),
            ],
            'row2' => [
                'label' => 'Close',
                'address' => $penyulangan->ccb_close_address ?? '',
                'obj' => $penyulangan->ccb_close_objfrmt ?? '',
                'checks' => $this->getCheckValue($c_cb, 'ccb_close'),
            ],
        ];

        // ARU Control
        $controls[] = [
            'name' => 'ARU',
            'row1' => [
                'label' => 'Use',
                'address' => $penyulangan->caru_use_address ?? '',
                'obj' => $penyulangan->caru_use_objfrmt ?? '',
                'checks' => $this->getCheckValue($c_aru, 'caru'),
            ],
            'row2' => [
                'label' => 'Unuse',
                'address' => $penyulangan->caru_unuse_address ?? '',
                'obj' => $penyulangan->caru_unuse_objfrmt ?? '',
                'checks' => $this->getCheckValue($c_aru, 'carun'),
            ],
        ];

        // Reset Control (Single Row)
        $controls[] = [
            'name' => 'RESET',
            'single' => true,
            'row1' => [
                'label' => 'Reset',
                'address' => $penyulangan->creset_on_address ?? '',
                'obj' => $penyulangan->creset_on_objfrmt ?? '',
                'checks' => $this->getCheckValue($c_rst, 'rrctrl_on'),
            ],
        ];

        // TC Control
        $controls[] = [
            'name' => 'TC',
            'row1' => [
                'label' => 'Raiser',
                'address' => $penyulangan->ctc_raiser_address ?? '',
                'obj' => $penyulangan->ctc_raiser_objfrmt ?? '',
                'checks' => $this->getCheckValue($c_tc, 'ctcr'),
            ],
            'row2' => [
                'label' => 'Lower',
                'address' => $penyulangan->ctc_lower_address ?? '',
                'obj' => $penyulangan->ctc_lower_objfrmt ?? '',
                'checks' => $this->getCheckValue($c_tc, 'ctcl'),
            ],
        ];

        return $controls;
    }

    /**
     * Parse Metering Data untuk Penyulangan
     */
    private function parseMeteringDataPeny($penyulangan)
    {
        $fields = [
            ['name' => 'IR', 'prefix' => 'ir', 'isPseudo' => false],
            ['name' => 'IS', 'prefix' => 'is', 'isPseudo' => false],
            ['name' => 'IT', 'prefix' => 'it', 'isPseudo' => false],
            ['name' => 'IFR', 'prefix' => 'ifr', 'isPseudo' => false],
            ['name' => 'IFS', 'prefix' => 'ifs', 'isPseudo' => false],
            ['name' => 'IFT', 'prefix' => 'ift', 'isPseudo' => false],
            ['name' => 'IFN', 'prefix' => 'ifn', 'isPseudo' => false],
            ['name' => 'IFR (Pseudo)', 'prefix' => 'ifr_psuedo', 'isPseudo' => true],
            ['name' => 'IFS (Pseudo)', 'prefix' => 'ifs_psuedo', 'isPseudo' => true],
            ['name' => 'IFT (Pseudo)', 'prefix' => 'ift_psuedo', 'isPseudo' => true],
            ['name' => 'IFN (Pseudo)', 'prefix' => 'ifn_psuedo', 'isPseudo' => true],
            ['name' => 'KV0', 'prefix' => 'kv0', 'isPseudo' => false],
        ];

        return collect($fields)->map(function ($field) use ($penyulangan) {
            $prefix = $field['prefix'];
            $addressKey = "{$prefix}_address";
            $objKey = "{$prefix}_objfrmt";
            $rtuKey = "{$prefix}_rtu";
            $msKey = "{$prefix}_ms";
            $scaleKey = "{$prefix}_scale";
            $checkKey = "t_{$prefix}";

            return [
                'name' => $field['name'],
                'address' => $penyulangan->$addressKey ?? '',
                'obj' => $penyulangan->$objKey ?? '',
                'rtu' => $penyulangan->$rtuKey ?? '',
                'ms' => $penyulangan->$msKey ?? '',
                'scale' => $penyulangan->$scaleKey ?? '',
                'checks' => $this->getMeteringCheckValuePeny($penyulangan->$checkKey ?? ''),
                'isPseudo' => $field['isPseudo'],
            ];
        })->toArray();
    }

    /**
     * Get metering check values (1=OK, 2=NOK, 5=SLD)
     */
    private function getMeteringCheckValuePeny($value)
    {
        $checks = [];

        if (empty($value) || $value === null) {
            return $checks;
        }

        $value = (string) $value;

        if (strpos($value, ',') !== false) {
            $items = array_map('trim', explode(',', $value));
            foreach ($items as $item) {
                if (is_numeric($item)) {
                    $checks[] = (int) $item;
                } elseif (preg_match('/_(\d+)$/', $item, $matches)) {
                    $checks[] = (int) $matches[1];
                } elseif (preg_match('/(\d+)$/', $item, $matches)) {
                    $checks[] = (int) $matches[1];
                }
            }
        } elseif (strpos($value, '[') === 0) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $checks = array_map('intval', $decoded);
            }
        } else {
            if (is_numeric($value)) {
                $checks[] = (int) $value;
            } elseif (preg_match('/_(\d+)$/', $value, $matches)) {
                $checks[] = (int) $matches[1];
            } elseif (preg_match('/(\d+)$/', $value, $matches)) {
                $checks[] = (int) $matches[1];
            }
        }

        return array_unique($checks);
    }


    public function exportSingleExcel($id)
    {
        // 1. Get Main Data
        $penyulangan = DB::table('tb_formpeny')
            ->where('id_peny', $id)
            ->first();

        if (!$penyulangan) {
            abort(404, 'Data Penyulangan tidak ditemukan');
        }

        // 2. Format tanggal
        $penyulangan->tgl_kom = $penyulangan->tgl_kom ? Carbon::parse($penyulangan->tgl_kom)->format('d-m-Y') : '-';

        // 3. Set default values
        $penyulangan->nama_rtugi = $penyulangan->id_rtugi ?? '-';
        $penyulangan->nama_medkom = $penyulangan->id_medkom ?? '-';
        $penyulangan->jenis_komkp = $penyulangan->id_komkp ?? '-';

        // 4. Get Pelaksana MS (PIC Master)
        $pelMsIds = json_decode($penyulangan->id_pelms ?? '[]', true) ?? [];
        $pelaksanaMs = collect();
        if (!empty($pelMsIds)) {
            $pelaksanaMs = DB::table('tb_picmaster')
                ->whereIn('id_picmaster', $pelMsIds)
                ->get();
        }

        // 5. Get Pelaksana RTU (Field Engineer)
        $pelRtuIds = json_decode($penyulangan->id_pelrtu ?? '[]', true) ?? [];
        $pelaksanaRtu = collect();
        if (!empty($pelRtuIds)) {
            $pelaksanaRtu = DB::table('tb_pelaksana_rtu')
                ->whereIn('id_pelrtu', $pelRtuIds)
                ->get();
        }

        // 6. Parse Data
        $statusData = $this->parseStatusDataPeny($penyulangan);
        $controlData = $this->parseControlDataPeny($penyulangan);
        $meteringData = $this->parseMeteringDataPeny($penyulangan);

        // 7. Generate filename
        $filename = 'Penyulangan_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $penyulangan->nama_peny ?? 'Export') . '_' . $id . '.xls';

        // 8. Set headers for Excel download
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ];

        // 9. Return view with Excel headers
        return response()->view('excel.singlepenyulangan_excel', [
            'row' => $penyulangan,
            'pelaksanaMs' => $pelaksanaMs,
            'pelaksanaRtu' => $pelaksanaRtu,
            'statusData' => $statusData,
            'controlData' => $controlData,
            'meteringData' => $meteringData,
        ])->withHeaders($headers);
    }


    public function create()
    {
        $rtugi = DB::table('tb_merkrtugi')->get();
        $medkom = DB::table('tb_medkom')->get();
        // $garduinduk = DB::table('tb_garduinduk')->get();
        $garduinduk = DB::connection('masterdata')->table('dg_mvcell')->select('gardu_induk')->distinct()->get();
        $komkp = DB::table('tb_komkp')->get();
        $pelms = DB::table('tb_picmaster')->get();
        $pelrtus = DB::table('tb_pelaksana_rtu')->get();
        return view('pages.penyulangan.add', compact('rtugi', 'medkom', 'garduinduk', 'komkp', 'pelms', 'pelrtus', ));
    }
    public function getKubikels($gardu_induk)
    {
        $kubikels = DB::connection('masterdata')->table('dg_mvcell')
            ->where('gardu_induk', urldecode($gardu_induk))
            ->pluck('nama_kubikel');
        return response()->json($kubikels);
    }

    public function store(Request $request)
    {
        $idPelmsInput = $request->input('id_pelms', '');
        $idPelmsArray = !empty($idPelmsInput) ? array_filter(array_map('trim', explode(',', $idPelmsInput))) : [];

        $idPelrtuInput = $request->input('id_pelrtu', '');
        $idPelrtuArray = !empty($idPelrtuInput) ? array_filter(array_map('trim', explode(',', $idPelrtuInput))) : [];

        $arrayFields = [
            's_cb',
            's_lr',
            's_ocr',
            's_ocri',
            's_dgr',
            's_cbtr',
            's_ar',
            's_aru',
            's_tc',
            'c_cb',
            'c_aru',
            'c_rst',
            'c_tc',
            't_ir',
            't_is',
            't_it',
            't_ifr',
            't_ifs',
            't_ift',
            't_ifn',
            't_ifr_psuedo',
            't_ifs_psuedo',
            't_ift_psuedo',
            't_ifn_psuedo',
            't_kv0'
        ];

        $validCheckboxValues = [
            'open_1',
            'open_2',
            'open_3',
            'open_4',
            'open_5',
            'close_1',
            'close_2',
            'close_3',
            'close_4',
            'close_5',
            'local_1',
            'local_2',
            'local_3',
            'local_4',
            'local_5',
            'remote_1',
            'remote_2',
            'remote_3',
            'remote_4',
            'remote_5',
            'ocrd_1',
            'ocrd_2',
            'ocrd_3',
            'ocrd_4',
            'ocrd_5',
            'ocra_1',
            'ocra_2',
            'ocra_3',
            'ocra_4',
            'ocra_5',
            'ocrid_1',
            'ocrid_2',
            'ocrid_3',
            'ocrid_4',
            'ocrid_5',
            'ocria_1',
            'ocria_2',
            'ocria_3',
            'ocria_4',
            'ocria_5',
            'dgrd_1',
            'dgrd_2',
            'dgrd_3',
            'dgrd_4',
            'dgrd_5',
            'dgra_1',
            'dgra_2',
            'dgra_3',
            'dgra_4',
            'dgra_5',
            'cbtrd_1',
            'cbtrd_2',
            'cbtrd_3',
            'cbtrd_4',
            'cbtrd_5',
            'cbtra_1',
            'cbtra_2',
            'cbtra_3',
            'cbtra_4',
            'cbtra_5',
            'ard_1',
            'ard_2',
            'ard_3',
            'ard_4',
            'ard_5',
            'ara_1',
            'ara_2',
            'ara_3',
            'ara_4',
            'ara_5',
            'arud_1',
            'arud_2',
            'arud_3',
            'arud_4',
            'arud_5',
            'arua_1',
            'arua_2',
            'arua_3',
            'arua_4',
            'arua_5',
            'tcd_1',
            'tcd_2',
            'tcd_3',
            'tcd_4',
            'tcd_5',
            'tca_1',
            'tca_2',
            'tca_3',
            'tca_4',
            'tca_5',
            'ccb_open_1',
            'ccb_open_2',
            'ccb_open_3',
            'ccb_open_4',
            'ccb_open_5',
            'ccb_close_1',
            'ccb_close_2',
            'ccb_close_3',
            'ccb_close_4',
            'ccb_close_5',
            'caru_1',
            'caru_2',
            'caru_3',
            'caru_4',
            'caru_5',
            'carun_1',
            'carun_2',
            'carun_3',
            'carun_4',
            'carun_5',
            'rrctrl_on_1',
            'rrctrl_on_2',
            'rrctrl_on_3',
            'rrctrl_on_4',
            'rrctrl_on_5',
            'ctcr_1',
            'ctcr_2',
            'ctcr_3',
            'ctcr_4',
            'ctcr_5',
            'ctcl_1',
            'ctcl_2',
            'ctcl_3',
            'ctcl_4',
            'ctcl_5',
            't_kv01',
            't_kv02',
            't_kv05',
            't_kv01',
            't_kv02',
            't_kv05',
            't_ir1',
            't_ir2',
            't_ir5',
            't_is1',
            't_is2',
            't_is5',
            't_it1',
            't_it2',
            't_it5',
            't_ifr1',
            't_ifr2',
            't_ifr5',
            't_ifs1',
            't_ifs2',
            't_ifs5',
            't_ift1',
            't_ift2',
            't_ift5',
            't_ifn1',
            't_ifn2',
            't_ifn5',
            't_ifr_psuedo1',
            't_ifr_psuedo2',
            't_ifr_psuedo5',
            't_ifs_psuedo1',
            't_ifs_psuedo2',
            't_ifs_psuedo5',
            't_ift_psuedo1',
            't_ift_psuedo2',
            't_ift_psuedo5',
            't_ifn_psuedo1',
            't_ifn_psuedo2',
            't_ifn_psuedo5',
            'normal',
            'ok',
            'nok',
            'log',
            'sld',
            'tidak_uji'
        ];

        $validated = $request->validate([
            'tgl_kom' => 'required|date',
            'nama_peny' => 'required|string|max:50',
            // 'id_gi' => 'required|string|max:25|exists:tb_garduinduk,id_gi',
            'id_gi' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                if (!DB::connection('masterdata')->table('dg_mvcell')->where('gardu_induk', $value)->exists()) {
                    $fail('The selected Gardu Induk is invalid.');
                }
            }],
            'id_rtugi' => 'required|integer|exists:tb_merkrtugi,id_rtugi',
            'rtu_addrs' => 'required|string|max:255',
            'id_medkom' => 'required|integer|exists:tb_medkom,id_medkom',

            // === GROUP: RTU ===
            'ir_rtu' => 'nullable|string|max:10',
            'is_rtu' => 'nullable|string|max:10',
            'it_rtu' => 'nullable|string|max:10',

            'ifr_rtu' => 'nullable|string|max:50',
            'ifs_rtu' => 'nullable|string|max:50',
            'ift_rtu' => 'nullable|string|max:50',
            'ifn_rtu' => 'nullable|string|max:50',

            // Psuedo RTU
            'ifr_psuedo_rtu' => 'nullable|string|max:255',
            'ifs_psuedo_rtu' => 'nullable|string|max:255',
            'ift_psuedo_rtu' => 'nullable|string|max:255',
            'ifn_psuedo_rtu' => 'nullable|string|max:255',

            'kv0_rtu' => 'nullable|string|max:50',


            // === GROUP: MS ===
            'ir_ms' => 'nullable|string|max:10',
            'is_ms' => 'nullable|string|max:10',
            'it_ms' => 'nullable|string|max:10',

            'ifr_ms' => 'nullable|string|max:50',
            'ifs_ms' => 'nullable|string|max:50',
            'ift_ms' => 'nullable|string|max:50',
            'ifn_ms' => 'nullable|string|max:50',

            // Psuedo MS
            'ifr_psuedo_ms' => 'nullable|string|max:255',
            'ifs_psuedo_ms' => 'nullable|string|max:255',
            'ift_psuedo_ms' => 'nullable|string|max:255',
            'ifn_psuedo_ms' => 'nullable|string|max:255',

            'kv0_ms' => 'nullable|string|max:50',


            // === GROUP: SCALE ===
            'ir_scale' => 'nullable|string|max:10',
            'is_scale' => 'nullable|string|max:10',
            'it_scale' => 'nullable|string|max:10',

            'ifr_scale' => 'nullable|string|max:50',
            'ifs_scale' => 'nullable|string|max:50',
            'ift_scale' => 'nullable|string|max:50',
            'ifn_scale' => 'nullable|string|max:50',

            // Psuedo Scale
            'ifr_psuedo_scale' => 'nullable|string|max:255',
            'ifs_psuedo_scale' => 'nullable|string|max:255',
            'ift_psuedo_scale' => 'nullable|string|max:255',
            'ifn_psuedo_scale' => 'nullable|string|max:255',

            'kv0_scale' => 'nullable|string|max:50',


            // === GROUP: ADDRESS ===
            'ir_address'  => 'nullable|string|max:255',
            'is_address'  => 'nullable|string|max:255',
            'it_address'  => 'nullable|string|max:255',

            'ifr_address' => 'nullable|string|max:255',
            'ifs_address' => 'nullable|string|max:255',
            'ift_address' => 'nullable|string|max:255',
            'ifn_address' => 'nullable|string|max:255',

            // Psuedo Address
            'ifr_psuedo_address' => 'nullable|string|max:255',
            'ifs_psuedo_address' => 'nullable|string|max:255',
            'ift_psuedo_address' => 'nullable|string|max:255',
            'ifn_psuedo_address' => 'nullable|string|max:255',

            'kv0_address' => 'nullable|string|max:255',


            // === GROUP: OBJECT FORMAT ===
            'ir_objfrmt'  => 'nullable|string|max:255',
            'is_objfrmt'  => 'nullable|string|max:255',
            'it_objfrmt'  => 'nullable|string|max:255',

            'ifr_objfrmt' => 'nullable|string|max:255',
            'ifs_objfrmt' => 'nullable|string|max:255',
            'ift_objfrmt' => 'nullable|string|max:255',
            'ifn_objfrmt' => 'nullable|string|max:255',

            // Psuedo Objfrmt
            'ifr_psuedo_objfrmt' => 'nullable|string|max:255',
            'ifs_psuedo_objfrmt' => 'nullable|string|max:255',
            'ift_psuedo_objfrmt' => 'nullable|string|max:255',
            'ifn_psuedo_objfrmt' => 'nullable|string|max:255',

            'kv0_objfrmt' => 'nullable|string|max:255',

            'scb_open_address' => 'nullable|string|max:100',
            'scb_close_address' => 'nullable|string|max:100',
            'slocal_address' => 'nullable|string|max:100',
            'sremote_address' => 'nullable|string|max:100',
            'socr_dis_address' => 'nullable|string|max:100',
            'socr_app_address' => 'nullable|string|max:100',
            'socri_dis_address' => 'nullable|string|max:100',
            'socri_app_address' => 'nullable|string|max:100',
            'sdgr_dis_address' => 'nullable|string|max:100',
            'sdgr_app_address' => 'nullable|string|max:100',
            'scbtr_dis_address' => 'nullable|string|max:100',
            'scbtr_app_address' => 'nullable|string|max:100',
            'sar_dis_address' => 'nullable|string|max:100',
            'sar_app_address' => 'nullable|string|max:100',
            'saru_dis_address' => 'nullable|string|max:100',
            'saru_app_address' => 'nullable|string|max:100',
            'stc_dis_address' => 'nullable|string|max:100',
            'stc_app_address' => 'nullable|string|max:100',
            'scb_open_rtu' => 'nullable|string|max:100',
            'scb_close_rtu' => 'nullable|string|max:100',
            'slocal_rtu' => 'nullable|string|max:100',
            'sremote_rtu' => 'nullable|string|max:100',
            'socr_dis_rtu' => 'nullable|string|max:100',
            'socr_app_rtu' => 'nullable|string|max:100',
            'socri_dis_rtu' => 'nullable|string|max:100',
            'socri_app_rtu' => 'nullable|string|max:100',
            'sdgr_dis_rtu' => 'nullable|string|max:100',
            'sdgr_app_rtu' => 'nullable|string|max:100',
            'scbtr_dis_rtu' => 'nullable|string|max:100',
            'scbtr_app_rtu' => 'nullable|string|max:100',
            'sar_dis_rtu' => 'nullable|string|max:100',
            'sar_app_rtu' => 'nullable|string|max:100',
            'saru_dis_rtu' => 'nullable|string|max:100',
            'saru_app_rtu' => 'nullable|string|max:100',
            'stc_dis_rtu' => 'nullable|string|max:100',
            'stc_app_rtu' => 'nullable|string|max:100',
            'scb_open_objfrmt' => 'nullable|string|max:100',
            'scb_close_objfrmt' => 'nullable|string|max:100',
            'slocal_objfrmt' => 'nullable|string|max:100',
            'sremote_objfrmt' => 'nullable|string|max:100',
            'socr_dis_objfrmt' => 'nullable|string|max:100',
            'socr_app_objfrmt' => 'nullable|string|max:100',
            'socri_dis_objfrmt' => 'nullable|string|max:100',
            'socri_app_objfrmt' => 'nullable|string|max:100',
            'sdgr_dis_objfrmt' => 'nullable|string|max:100',
            'sdgr_app_objfrmt' => 'nullable|string|max:100',
            'scbtr_dis_objfrmt' => 'nullable|string|max:100',
            'scbtr_app_objfrmt' => 'nullable|string|max:100',
            'sar_dis_objfrmt' => 'nullable|string|max:100',
            'sar_app_objfrmt' => 'nullable|string|max:100',
            'saru_dis_objfrmt' => 'nullable|string|max:100',
            'saru_app_objfrmt' => 'nullable|string|max:100',
            'stc_dis_objfrmt' => 'nullable|string|max:100',
            'stc_app_objfrmt' => 'nullable|string|max:100',
            'ccb_open_address' => 'nullable|string|max:100',
            'ccb_close_address' => 'nullable|string|max:100',
            'caru_use_address' => 'nullable|string|max:100',
            'caru_unuse_address' => 'nullable|string|max:100',
            'creset_on_address' => 'nullable|string|max:100',
            'ctc_raiser_address' => 'nullable|string|max:100',
            'ctc_lower_address' => 'nullable|string|max:100',
            'ccb_open_rtu' => 'nullable|string|max:100',
            'ccb_close_rtu' => 'nullable|string|max:100',
            'caru_use_rtu' => 'nullable|string|max:100',
            'caru_unuse_rtu' => 'nullable|string|max:100',
            'creset_on_rtu' => 'nullable|string|max:100',
            'ctc_raiser_rtu' => 'nullable|string|max:100',
            'ctc_lower_rtu' => 'nullable|string|max:100',
            'ccb_open_objfrmt' => 'nullable|string|max:100',
            'ccb_close_objfrmt' => 'nullable|string|max:100',
            'caru_use_objfrmt' => 'nullable|string|max:100',
            'caru_unuse_objfrmt' => 'nullable|string|max:100',
            'creset_on_objfrmt' => 'nullable|string|max:100',
            'ctc_raiser_objfrmt' => 'nullable|string|max:100',
            'ctc_lower_objfrmt' => 'nullable|string|max:100',
            'ketfd' => 'nullable|string|max:100',
            'ketfts' => 'nullable|string|max:100',
            'ketftc' => 'nullable|string|max:100',
            'ketftm' => 'nullable|string|max:100',
            'ketpk' => 'nullable|string|max:100',
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',
            'nama_user' => 'nullable|string|max:10',
            'id_pelms' => ['required', function ($attribute, $value, $fail) use ($idPelmsArray) {
                if (empty($idPelmsArray)) {
                    $fail('The id pelms field must be an array and cannot be empty.');
                }
                foreach ($idPelmsArray as $id) {
                    if (!DB::table('tb_picmaster')->where('id_picmaster', $id)->exists()) {
                        $fail("Invalid id_pelms: $id");
                    }
                }
            }],
            'id_pelrtu' => ['required', function ($attribute, $value, $fail) use ($idPelrtuArray) {
                if (empty($idPelrtuArray)) {
                    $fail('The id pelrtu field must be an array and cannot be empty.');
                }
                foreach ($idPelrtuArray as $id) {
                    if (!DB::table('tb_pelaksana_rtu')->where('id_pelrtu', $id)->exists()) {
                        $fail("Invalid id_pelrtu: $id");
                    }
                }
            }],
            'catatanpeny' => 'required|string|max:500',
        ]);

        foreach ($arrayFields as $field) {
            $request->validate([
                $field => 'nullable|array',
                $field . '.*' => 'string|in:' . implode(',', $validCheckboxValues),
            ]);
            $validated[$field] = $request->has($field) && is_array($request->input($field)) && !empty($request->input($field))
                ? implode(',', array_filter($request->input($field)))
                : '';
        }

        $validated['id_pelms'] = json_encode($idPelmsArray);
        $validated['id_pelrtu'] = json_encode($idPelrtuArray);

        Penyulangan::create($validated);

        return redirect()->route('penyulangan.index')->with('success', 'Penyulangan created successfully!');
    }

    public function edit(string $id)
    {
        $penyulang = Penyulangan::findOrFail($id);

        // 1. Get Master Data lists
        $rtugi = DB::table('tb_merkrtugi')->get();
        $medkom = DB::table('tb_medkom')->get();

        // Get distinct Gardu Induk list for the first dropdown
        $garduinduk = DB::connection('masterdata')->table('dg_mvcell')
            ->select('gardu_induk')
            ->distinct()
            ->get();

        $komkp = DB::table('tb_komkp')->get();
        $pelms = DB::table('tb_picmaster')->get();
        $pelrtus = DB::table('tb_pelaksana_rtu')->get();

        // --- KEY LOGIC HERE ---
        // 2. Fetch 'nama_peny' list from masterdata, FILTERED by the saved Gardu Induk
        $availableKubikels = [];
        if ($penyulang->id_gi) {
            $availableKubikels = DB::connection('masterdata')->table('dg_mvcell')
                ->where('gardu_induk', $penyulang->id_gi) // <--- THIS FILTERS BY REFERENCE
                ->pluck('nama_kubikel');
        }
        // ----------------------

        // 3. Decode JSON data
        $decodedPelms = json_decode($penyulang->id_pelms, true);
        $selectedPelms = is_array($decodedPelms) ? $decodedPelms : [];

        $decodedRtu = json_decode($penyulang->id_pelrtu, true);
        $selectedPelrtus = is_array($decodedRtu) ? $decodedRtu : [];

        // 4. Decode Checkboxes
        $arrayFields = [
            's_cb',
            's_lr',
            's_ocr',
            's_ocri',
            's_dgr',
            's_cbtr',
            's_ar',
            's_aru',
            's_tc',
            'c_cb',
            'c_aru',
            'c_rst',
            'c_tc'
        ];

        $checkedValues = [];
        foreach ($arrayFields as $field) {
            $checkedValues[$field] = $penyulang->$field ? explode(',', $penyulang->$field) : [];
        }

        return view('pages.penyulangan.edit', compact(
            'penyulang',
            'rtugi',
            'medkom',
            'garduinduk',
            'komkp',
            'pelms',
            'pelrtus',
            'selectedPelms',
            'selectedPelrtus',
            'checkedValues',
            'availableKubikels' // <--- Sending the filtered list to the view
        ));
    }
    public function update(Request $request, string $id)
    {
        $penyulang = Penyulangan::findOrFail($id);

        // 1. Pre-process Input Strings to Arrays (for validation logic)
        $idPelmsInput = $request->input('id_pelms', '');
        $idPelmsArray = !empty($idPelmsInput) ? array_filter(array_map('trim', explode(',', $idPelmsInput))) : [];

        $idPelrtuInput = $request->input('id_pelrtu', '');
        $idPelrtuArray = !empty($idPelrtuInput) ? array_filter(array_map('trim', explode(',', $idPelrtuInput))) : [];

        $arrayFields = [
            's_cb',
            's_lr',
            's_ocr',
            's_ocri',
            's_dgr',
            's_cbtr',
            's_ar',
            's_aru',
            's_tc',
            'c_cb',
            'c_aru',
            'c_rst',
            'c_tc',
            't_ir',
            't_is',
            't_it',
            't_ifr',
            't_ifs',
            't_ift',
            't_ifn',
            't_ifr_psuedo',
            't_ifs_psuedo',
            't_ift_psuedo',
            't_ifn_psuedo',
            't_kv0'

        ];

        $validCheckboxValues = [
            'open_1',
            'open_2',
            'open_3',
            'open_4',
            'open_5',
            'close_1',
            'close_2',
            'close_3',
            'close_4',
            'close_5',
            'local_1',
            'local_2',
            'local_3',
            'local_4',
            'local_5',
            'remote_1',
            'remote_2',
            'remote_3',
            'remote_4',
            'remote_5',
            'ocrd_1',
            'ocrd_2',
            'ocrd_3',
            'ocrd_4',
            'ocrd_5',
            'ocra_1',
            'ocra_2',
            'ocra_3',
            'ocra_4',
            'ocra_5',
            'ocrid_1',
            'ocrid_2',
            'ocrid_3',
            'ocrid_4',
            'ocrid_5',
            'ocria_1',
            'ocria_2',
            'ocria_3',
            'ocria_4',
            'ocria_5',
            'dgrd_1',
            'dgrd_2',
            'dgrd_3',
            'dgrd_4',
            'dgrd_5',
            'dgra_1',
            'dgra_2',
            'dgra_3',
            'dgra_4',
            'dgra_5',
            'cbtrd_1',
            'cbtrd_2',
            'cbtrd_3',
            'cbtrd_4',
            'cbtrd_5',
            'cbtra_1',
            'cbtra_2',
            'cbtra_3',
            'cbtra_4',
            'cbtra_5',
            'ard_1',
            'ard_2',
            'ard_3',
            'ard_4',
            'ard_5',
            'ara_1',
            'ara_2',
            'ara_3',
            'ara_4',
            'ara_5',
            'arud_1',
            'arud_2',
            'arud_3',
            'arud_4',
            'arud_5',
            'arua_1',
            'arua_2',
            'arua_3',
            'arua_4',
            'arua_5',
            'tcd_1',
            'tcd_2',
            'tcd_3',
            'tcd_4',
            'tcd_5',
            'tca_1',
            'tca_2',
            'tca_3',
            'tca_4',
            'tca_5',
            'ccb_open_1',
            'ccb_open_2',
            'ccb_open_3',
            'ccb_open_4',
            'ccb_open_5',
            'ccb_close_1',
            'ccb_close_2',
            'ccb_close_3',
            'ccb_close_4',
            'ccb_close_5',
            'caru_1',
            'caru_2',
            'caru_3',
            'caru_4',
            'caru_5',
            'carun_1',
            'carun_2',
            'carun_3',
            'carun_4',
            'carun_5',
            'rrctrl_on_1',
            'rrctrl_on_2',
            'rrctrl_on_3',
            'rrctrl_on_4',
            'rrctrl_on_5',
            'ctcr_1',
            'ctcr_2',
            'ctcr_3',
            'ctcr_4',
            'ctcr_5',
            'ctcl_1',
            'ctcl_2',
            'ctcl_3',
            'ctcl_4',
            'ctcl_5',
            't_kv01',
            't_kv02',
            't_kv05',
            't_ir1',
            't_ir2',
            't_ir5',
            't_is1',
            't_is2',
            't_is5',
            't_it1',
            't_it2',
            't_it5',
            't_ifr1',
            't_ifr2',
            't_ifr5',
            't_ifs1',
            't_ifs2',
            't_ifs5',
            't_ift1',
            't_ift2',
            't_ift5',
            't_ifn1',
            't_ifn2',
            't_ifn5',
            't_ifr_psuedo1',
            't_ifr_psuedo2',
            't_ifr_psuedo5',
            't_ifs_psuedo1',
            't_ifs_psuedo2',
            't_ifs_psuedo5',
            't_ift_psuedo1',
            't_ift_psuedo2',
            't_ift_psuedo5',
            't_ifn_psuedo1',
            't_ifn_psuedo2',
            't_ifn_psuedo5',
            'normal',
            'ok',
            'nok',
            'log',
            'sld',
            'tidak_uji'
        ];

        $validated = $request->validate([
            // Removed 'id_peny' validation (Primary Key should not be validated/updated here usually)
            'tgl_kom' => 'required|date',
            'nama_peny' => 'required|string|max:50',
            // Corrected validation for id_gi to match Store method logic
            'id_gi' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                if (!DB::connection('masterdata')->table('dg_mvcell')->where('gardu_induk', $value)->exists()) {
                    $fail('The selected Gardu Induk is invalid.');
                }
            }],
            'id_rtugi' => 'required|integer|exists:tb_merkrtugi,id_rtugi',
            'rtu_addrs' => 'required|string|max:255',
            'id_medkom' => 'required|integer|exists:tb_medkom,id_medkom',

            // === GROUP: RTU ===
            'ir_rtu' => 'nullable|string|max:10',
            'is_rtu' => 'nullable|string|max:10',
            'it_rtu' => 'nullable|string|max:10',

            'ifr_rtu' => 'nullable|string|max:50',
            'ifs_rtu' => 'nullable|string|max:50',
            'ift_rtu' => 'nullable|string|max:50',
            'ifn_rtu' => 'nullable|string|max:50',

            // Psuedo RTU
            'ifr_psuedo_rtu' => 'nullable|string|max:255',
            'ifs_psuedo_rtu' => 'nullable|string|max:255',
            'ift_psuedo_rtu' => 'nullable|string|max:255',
            'ifn_psuedo_rtu' => 'nullable|string|max:255',

            'kv0_rtu' => 'nullable|string|max:50',


            // === GROUP: MS ===
            'ir_ms' => 'nullable|string|max:10',
            'is_ms' => 'nullable|string|max:10',
            'it_ms' => 'nullable|string|max:10',

            'ifr_ms' => 'nullable|string|max:50',
            'ifs_ms' => 'nullable|string|max:50',
            'ift_ms' => 'nullable|string|max:50',
            'ifn_ms' => 'nullable|string|max:50',

            // Psuedo MS
            'ifr_psuedo_ms' => 'nullable|string|max:255',
            'ifs_psuedo_ms' => 'nullable|string|max:255',
            'ift_psuedo_ms' => 'nullable|string|max:255',
            'ifn_psuedo_ms' => 'nullable|string|max:255',

            'kv0_ms' => 'nullable|string|max:50',


            // === GROUP: SCALE ===
            'ir_scale' => 'nullable|string|max:10',
            'is_scale' => 'nullable|string|max:10',
            'it_scale' => 'nullable|string|max:10',

            'ifr_scale' => 'nullable|string|max:50',
            'ifs_scale' => 'nullable|string|max:50',
            'ift_scale' => 'nullable|string|max:50',
            'ifn_scale' => 'nullable|string|max:50',

            // Psuedo Scale
            'ifr_psuedo_scale' => 'nullable|string|max:255',
            'ifs_psuedo_scale' => 'nullable|string|max:255',
            'ift_psuedo_scale' => 'nullable|string|max:255',
            'ifn_psuedo_scale' => 'nullable|string|max:255',

            'kv0_scale' => 'nullable|string|max:50',


            // === GROUP: ADDRESS ===
            'ir_address'  => 'nullable|string|max:255',
            'is_address'  => 'nullable|string|max:255',
            'it_address'  => 'nullable|string|max:255',

            'ifr_address' => 'nullable|string|max:255',
            'ifs_address' => 'nullable|string|max:255',
            'ift_address' => 'nullable|string|max:255',
            'ifn_address' => 'nullable|string|max:255',

            // Psuedo Address
            'ifr_psuedo_address' => 'nullable|string|max:255',
            'ifs_psuedo_address' => 'nullable|string|max:255',
            'ift_psuedo_address' => 'nullable|string|max:255',
            'ifn_psuedo_address' => 'nullable|string|max:255',

            'kv0_address' => 'nullable|string|max:255',


            // === GROUP: OBJECT FORMAT ===
            'ir_objfrmt'  => 'nullable|string|max:255',
            'is_objfrmt'  => 'nullable|string|max:255',
            'it_objfrmt'  => 'nullable|string|max:255',

            'ifr_objfrmt' => 'nullable|string|max:255',
            'ifs_objfrmt' => 'nullable|string|max:255',
            'ift_objfrmt' => 'nullable|string|max:255',
            'ifn_objfrmt' => 'nullable|string|max:255',

            // Psuedo Objfrmt
            'ifr_psuedo_objfrmt' => 'nullable|string|max:255',
            'ifs_psuedo_objfrmt' => 'nullable|string|max:255',
            'ift_psuedo_objfrmt' => 'nullable|string|max:255',
            'ifn_psuedo_objfrmt' => 'nullable|string|max:255',

            'kv0_objfrmt' => 'nullable|string|max:255',
            // ... (Addresses) ...
            'scb_open_address' => 'nullable|string|max:100',
            'scb_close_address' => 'nullable|string|max:100',
            'slocal_address' => 'nullable|string|max:100',
            'sremote_address' => 'nullable|string|max:100',
            'socr_dis_address' => 'nullable|string|max:100',
            'socr_app_address' => 'nullable|string|max:100',
            'socri_dis_address' => 'nullable|string|max:100',
            'socri_app_address' => 'nullable|string|max:100',
            'sdgr_dis_address' => 'nullable|string|max:100',
            'sdgr_app_address' => 'nullable|string|max:100',
            'scbtr_dis_address' => 'nullable|string|max:100',
            'scbtr_app_address' => 'nullable|string|max:100',
            'sar_dis_address' => 'nullable|string|max:100',
            'sar_app_address' => 'nullable|string|max:100',
            'saru_dis_address' => 'nullable|string|max:100',
            'saru_app_address' => 'nullable|string|max:100',
            'stc_dis_address' => 'nullable|string|max:100',
            'stc_app_address' => 'nullable|string|max:100',
            // ... (RTUs) ...
            'scb_open_rtu' => 'nullable|string|max:100',
            'scb_close_rtu' => 'nullable|string|max:100',
            'slocal_rtu' => 'nullable|string|max:100',
            'sremote_rtu' => 'nullable|string|max:100',
            'socr_dis_rtu' => 'nullable|string|max:100',
            'socr_app_rtu' => 'nullable|string|max:100',
            'socri_dis_rtu' => 'nullable|string|max:100',
            'socri_app_rtu' => 'nullable|string|max:100',
            'sdgr_dis_rtu' => 'nullable|string|max:100',
            'sdgr_app_rtu' => 'nullable|string|max:100',
            'scbtr_dis_rtu' => 'nullable|string|max:100',
            'scbtr_app_rtu' => 'nullable|string|max:100',
            'sar_dis_rtu' => 'nullable|string|max:100',
            'sar_app_rtu' => 'nullable|string|max:100',
            'saru_dis_rtu' => 'nullable|string|max:100',
            'saru_app_rtu' => 'nullable|string|max:100',
            'stc_dis_rtu' => 'nullable|string|max:100',
            'stc_app_rtu' => 'nullable|string|max:100',
            // ... (Obj Frmts) ...
            'scb_open_objfrmt' => 'nullable|string|max:100',
            'scb_close_objfrmt' => 'nullable|string|max:100',
            'slocal_objfrmt' => 'nullable|string|max:100',
            'sremote_objfrmt' => 'nullable|string|max:100',
            'socr_dis_objfrmt' => 'nullable|string|max:100',
            'socr_app_objfrmt' => 'nullable|string|max:100',
            'socri_dis_objfrmt' => 'nullable|string|max:100',
            'socri_app_objfrmt' => 'nullable|string|max:100',
            'sdgr_dis_objfrmt' => 'nullable|string|max:100',
            'sdgr_app_objfrmt' => 'nullable|string|max:100',
            'scbtr_dis_objfrmt' => 'nullable|string|max:100',
            'scbtr_app_objfrmt' => 'nullable|string|max:100',
            'sar_dis_objfrmt' => 'nullable|string|max:100',
            'sar_app_objfrmt' => 'nullable|string|max:100',
            'saru_dis_objfrmt' => 'nullable|string|max:100',
            'saru_app_objfrmt' => 'nullable|string|max:100',
            'stc_dis_objfrmt' => 'nullable|string|max:100',
            'stc_app_objfrmt' => 'nullable|string|max:100',
            // ... (Control Addresses/RTU/Frmt) ...
            'ccb_open_address' => 'nullable|string|max:100',
            'ccb_close_address' => 'nullable|string|max:100',
            'caru_use_address' => 'nullable|string|max:100',
            'caru_unuse_address' => 'nullable|string|max:100',
            'creset_on_address' => 'nullable|string|max:100',
            'ctc_raiser_address' => 'nullable|string|max:100',
            'ctc_lower_address' => 'nullable|string|max:100',
            'ccb_open_rtu' => 'nullable|string|max:100',
            'ccb_close_rtu' => 'nullable|string|max:100',
            'caru_use_rtu' => 'nullable|string|max:100',
            'caru_unuse_rtu' => 'nullable|string|max:100',
            'creset_on_rtu' => 'nullable|string|max:100',
            'ctc_raiser_rtu' => 'nullable|string|max:100',
            'ctc_lower_rtu' => 'nullable|string|max:100',
            'ccb_open_objfrmt' => 'nullable|string|max:100',
            'ccb_close_objfrmt' => 'nullable|string|max:100',
            'caru_use_objfrmt' => 'nullable|string|max:100',
            'caru_unuse_objfrmt' => 'nullable|string|max:100',
            'creset_on_objfrmt' => 'nullable|string|max:100',
            'ctc_raiser_objfrmt' => 'nullable|string|max:100',
            'ctc_lower_objfrmt' => 'nullable|string|max:100',

            'ketfd' => 'nullable|string|max:100',
            'ketfts' => 'nullable|string|max:100',
            'ketftc' => 'nullable|string|max:100',
            'ketftm' => 'nullable|string|max:100',
            'ketpk' => 'nullable|string|max:100',

            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',
            'nama_user' => 'nullable|string|max:10',
            'id_pelms' => ['required', function ($attribute, $value, $fail) use ($idPelmsArray) {
                if (empty($idPelmsArray)) {
                    $fail('The id pelms field must be an array and cannot be empty.');
                }
                foreach ($idPelmsArray as $id) {
                    if (!DB::table('tb_picmaster')->where('id_picmaster', $id)->exists()) {
                        $fail("Invalid id_pelms: $id");
                    }
                }
            }],
            'id_pelrtu' => ['required', function ($attribute, $value, $fail) use ($idPelrtuArray) {
                if (empty($idPelrtuArray)) {
                    $fail('The id pelrtu field must be an array and cannot be empty.');
                }
                foreach ($idPelrtuArray as $id) {
                    if (!DB::table('tb_pelaksana_rtu')->where('id_pelrtu', $id)->exists()) {
                        $fail("Invalid id_pelrtu: $id");
                    }
                }
            }],
            'catatanpeny' => 'required|string|max:500',
        ]);

        // Process Checkbox Fields (Array from Request -> String for DB)
        foreach ($arrayFields as $field) {
            $request->validate([
                $field => 'nullable|array',
                $field . '.*' => 'string|in:' . implode(',', $validCheckboxValues),
            ]);
            $validated[$field] = $request->has($field) && is_array($request->input($field)) && !empty($request->input($field))
                ? implode(',', array_filter($request->input($field)))
                : '';
        }

        // Process Telemetering Checkbox Fields
        $telemeteringFields = [
            'ir',
            'is',
            'it',
            'fir',
            'fis',
            'fit',
            'fin',
            'kv0'
        ];

        foreach ($telemeteringFields as $field) {
            $request->validate([
                $field => 'nullable|array',
                $field . '.*' => 'in:1,2,5',
            ]);
            $validated[$field] = $request->has($field) && is_array($request->input($field)) && !empty($request->input($field))
                ? implode(',', array_filter($request->input($field)))
                : '';
        }

        $validated['id_pelms'] = json_encode($idPelmsArray);
        $validated['id_pelrtu'] = json_encode($idPelrtuArray);

        $penyulang->update($validated);

        return redirect()->route('penyulangan.index')->with('success', 'Penyulangan updated successfully!');
    }

    public function clone($id)
    {
        // 1. Ambil data sumber yang akan diclone
        $penyulang = Penyulangan::findOrFail($id);

        // 2. Master Data
        $rtugi = DB::table('tb_merkrtugi')->get();
        $medkom = DB::table('tb_medkom')->get();

        // Ambil list Gardu Induk
        $garduinduk = DB::connection('masterdata')->table('dg_mvcell')
            ->select('gardu_induk')
            ->distinct()
            ->get();

        $komkp = DB::table('tb_komkp')->get();
        $pelms = DB::table('tb_picmaster')->get();
        $pelrtus = DB::table('tb_pelaksana_rtu')->get();

        // 3. LOGIKA KUNCI: Ambil list 'nama_peny' (kubikel) berdasarkan Gardu Induk dari data sumber
        $availableKubikels = [];
        if ($penyulang->id_gi) {
            $availableKubikels = DB::connection('masterdata')->table('dg_mvcell')
                ->where('gardu_induk', $penyulang->id_gi)
                ->pluck('nama_kubikel');
        }

        // 4. Decode JSON fields untuk Custom Select
        $decodedPelms = json_decode($penyulang->id_pelms, true);
        $selectedPelms = is_array($decodedPelms) ? $decodedPelms : [];

        $decodedRtu = json_decode($penyulang->id_pelrtu, true);
        $selectedPelrtus = is_array($decodedRtu) ? $decodedRtu : [];

        // Return view clone
        return view('pages.penyulangan.clone', compact(
            'penyulang',
            'rtugi',
            'medkom',
            'garduinduk',
            'komkp',
            'pelms',
            'pelrtus',
            'selectedPelms',
            'selectedPelrtus',
            'availableKubikels' // Variable ini PENTING agar dropdown tidak kosong
        ));
    }

    public function storeClone(Request $request)
    {
        // 1. Pre-process Input Strings to Arrays (for validation logic)
        $idPelmsInput = $request->input('id_pelms', '');
        $idPelmsArray = !empty($idPelmsInput) ? array_filter(array_map('trim', explode(',', $idPelmsInput))) : [];

        $idPelrtuInput = $request->input('id_pelrtu', '');
        $idPelrtuArray = !empty($idPelrtuInput) ? array_filter(array_map('trim', explode(',', $idPelrtuInput))) : [];

        $arrayFields = [
            's_cb',
            's_lr',
            's_ocr',
            's_ocri',
            's_dgr',
            's_cbtr',
            's_ar',
            's_aru',
            's_tc',
            'c_cb',
            'c_aru',
            'c_rst',
            'c_tc',
            't_ir',
            't_is',
            't_it',
            't_ifr',
            't_ifs',
            't_ift',
            't_ifn',
            't_ifr_psuedo',
            't_ifs_psuedo',
            't_ift_psuedo',
            't_ifn_psuedo',
            't_kv0'
        ];

        // List value valid untuk checkbox (disingkat agar tidak terlalu panjang di sini, gunakan list lengkap Anda)
        $validCheckboxValues = [
            'open_1',
            'open_2',
            'open_3',
            'open_4',
            'open_5',
            'close_1',
            'close_2',
            'close_3',
            'close_4',
            'close_5',
            'local_1',
            'local_2',
            'local_3',
            'local_4',
            'local_5',
            'remote_1',
            'remote_2',
            'remote_3',
            'remote_4',
            'remote_5',
            'ocrd_1',
            'ocrd_2',
            'ocrd_3',
            'ocrd_4',
            'ocrd_5',
            'ocra_1',
            'ocra_2',
            'ocra_3',
            'ocra_4',
            'ocra_5',
            'ocrid_1',
            'ocrid_2',
            'ocrid_3',
            'ocrid_4',
            'ocrid_5',
            'ocria_1',
            'ocria_2',
            'ocria_3',
            'ocria_4',
            'ocria_5',
            'dgrd_1',
            'dgrd_2',
            'dgrd_3',
            'dgrd_4',
            'dgrd_5',
            'dgra_1',
            'dgra_2',
            'dgra_3',
            'dgra_4',
            'dgra_5',
            'cbtrd_1',
            'cbtrd_2',
            'cbtrd_3',
            'cbtrd_4',
            'cbtrd_5',
            'cbtra_1',
            'cbtra_2',
            'cbtra_3',
            'cbtra_4',
            'cbtra_5',
            'ard_1',
            'ard_2',
            'ard_3',
            'ard_4',
            'ard_5',
            'ara_1',
            'ara_2',
            'ara_3',
            'ara_4',
            'ara_5',
            'arud_1',
            'arud_2',
            'arud_3',
            'arud_4',
            'arud_5',
            'arua_1',
            'arua_2',
            'arua_3',
            'arua_4',
            'arua_5',
            'tcd_1',
            'tcd_2',
            'tcd_3',
            'tcd_4',
            'tcd_5',
            'tca_1',
            'tca_2',
            'tca_3',
            'tca_4',
            'tca_5',
            'ccb_open_1',
            'ccb_open_2',
            'ccb_open_3',
            'ccb_open_4',
            'ccb_open_5',
            'ccb_close_1',
            'ccb_close_2',
            'ccb_close_3',
            'ccb_close_4',
            'ccb_close_5',
            'caru_1',
            'caru_2',
            'caru_3',
            'caru_4',
            'caru_5',
            'carun_1',
            'carun_2',
            'carun_3',
            'carun_4',
            'carun_5',
            'rrctrl_on_1',
            'rrctrl_on_2',
            'rrctrl_on_3',
            'rrctrl_on_4',
            'rrctrl_on_5',
            'ctcr_1',
            'ctcr_2',
            'ctcr_3',
            'ctcr_4',
            'ctcr_5',
            'ctcl_1',
            'ctcl_2',
            'ctcl_3',
            'ctcl_4',
            'ctcl_5',

            't_kv01',
            't_kv02',
            't_kv05',
            't_ir1',
            't_ir2',
            't_ir5',
            't_is1',
            't_is2',
            't_is5',
            't_it1',
            't_it2',
            't_it5',
            't_ifr1',
            't_ifr2',
            't_ifr5',
            't_ifs1',
            't_ifs2',
            't_ifs5',
            't_ift1',
            't_ift2',
            't_ift5',
            't_ifn1',
            't_ifn2',
            't_ifn5',
            't_ifr_psuedo1',
            't_ifr_psuedo2',
            't_ifr_psuedo5',
            't_ifs_psuedo1',
            't_ifs_psuedo2',
            't_ifs_psuedo5',
            't_ift_psuedo1',
            't_ift_psuedo2',
            't_ift_psuedo5',
            't_ifn_psuedo1',
            't_ifn_psuedo2',
            't_ifn_psuedo5',


            'normal',
            'ok',
            'nok',
            'log',
            'sld',
            'tidak_uji'
        ];

        $validated = $request->validate([
            'tgl_kom' => 'required|date',
            'nama_peny' => 'required|string|max:50',
            // Gunakan validasi strict ke masterdata agar konsisten
            'id_gi' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                if (!DB::connection('masterdata')->table('dg_mvcell')->where('gardu_induk', $value)->exists()) {
                    $fail('The selected Gardu Induk is invalid.');
                }
            }],
            'id_rtugi' => 'required|integer|exists:tb_merkrtugi,id_rtugi',
            'rtu_addrs' => 'required|string|max:255',
            'id_medkom' => 'required|integer|exists:tb_medkom,id_medkom',

            // === GROUP: RTU ===
            'ir_rtu' => 'nullable|string|max:10',
            'is_rtu' => 'nullable|string|max:10',
            'it_rtu' => 'nullable|string|max:10',

            'ifr_rtu' => 'nullable|string|max:50',
            'ifs_rtu' => 'nullable|string|max:50',
            'ift_rtu' => 'nullable|string|max:50',
            'ifn_rtu' => 'nullable|string|max:50',

            // Psuedo RTU
            'ifr_psuedo_rtu' => 'nullable|string|max:255',
            'ifs_psuedo_rtu' => 'nullable|string|max:255',
            'ift_psuedo_rtu' => 'nullable|string|max:255',
            'ifn_psuedo_rtu' => 'nullable|string|max:255',

            'kv0_rtu' => 'nullable|string|max:50',


            // === GROUP: MS ===
            'ir_ms' => 'nullable|string|max:10',
            'is_ms' => 'nullable|string|max:10',
            'it_ms' => 'nullable|string|max:10',

            'ifr_ms' => 'nullable|string|max:50',
            'ifs_ms' => 'nullable|string|max:50',
            'ift_ms' => 'nullable|string|max:50',
            'ifn_ms' => 'nullable|string|max:50',

            // Psuedo MS
            'ifr_psuedo_ms' => 'nullable|string|max:255',
            'ifs_psuedo_ms' => 'nullable|string|max:255',
            'ift_psuedo_ms' => 'nullable|string|max:255',
            'ifn_psuedo_ms' => 'nullable|string|max:255',

            'kv0_ms' => 'nullable|string|max:50',


            // === GROUP: SCALE ===
            'ir_scale' => 'nullable|string|max:10',
            'is_scale' => 'nullable|string|max:10',
            'it_scale' => 'nullable|string|max:10',

            'ifr_scale' => 'nullable|string|max:50',
            'ifs_scale' => 'nullable|string|max:50',
            'ift_scale' => 'nullable|string|max:50',
            'ifn_scale' => 'nullable|string|max:50',

            // Psuedo Scale
            'ifr_psuedo_scale' => 'nullable|string|max:255',
            'ifs_psuedo_scale' => 'nullable|string|max:255',
            'ift_psuedo_scale' => 'nullable|string|max:255',
            'ifn_psuedo_scale' => 'nullable|string|max:255',

            'kv0_scale' => 'nullable|string|max:50',


            // === GROUP: ADDRESS ===
            'ir_address'  => 'nullable|string|max:255',
            'is_address'  => 'nullable|string|max:255',
            'it_address'  => 'nullable|string|max:255',

            'ifr_address' => 'nullable|string|max:255',
            'ifs_address' => 'nullable|string|max:255',
            'ift_address' => 'nullable|string|max:255',
            'ifn_address' => 'nullable|string|max:255',

            // Psuedo Address
            'ifr_psuedo_address' => 'nullable|string|max:255',
            'ifs_psuedo_address' => 'nullable|string|max:255',
            'ift_psuedo_address' => 'nullable|string|max:255',
            'ifn_psuedo_address' => 'nullable|string|max:255',

            'kv0_address' => 'nullable|string|max:255',


            // === GROUP: OBJECT FORMAT ===
            'ir_objfrmt'  => 'nullable|string|max:255',
            'is_objfrmt'  => 'nullable|string|max:255',
            'it_objfrmt'  => 'nullable|string|max:255',

            'ifr_objfrmt' => 'nullable|string|max:255',
            'ifs_objfrmt' => 'nullable|string|max:255',
            'ift_objfrmt' => 'nullable|string|max:255',
            'ifn_objfrmt' => 'nullable|string|max:255',

            // Psuedo Objfrmt
            'ifr_psuedo_objfrmt' => 'nullable|string|max:255',
            'ifs_psuedo_objfrmt' => 'nullable|string|max:255',
            'ift_psuedo_objfrmt' => 'nullable|string|max:255',
            'ifn_psuedo_objfrmt' => 'nullable|string|max:255',

            'kv0_objfrmt' => 'nullable|string|max:255',



            'scb_open_address' => 'nullable|string|max:100',
            'scb_close_address' => 'nullable|string|max:100',
            'slocal_address' => 'nullable|string|max:100',
            'sremote_address' => 'nullable|string|max:100',
            'socr_dis_address' => 'nullable|string|max:100',
            'socr_app_address' => 'nullable|string|max:100',
            'socri_dis_address' => 'nullable|string|max:100',
            'socri_app_address' => 'nullable|string|max:100',
            'sdgr_dis_address' => 'nullable|string|max:100',
            'sdgr_app_address' => 'nullable|string|max:100',
            'scbtr_dis_address' => 'nullable|string|max:100',
            'scbtr_app_address' => 'nullable|string|max:100',
            'sar_dis_address' => 'nullable|string|max:100',
            'sar_app_address' => 'nullable|string|max:100',
            'saru_dis_address' => 'nullable|string|max:100',
            'saru_app_address' => 'nullable|string|max:100',
            'stc_dis_address' => 'nullable|string|max:100',
            'stc_app_address' => 'nullable|string|max:100',
            'scb_open_rtu' => 'nullable|string|max:100',
            'scb_close_rtu' => 'nullable|string|max:100',
            'slocal_rtu' => 'nullable|string|max:100',
            'sremote_rtu' => 'nullable|string|max:100',
            'socr_dis_rtu' => 'nullable|string|max:100',
            'socr_app_rtu' => 'nullable|string|max:100',
            'socri_dis_rtu' => 'nullable|string|max:100',
            'socri_app_rtu' => 'nullable|string|max:100',
            'sdgr_dis_rtu' => 'nullable|string|max:100',
            'sdgr_app_rtu' => 'nullable|string|max:100',
            'scbtr_dis_rtu' => 'nullable|string|max:100',
            'scbtr_app_rtu' => 'nullable|string|max:100',
            'sar_dis_rtu' => 'nullable|string|max:100',
            'sar_app_rtu' => 'nullable|string|max:100',
            'saru_dis_rtu' => 'nullable|string|max:100',
            'saru_app_rtu' => 'nullable|string|max:100',
            'stc_dis_rtu' => 'nullable|string|max:100',
            'stc_app_rtu' => 'nullable|string|max:100',
            'scb_open_objfrmt' => 'nullable|string|max:100',
            'scb_close_objfrmt' => 'nullable|string|max:100',
            'slocal_objfrmt' => 'nullable|string|max:100',
            'sremote_objfrmt' => 'nullable|string|max:100',
            'socr_dis_objfrmt' => 'nullable|string|max:100',
            'socr_app_objfrmt' => 'nullable|string|max:100',
            'socri_dis_objfrmt' => 'nullable|string|max:100',
            'socri_app_objfrmt' => 'nullable|string|max:100',
            'sdgr_dis_objfrmt' => 'nullable|string|max:100',
            'sdgr_app_objfrmt' => 'nullable|string|max:100',
            'scbtr_dis_objfrmt' => 'nullable|string|max:100',
            'scbtr_app_objfrmt' => 'nullable|string|max:100',
            'sar_dis_objfrmt' => 'nullable|string|max:100',
            'sar_app_objfrmt' => 'nullable|string|max:100',
            'saru_dis_objfrmt' => 'nullable|string|max:100',
            'saru_app_objfrmt' => 'nullable|string|max:100',
            'stc_dis_objfrmt' => 'nullable|string|max:100',
            'stc_app_objfrmt' => 'nullable|string|max:100',
            'ccb_open_address' => 'nullable|string|max:100',
            'ccb_close_address' => 'nullable|string|max:100',
            'caru_use_address' => 'nullable|string|max:100',
            'caru_unuse_address' => 'nullable|string|max:100',
            'creset_on_address' => 'nullable|string|max:100',
            'ctc_raiser_address' => 'nullable|string|max:100',
            'ctc_lower_address' => 'nullable|string|max:100',
            'ccb_open_rtu' => 'nullable|string|max:100',
            'ccb_close_rtu' => 'nullable|string|max:100',
            'caru_use_rtu' => 'nullable|string|max:100',
            'caru_unuse_rtu' => 'nullable|string|max:100',
            'creset_on_rtu' => 'nullable|string|max:100',
            'ctc_raiser_rtu' => 'nullable|string|max:100',
            'ctc_lower_rtu' => 'nullable|string|max:100',
            'ccb_open_objfrmt' => 'nullable|string|max:100',
            'ccb_close_objfrmt' => 'nullable|string|max:100',
            'caru_use_objfrmt' => 'nullable|string|max:100',
            'caru_unuse_objfrmt' => 'nullable|string|max:100',
            'creset_on_objfrmt' => 'nullable|string|max:100',
            'ctc_raiser_objfrmt' => 'nullable|string|max:100',
            'ctc_lower_objfrmt' => 'nullable|string|max:100',
            'ketfd' => 'nullable|string|max:100',
            'ketfts' => 'nullable|string|max:100',
            'ketftc' => 'nullable|string|max:100',
            'ketftm' => 'nullable|string|max:100',
            'ketpk' => 'nullable|string|max:100',
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',
            'nama_user' => 'nullable|string|max:10',
            'id_pelms' => ['required', function ($attribute, $value, $fail) use ($idPelmsArray) {
                if (empty($idPelmsArray)) {
                    $fail('The id pelms field must be an array and cannot be empty.');
                }
                foreach ($idPelmsArray as $id) {
                    if (!DB::table('tb_picmaster')->where('id_picmaster', $id)->exists()) {
                        $fail("Invalid id_pelms: $id");
                    }
                }
            }],
            'id_pelrtu' => ['required', function ($attribute, $value, $fail) use ($idPelrtuArray) {
                if (empty($idPelrtuArray)) {
                    $fail('The id pelrtu field must be an array and cannot be empty.');
                }
                foreach ($idPelrtuArray as $id) {
                    if (!DB::table('tb_pelaksana_rtu')->where('id_pelrtu', $id)->exists()) {
                        $fail("Invalid id_pelrtu: $id");
                    }
                }
            }],
            'catatanpeny' => 'required|string|max:500',
        ]);

        foreach ($arrayFields as $field) {
            $request->validate([
                $field => 'nullable|array',
                $field . '.*' => 'string|in:' . implode(',', $validCheckboxValues),
            ]);
            $validated[$field] = $request->has($field) && is_array($request->input($field)) && !empty($request->input($field))
                ? implode(',', array_filter($request->input($field)))
                : '';
        }

        $validated['id_pelms'] = json_encode($idPelmsArray);
        $validated['id_pelrtu'] = json_encode($idPelrtuArray);

        // CREATE NEW RECORD
        Penyulangan::create($validated);

        return redirect()->route('penyulangan.index')->with('success', 'Penyulangan cloned successfully!');
    }


    public function destroy(string $id)
    {
        $penyulang = Penyulangan::findOrFail($id);
        $penyulang->delete();
        return redirect()->route('penyulangan.index')->with('success', 'Penyulangan deleted successfully!');
    }




}