<?php

namespace App\Http\Controllers;

use App\Models\Keypoint;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use TCPDF; // Assuming TCPDF is installed via composer or available


class KeypointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Simply return the view; data will be loaded via AJAX for the table
        return view('pages.keypoint.index');
    }

    /**
     * Server-side DataTables data provider
     */
    public function data(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $searchValue = $request->search['value'];
        $orderColumnIndex = $request->order[0]['column'];
        $orderDir = $request->order[0]['dir'];
        $columns = $request->columns;

        // Additional date filters
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        // Map DataTables column indices to database fields
        $columnMap = [
            0 => 'tb_formkp.tgl_komisioning',
            1 => 'tb_formkp.nama_lbs',
            2 => 'gi_penyulang',
            3 => 'merk_modem_rtu',
            4 => 'tb_formkp.catatankp',
            5 => 'tb_formkp.nama_user',
            6 => 'pelaksana_rtu',
        ];

        $orderColumn = $columnMap[$orderColumnIndex] ?? 'tb_formkp.tgl_komisioning';

        // Base query with joins
        $query = DB::table('tb_formkp')
            ->select(
                'tb_formkp.id_formkp',
                'tb_formkp.tgl_komisioning',
                'tb_formkp.nama_lbs as nama_keypoint',
                DB::raw("CONCAT(tb_formkp.id_gi, ' - ', tb_formkp.nama_peny) as gi_penyulang"),
                'tb_formkp.id_merkrtu',
                'tb_formkp.id_modem',
                'tb_formkp.catatankp as keterangan',
                'tb_formkp.nama_user as master',
                'tb_formkp.id_pelrtu'
            );

        // Apply date range filter
        if ($fromDate && $toDate) {
            $query->whereBetween('tb_formkp.tgl_komisioning', [$fromDate, $toDate]);
        } elseif ($fromDate) {
            $query->whereDate('tb_formkp.tgl_komisioning', '>=', $fromDate);
        } elseif ($toDate) {
            $query->whereDate('tb_formkp.tgl_komisioning', '<=', $toDate);
        }

        // Global search
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('tb_formkp.nama_lbs', 'like', "%{$searchValue}%")
                    ->orWhere('tb_formkp.catatankp', 'like', "%{$searchValue}%")
                    ->orWhere('tb_formkp.nama_peny', 'like', "%{$searchValue}%")
                    ->orWhere('tb_formkp.nama_user', 'like', "%{$searchValue}%")
                    ->orWhereRaw("CONCAT(tb_formkp.id_gi, ' - ', tb_formkp.nama_peny) LIKE ?", ["%{$searchValue}%"])
                    ->orWhere('tb_formkp.id_merkrtu', 'like', "%{$searchValue}%")
                    ->orWhere('tb_formkp.id_modem', 'like', "%{$searchValue}%");
            });
        }

        // Per-column searches
        foreach ($columns as $index => $col) {
            $colSearchValue = $col['search']['value'];
            if (!empty($colSearchValue) && $col['searchable'] == 'true') {
                switch ($index) {
                    case 0:
                        $query->whereDate('tb_formkp.tgl_komisioning', 'like', "%{$colSearchValue}%");
                        break;
                    case 1:
                        $query->where('tb_formkp.nama_lbs', 'like', "%{$colSearchValue}%");
                        break;
                    case 2:
                        $query->whereRaw("CONCAT(tb_formkp.id_gi, ' - ', tb_formkp.nama_peny) LIKE ?", ["%{$colSearchValue}%"]);
                        break;
                    case 3:
                        $query->where('tb_formkp.id_merkrtu', 'like', "%{$colSearchValue}%")
                            ->orWhere('tb_formkp.id_modem', 'like', "%{$colSearchValue}%");
                        break;
                    case 4:
                        $query->where('tb_formkp.catatankp', 'like', "%{$colSearchValue}%");
                        break;
                    case 5:
                        $query->where('tb_formkp.nama_user', 'like', "%{$colSearchValue}%");
                        break;
                }
            }
        }

        // Total records
        $totalRecords = DB::table('tb_formkp')->count();

        // Total filtered
        $totalFiltered = $query->count();

        // Apply ordering
        if (strpos($orderColumn, 'gi_penyulang') !== false) {
            $query->orderByRaw("CONCAT(tb_formkp.id_gi, ' - ', tb_formkp.penyulang) {$orderDir}");
        } elseif (strpos($orderColumn, 'merk_modem_rtu') !== false) {
            $query->orderBy('tb_formkp.id_merkrtu', $orderDir);
        } else {
            $query->orderBy($orderColumn, $orderDir);
        }

        // Pagination
        $records = $query->offset($start)->limit($length)->get();

        // Format data
        $data = $records->map(function ($row) {
            $row->tgl_komisioning = Carbon::parse($row->tgl_komisioning)->format('l, d-m-Y');

            // Process id_pelrtu to get Pelaksana RTU names
            $idPelrtuArray = json_decode($row->id_pelrtu, true) ?? [];
            $pelaksanaRtu = '';
            if (!empty($idPelrtuArray)) {
                $names = DB::table('tb_pelaksana_rtu')
                    ->whereIn('id_pelrtu', $idPelrtuArray)
                    ->pluck('nama_pelrtu')
                    ->join(', ');
                $pelaksanaRtu = $names;
            }
            $row->pelaksana_rtu = $pelaksanaRtu;

            $row->merk_modem_rtu = $row->id_merkrtu . ' - ' . $row->id_modem; // Simple concat if no joins

            $row->action = '
            <a href="' . route('keypoint.clone', $row->id_formkp) . '" class="btn btn-icon btn-round btn-primary">
                <i class="far fa-clone"></i>
            </a>
            <a href="' . route('keypoint.edit', $row->id_formkp) . '" class="btn btn-icon btn-round btn-warning">
                <i class="fa fa-pen"></i>
            </a>
            <a href="' . route('keypoint.exportsinglepdf', $row->id_formkp) . '" target="_blank" class="btn btn-icon btn-round btn-danger">
                <i class="fas fa-file-pdf"></i>
            </a>
            <form action="' . route('keypoint.destroy', $row->id_formkp) . '" method="POST" style="display:inline;">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="submit" class="btn btn-icon btn-round btn-secondary" onclick="return confirm(\'Are you sure you want to delete this keypoint?\')">
                    <i class="fa fa-trash"></i>
                </button>
            </form>
            ';
            return $row;
        })->toArray();

        return response()->json([
            'draw' => (int)$draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }


    public function exportSinglePdf($id)
    {
        // 1. Get Main Data with all necessary joins
        $keypoint = DB::table('tb_formkp')
            ->leftJoin('tb_merklbs', 'tb_formkp.id_merkrtu', '=', 'tb_merklbs.id_merkrtu')
            ->leftJoin('tb_modem', 'tb_formkp.id_modem', '=', 'tb_modem.id_modem')
            ->leftJoin('tb_medkom', 'tb_formkp.id_medkom', '=', 'tb_medkom.id_medkom')
            ->leftJoin('tb_komkp', 'tb_formkp.id_komkp', '=', 'tb_komkp.id_komkp')
            ->select(
                'tb_formkp.*',
                'tb_merklbs.nama_merklbs',
                'tb_modem.nama_modem',
                'tb_medkom.nama_medkom',
                'tb_komkp.jenis_komkp',
                // Aliases untuk view
                'tb_formkp.nama_lbs as nama_keypoint',
                'tb_formkp.rtu_addrs as alamat_rtu',
                'tb_formkp.ip_kp as ip_rtu',
                'tb_formkp.nama_peny as penyulang',
                'tb_formkp.catatankp as keterangan',
                'tb_formkp.id_gi as gardu_induk',
                'tb_formkp.id_sec as sectoral'
            )
            ->where('tb_formkp.id_formkp', $id)
            ->first();

        if (!$keypoint) {
            abort(404, 'Data Keypoint tidak ditemukan');
        }

        // 2. Format tanggal
        $keypoint->tgl_komisioning = Carbon::parse($keypoint->tgl_komisioning)->format('d-m-Y');

        // 3. Get Pelaksana MS (PIC Master)
        $pelMsIds = json_decode($keypoint->id_pelms, true) ?? [];
        $pelaksanaMs = collect();
        if (!empty($pelMsIds)) {
            $pelaksanaMs = DB::table('tb_picmaster')
                ->whereIn('id_picmaster', $pelMsIds)
                ->get();
        }

        // 4. Get Pelaksana RTU (Field Engineer)
        $pelRtuIds = json_decode($keypoint->id_pelrtu, true) ?? [];
        $pelaksanaRtu = collect();
        if (!empty($pelRtuIds)) {
            $pelaksanaRtu = DB::table('tb_pelaksana_rtu')
                ->whereIn('id_pelrtu', $pelRtuIds)
                ->get();
        }

        // 5. Parse Status Data
        $statusData = $this->parseStatusData($keypoint);

        // 6. Parse Control Data
        $controlData = $this->parseControlData($keypoint);

        // 7. Parse Metering Data
        $meteringData = $this->parseMeteringData($keypoint);

        // 8. Parse Hardware & System Data
        $hardwareData = $this->parseHardwareData($keypoint);
        $systemData = $this->parseSystemData($keypoint);
        $recloserData = $this->parseRecloserData($keypoint);

        // 9. Load View dengan semua data
        $pdf = Pdf::loadView('pdf.singlekeypoint_dompdf', [
            'row' => $keypoint,
            'pelaksanaMs' => $pelaksanaMs,
            'pelaksanaRtu' => $pelaksanaRtu,
            'statusData' => $statusData,
            'controlData' => $controlData,
            'meteringData' => $meteringData,
            'hardwareData' => $hardwareData,
            'systemData' => $systemData,
            'recloserData' => $recloserData,
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
        $filename = 'Keypoint_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $keypoint->nama_lbs) . '_' . $id . '.pdf';

        // 12. Download atau Stream
        return $pdf->download($filename);
        // Atau gunakan stream untuk preview: return $pdf->stream($filename);
    }

    /**
     * Parse Status Data dari database
     */
    private function parseStatusData($keypoint)
    {
        $statuses = [];

        // CB Status
        $statuses[] = [
            'name' => 'CB',
            'values' => ['Open', 'Close'],
            'data' => $this->parseCheckboxValue($keypoint->s_cb ?? ''),
            'addresses' => [
                'open' => [
                    'ms' => $keypoint->scb_open_addms ?? '',
                    'rtu' => $keypoint->scb_open_addrtu ?? '',
                    'obj' => $keypoint->scb_open_objfrmt ?? ''
                ],
                'close' => [
                    'ms' => $keypoint->scb_close_addms ?? '',
                    'rtu' => $keypoint->scb_close_addrtu ?? '',
                    'obj' => $keypoint->scb_close_objfrmt ?? ''
                ]
            ]
        ];

        // CB2 Status
        $statuses[] = [
            'name' => 'CB 2',
            'values' => ['Open', 'Close'],
            'data' => $this->parseCheckboxValue($keypoint->s_cb2 ?? ''),
            'addresses' => [
                'open' => [
                    'ms' => $keypoint->scb2_open_addms ?? '',
                    'rtu' => $keypoint->scb2_open_addrtu ?? '',
                    'obj' => $keypoint->scb2_open_objfrmt ?? ''
                ],
                'close' => [
                    'ms' => $keypoint->scb2_close_addms ?? '',
                    'rtu' => $keypoint->scb2_close_addrtu ?? '',
                    'obj' => $keypoint->scb2_close_objfrmt ?? ''
                ]
            ]
        ];

        // L/R Status
        $statuses[] = [
            'name' => 'L/R',
            'values' => ['Local', 'Remote'],
            'data' => $this->parseCheckboxValue($keypoint->s_lr ?? ''),
            'addresses' => [
                'local' => [
                    'ms' => $keypoint->slr_local_addms ?? '',
                    'rtu' => $keypoint->slr_local_addrtu ?? '',
                    'obj' => $keypoint->slr_local_objfrmt ?? ''
                ],
                'remote' => [
                    'ms' => $keypoint->slr_remote_addms ?? '',
                    'rtu' => $keypoint->slr_remote_addrtu ?? '',
                    'obj' => $keypoint->slr_remote_objfrmt ?? ''
                ]
            ]
        ];

        // DOOR Status
        $statuses[] = [
            'name' => 'DOOR',
            'values' => ['Open', 'Close'],
            'data' => $this->parseCheckboxValue($keypoint->s_door ?? ''),
            'addresses' => [
                'open' => [
                    'ms' => $keypoint->sdoor_open_addms ?? '',
                    'rtu' => $keypoint->sdoor_open_addrtu ?? '',
                    'obj' => $keypoint->sdoor_open_objfrmt ?? ''
                ],
                'close' => [
                    'ms' => $keypoint->sdoor_close_addms ?? '',
                    'rtu' => $keypoint->sdoor_close_addrtu ?? '',
                    'obj' => $keypoint->sdoor_close_objfrmt ?? ''
                ]
            ]
        ];

        // ACF Status
        $statuses[] = [
            'name' => 'ACF',
            'values' => ['Normal', 'Failed'],
            'data' => $this->parseCheckboxValue($keypoint->s_acf ?? ''),
            'addresses' => [
                'normal' => [
                    'ms' => $keypoint->sacf_normal_addms ?? '',
                    'rtu' => $keypoint->sacf_normal_addrtu ?? '',
                    'obj' => $keypoint->sacf_normal_objfrmt ?? ''
                ],
                'fail' => [
                    'ms' => $keypoint->sacf_fail_addms ?? '',
                    'rtu' => $keypoint->sacf_fail_addrtu ?? '',
                    'obj' => $keypoint->sacf_fail_objfrmt ?? ''
                ]
            ]
        ];

        // DCF Status
        $statuses[] = [
            'name' => 'DCF',
            'values' => ['Normal', 'Failed'],
            'data' => $this->parseCheckboxValue($keypoint->s_dcf ?? ''),
            'addresses' => [
                'normal' => [
                    'ms' => $keypoint->sdcf_normal_addms ?? '',
                    'rtu' => $keypoint->sdcf_normal_addrtu ?? '',
                    'obj' => $keypoint->sdcf_normal_objfrmt ?? ''
                ],
                'fail' => [
                    'ms' => $keypoint->sdcf_fail_addms ?? '',
                    'rtu' => $keypoint->sdcf_fail_addrtu ?? '',
                    'obj' => $keypoint->sdcf_fail_objfrmt ?? ''
                ]
            ]
        ];

        // DCD Status
        $statuses[] = [
            'name' => 'DCD',
            'values' => ['Normal', 'Failed'],
            'data' => $this->parseCheckboxValue($keypoint->s_dcd ?? ''),
            'addresses' => [
                'normal' => [
                    'ms' => $keypoint->sdcd_normal_addms ?? '',
                    'rtu' => $keypoint->sdcd_normal_addrtu ?? '',
                    'obj' => $keypoint->sdcd_normal_objfrmt ?? ''
                ],
                'fail' => [
                    'ms' => $keypoint->sdcd_fail_addms ?? '',
                    'rtu' => $keypoint->sdcd_fail_addrtu ?? '',
                    'obj' => $keypoint->sdcd_fail_objfrmt ?? ''
                ]
            ]
        ];

        // HLT Status
        $statuses[] = [
            'name' => 'HLT',
            'values' => ['Active', 'Inactive'],
            'data' => $this->parseCheckboxValue($keypoint->s_hlt ?? ''),
            'addresses' => [
                'on' => [
                    'ms' => $keypoint->shlt_on_addms ?? '',
                    'rtu' => $keypoint->shlt_on_addrtu ?? '',
                    'obj' => $keypoint->shlt_on_objfrmt ?? ''
                ],
                'off' => [
                    'ms' => $keypoint->shlt_off_addms ?? '',
                    'rtu' => $keypoint->shlt_off_addrtu ?? '',
                    'obj' => $keypoint->shlt_off_objfrmt ?? ''
                ]
            ]
        ];

        // SF6 Status
        $statuses[] = [
            'name' => 'SF6',
            'values' => ['Normal', 'Low'],
            'data' => $this->parseCheckboxValue($keypoint->s_sf6 ?? ''),
            'addresses' => [
                'normal' => [
                    'ms' => $keypoint->ssf6_normal_addms ?? '',
                    'rtu' => $keypoint->ssf6_normal_addrtu ?? '',
                    'obj' => $keypoint->ssf6_normal_objfrmt ?? ''
                ],
                'fail' => [
                    'ms' => $keypoint->ssf6_fail_addms ?? '',
                    'rtu' => $keypoint->ssf6_fail_addrtu ?? '',
                    'obj' => $keypoint->ssf6_fail_objfrmt ?? ''
                ]
            ]
        ];

        // FIR Status
        $statuses[] = [
            'name' => 'FIR',
            'values' => ['Normal', 'Failed'],
            'data' => $this->parseCheckboxValue($keypoint->s_fir ?? ''),
            'addresses' => [
                'normal' => [
                    'ms' => $keypoint->sfir_normal_addms ?? '',
                    'rtu' => $keypoint->sfir_normal_addrtu ?? '',
                    'obj' => $keypoint->sfir_normal_objfrmt ?? ''
                ],
                'fail' => [
                    'ms' => $keypoint->sfir_fail_addms ?? '',
                    'rtu' => $keypoint->sfir_fail_addrtu ?? '',
                    'obj' => $keypoint->sfir_fail_objfrmt ?? ''
                ]
            ]
        ];

        // FIS Status
        $statuses[] = [
            'name' => 'FIS',
            'values' => ['Normal', 'Failed'],
            'data' => $this->parseCheckboxValue($keypoint->s_fis ?? ''),
            'addresses' => [
                'normal' => [
                    'ms' => $keypoint->sfis_normal_addms ?? '',
                    'rtu' => $keypoint->sfis_normal_addrtu ?? '',
                    'obj' => $keypoint->sfis_normal_objfrmt ?? ''
                ],
                'fail' => [
                    'ms' => $keypoint->sfis_fail_addms ?? '',
                    'rtu' => $keypoint->sfis_fail_addrtu ?? '',
                    'obj' => $keypoint->sfis_fail_objfrmt ?? ''
                ]
            ]
        ];

        // FIT Status
        $statuses[] = [
            'name' => 'FIT',
            'values' => ['Normal', 'Failed'],
            'data' => $this->parseCheckboxValue($keypoint->s_fit ?? ''),
            'addresses' => [
                'normal' => [
                    'ms' => $keypoint->sfit_normal_addms ?? '',
                    'rtu' => $keypoint->sfit_normal_addrtu ?? '',
                    'obj' => $keypoint->sfit_normal_objfrmt ?? ''
                ],
                'fail' => [
                    'ms' => $keypoint->sfit_fail_addms ?? '',
                    'rtu' => $keypoint->sfit_fail_addrtu ?? '',
                    'obj' => $keypoint->sfit_fail_objfrmt ?? ''
                ]
            ]
        ];

        return $statuses;
    }

    /**
     * Parse Control Data dari database
     */
    private function parseControlData($keypoint)
    {
        $controls = [];

        // CB Control
        $controls[] = [
            'name' => 'CB',
            'values' => ['Open', 'Close'],
            'data' => $this->parseCheckboxValue($keypoint->c_cb ?? ''),
            'addresses' => [
                'open' => [
                    'ms' => $keypoint->ccb_open_addms ?? '',
                    'rtu' => $keypoint->ccb_open_addrtu ?? '',
                    'obj' => $keypoint->ccb_open_objfrmt ?? ''
                ],
                'close' => [
                    'ms' => $keypoint->ccb_close_addms ?? '',
                    'rtu' => $keypoint->ccb_close_addrtu ?? '',
                    'obj' => $keypoint->ccb_close_objfrmt ?? ''
                ]
            ]
        ];

        // CB2 Control
        $controls[] = [
            'name' => 'CB 2',
            'values' => ['Open', 'Close'],
            'data' => $this->parseCheckboxValue($keypoint->c_cb2 ?? ''),
            'addresses' => [
                'open' => [
                    'ms' => $keypoint->ccb2_open_addms ?? '',
                    'rtu' => $keypoint->ccb2_open_addrtu ?? '',
                    'obj' => $keypoint->ccb2_open_objfrmt ?? ''
                ],
                'close' => [
                    'ms' => $keypoint->ccb2_close_addms ?? '',
                    'rtu' => $keypoint->ccb2_close_addrtu ?? '',
                    'obj' => $keypoint->ccb2_close_objfrmt ?? ''
                ]
            ]
        ];

        // HLT Control
        $controls[] = [
            'name' => 'HLT',
            'values' => ['On', 'Off'],
            'data' => $this->parseCheckboxValue($keypoint->c_hlt ?? ''),
            'addresses' => [
                'on' => [
                    'ms' => $keypoint->chlt_on_addms ?? '',
                    'rtu' => $keypoint->chlt_on_addrtu ?? '',
                    'obj' => $keypoint->chlt_on_objfrmt ?? ''
                ],
                'off' => [
                    'ms' => $keypoint->chlt_off_addms ?? '',
                    'rtu' => $keypoint->chlt_off_addrtu ?? '',
                    'obj' => $keypoint->chlt_off_objfrmt ?? ''
                ]
            ]
        ];

        // Reset Control
        $controls[] = [
            'name' => 'RR',
            'values' => ['Reset'],
            'data' => $this->parseCheckboxValue($keypoint->c_rst ?? ''),
            'addresses' => [
                'reset' => [
                    'ms' => $keypoint->crst_addms ?? '',
                    'rtu' => $keypoint->crst_addrtu ?? '',
                    'obj' => $keypoint->crst_objfrmt ?? ''
                ]
            ]
        ];

        return $controls;
    }

    /**
     * Parse Metering Data dari database
     */
    private function parseMeteringData($keypoint)
    {
        return [
            [
                'name' => 'HZ',
                'rtu' => $keypoint->hz_rtu ?? '',
                'ms' => $keypoint->hz_ms ?? '',
                'scale' => $keypoint->hz_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->hz_addrtu ?? '',
                    'ms' => $keypoint->hz_addms ?? '',
                    'obj' => $keypoint->hz_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_hz ?? '',
                'isPseudo' => false
            ],
            [
                'name' => 'I AVG',
                'rtu' => $keypoint->iavg_rtu ?? '',
                'ms' => $keypoint->iavg_ms ?? '',
                'scale' => $keypoint->iavg_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->iavg_addrtu ?? '',
                    'ms' => $keypoint->iavg_addms ?? '',
                    'obj' => $keypoint->iavg_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_iavg ?? '',
                'isPseudo' => false
            ],
            [
                'name' => 'IR',
                'rtu' => $keypoint->ir_rtu ?? '',
                'ms' => $keypoint->ir_ms ?? '',
                'scale' => $keypoint->ir_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->ir_addrtu ?? '',
                    'ms' => $keypoint->ir_addms ?? '',
                    'obj' => $keypoint->ir_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_ir ?? '',
                'isPseudo' => false
            ],
            [
                'name' => 'IS',
                'rtu' => $keypoint->is_rtu ?? '',
                'ms' => $keypoint->is_ms ?? '',
                'scale' => $keypoint->is_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->is_addrtu ?? '',
                    'ms' => $keypoint->is_addms ?? '',
                    'obj' => $keypoint->is_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_is ?? '',
                'isPseudo' => false
            ],
            [
                'name' => 'IT',
                'rtu' => $keypoint->it_rtu ?? '',
                'ms' => $keypoint->it_ms ?? '',
                'scale' => $keypoint->it_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->it_addrtu ?? '',
                    'ms' => $keypoint->it_addms ?? '',
                    'obj' => $keypoint->it_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_it ?? '',
                'isPseudo' => false
            ],
            [
                'name' => 'IN',
                'rtu' => $keypoint->in_rtu ?? '',
                'ms' => $keypoint->in_ms ?? '',
                'scale' => $keypoint->in_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->in_addrtu ?? '',
                    'ms' => $keypoint->in_addms ?? '',
                    'obj' => $keypoint->in_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_in ?? '',
                'isPseudo' => false
            ],
            [
                'name' => 'IFR',
                'rtu' => $keypoint->ifr_rtu ?? '',
                'ms' => $keypoint->ifr_ms ?? '',
                'scale' => $keypoint->ifr_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->ifr_addrtu ?? '',
                    'ms' => $keypoint->ifr_addms ?? '',
                    'obj' => $keypoint->ifr_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_ifr ?? '',
                'isPseudo' => true
            ],
            [
                'name' => 'IFS',
                'rtu' => $keypoint->ifs_rtu ?? '',
                'ms' => $keypoint->ifs_ms ?? '',
                'scale' => $keypoint->ifs_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->ifs_addrtu ?? '',
                    'ms' => $keypoint->ifs_addms ?? '',
                    'obj' => $keypoint->ifs_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_ifs ?? '',
                'isPseudo' => true
            ],
            [
                'name' => 'IFT',
                'rtu' => $keypoint->ift_rtu ?? '',
                'ms' => $keypoint->ift_ms ?? '',
                'scale' => $keypoint->ift_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->ift_addrtu ?? '',
                    'ms' => $keypoint->ift_addms ?? '',
                    'obj' => $keypoint->ift_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_ift ?? '',
                'isPseudo' => true
            ],
            [
                'name' => 'IFN',
                'rtu' => $keypoint->ifn_rtu ?? '',
                'ms' => $keypoint->ifn_ms ?? '',
                'scale' => $keypoint->ifn_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->ifn_addrtu ?? '',
                    'ms' => $keypoint->ifn_addms ?? '',
                    'obj' => $keypoint->ifn_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_ifn ?? '',
                'isPseudo' => true
            ],
            [
                'name' => 'PF',
                'rtu' => $keypoint->pf_rtu ?? '',
                'ms' => $keypoint->pf_ms ?? '',
                'scale' => $keypoint->pf_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->pf_addrtu ?? '',
                    'ms' => $keypoint->pf_addms ?? '',
                    'obj' => $keypoint->pf_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_pf ?? '',
                'isPseudo' => false
            ],
            [
                'name' => 'V AVG',
                'rtu' => $keypoint->vavg_rtu ?? '',
                'ms' => $keypoint->vavg_ms ?? '',
                'scale' => $keypoint->vavg_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->vavg_addrtu ?? '',
                    'ms' => $keypoint->vavg_addms ?? '',
                    'obj' => $keypoint->vavg_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_vavg ?? '',
                'isPseudo' => false
            ],
            [
                'name' => 'V-R_IN',
                'rtu' => $keypoint->vrin_rtu ?? '',
                'ms' => $keypoint->vrin_ms ?? '',
                'scale' => $keypoint->vrin_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->vrin_addrtu ?? '',
                    'ms' => $keypoint->vrin_addms ?? '',
                    'obj' => $keypoint->vrin_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_vrin ?? '',
                'isPseudo' => false
            ],
            [
                'name' => 'V-S_IN',
                'rtu' => $keypoint->vsin_rtu ?? '',
                'ms' => $keypoint->vsin_ms ?? '',
                'scale' => $keypoint->vsin_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->vsin_addrtu ?? '',
                    'ms' => $keypoint->vsin_addms ?? '',
                    'obj' => $keypoint->vsin_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_vsin ?? '',
                'isPseudo' => false
            ],
            [
                'name' => 'V-T_IN',
                'rtu' => $keypoint->vtin_rtu ?? '',
                'ms' => $keypoint->vtin_ms ?? '',
                'scale' => $keypoint->vtin_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->vtin_addrtu ?? '',
                    'ms' => $keypoint->vtin_addms ?? '',
                    'obj' => $keypoint->vtin_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_vtin ?? '',
                'isPseudo' => false
            ],
            [
                'name' => 'V-R_OUT',
                'rtu' => $keypoint->vrout_rtu ?? '',
                'ms' => $keypoint->vrout_ms ?? '',
                'scale' => $keypoint->vrout_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->vrout_addrtu ?? '',
                    'ms' => $keypoint->vrout_addms ?? '',
                    'obj' => $keypoint->vrout_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_vrout ?? '',
                'isPseudo' => false
            ],
            [
                'name' => 'V-S_OUT',
                'rtu' => $keypoint->vsout_rtu ?? '',
                'ms' => $keypoint->vsout_ms ?? '',
                'scale' => $keypoint->vsout_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->vsout_addrtu ?? '',
                    'ms' => $keypoint->vsout_addms ?? '',
                    'obj' => $keypoint->vsout_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_vsout ?? '',
                'isPseudo' => false
            ],
            [
                'name' => 'V-T_OUT',
                'rtu' => $keypoint->vtout_rtu ?? '',
                'ms' => $keypoint->vtout_ms ?? '',
                'scale' => $keypoint->vtout_scale ?? '',
                'address' => [
                    'rtu' => $keypoint->vtout_addrtu ?? '',
                    'ms' => $keypoint->vtout_addms ?? '',
                    'obj' => $keypoint->vtout_addobjfrmt ?? ''
                ],
                'test' => $keypoint->t_vtout ?? '',
                'isPseudo' => false
            ],
        ];
    }

    /**
     * Parse Hardware Data
     */
    private function parseHardwareData($keypoint)
    {
        return [
            [
                'name' => 'Batere',
                'status' => $this->getTestResult($keypoint->hard_batere ?? ''),
                'value' => $keypoint->hard_batere_input ?? ''
            ],
            [
                'name' => 'PS 220',
                'status' => $this->getTestResult($keypoint->hard_ps220 ?? ''),
                'value' => $keypoint->hard_ps220_input ?? ''
            ],
            [
                'name' => 'Charger',
                'status' => $this->getTestResult($keypoint->hard_charger ?? ''),
                'value' => $keypoint->hard_charger_input ?? ''
            ],
            [
                'name' => 'Limit Switch',
                'status' => $this->getTestResult($keypoint->hard_limitswith ?? ''),
                'value' => $keypoint->hard_limitswith_input ?? ''
            ],
        ];
    }

    /**
     * Parse System Data
     */
    private function parseSystemData($keypoint)
    {
        return [
            [
                'name' => 'COMF',
                'status' => $this->getTestResult($keypoint->sys_comf ?? ''),
                'value' => $keypoint->sys_comf_input ?? ''
            ],
            [
                'name' => 'LRUF',
                'status' => $this->getTestResult($keypoint->sys_lruf ?? ''),
                'value' => $keypoint->sys_lruf_input ?? ''
            ],
            [
                'name' => 'SIGN S',
                'status' => $this->getTestResult($keypoint->sys_signs ?? ''),
                'value' => $keypoint->sys_signs_input ?? ''
            ],
            [
                'name' => 'Limit Switch',
                'status' => $this->getTestResult($keypoint->sys_limitswith ?? ''),
                'value' => $keypoint->sys_limitswith_input ?? ''
            ],
        ];
    }

    /**
     * Parse Recloser Data
     */
    private function parseRecloserData($keypoint)
    {
        return [
            [
                'name' => 'AR',
                'on' => $this->getTestResult($keypoint->re_ar_on ?? ''),
                'off' => $this->getTestResult($keypoint->re_ar_off ?? '')
            ],
            [
                'name' => 'CTRL AR',
                'on' => $this->getTestResult($keypoint->re_ctrl_ar_on ?? ''),
                'off' => $this->getTestResult($keypoint->re_ctrl_ar_off ?? '')
            ],
        ];
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
     * Convert test result code to readable format
     */
    private function getTestResult($code)
    {
        $results = [
            '1' => 'OK',
            '2' => 'NOK',
            '3' => 'N/A',
            '4' => 'SKIP',
            '5' => 'PENDING'
        ];

        // Extract number from string like 'hard_batere1' -> '1'
        preg_match('/(\d+)$/', $code, $matches);
        $num = $matches[1] ?? '';

        return $results[$num] ?? $code;
    }

    // New methods for filtered exports (PDF and Excel)
    // Assume you have a view 'pdf.allkeypoints' with a table loop similar to index
    public function exportPdfFiltered(Request $request)
    {
        $fromDate = $request->query('from');
        $toDate = $request->query('to');

        // Reuse the same query logic as in data() but without pagination/search columns (only dates for export as per UI)
        $query = DB::table('tb_formkp')
            ->leftJoin('tb_merklbs', 'tb_formkp.id_merkrtu', '=', 'tb_merklbs.id_merkrtu')
            ->leftJoin('tb_modem', 'tb_formkp.id_modem', '=', 'tb_modem.id_modem')
            ->select(
                'tb_formkp.tgl_komisioning',
                'tb_formkp.nama_lbs as nama_keypoint',
                DB::raw("CONCAT(tb_formkp.id_gi, ' - ', tb_formkp.penyulang) as gi_penyulang"),
                DB::raw("CONCAT(COALESCE(tb_merklbs.nama_merklbs, 'N/A'), ' - ', COALESCE(tb_modem.nama_modem, 'N/A')) as merk_modem_rtu"),
                'tb_formkp.catatankp as keterangan',
                'tb_formkp.nama_user as master'
            );

        if ($fromDate && $toDate) {
            $query->whereBetween('tb_formkp.tgl_komisioning', [$fromDate, $toDate]);
        } // Add more filters if needed later

        $keypoints = $query->get();

        // Format dates
        $keypoints = $keypoints->map(function ($row) {
            $row->tgl_komisioning = Carbon::parse($row->tgl_komisioning)->format('l, d-m-Y');
            return $row;
        });

        $data = ['keypoints' => $keypoints];
        $html = view('pdf.allkeypoints', $data)->render(); // Create this view with <table> loop

        $filename = "Data_Keypoint_" . now()->format('d-m-Y') . ".pdf";
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetMargins(10, 5, 10);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage('L');
        $pdf->writeHTML($html, true, false, true, false, '');

        return response()->streamDownload(function () use ($pdf, $filename) {
            $pdf->Output($filename, 'I');
        }, $filename, ['Content-Type' => 'application/pdf']);
    }

    // For Excel: Fallback to CSV if no library; recommend installing maatwebsite/excel
    public function exportExcelFiltered(Request $request)
    {
        $fromDate = $request->query('from');
        $toDate = $request->query('to');

        // Similar query as PDF
        $query = DB::table('tb_formkp')
            ->leftJoin('tb_merklbs', 'tb_formkp.id_merkrtu', '=', 'tb_merklbs.id_merkrtu')
            ->leftJoin('tb_modem', 'tb_formkp.id_modem', '=', 'tb_modem.id_modem')
            ->select(
                DB::raw("DATE_FORMAT(tb_formkp.tgl_komisioning, '%d-%m-%Y') as tgl_komisioning"),
                'tb_formkp.nama_lbs as nama_keypoint',
                DB::raw("CONCAT(tb_formkp.id_gi, ' - ', tb_formkp.penyulang) as gi_penyulang"),
                DB::raw("CONCAT(COALESCE(tb_merklbs.nama_merklbs, 'N/A'), ' - ', COALESCE(tb_modem.nama_modem, 'N/A')) as merk_modem_rtu"),
                'tb_formkp.catatankp as keterangan',
                'tb_formkp.nama_user as master'
            );

        if ($fromDate && $toDate) {
            $query->whereBetween('tb_formkp.tgl_komisioning', [$fromDate, $toDate]);
        }

        $keypoints = $query->get()->toArray();

        $filename = "Data_Keypoint_" . now()->format('d-m-Y') . ".csv";
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Tgl Komisioning', 'Nama Keypoint', 'GI & Penyulang', 'Merk Modem & RTU', 'Keterangan', 'Master']); // Headers

        foreach ($keypoints as $row) {
            fputcsv($handle, (array)$row);
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        return response()->streamDownload(function () use ($handle) {
            fclose($handle);
        }, $filename, $headers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $merklbs = DB::table('tb_merklbs')->get();
        $modems = DB::table('tb_modem')->get();
        $medkom = DB::table('tb_medkom')->get();
        // $garduinduk = DB::table('tb_garduinduk')->get();
        $garduinduk = DB::connection('masterdata')->table('dg_keypoint')->select('gardu_induk')->distinct()->get();
        $sectoral = DB::table('tb_sectoral')->get();
        $komkp = DB::table('tb_komkp')->get();
        $pelms = DB::table('tb_picmaster')->get();
        $pelrtus = DB::table('tb_pelaksana_rtu')->get();

        return view('pages.keypoint.add', compact('merklbs', 'modems', 'medkom', 'garduinduk', 'sectoral', 'komkp', 'pelms', 'pelrtus'));
    }
    public function getNamaKeypoint($gardu_induk, $penyulang)
    {
        $keypoints = DB::connection('masterdata')->table('dg_keypoint')
            ->where('gardu_induk', urldecode($gardu_induk))
            ->where('penyulang', urldecode($penyulang))
            ->select(
                DB::raw("CONCAT(type_keypoint, ' ', nama_keypoint) as full_name")
            )
            ->get()
            ->pluck('full_name', 'full_name'); // Gunakan full_name sebagai key DAN value

        return response()->json($keypoints);
    }

    public function getPenyulang($gardu_induk)
    {
        $penyulang = DB::connection('masterdata')->table('dg_keypoint')
            ->where('gardu_induk', urldecode($gardu_induk))
            ->pluck('penyulang')
            ->unique();
        return response()->json($penyulang);
    }



    public function getSektoral($gardu_induk, $penyulang)
    {
        $sektoral = DB::connection('masterdata')->table('dg_keypoint')
            ->where('gardu_induk', urldecode($gardu_induk))
            ->where('penyulang', urldecode($penyulang))
            ->select(
                DB::raw("CONCAT(up3, ' ', sektoral) as full_name")
            )
            ->distinct()
            ->get()
            ->pluck('full_name', 'full_name');

        return response()->json($sektoral);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Prepare Arrays for ID fields
        $idPelmsInput = $request->input('id_pelms', '');
        $idPelmsArray = !empty($idPelmsInput) ? array_filter(array_map('trim', explode(',', $idPelmsInput))) : [];

        $idPelrtuInput = $request->input('id_pelrtu', '');
        $idPelrtuArray = !empty($idPelrtuInput) ? array_filter(array_map('trim', explode(',', $idPelrtuInput))) : [];

        // 2. Define ALL valid checkbox values (Must match value="..." in Blade)
        $validCheckboxValues = [
            // --- Common Values ---
            'normal',
            'ok',
            'nok',
            'log',
            'sld',
            'tidak_uji',
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
            'dropen_1',
            'dropen_2',
            'dropen_3',
            'dropen_4',
            'dropen_5',
            'drclose_1',
            'drclose_2',
            'drclose_3',
            'drclose_4',
            'drclose_5',
            'acnrml_1',
            'acnrml_2',
            'acnrml_3',
            'acnrml_4',
            'acnrml_5',
            'acfail_1',
            'acfail_2',
            'acfail_3',
            'acfail_4',
            'acfail_5',
            'dcnrml_1',
            'dcnrml_2',
            'dcnrml_3',
            'dcnrml_4',
            'dcnrml_5',
            'dcfail_1',
            'dcfail_2',
            'dcfail_3',
            'dcfail_4',
            'dcfail_5',
            'dcfnrml_1',
            'dcfnrml_2',
            'dcfnrml_3',
            'dcfnrml_4',
            'dcfnrml_5',
            'dcffail_1',
            'dcffail_2',
            'dcffail_3',
            'dcffail_4',
            'dcffail_5',
            'hlton_1',
            'hlton_2',
            'hlton_3',
            'hlton_4',
            'hlton_5',
            'hltoff_1',
            'hltoff_2',
            'hltoff_3',
            'hltoff_4',
            'hltoff_5',
            'sf6nrml_1',
            'sf6nrml_2',
            'sf6nrml_3',
            'sf6nrml_4',
            'sf6nrml_5',
            'sf6fail_1',
            'sf6fail_2',
            'sf6fail_3',
            'sf6fail_4',
            'sf6fail_5',
            'firnrml_1',
            'firnrml_2',
            'firnrml_3',
            'firnrml_4',
            'firnrml_5',
            'firfail_1',
            'firfail_2',
            'firfail_3',
            'firfail_4',
            'firfail_5',
            'fisnrml_1',
            'fisnrml_2',
            'fisnrml_3',
            'fisnrml_4',
            'fisnrml_5',
            'fisfail_1',
            'fisfail_2',
            'fisfail_3',
            'fisfail_4',
            'fisfail_5',
            'fitnrml_1',
            'fitnrml_2',
            'fitnrml_3',
            'fitnrml_4',
            'fitnrml_5',
            'fitfail_1',
            'fitfail_2',
            'fitfail_3',
            'fitfail_4',
            'fitfail_5',
            'finnrml_1',
            'finnrml_2',
            'finnrml_3',
            'finnrml_4',
            'finnrml_5',
            'finfail_1',
            'finfail_2',
            'finfail_3',
            'finfail_4',
            'finfail_5',
            'comf_nrml_1',
            'comf_nrml_2',
            'comf_nrml_3',
            'lruf_nrml_1',
            'lruf_nrml_2',
            'lruf_nrml_5',

            // --- Telecontrol (FormTelecontrol) ---
            'cbctrl_op_1',
            'cbctrl_op_2',
            'cbctrl_op_3',
            'cbctrl_op_4',
            'cbctrl_op_5',
            'cbctrl_cl_1',
            'cbctrl_cl_2',
            'cbctrl_cl_3',
            'cbctrl_cl_4',
            'cbctrl_cl_5',
            'cbctrl2_op_1',
            'cbctrl2_op_2',
            'cbctrl2_op_3',
            'cbctrl2_op_4',
            'cbctrl2_op_5',
            'cbctrl2_cl_1',
            'cbctrl2_cl_2',
            'cbctrl2_cl_3',
            'cbctrl2_cl_4',
            'cbctrl2_cl_5',
            'hltctrl_off_1',
            'hltctrl_off_2',
            'hltctrl_off_3',
            'hltctrl_off_4',
            'hltctrl_off_5',
            'hltctrl_on_1',
            'hltctrl_on_2',
            'hltctrl_on_3',
            'hltctrl_on_4',
            'hltctrl_on_5',
            'rrctrl_on_1',
            'rrctrl_on_2',
            'rrctrl_on_3',
            'rrctrl_on_4',
            'rrctrl_on_5',

            // --- System (FormSystem) ---
            'sys_comf1',
            'sys_comf2',
            'sys_comf5',
            'sys_lruf1',
            'sys_lruf2',
            'sys_lruf5',
            'sys_signs1',
            'sys_signs2',
            'sys_signs5',
            'sys_limitswith1',
            'sys_limitswith2',
            'sys_limitswith5',

            // --- Hardware (FormHardware) ---
            'hard_batere1',
            'hard_batere2',
            'hard_batere5',
            'hard_ps2201',
            'hard_ps2202',
            'hard_ps2205',
            'hard_charger1',
            'hard_charger2',
            'hard_charger5',
            'hard_limitswith1',
            'hard_limitswith2',
            'hard_limitswith5',

            // --- Recloser (FormRecloser) ---
            're_ar_on1',
            're_ar_on2',
            're_ar_on5',
            're_ar_off1',
            're_ar_off2',
            're_ar_off5',
            're_ctrl_ar_on1',
            're_ctrl_ar_on2',
            're_ctrl_ar_on5',
            're_ctrl_ar_off1',
            're_ctrl_ar_off2',
            're_ctrl_ar_off5',

            // --- TELEMETERING NEW VALUES (ADDED) ---
            // Arus
            't_ir1',
            't_ir2',
            't_ir5',
            't_is1',
            't_is2',
            't_is5',
            't_it1',
            't_it2',
            't_it5',
            't_in1',
            't_in2',
            't_in5',
            // Tegangan Input
            't_vrin1',
            't_vrin2',
            't_vrin5',
            't_vsin1',
            't_vsin2',
            't_vsin5',
            't_vtin1',
            't_vtin2',
            't_vtin5',
            // Tegangan Output
            't_vrout1',
            't_vrout2',
            't_vrout5',
            't_vsout1',
            't_vsout2',
            't_vsout5',
            't_vtout1',
            't_vtout2',
            't_vtout5',
            // Tegangan Rata2 & Frekuensi
            't_vavg1',
            't_vavg2',
            't_vavg5',
            't_hz1',
            't_hz2',
            't_hz5',
            // Arus Rata2 & Power Factor
            't_iavg1',
            't_iavg2',
            't_iavg5',
            't_pf1',
            't_pf2',
            't_pf5',
            // Arus Gangguan
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
            // Arus Gangguan Psuedo
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
        ];

        // 3. Define Validation Rules
        $rules = [
            'tgl_komisioning' => 'required|date',
            'nama_lbs' => ['required', 'string', 'max:100', function ($attribute, $value, $fail) use ($request) {
                $modeInput = $request->input('mode_input', 0);

                if ($modeInput == 0 || $modeInput == '0') {
                    $gi = $request->id_gi;
                    $peny = $request->nama_peny;

                    $exists = DB::connection('masterdata')->table('dg_keypoint')
                        ->where('gardu_induk', $gi)
                        ->where('penyulang', $peny)
                        ->whereRaw("CONCAT(type_keypoint, ' ', nama_keypoint) = ?", [$value])
                        ->exists();

                    if (!$exists) {
                        $fail('Nama Keypoint tidak valid.');
                    }
                }
            }],
            'id_merkrtu' => 'required|integer|exists:tb_merklbs,id_merkrtu',
            'id_modem' => 'required|integer|exists:tb_modem,id_modem',
            'rtu_addrs' => 'required|string|max:255',
            'id_medkom' => 'required|integer|exists:tb_medkom,id_medkom',
            'ip_kp' => 'required|string|max:255',
            'id_gi' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                if (!DB::connection('masterdata')->table('dg_keypoint')->where('gardu_induk', $value)->exists()) {
                    $fail('The selected Gardu Induk is invalid.');
                }
            }],
            'nama_peny' => ['required', 'string', 'max:25', function ($attribute, $value, $fail) use ($request) {
                $gi = $request->id_gi;
                if (!DB::connection('masterdata')->table('dg_keypoint')->where('gardu_induk', $gi)->where('penyulang', $value)->exists()) {
                    $fail('Invalid Nama Penyulangan for selected Gardu Induk.');
                }
            }],
            // Validasi nama_sec untuk format up3 + sektoral (akan disimpan ke id_sec)
            'nama_sec' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) use ($request) {
                $modeInput = $request->input('mode_input', 0);

                if ($modeInput == 0 || $modeInput == '0') {
                    $gi = $request->id_gi;
                    $peny = $request->nama_peny;

                    $exists = DB::connection('masterdata')->table('dg_keypoint')
                        ->where('gardu_induk', $gi)
                        ->where('penyulang', $peny)
                        ->whereRaw("CONCAT(up3, ' ', sektoral) = ?", [$value])
                        ->exists();

                    if (!$exists) {
                        $fail('Sectoral tidak valid.');
                    }
                }
            }],
            // --- TELEMETERING FIELDS ---

            // Arus (Existing)
            'ir_rtu' => 'required|integer',
            'ir_ms' => 'required|integer',
            'ir_scale' => 'required|string|max:10',
            'is_rtu' => 'required|integer',
            'is_ms' => 'required|integer',
            'is_scale' => 'required|string|max:10',
            'it_rtu' => 'required|integer',
            'it_ms' => 'required|integer',
            'it_scale' => 'required|string|max:10',

            // --- 1. ARUS (Existing) ---
            'ir_addrtu'     => 'required|integer',
            'ir_addms'      => 'required|integer',
            'ir_addobjfrmt' => 'required|string|max:10', // Sebelumnya ir_scale

            'is_addrtu'     => 'required|integer',
            'is_addms'      => 'required|integer',
            'is_addobjfrmt' => 'required|string|max:10', // Sebelumnya is_scale

            'it_addrtu'     => 'required|integer',
            'it_addms'      => 'required|integer',
            'it_addobjfrmt' => 'required|string|max:10', // Sebelumnya it_scale

            'in_addrtu'     => 'nullable|string|max:100', // Ditambahkan dari section bawah
            'in_addms'      => 'nullable|string|max:100',
            'in_addobjfrmt' => 'nullable|string|max:100',

            // Tegangan Input (Existing)
            'vrin_rtu' => 'required|string|max:10',
            'vrin_ms' => 'required|string|max:10',
            'vrin_scale' => 'required|string|max:10',
            'vsin_rtu' => 'required|string|max:10',
            'vsin_ms' => 'required|string|max:10',
            'vsin_scale' => 'required|string|max:10',
            'vtin_rtu' => 'required|string|max:10',
            'vtin_ms' => 'required|string|max:10',
            'vtin_scale' => 'required|string|max:10',

            // --- 2. TEGANGAN INPUT (Existing) ---
            'vrin_addrtu'     => 'required|string|max:10',
            'vrin_addms'      => 'required|string|max:10',
            'vrin_addobjfrmt' => 'required|string|max:10',

            'vsin_addrtu'     => 'required|string|max:10',
            'vsin_addms'      => 'required|string|max:10',
            'vsin_addobjfrmt' => 'required|string|max:10',

            'vtin_addrtu'     => 'required|string|max:10',
            'vtin_addms'      => 'required|string|max:10',
            'vtin_addobjfrmt' => 'required|string|max:10',

            // Tegangan Output (BARU DITAMBAHKAN)
            'vrout_rtu' => 'nullable|string|max:10',
            'vrout_ms' => 'nullable|string|max:10',
            'vrout_scale' => 'nullable|string|max:10',
            'vsout_rtu' => 'nullable|string|max:10',
            'vsout_ms' => 'nullable|string|max:10',
            'vsout_scale' => 'nullable|string|max:10',
            'vtout_rtu' => 'nullable|string|max:10',
            'vtout_ms' => 'nullable|string|max:10',
            'vtout_scale' => 'nullable|string|max:10',

            // --- 3. TEGANGAN OUTPUT (BARU) ---
            'vrout_addrtu'     => 'nullable|string|max:10',
            'vrout_addms'      => 'nullable|string|max:10',
            'vrout_addobjfrmt' => 'nullable|string|max:10',

            'vsout_addrtu'     => 'nullable|string|max:10',
            'vsout_addms'      => 'nullable|string|max:10',
            'vsout_addobjfrmt' => 'nullable|string|max:10',

            'vtout_addrtu'     => 'nullable|string|max:10',
            'vtout_addms'      => 'nullable|string|max:10',
            'vtout_addobjfrmt' => 'nullable|string|max:10',

            'vavg_addrtu'      => 'nullable|string|max:100', // Ditambahkan dari section bawah
            'vavg_addms'       => 'nullable|string|max:100',
            'vavg_addobjfrmt'  => 'nullable|string|max:100',

            // Frekuensi, Arus Rata2, Power Factor (BARU DITAMBAHKAN)
            'hz_rtu' => 'nullable|string|max:10',
            'hz_ms' => 'nullable|string|max:10',
            'hz_scale' => 'nullable|string|max:10',
            'iavg_rtu' => 'nullable|string|max:10',
            'iavg_ms' => 'nullable|string|max:10',
            'iavg_scale' => 'nullable|string|max:10',
            'pf_rtu' => 'nullable|string|max:10',
            'pf_ms' => 'nullable|string|max:10',
            'pf_scale' => 'nullable|string|max:10',

            // --- 4. FREKUENSI, ARUS RATA2, POWER FACTOR (BARU) ---
            'hz_addrtu'     => 'nullable|string|max:10',
            'hz_addms'      => 'nullable|string|max:10',
            'hz_addobjfrmt' => 'nullable|string|max:10',

            'iavg_addrtu'     => 'nullable|string|max:100',
            'iavg_addms'      => 'nullable|string|max:100',
            'iavg_addobjfrmt' => 'nullable|string|max:100',

            'pf_addrtu'     => 'nullable|string|max:10',
            'pf_addms'      => 'nullable|string|max:10',
            'pf_addobjfrmt' => 'nullable|string|max:10',

            // Arus Gangguan / Fault Current (BARU DITAMBAHKAN)
            'ifr_rtu' => 'nullable|string|max:10',
            'ifr_ms' => 'nullable|string|max:10',
            'ifr_scale' => 'nullable|string|max:10',
            'ifs_rtu' => 'nullable|string|max:10',
            'ifs_ms' => 'nullable|string|max:10',
            'ifs_scale' => 'nullable|string|max:10',
            'ift_rtu' => 'nullable|string|max:10',
            'ift_ms' => 'nullable|string|max:10',
            'ift_scale' => 'nullable|string|max:10',
            'ifn_rtu' => 'nullable|string|max:10',
            'ifn_ms' => 'nullable|string|max:10',
            'ifn_scale' => 'nullable|string|max:10',

            // --- 5. ARUS GANGGUAN / FAULT CURRENT (BARU) ---
            'ifr_addrtu'     => 'nullable|string|max:10',
            'ifr_addms'      => 'nullable|string|max:10',
            'ifr_addobjfrmt' => 'nullable|string|max:10',

            'ifs_addrtu'     => 'nullable|string|max:10',
            'ifs_addms'      => 'nullable|string|max:10',
            'ifs_addobjfrmt' => 'nullable|string|max:10',

            'ift_addrtu'     => 'nullable|string|max:10',
            'ift_addms'      => 'nullable|string|max:10',
            'ift_addobjfrmt' => 'nullable|string|max:10',

            'ifn_addrtu'     => 'nullable|string|max:10',
            'ifn_addms'      => 'nullable|string|max:10',
            'ifn_addobjfrmt' => 'nullable|string|max:10',

            // Arus Gangguan Pseudo (BARU DITAMBAHKAN)
            'ifr_psuedo_rtu' => 'nullable|string|max:10',
            'ifr_psuedo_ms' => 'nullable|string|max:10',
            'ifr_psuedo_scale' => 'nullable|string|max:10',
            'ifs_psuedo_rtu' => 'nullable|string|max:10',
            'ifs_psuedo_ms' => 'nullable|string|max:10',
            'ifs_psuedo_scale' => 'nullable|string|max:10',
            'ift_psuedo_rtu' => 'nullable|string|max:10',
            'ift_psuedo_ms' => 'nullable|string|max:10',
            'ift_psuedo_scale' => 'nullable|string|max:10',
            'ifn_psuedo_rtu' => 'nullable|string|max:10',
            'ifn_psuedo_ms' => 'nullable|string|max:10',
            'ifn_psuedo_scale' => 'nullable|string|max:10',

            // --- 6. ARUS GANGGUAN PSEUDO (BARU) ---
            // Perhatikan penulisan 'psuedo' disesuaikan dengan gambar (bukan pseudo)
            'ifr_psuedo_addrtu'     => 'nullable|string|max:10',
            'ifr_psuedo_addms'      => 'nullable|string|max:10',
            'ifr_psuedo_addobjfrmt' => 'nullable|string|max:10',

            'ifs_psuedo_addrtu'     => 'nullable|string|max:10',
            'ifs_psuedo_addms'      => 'nullable|string|max:10',
            'ifs_psuedo_addobjfrmt' => 'nullable|string|max:10',

            'ift_psuedo_addrtu'     => 'nullable|string|max:10',
            'ift_psuedo_addms'      => 'nullable|string|max:10',
            'ift_psuedo_addobjfrmt' => 'nullable|string|max:10',

            'ifn_psuedo_addrtu'     => 'nullable|string|max:10',
            'ifn_psuedo_addms'      => 'nullable|string|max:10',
            'ifn_psuedo_addobjfrmt' => 'nullable|string|max:10',

            // --- IN & VAVG ---
            'iavg_rtu' => 'nullable|string|max:100',
            'iavg_ms' => 'nullable|string|max:100',
            'iavg_scale' => 'nullable|string|max:100',
            'in_rtu' => 'nullable|string|max:100',
            'in_ms' => 'nullable|string|max:100',
            'in_scale' => 'nullable|string|max:100',
            'vavg_rtu' => 'nullable|string|max:100',
            'vavg_ms' => 'nullable|string|max:100',
            'vavg_scale' => 'nullable|string|max:100',

            // Notes and Text inputs
            'ketsys' => 'nullable|string|max:500',
            'kethard' => 'nullable|string|max:500',
            'ketre' => 'nullable|string|max:500',
            'catatankp' => 'required|string|max:500',
            'ketfd' => 'nullable|string|max:500',
            'ketfts' => 'nullable|string|max:500',
            'ketftc' => 'nullable|string|max:500',
            'ketftm' => 'nullable|string|max:500',
            'ketpk' => 'nullable|string|max:500',
            'sys_comf_input' => 'nullable|string|max:100',
            'sys_lruf_input' => 'nullable|string|max:100',
            'sys_signs_input' => 'nullable|string|max:100',
            'sys_limitswith_input' => 'nullable|string|max:100',
            'hard_batere_input' => 'nullable|string|max:100',
            'hard_ps220_input' => 'nullable|string|max:100',
            'hard_charger_input' => 'nullable|string|max:100',
            'hard_limitswith_input' => 'nullable|string|max:100',
            'nama_user' => 'required|string|max:50', // increased max length just in case
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',

            // AddMs / AddRtu / ObjFrmt fields (Strings)
            'sacf_fail_addms' => 'nullable|string|max:100',
            'sacf_fail_addrtu' => 'nullable|string|max:100',
            'sacf_fail_objfrmt' => 'nullable|string|max:100',
            'sacf_normal_addms' => 'nullable|string|max:100',
            'sacf_normal_addrtu' => 'nullable|string|max:100',
            'sacf_normal_objfrmt' => 'nullable|string|max:100',
            'scb2_close_addms' => 'nullable|string|max:100',
            'scb2_close_addrtu' => 'nullable|string|max:100',
            'scb2_close_objfrmt' => 'nullable|string|max:100',
            'scb2_open_addms' => 'nullable|string|max:100',
            'scb2_open_addrtu' => 'nullable|string|max:100',
            'scb2_open_objfrmt' => 'nullable|string|max:100',
            'scb_close_addms' => 'nullable|string|max:100',
            'scb_close_addrtu' => 'nullable|string|max:100',
            'scb_close_objfrmt' => 'nullable|string|max:100',
            'scb_open_addms' => 'nullable|string|max:100',
            'scb_open_addrtu' => 'nullable|string|max:100',
            'scb_open_objfrmt' => 'nullable|string|max:100',
            'sdcd_fail_addms' => 'nullable|string|max:100',
            'sdcd_fail_addrtu' => 'nullable|string|max:100',
            'sdcd_fail_objfrmt' => 'nullable|string|max:100',
            'sdcd_normal_addms' => 'nullable|string|max:100',
            'sdcd_normal_addrtu' => 'nullable|string|max:100',
            'sdcd_normal_objfrmt' => 'nullable|string|max:100',
            'sdcf_fail_addms' => 'nullable|string|max:100',
            'sdcf_fail_addrtu' => 'nullable|string|max:100',
            'sdcf_fail_objfrmt' => 'nullable|string|max:100',
            'sdcf_normal_addms' => 'nullable|string|max:100',
            'sdcf_normal_addrtu' => 'nullable|string|max:100',
            'sdcf_normal_objfrmt' => 'nullable|string|max:100',
            'sdoor_close_addms' => 'nullable|string|max:100',
            'sdoor_close_addrtu' => 'nullable|string|max:100',
            'sdoor_close_objfrmt' => 'nullable|string|max:100',
            'sdoor_open_addms' => 'nullable|string|max:100',
            'sdoor_open_addrtu' => 'nullable|string|max:100',
            'sdoor_open_objfrmt' => 'nullable|string|max:100',
            'sfin_fail_addms' => 'nullable|string|max:100',
            'sfin_fail_addrtu' => 'nullable|string|max:100',
            'sfin_fail_objfrmt' => 'nullable|string|max:100',
            'sfin_normal_addms' => 'nullable|string|max:100',
            'sfin_normal_addrtu' => 'nullable|string|max:100',
            'sfin_normal_objfrmt' => 'nullable|string|max:100',
            'sfir_fail_addms' => 'nullable|string|max:100',
            'sfir_fail_addrtu' => 'nullable|string|max:100',
            'sfir_fail_objfrmt' => 'nullable|string|max:100',
            'sfir_normal_addms' => 'nullable|string|max:100',
            'sfir_normal_addrtu' => 'nullable|string|max:100',
            'sfir_normal_objfrmt' => 'nullable|string|max:100',
            'sfis_fail_addms' => 'nullable|string|max:100',
            'sfis_fail_addrtu' => 'nullable|string|max:100',
            'sfis_fail_objfrmt' => 'nullable|string|max:100',
            'sfis_normal_addms' => 'nullable|string|max:100',
            'sfis_normal_addrtu' => 'nullable|string|max:100',
            'sfis_normal_objfrmt' => 'nullable|string|max:100',
            'sfit_fail_addms' => 'nullable|string|max:100',
            'sfit_fail_addrtu' => 'nullable|string|max:100',
            'sfit_fail_objfrmt' => 'nullable|string|max:100',
            'sfit_normal_addms' => 'nullable|string|max:100',
            'sfit_normal_addrtu' => 'nullable|string|max:100',
            'sfit_normal_objfrmt' => 'nullable|string|max:100',
            'shlt_off_addms' => 'nullable|string|max:100',
            'shlt_off_addrtu' => 'nullable|string|max:100',
            'shlt_off_objfrmt' => 'nullable|string|max:100',
            'shlt_on_addms' => 'nullable|string|max:100',
            'shlt_on_addrtu' => 'nullable|string|max:100',
            'shlt_on_objfrmt' => 'nullable|string|max:100',
            'slr_local_addms' => 'nullable|string|max:100',
            'slr_local_addrtu' => 'nullable|string|max:100',
            'slr_local_objfrmt' => 'nullable|string|max:100',
            'slr_remote_addms' => 'nullable|string|max:100',
            'slr_remote_addrtu' => 'nullable|string|max:100',
            'slr_remote_objfrmt' => 'nullable|string|max:100',
            // 'slruf_addms' => 'nullable|string|max:100', 'slruf_addrtu' => 'nullable|string|max:100', 'slruf_objfrmt' => 'nullable|string|max:100',
            'ssf6_fail_addms' => 'nullable|string|max:100',
            'ssf6_fail_addrtu' => 'nullable|string|max:100',
            'ssf6_fail_objfrmt' => 'nullable|string|max:100',
            'ssf6_normal_addms' => 'nullable|string|max:100',
            'ssf6_normal_addrtu' => 'nullable|string|max:100',
            'ssf6_normal_objfrmt' => 'nullable|string|max:100',

            'ccb_open_addms' => 'nullable|string|max:100',
            'ccb_open_addrtu' => 'nullable|string|max:100',
            'ccb_open_objfrmt' => 'nullable|string|max:100',
            'ccb_close_addms' => 'nullable|string|max:100',
            'ccb_close_addrtu' => 'nullable|string|max:100',
            'ccb_close_objfrmt' => 'nullable|string|max:100',
            'ccb2_open_addms' => 'nullable|string|max:100',
            'ccb2_open_addrtu' => 'nullable|string|max:100',
            'ccb2_open_objfrmt' => 'nullable|string|max:100',
            'ccb2_close_addms' => 'nullable|string|max:100',
            'ccb2_close_addrtu' => 'nullable|string|max:100',
            'ccb2_close_objfrmt' => 'nullable|string|max:100',
            'chlt_on_addms' => 'nullable|string|max:100',
            'chlt_on_addrtu' => 'nullable|string|max:100',
            'chlt_on_objfrmt' => 'nullable|string|max:100',
            'chlt_off_addms' => 'nullable|string|max:100',
            'chlt_off_addrtu' => 'nullable|string|max:100',
            'chlt_off_objfrmt' => 'nullable|string|max:100',
            'crst_addms' => 'nullable|string|max:100',
            'crst_addrtu' => 'nullable|string|max:100',
            'crst_objfrmt' => 'nullable|string|max:100',



            // Custom Validation for Array IDs
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
        ];

        // 4. Add Checkbox Array Validations Dynamically
        $checkboxFields = [
            's_cb',
            's_cb2',
            's_lr',
            's_door',
            's_acf',
            's_dcf',
            's_dcd',
            's_hlt',
            's_sf6',
            's_fir',
            's_fis',
            's_fit',
            's_fin',
            'sys_comf',
            'sys_lruf',
            'sys_signs',
            'sys_limitswith',
            'hard_batere',
            'hard_ps220',
            'hard_charger',
            'hard_limitswith',
            're_ar_on',
            're_ar_off',
            're_ctrl_ar_on',
            're_ctrl_ar_off',
            'c_cb',
            'c_cb2',
            'c_hlt',
            'c_rst',
// --- TELEMETERING CHECKBOXES ---
            't_ir',
            't_is',
            't_it',
            't_in',
            't_vrin',
            't_vsin',
            't_vtin',
            't_vrout',
            't_vsout',
            't_vtout',
            't_vavg',
            't_ifr',
            't_ifs',
            't_ift',
            't_ifn',
            't_ifr_psuedo',
            't_ifs_psuedo',
            't_ift_psuedo',
            't_ifn_psuedo',
            't_hz',
            't_iavg',
            't_pf'
        ];

        foreach ($checkboxFields as $field) {
            $rules[$field] = 'nullable|array';
            $rules[$field . '.*'] = 'string|in:' . implode(',', $validCheckboxValues);
        }

        // 5. Run Validation
        $validated = $request->validate($rules);

        // 6. Post-Processing: Convert Arrays to Comma-Separated Strings for Database
        foreach ($checkboxFields as $field) {
            // If the field exists in request and is an array, implode it. Otherwise, empty string.
            $validated[$field] = ($request->has($field) && is_array($request->input($field)))
                ? implode(',', array_filter($request->input($field)))
                : '';
        }

        // 7. Handle Sectoral Logic
        if (!empty($validated['nama_sec'])) {
            $namaSec = $validated['nama_sec']; // Ini sudah berisi "up3 sektoral"

            // Cek apakah sudah ada di tb_sectoral
            $existingSec = DB::table('tb_sectoral')->where('nama_sec', $namaSec)->first();

            if ($existingSec) {
                // Use existing sectoral ID
                $validated['id_sec'] = $existingSec->id_sec; // or use the actual ID column
            } else {
                // Option A: Still use nama_sec as id_sec
                $validated['id_sec'] = $namaSec;

                // Option B: Create new entry in tb_sectoral first
                // $newId = DB::table('tb_sectoral')->insertGetId(['nama_sec' => $namaSec]);
                // $validated['id_sec'] = $newId;
            }
        }
        unset($validated['nama_sec']); // Hapus nama_sec, hanya simpan id_sec

        // 8. Handle JSON encoded IDs
        $validated['id_pelms'] = json_encode($idPelmsArray);
        $validated['id_pelrtu'] = json_encode($idPelrtuArray);

        // 9. Save to Database
        Keypoint::create($validated);

        return redirect()->route('keypoint.index')->with('success', 'Keypoint created successfully!');
    }


























































    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $keypoint = Keypoint::findOrFail($id);
        $merklbs = DB::table('tb_merklbs')->get();
        $modems = DB::table('tb_modem')->get();
        $medkom = DB::table('tb_medkom')->get();
        $garduinduk = DB::connection('masterdata')->table('dg_keypoint')->select('gardu_induk')->distinct()->get();

        $komkp = DB::table('tb_komkp')->get();
        $pelms = DB::table('tb_picmaster')->get();
        $pelrtus = DB::table('tb_pelaksana_rtu')->get();

        $decoded = json_decode($keypoint->id_pelms, true);
        $selectedPelms = is_array($decoded) ? $decoded : ($decoded ? [$decoded] : []);
        $decodedRtu = json_decode($keypoint->id_pelrtu, true);
        $selectedPelrtus = is_array($decodedRtu) ? $decodedRtu : ($decodedRtu ? [$decodedRtu] : []);

        // ✅ SIMPLE: id_sec sudah menyimpan nama sektoral langsung
        $keypoint->nama_sec = $keypoint->id_sec;


        return view('pages.keypoint.edit', compact('keypoint', 'merklbs', 'modems', 'medkom', 'garduinduk', 'komkp', 'pelms', 'selectedPelms', 'pelrtus', 'selectedPelrtus'));
    }




    public function update(Request $request, $id)
    {
        // 0. Cari Data yang akan diupdate
        $keypoint = Keypoint::findOrFail($id);

        // 1. Prepare Arrays for ID fields
        $idPelmsInput = $request->input('id_pelms', '');
        $idPelmsArray = !empty($idPelmsInput) ? array_filter(array_map('trim', explode(',', $idPelmsInput))) : [];

        $idPelrtuInput = $request->input('id_pelrtu', '');
        $idPelrtuArray = !empty($idPelrtuInput) ? array_filter(array_map('trim', explode(',', $idPelrtuInput))) : [];

        // 2. Define ALL valid checkbox values
        $validCheckboxValues = [
            // --- Common Values ---
            'normal',
            'ok',
            'nok',
            'log',
            'sld',
            'tidak_uji',
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
            'dropen_1',
            'dropen_2',
            'dropen_3',
            'dropen_4',
            'dropen_5',
            'drclose_1',
            'drclose_2',
            'drclose_3',
            'drclose_4',
            'drclose_5',
            'acnrml_1',
            'acnrml_2',
            'acnrml_3',
            'acnrml_4',
            'acnrml_5',
            'acfail_1',
            'acfail_2',
            'acfail_3',
            'acfail_4',
            'acfail_5',
            'dcnrml_1',
            'dcnrml_2',
            'dcnrml_3',
            'dcnrml_4',
            'dcnrml_5',
            'dcfail_1',
            'dcfail_2',
            'dcfail_3',
            'dcfail_4',
            'dcfail_5',
            'dcfnrml_1',
            'dcfnrml_2',
            'dcfnrml_3',
            'dcfnrml_4',
            'dcfnrml_5',
            'dcffail_1',
            'dcffail_2',
            'dcffail_3',
            'dcffail_4',
            'dcffail_5',
            'hlton_1',
            'hlton_2',
            'hlton_3',
            'hlton_4',
            'hlton_5',
            'hltoff_1',
            'hltoff_2',
            'hltoff_3',
            'hltoff_4',
            'hltoff_5',
            'sf6nrml_1',
            'sf6nrml_2',
            'sf6nrml_3',
            'sf6nrml_4',
            'sf6nrml_5',
            'sf6fail_1',
            'sf6fail_2',
            'sf6fail_3',
            'sf6fail_4',
            'sf6fail_5',
            'firnrml_1',
            'firnrml_2',
            'firnrml_3',
            'firnrml_4',
            'firnrml_5',
            'firfail_1',
            'firfail_2',
            'firfail_3',
            'firfail_4',
            'firfail_5',
            'fisnrml_1',
            'fisnrml_2',
            'fisnrml_3',
            'fisnrml_4',
            'fisnrml_5',
            'fisfail_1',
            'fisfail_2',
            'fisfail_3',
            'fisfail_4',
            'fisfail_5',
            'fitnrml_1',
            'fitnrml_2',
            'fitnrml_3',
            'fitnrml_4',
            'fitnrml_5',
            'fitfail_1',
            'fitfail_2',
            'fitfail_3',
            'fitfail_4',
            'fitfail_5',
            'finnrml_1',
            'finnrml_2',
            'finnrml_3',
            'finnrml_4',
            'finnrml_5',
            'finfail_1',
            'finfail_2',
            'finfail_3',
            'finfail_4',
            'finfail_5',
            'comf_nrml_1',
            'comf_nrml_2',
            'comf_nrml_3',
            'lruf_nrml_1',
            'lruf_nrml_2',
            'lruf_nrml_5',

            // --- Telecontrol (FormTelecontrol) ---
            'cbctrl_op_1',
            'cbctrl_op_2',
            'cbctrl_op_3',
            'cbctrl_op_4',
            'cbctrl_op_5',
            'cbctrl_cl_1',
            'cbctrl_cl_2',
            'cbctrl_cl_3',
            'cbctrl_cl_4',
            'cbctrl_cl_5',
            'cbctrl2_op_1',
            'cbctrl2_op_2',
            'cbctrl2_op_3',
            'cbctrl2_op_4',
            'cbctrl2_op_5',
            'cbctrl2_cl_1',
            'cbctrl2_cl_2',
            'cbctrl2_cl_3',
            'cbctrl2_cl_4',
            'cbctrl2_cl_5',
            'hltctrl_off_1',
            'hltctrl_off_2',
            'hltctrl_off_3',
            'hltctrl_off_4',
            'hltctrl_off_5',
            'hltctrl_on_1',
            'hltctrl_on_2',
            'hltctrl_on_3',
            'hltctrl_on_4',
            'hltctrl_on_5',
            'rrctrl_on_1',
            'rrctrl_on_2',
            'rrctrl_on_3',
            'rrctrl_on_4',
            'rrctrl_on_5',

            // --- System (FormSystem) ---
            'sys_comf1',
            'sys_comf2',
            'sys_comf5',
            'sys_lruf1',
            'sys_lruf2',
            'sys_lruf5',
            'sys_signs1',
            'sys_signs2',
            'sys_signs5',
            'sys_limitswith1',
            'sys_limitswith2',
            'sys_limitswith5',

            // --- Hardware (FormHardware) ---
            'hard_batere1',
            'hard_batere2',
            'hard_batere5',
            'hard_ps2201',
            'hard_ps2202',
            'hard_ps2205',
            'hard_charger1',
            'hard_charger2',
            'hard_charger5',
            'hard_limitswith1',
            'hard_limitswith2',
            'hard_limitswith5',

            // --- Recloser (FormRecloser) ---
            're_ar_on1',
            're_ar_on2',
            're_ar_on5',
            're_ar_off1',
            're_ar_off2',
            're_ar_off5',
            're_ctrl_ar_on1',
            're_ctrl_ar_on2',
            're_ctrl_ar_on5',
            're_ctrl_ar_off1',
            're_ctrl_ar_off2',
            're_ctrl_ar_off5',

            // --- TELEMETERING NEW VALUES (ADDED) ---
            't_ir1',
            't_ir2',
            't_ir5',
            't_is1',
            't_is2',
            't_is5',
            't_it1',
            't_it2',
            't_it5',
            't_in1',
            't_in2',
            't_in5',
            't_vrin1',
            't_vrin2',
            't_vrin5',
            't_vsin1',
            't_vsin2',
            't_vsin5',
            't_vtin1',
            't_vtin2',
            't_vtin5',
            't_vrout1',
            't_vrout2',
            't_vrout5',
            't_vsout1',
            't_vsout2',
            't_vsout5',
            't_vtout1',
            't_vtout2',
            't_vtout5',
            't_vavg1',
            't_vavg2',
            't_vavg5',
            't_hz1',
            't_hz2',
            't_hz5',
            't_iavg1',
            't_iavg2',
            't_iavg5',
            't_pf1',
            't_pf2',
            't_pf5',
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
        ];

        // 3. Define Validation Rules
        $rules = [
            'tgl_komisioning' => 'required|date',
            'nama_lbs' => ['required', 'string', 'max:100', function ($attribute, $value, $fail) use ($request) {
                $modeInput = $request->input('mode_input', 0);

                if ($modeInput == 0 || $modeInput == '0') {
                    $gi = $request->id_gi;
                    $peny = $request->nama_peny;

                    $exists = DB::connection('masterdata')->table('dg_keypoint')
                        ->where('gardu_induk', $gi)
                        ->where('penyulang', $peny)
                        ->whereRaw("CONCAT(type_keypoint, ' ', nama_keypoint) = ?", [$value])
                        ->exists();

                    if (!$exists) {
                        $fail('Nama Keypoint tidak valid.');
                    }
                }
            }],
            'id_merkrtu' => 'required|integer|exists:tb_merklbs,id_merkrtu',
            'id_modem' => 'required|integer|exists:tb_modem,id_modem',
            'rtu_addrs' => 'required|string|max:255',
            'id_medkom' => 'required|integer|exists:tb_medkom,id_medkom',
            'ip_kp' => 'required|string|max:255',
            'id_gi' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                if (!DB::connection('masterdata')->table('dg_keypoint')->where('gardu_induk', $value)->exists()) {
                    $fail('The selected Gardu Induk is invalid.');
                }
            }],
            'nama_peny' => ['required', 'string', 'max:25', function ($attribute, $value, $fail) use ($request) {
                $gi = $request->id_gi;
                if (!DB::connection('masterdata')->table('dg_keypoint')->where('gardu_induk', $gi)->where('penyulang', $value)->exists()) {
                    $fail('Invalid Nama Penyulangan for selected Gardu Induk.');
                }
            }],
            'nama_sec' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) use ($request) {
                $modeInput = $request->input('mode_input', 0);

                if ($modeInput == 0 || $modeInput == '0') {
                    $gi = $request->id_gi;
                    $peny = $request->nama_peny;

                    $exists = DB::connection('masterdata')->table('dg_keypoint')
                        ->where('gardu_induk', $gi)
                        ->where('penyulang', $peny)
                        ->whereRaw("CONCAT(up3, ' ', sektoral) = ?", [$value])
                        ->exists();

                    if (!$exists) {
                        $fail('Sectoral tidak valid.');
                    }
                }
            }],

            // --- TELEMETERING FIELDS ---
            'ir_rtu' => 'required|integer',
            'ir_ms' => 'required|integer',
            'ir_scale' => 'required|string|max:10',
            'is_rtu' => 'required|integer',
            'is_ms' => 'required|integer',
            'is_scale' => 'required|string|max:10',
            'it_rtu' => 'required|integer',
            'it_ms' => 'required|integer',
            'it_scale' => 'required|string|max:10',
            'ir_addrtu' => 'required|integer',
            'ir_addms' => 'required|integer',
            'ir_addobjfrmt' => 'required|string|max:10',
            'is_addrtu' => 'required|integer',
            'is_addms' => 'required|integer',
            'is_addobjfrmt' => 'required|string|max:10',
            'it_addrtu' => 'required|integer',
            'it_addms' => 'required|integer',
            'it_addobjfrmt' => 'required|string|max:10',
            'in_addrtu' => 'nullable|string|max:100',
            'in_addms' => 'nullable|string|max:100',
            'in_addobjfrmt' => 'nullable|string|max:100',
            'vrin_rtu' => 'required|string|max:10',
            'vrin_ms' => 'required|string|max:10',
            'vrin_scale' => 'required|string|max:10',
            'vsin_rtu' => 'required|string|max:10',
            'vsin_ms' => 'required|string|max:10',
            'vsin_scale' => 'required|string|max:10',
            'vtin_rtu' => 'required|string|max:10',
            'vtin_ms' => 'required|string|max:10',
            'vtin_scale' => 'required|string|max:10',
            'vrin_addrtu' => 'required|string|max:10',
            'vrin_addms' => 'required|string|max:10',
            'vrin_addobjfrmt' => 'required|string|max:10',
            'vsin_addrtu' => 'required|string|max:10',
            'vsin_addms' => 'required|string|max:10',
            'vsin_addobjfrmt' => 'required|string|max:10',
            'vtin_addrtu' => 'required|string|max:10',
            'vtin_addms' => 'required|string|max:10',
            'vtin_addobjfrmt' => 'required|string|max:10',
            'vrout_rtu' => 'nullable|string|max:10',
            'vrout_ms' => 'nullable|string|max:10',
            'vrout_scale' => 'nullable|string|max:10',
            'vsout_rtu' => 'nullable|string|max:10',
            'vsout_ms' => 'nullable|string|max:10',
            'vsout_scale' => 'nullable|string|max:10',
            'vtout_rtu' => 'nullable|string|max:10',
            'vtout_ms' => 'nullable|string|max:10',
            'vtout_scale' => 'nullable|string|max:10',
            'vrout_addrtu' => 'nullable|string|max:10',
            'vrout_addms' => 'nullable|string|max:10',
            'vrout_addobjfrmt' => 'nullable|string|max:10',
            'vsout_addrtu' => 'nullable|string|max:10',
            'vsout_addms' => 'nullable|string|max:10',
            'vsout_addobjfrmt' => 'nullable|string|max:10',
            'vtout_addrtu' => 'nullable|string|max:10',
            'vtout_addms' => 'nullable|string|max:10',
            'vtout_addobjfrmt' => 'nullable|string|max:10',
            'vavg_addrtu' => 'nullable|string|max:100',
            'vavg_addms' => 'nullable|string|max:100',
            'vavg_addobjfrmt' => 'nullable|string|max:100',
            'hz_rtu' => 'nullable|string|max:10',
            'hz_ms' => 'nullable|string|max:10',
            'hz_scale' => 'nullable|string|max:10',
            'iavg_rtu' => 'nullable|string|max:10',
            'iavg_ms' => 'nullable|string|max:10',
            'iavg_scale' => 'nullable|string|max:10',
            'pf_rtu' => 'nullable|string|max:10',
            'pf_ms' => 'nullable|string|max:10',
            'pf_scale' => 'nullable|string|max:10',
            'hz_addrtu' => 'nullable|string|max:10',
            'hz_addms' => 'nullable|string|max:10',
            'hz_addobjfrmt' => 'nullable|string|max:10',
            'iavg_addrtu' => 'nullable|string|max:100',
            'iavg_addms' => 'nullable|string|max:100',
            'iavg_addobjfrmt' => 'nullable|string|max:100',
            'pf_addrtu' => 'nullable|string|max:10',
            'pf_addms' => 'nullable|string|max:10',
            'pf_addobjfrmt' => 'nullable|string|max:10',
            'ifr_rtu' => 'nullable|string|max:10',
            'ifr_ms' => 'nullable|string|max:10',
            'ifr_scale' => 'nullable|string|max:10',
            'ifs_rtu' => 'nullable|string|max:10',
            'ifs_ms' => 'nullable|string|max:10',
            'ifs_scale' => 'nullable|string|max:10',
            'ift_rtu' => 'nullable|string|max:10',
            'ift_ms' => 'nullable|string|max:10',
            'ift_scale' => 'nullable|string|max:10',
            'ifn_rtu' => 'nullable|string|max:10',
            'ifn_ms' => 'nullable|string|max:10',
            'ifn_scale' => 'nullable|string|max:10',
            'ifr_addrtu' => 'nullable|string|max:10',
            'ifr_addms' => 'nullable|string|max:10',
            'ifr_addobjfrmt' => 'nullable|string|max:10',
            'ifs_addrtu' => 'nullable|string|max:10',
            'ifs_addms' => 'nullable|string|max:10',
            'ifs_addobjfrmt' => 'nullable|string|max:10',
            'ift_addrtu' => 'nullable|string|max:10',
            'ift_addms' => 'nullable|string|max:10',
            'ift_addobjfrmt' => 'nullable|string|max:10',
            'ifn_addrtu' => 'nullable|string|max:10',
            'ifn_addms' => 'nullable|string|max:10',
            'ifn_addobjfrmt' => 'nullable|string|max:10',
            'ifr_psuedo_rtu' => 'nullable|string|max:10',
            'ifr_psuedo_ms' => 'nullable|string|max:10',
            'ifr_psuedo_scale' => 'nullable|string|max:10',
            'ifs_psuedo_rtu' => 'nullable|string|max:10',
            'ifs_psuedo_ms' => 'nullable|string|max:10',
            'ifs_psuedo_scale' => 'nullable|string|max:10',
            'ift_psuedo_rtu' => 'nullable|string|max:10',
            'ift_psuedo_ms' => 'nullable|string|max:10',
            'ift_psuedo_scale' => 'nullable|string|max:10',
            'ifn_psuedo_rtu' => 'nullable|string|max:10',
            'ifn_psuedo_ms' => 'nullable|string|max:10',
            'ifn_psuedo_scale' => 'nullable|string|max:10',
            'ifr_psuedo_addrtu' => 'nullable|string|max:10',
            'ifr_psuedo_addms' => 'nullable|string|max:10',
            'ifr_psuedo_addobjfrmt' => 'nullable|string|max:10',
            'ifs_psuedo_addrtu' => 'nullable|string|max:10',
            'ifs_psuedo_addms' => 'nullable|string|max:10',
            'ifs_psuedo_addobjfrmt' => 'nullable|string|max:10',
            'ift_psuedo_addrtu' => 'nullable|string|max:10',
            'ift_psuedo_addms' => 'nullable|string|max:10',
            'ift_psuedo_addobjfrmt' => 'nullable|string|max:10',
            'ifn_psuedo_addrtu' => 'nullable|string|max:10',
            'ifn_psuedo_addms' => 'nullable|string|max:10',
            'ifn_psuedo_addobjfrmt' => 'nullable|string|max:10',
            'iavg_rtu' => 'nullable|string|max:100',
            'iavg_ms' => 'nullable|string|max:100',
            'iavg_scale' => 'nullable|string|max:100',
            'in_rtu' => 'nullable|string|max:100',
            'in_ms' => 'nullable|string|max:100',
            'in_scale' => 'nullable|string|max:100',
            'vavg_rtu' => 'nullable|string|max:100',
            'vavg_ms' => 'nullable|string|max:100',
            'vavg_scale' => 'nullable|string|max:100',

            // Notes and Text inputs
            'ketsys' => 'nullable|string|max:500',
            'kethard' => 'nullable|string|max:500',
            'ketre' => 'nullable|string|max:500',
            'catatankp' => 'required|string|max:500',
            'ketfd' => 'nullable|string|max:500',
            'ketfts' => 'nullable|string|max:500',
            'ketftc' => 'nullable|string|max:500',
            'ketftm' => 'nullable|string|max:500',
            'ketpk' => 'nullable|string|max:500',
            'sys_comf_input' => 'nullable|string|max:100',
            'sys_lruf_input' => 'nullable|string|max:100',
            'sys_signs_input' => 'nullable|string|max:100',
            'sys_limitswith_input' => 'nullable|string|max:100',
            'hard_batere_input' => 'nullable|string|max:100',
            'hard_ps220_input' => 'nullable|string|max:100',
            'hard_charger_input' => 'nullable|string|max:100',
            'hard_limitswith_input' => 'nullable|string|max:100',
            'nama_user' => 'required|string|max:50',
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',

            'sacf_fail_addms' => 'nullable|string|max:100',
            'sacf_fail_addrtu' => 'nullable|string|max:100',
            'sacf_fail_objfrmt' => 'nullable|string|max:100',
            'sacf_normal_addms' => 'nullable|string|max:100',
            'sacf_normal_addrtu' => 'nullable|string|max:100',
            'sacf_normal_objfrmt' => 'nullable|string|max:100',
            'scb2_close_addms' => 'nullable|string|max:100',
            'scb2_close_addrtu' => 'nullable|string|max:100',
            'scb2_close_objfrmt' => 'nullable|string|max:100',
            'scb2_open_addms' => 'nullable|string|max:100',
            'scb2_open_addrtu' => 'nullable|string|max:100',
            'scb2_open_objfrmt' => 'nullable|string|max:100',
            'scb_close_addms' => 'nullable|string|max:100',
            'scb_close_addrtu' => 'nullable|string|max:100',
            'scb_close_objfrmt' => 'nullable|string|max:100',
            'scb_open_addms' => 'nullable|string|max:100',
            'scb_open_addrtu' => 'nullable|string|max:100',
            'scb_open_objfrmt' => 'nullable|string|max:100',
            'sdcd_fail_addms' => 'nullable|string|max:100',
            'sdcd_fail_addrtu' => 'nullable|string|max:100',
            'sdcd_fail_objfrmt' => 'nullable|string|max:100',
            'sdcd_normal_addms' => 'nullable|string|max:100',
            'sdcd_normal_addrtu' => 'nullable|string|max:100',
            'sdcd_normal_objfrmt' => 'nullable|string|max:100',
            'sdcf_fail_addms' => 'nullable|string|max:100',
            'sdcf_fail_addrtu' => 'nullable|string|max:100',
            'sdcf_fail_objfrmt' => 'nullable|string|max:100',
            'sdcf_normal_addms' => 'nullable|string|max:100',
            'sdcf_normal_addrtu' => 'nullable|string|max:100',
            'sdcf_normal_objfrmt' => 'nullable|string|max:100',
            'sdoor_close_addms' => 'nullable|string|max:100',
            'sdoor_close_addrtu' => 'nullable|string|max:100',
            'sdoor_close_objfrmt' => 'nullable|string|max:100',
            'sdoor_open_addms' => 'nullable|string|max:100',
            'sdoor_open_addrtu' => 'nullable|string|max:100',
            'sdoor_open_objfrmt' => 'nullable|string|max:100',
            'sfin_fail_addms' => 'nullable|string|max:100',
            'sfin_fail_addrtu' => 'nullable|string|max:100',
            'sfin_fail_objfrmt' => 'nullable|string|max:100',
            'sfin_normal_addms' => 'nullable|string|max:100',
            'sfin_normal_addrtu' => 'nullable|string|max:100',
            'sfin_normal_objfrmt' => 'nullable|string|max:100',
            'sfir_fail_addms' => 'nullable|string|max:100',
            'sfir_fail_addrtu' => 'nullable|string|max:100',
            'sfir_fail_objfrmt' => 'nullable|string|max:100',
            'sfir_normal_addms' => 'nullable|string|max:100',
            'sfir_normal_addrtu' => 'nullable|string|max:100',
            'sfir_normal_objfrmt' => 'nullable|string|max:100',
            'sfis_fail_addms' => 'nullable|string|max:100',
            'sfis_fail_addrtu' => 'nullable|string|max:100',
            'sfis_fail_objfrmt' => 'nullable|string|max:100',
            'sfis_normal_addms' => 'nullable|string|max:100',
            'sfis_normal_addrtu' => 'nullable|string|max:100',
            'sfis_normal_objfrmt' => 'nullable|string|max:100',
            'sfit_fail_addms' => 'nullable|string|max:100',
            'sfit_fail_addrtu' => 'nullable|string|max:100',
            'sfit_fail_objfrmt' => 'nullable|string|max:100',
            'sfit_normal_addms' => 'nullable|string|max:100',
            'sfit_normal_addrtu' => 'nullable|string|max:100',
            'sfit_normal_objfrmt' => 'nullable|string|max:100',
            'shlt_off_addms' => 'nullable|string|max:100',
            'shlt_off_addrtu' => 'nullable|string|max:100',
            'shlt_off_objfrmt' => 'nullable|string|max:100',
            'shlt_on_addms' => 'nullable|string|max:100',
            'shlt_on_addrtu' => 'nullable|string|max:100',
            'shlt_on_objfrmt' => 'nullable|string|max:100',
            'slr_local_addms' => 'nullable|string|max:100',
            'slr_local_addrtu' => 'nullable|string|max:100',
            'slr_local_objfrmt' => 'nullable|string|max:100',
            'slr_remote_addms' => 'nullable|string|max:100',
            'slr_remote_addrtu' => 'nullable|string|max:100',
            'slr_remote_objfrmt' => 'nullable|string|max:100',
            'ssf6_fail_addms' => 'nullable|string|max:100',
            'ssf6_fail_addrtu' => 'nullable|string|max:100',
            'ssf6_fail_objfrmt' => 'nullable|string|max:100',
            'ssf6_normal_addms' => 'nullable|string|max:100',
            'ssf6_normal_addrtu' => 'nullable|string|max:100',
            'ssf6_normal_objfrmt' => 'nullable|string|max:100',
            'ccb_open_addms' => 'nullable|string|max:100',
            'ccb_open_addrtu' => 'nullable|string|max:100',
            'ccb_open_objfrmt' => 'nullable|string|max:100',
            'ccb_close_addms' => 'nullable|string|max:100',
            'ccb_close_addrtu' => 'nullable|string|max:100',
            'ccb_close_objfrmt' => 'nullable|string|max:100',
            'ccb2_open_addms' => 'nullable|string|max:100',
            'ccb2_open_addrtu' => 'nullable|string|max:100',
            'ccb2_open_objfrmt' => 'nullable|string|max:100',
            'ccb2_close_addms' => 'nullable|string|max:100',
            'ccb2_close_addrtu' => 'nullable|string|max:100',
            'ccb2_close_objfrmt' => 'nullable|string|max:100',
            'chlt_on_addms' => 'nullable|string|max:100',
            'chlt_on_addrtu' => 'nullable|string|max:100',
            'chlt_on_objfrmt' => 'nullable|string|max:100',
            'chlt_off_addms' => 'nullable|string|max:100',
            'chlt_off_addrtu' => 'nullable|string|max:100',
            'chlt_off_objfrmt' => 'nullable|string|max:100',
            'crst_addms' => 'nullable|string|max:100',
            'crst_addrtu' => 'nullable|string|max:100',
            'crst_objfrmt' => 'nullable|string|max:100',

            // Custom Validation for Array IDs
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
        ];

        // 4. Add Checkbox Array Validations Dynamically
        $checkboxFields = [
            's_cb',
            's_cb2',
            's_lr',
            's_door',
            's_acf',
            's_dcf',
            's_dcd',
            's_hlt',
            's_sf6',
            's_fir',
            's_fis',
            's_fit',
            's_fin',
            'sys_comf',
            'sys_lruf',
            'sys_signs',
            'sys_limitswith',
            'hard_batere',
            'hard_ps220',
            'hard_charger',
            'hard_limitswith',
            're_ar_on',
            're_ar_off',
            're_ctrl_ar_on',
            're_ctrl_ar_off',
            'c_cb',
            'c_cb2',
            'c_hlt',
            'c_rst',
            't_ir',
            't_is',
            't_it',
            't_in',
            't_vrin',
            't_vsin',
            't_vtin',
            't_vrout',
            't_vsout',
            't_vtout',
            't_vavg',
            't_ifr',
            't_ifs',
            't_ift',
            't_ifn',
            't_ifr_psuedo',
            't_ifs_psuedo',
            't_ift_psuedo',
            't_ifn_psuedo',
            't_hz',
            't_iavg',
            't_pf',
        ];

        foreach ($checkboxFields as $field) {
            $rules[$field] = 'nullable|array';
            $rules[$field . '.*'] = 'string|in:' . implode(',', $validCheckboxValues);
        }

        // 5. Run Validation
        $validated = $request->validate($rules);

        // 6. Post-Processing: Convert Arrays to Comma-Separated Strings for Database
        foreach ($checkboxFields as $field) {
            // If the field exists in request and is an array, implode it. Otherwise, empty string.
            $validated[$field] = ($request->has($field) && is_array($request->input($field)))
                ? implode(',', array_filter($request->input($field)))
                : '';
        }

        // 7. Handle Sectoral Logic
        if (!empty($validated['nama_sec'])) {
            $namaSec = $validated['nama_sec']; // Ini sudah berisi "up3 sektoral"
            $existingSec = DB::table('tb_sectoral')->where('nama_sec', $namaSec)->first();

            if ($existingSec) {
                $validated['id_sec'] = $existingSec->id_sec;
            } else {
                // Option A: Still use nama_sec as id_sec
                $validated['id_sec'] = $namaSec;
            }
        }
        unset($validated['nama_sec']); // Hapus nama_sec, hanya simpan id_sec

        // 8. Handle JSON encoded IDs
        $validated['id_pelms'] = json_encode($idPelmsArray);
        $validated['id_pelrtu'] = json_encode($idPelrtuArray);

        // 9. Update Database
        $keypoint->update($validated);

        return redirect()->route('keypoint.index')->with('success', 'Keypoint updated successfully!');
    }


    /**
     * Show the form for cloning a resource.
     * (Same as edit, but for creating a new record)
     */
    public function clone($id)
    {
        $keypoint = Keypoint::findOrFail($id);
        $merklbs = DB::table('tb_merklbs')->get();
        $modems = DB::table('tb_modem')->get();
        $medkom = DB::table('tb_medkom')->get();
        $garduinduk = DB::connection('masterdata')->table('dg_keypoint')->select('gardu_induk')->distinct()->get();

        $komkp = DB::table('tb_komkp')->get();
        $pelms = DB::table('tb_picmaster')->get();
        $pelrtus = DB::table('tb_pelaksana_rtu')->get();

        $decoded = json_decode($keypoint->id_pelms, true);
        $selectedPelms = is_array($decoded) ? $decoded : ($decoded ? [$decoded] : []);
        $decodedRtu = json_decode($keypoint->id_pelrtu, true);
        $selectedPelrtus = is_array($decodedRtu) ? $decodedRtu : ($decodedRtu ? [$decodedRtu] : []);

        // ✅ SIMPLE: id_sec sudah menyimpan nama sektoral langsung
        $keypoint->nama_sec = $keypoint->id_sec;

        return view('pages.keypoint.clone', compact('keypoint', 'merklbs', 'modems', 'medkom', 'garduinduk', 'komkp', 'pelms', 'selectedPelms', 'pelrtus', 'selectedPelrtus'));
    }

    public function storeClone(Request $request)
    {
        // 1. Prepare Arrays for ID fields (Personnel)
        $idPelmsInput = $request->input('id_pelms', '');
        $idPelmsArray = !empty($idPelmsInput) ? array_filter(array_map('trim', explode(',', $idPelmsInput))) : [];

        $idPelrtuInput = $request->input('id_pelrtu', '');
        $idPelrtuArray = !empty($idPelrtuInput) ? array_filter(array_map('trim', explode(',', $idPelrtuInput))) : [];

        // 2. Define ALL valid checkbox values
        $validCheckboxValues = [
            // --- Common Values ---
            'normal',
            'ok',
            'nok',
            'log',
            'sld',
            'tidak_uji',
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
            'dropen_1',
            'dropen_2',
            'dropen_3',
            'dropen_4',
            'dropen_5',
            'drclose_1',
            'drclose_2',
            'drclose_3',
            'drclose_4',
            'drclose_5',
            'acnrml_1',
            'acnrml_2',
            'acnrml_3',
            'acnrml_4',
            'acnrml_5',
            'acfail_1',
            'acfail_2',
            'acfail_3',
            'acfail_4',
            'acfail_5',
            'dcnrml_1',
            'dcnrml_2',
            'dcnrml_3',
            'dcnrml_4',
            'dcnrml_5',
            'dcfail_1',
            'dcfail_2',
            'dcfail_3',
            'dcfail_4',
            'dcfail_5',
            'dcfnrml_1',
            'dcfnrml_2',
            'dcfnrml_3',
            'dcfnrml_4',
            'dcfnrml_5',
            'dcffail_1',
            'dcffail_2',
            'dcffail_3',
            'dcffail_4',
            'dcffail_5',
            'hlton_1',
            'hlton_2',
            'hlton_3',
            'hlton_4',
            'hlton_5',
            'hltoff_1',
            'hltoff_2',
            'hltoff_3',
            'hltoff_4',
            'hltoff_5',
            'sf6nrml_1',
            'sf6nrml_2',
            'sf6nrml_3',
            'sf6nrml_4',
            'sf6nrml_5',
            'sf6fail_1',
            'sf6fail_2',
            'sf6fail_3',
            'sf6fail_4',
            'sf6fail_5',
            'firnrml_1',
            'firnrml_2',
            'firnrml_3',
            'firnrml_4',
            'firnrml_5',
            'firfail_1',
            'firfail_2',
            'firfail_3',
            'firfail_4',
            'firfail_5',
            'fisnrml_1',
            'fisnrml_2',
            'fisnrml_3',
            'fisnrml_4',
            'fisnrml_5',
            'fisfail_1',
            'fisfail_2',
            'fisfail_3',
            'fisfail_4',
            'fisfail_5',
            'fitnrml_1',
            'fitnrml_2',
            'fitnrml_3',
            'fitnrml_4',
            'fitnrml_5',
            'fitfail_1',
            'fitfail_2',
            'fitfail_3',
            'fitfail_4',
            'fitfail_5',
            'finnrml_1',
            'finnrml_2',
            'finnrml_3',
            'finnrml_4',
            'finnrml_5',
            'finfail_1',
            'finfail_2',
            'finfail_3',
            'finfail_4',
            'finfail_5',
            'comf_nrml_1',
            'comf_nrml_2',
            'comf_nrml_3',
            'lruf_nrml_1',
            'lruf_nrml_2',
            'lruf_nrml_5',

            // --- Telecontrol ---
            'cbctrl_op_1',
            'cbctrl_op_2',
            'cbctrl_op_3',
            'cbctrl_op_4',
            'cbctrl_op_5',
            'cbctrl_cl_1',
            'cbctrl_cl_2',
            'cbctrl_cl_3',
            'cbctrl_cl_4',
            'cbctrl_cl_5',
            'cbctrl2_op_1',
            'cbctrl2_op_2',
            'cbctrl2_op_3',
            'cbctrl2_op_4',
            'cbctrl2_op_5',
            'cbctrl2_cl_1',
            'cbctrl2_cl_2',
            'cbctrl2_cl_3',
            'cbctrl2_cl_4',
            'cbctrl2_cl_5',
            'hltctrl_off_1',
            'hltctrl_off_2',
            'hltctrl_off_3',
            'hltctrl_off_4',
            'hltctrl_off_5',
            'hltctrl_on_1',
            'hltctrl_on_2',
            'hltctrl_on_3',
            'hltctrl_on_4',
            'hltctrl_on_5',
            'rrctrl_on_1',
            'rrctrl_on_2',
            'rrctrl_on_3',
            'rrctrl_on_4',
            'rrctrl_on_5',

            // --- System & Hardware ---
            'sys_comf1',
            'sys_comf2',
            'sys_comf5',
            'sys_lruf1',
            'sys_lruf2',
            'sys_lruf5',
            'sys_signs1',
            'sys_signs2',
            'sys_signs5',
            'sys_limitswith1',
            'sys_limitswith2',
            'sys_limitswith5',
            'hard_batere1',
            'hard_batere2',
            'hard_batere5',
            'hard_ps2201',
            'hard_ps2202',
            'hard_ps2205',
            'hard_charger1',
            'hard_charger2',
            'hard_charger5',
            'hard_limitswith1',
            'hard_limitswith2',
            'hard_limitswith5',

            // --- Recloser ---
            're_ar_on1',
            're_ar_on2',
            're_ar_on5',
            're_ar_off1',
            're_ar_off2',
            're_ar_off5',
            're_ctrl_ar_on1',
            're_ctrl_ar_on2',
            're_ctrl_ar_on5',
            're_ctrl_ar_off1',
            're_ctrl_ar_off2',
            're_ctrl_ar_off5',

            // --- TELEMETERING NEW VALUES ---
            't_ir1',
            't_ir2',
            't_ir5',
            't_is1',
            't_is2',
            't_is5',
            't_it1',
            't_it2',
            't_it5',
            't_in1',
            't_in2',
            't_in5',
            't_vrin1',
            't_vrin2',
            't_vrin5',
            't_vsin1',
            't_vsin2',
            't_vsin5',
            't_vtin1',
            't_vtin2',
            't_vtin5',
            't_vrout1',
            't_vrout2',
            't_vrout5',
            't_vsout1',
            't_vsout2',
            't_vsout5',
            't_vtout1',
            't_vtout2',
            't_vtout5',
            't_vavg1',
            't_vavg2',
            't_vavg5',
            't_hz1',
            't_hz2',
            't_hz5',
            't_iavg1',
            't_iavg2',
            't_iavg5',
            't_pf1',
            't_pf2',
            't_pf5',
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
            // Pseudo
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
        ];

        // 3. Define Validation Rules
        $rules = [
            'tgl_komisioning' => 'required|date',
            'nama_lbs' => ['required', 'string', 'max:100', function ($attribute, $value, $fail) use ($request) {
                $modeInput = $request->input('mode_input', 0);
                if ($modeInput == 0 || $modeInput == '0') {
                    $gi = $request->id_gi;
                    $peny = $request->nama_peny;
                    $exists = DB::connection('masterdata')->table('dg_keypoint')
                        ->where('gardu_induk', $gi)
                        ->where('penyulang', $peny)
                        ->whereRaw("CONCAT(type_keypoint, ' ', nama_keypoint) = ?", [$value])
                        ->exists();
                    if (!$exists) {
                        $fail('Nama Keypoint tidak valid.');
                    }
                }
            }],
            'id_merkrtu' => 'required|integer|exists:tb_merklbs,id_merkrtu',
            'id_modem' => 'required|integer|exists:tb_modem,id_modem',
            'rtu_addrs' => 'required|string|max:255',
            'id_medkom' => 'required|integer|exists:tb_medkom,id_medkom',
            'ip_kp' => 'required|string|max:255',
            'id_gi' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                if (!DB::connection('masterdata')->table('dg_keypoint')->where('gardu_induk', $value)->exists()) {
                    $fail('The selected Gardu Induk is invalid.');
                }
            }],
            'nama_peny' => ['required', 'string', 'max:25', function ($attribute, $value, $fail) use ($request) {
                $gi = $request->id_gi;
                if (!DB::connection('masterdata')->table('dg_keypoint')->where('gardu_induk', $gi)->where('penyulang', $value)->exists()) {
                    $fail('Invalid Nama Penyulangan for selected Gardu Induk.');
                }
            }],
            'nama_sec' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) use ($request) {
                $modeInput = $request->input('mode_input', 0);
                if ($modeInput == 0 || $modeInput == '0') {
                    $gi = $request->id_gi;
                    $peny = $request->nama_peny;
                    $exists = DB::connection('masterdata')->table('dg_keypoint')
                        ->where('gardu_induk', $gi)
                        ->where('penyulang', $peny)
                        ->whereRaw("CONCAT(up3, ' ', sektoral) = ?", [$value])
                        ->exists();
                    if (!$exists) {
                        $fail('Sectoral tidak valid.');
                    }
                }
            }],

            // --- TELEMETERING FIELDS ---
            'ir_rtu' => 'required|integer',
            'ir_ms' => 'required|integer',
            'ir_scale' => 'required|string|max:10',
            'is_rtu' => 'required|integer',
            'is_ms' => 'required|integer',
            'is_scale' => 'required|string|max:10',
            'it_rtu' => 'required|integer',
            'it_ms' => 'required|integer',
            'it_scale' => 'required|string|max:10',

            // ADD Fields (Existing & New)
            'ir_addrtu' => 'required|integer',
            'ir_addms' => 'required|integer',
            'ir_addobjfrmt' => 'required|string|max:10',
            'is_addrtu' => 'required|integer',
            'is_addms' => 'required|integer',
            'is_addobjfrmt' => 'required|string|max:10',
            'it_addrtu' => 'required|integer',
            'it_addms' => 'required|integer',
            'it_addobjfrmt' => 'required|string|max:10',
            'in_addrtu' => 'nullable|string|max:100',
            'in_addms' => 'nullable|string|max:100',
            'in_addobjfrmt' => 'nullable|string|max:100',

            'vrin_rtu' => 'required|string|max:10',
            'vrin_ms' => 'required|string|max:10',
            'vrin_scale' => 'required|string|max:10',
            'vsin_rtu' => 'required|string|max:10',
            'vsin_ms' => 'required|string|max:10',
            'vsin_scale' => 'required|string|max:10',
            'vtin_rtu' => 'required|string|max:10',
            'vtin_ms' => 'required|string|max:10',
            'vtin_scale' => 'required|string|max:10',

            'vrin_addrtu' => 'required|string|max:10',
            'vrin_addms' => 'required|string|max:10',
            'vrin_addobjfrmt' => 'required|string|max:10',
            'vsin_addrtu' => 'required|string|max:10',
            'vsin_addms' => 'required|string|max:10',
            'vsin_addobjfrmt' => 'required|string|max:10',
            'vtin_addrtu' => 'required|string|max:10',
            'vtin_addms' => 'required|string|max:10',
            'vtin_addobjfrmt' => 'required|string|max:10',

            'vrout_rtu' => 'nullable|string|max:10',
            'vrout_ms' => 'nullable|string|max:10',
            'vrout_scale' => 'nullable|string|max:10',
            'vsout_rtu' => 'nullable|string|max:10',
            'vsout_ms' => 'nullable|string|max:10',
            'vsout_scale' => 'nullable|string|max:10',
            'vtout_rtu' => 'nullable|string|max:10',
            'vtout_ms' => 'nullable|string|max:10',
            'vtout_scale' => 'nullable|string|max:10',

            'vrout_addrtu' => 'nullable|string|max:10',
            'vrout_addms' => 'nullable|string|max:10',
            'vrout_addobjfrmt' => 'nullable|string|max:10',
            'vsout_addrtu' => 'nullable|string|max:10',
            'vsout_addms' => 'nullable|string|max:10',
            'vsout_addobjfrmt' => 'nullable|string|max:10',
            'vtout_addrtu' => 'nullable|string|max:10',
            'vtout_addms' => 'nullable|string|max:10',
            'vtout_addobjfrmt' => 'nullable|string|max:10',

            'vavg_addrtu' => 'nullable|string|max:100',
            'vavg_addms' => 'nullable|string|max:100',
            'vavg_addobjfrmt' => 'nullable|string|max:100',

            'hz_rtu' => 'nullable|string|max:10',
            'hz_ms' => 'nullable|string|max:10',
            'hz_scale' => 'nullable|string|max:10',
            'iavg_rtu' => 'nullable|string|max:10',
            'iavg_ms' => 'nullable|string|max:10',
            'iavg_scale' => 'nullable|string|max:10',
            'pf_rtu' => 'nullable|string|max:10',
            'pf_ms' => 'nullable|string|max:10',
            'pf_scale' => 'nullable|string|max:10',

            'hz_addrtu' => 'nullable|string|max:10',
            'hz_addms' => 'nullable|string|max:10',
            'hz_addobjfrmt' => 'nullable|string|max:10',
            'iavg_addrtu' => 'nullable|string|max:100',
            'iavg_addms' => 'nullable|string|max:100',
            'iavg_addobjfrmt' => 'nullable|string|max:100',
            'pf_addrtu' => 'nullable|string|max:10',
            'pf_addms' => 'nullable|string|max:10',
            'pf_addobjfrmt' => 'nullable|string|max:10',

            'ifr_rtu' => 'nullable|string|max:10',
            'ifr_ms' => 'nullable|string|max:10',
            'ifr_scale' => 'nullable|string|max:10',
            'ifs_rtu' => 'nullable|string|max:10',
            'ifs_ms' => 'nullable|string|max:10',
            'ifs_scale' => 'nullable|string|max:10',
            'ift_rtu' => 'nullable|string|max:10',
            'ift_ms' => 'nullable|string|max:10',
            'ift_scale' => 'nullable|string|max:10',
            'ifn_rtu' => 'nullable|string|max:10',
            'ifn_ms' => 'nullable|string|max:10',
            'ifn_scale' => 'nullable|string|max:10',

            'ifr_addrtu' => 'nullable|string|max:10',
            'ifr_addms' => 'nullable|string|max:10',
            'ifr_addobjfrmt' => 'nullable|string|max:10',
            'ifs_addrtu' => 'nullable|string|max:10',
            'ifs_addms' => 'nullable|string|max:10',
            'ifs_addobjfrmt' => 'nullable|string|max:10',
            'ift_addrtu' => 'nullable|string|max:10',
            'ift_addms' => 'nullable|string|max:10',
            'ift_addobjfrmt' => 'nullable|string|max:10',
            'ifn_addrtu' => 'nullable|string|max:10',
            'ifn_addms' => 'nullable|string|max:10',
            'ifn_addobjfrmt' => 'nullable|string|max:10',

            // Psuedo fields
            'ifr_psuedo_rtu' => 'nullable|string|max:10',
            'ifr_psuedo_ms' => 'nullable|string|max:10',
            'ifr_psuedo_scale' => 'nullable|string|max:10',
            'ifs_psuedo_rtu' => 'nullable|string|max:10',
            'ifs_psuedo_ms' => 'nullable|string|max:10',
            'ifs_psuedo_scale' => 'nullable|string|max:10',
            'ift_psuedo_rtu' => 'nullable|string|max:10',
            'ift_psuedo_ms' => 'nullable|string|max:10',
            'ift_psuedo_scale' => 'nullable|string|max:10',
            'ifn_psuedo_rtu' => 'nullable|string|max:10',
            'ifn_psuedo_ms' => 'nullable|string|max:10',
            'ifn_psuedo_scale' => 'nullable|string|max:10',

            'ifr_psuedo_addrtu' => 'nullable|string|max:10',
            'ifr_psuedo_addms' => 'nullable|string|max:10',
            'ifr_psuedo_addobjfrmt' => 'nullable|string|max:10',
            'ifs_psuedo_addrtu' => 'nullable|string|max:10',
            'ifs_psuedo_addms' => 'nullable|string|max:10',
            'ifs_psuedo_addobjfrmt' => 'nullable|string|max:10',
            'ift_psuedo_addrtu' => 'nullable|string|max:10',
            'ift_psuedo_addms' => 'nullable|string|max:10',
            'ift_psuedo_addobjfrmt' => 'nullable|string|max:10',
            'ifn_psuedo_addrtu' => 'nullable|string|max:10',
            'ifn_psuedo_addms' => 'nullable|string|max:10',
            'ifn_psuedo_addobjfrmt' => 'nullable|string|max:10',

            'iavg_rtu' => 'nullable|string|max:100',
            'iavg_ms' => 'nullable|string|max:100',
            'iavg_scale' => 'nullable|string|max:100',
            'in_rtu' => 'nullable|string|max:100',
            'in_ms' => 'nullable|string|max:100',
            'in_scale' => 'nullable|string|max:100',
            'vavg_rtu' => 'nullable|string|max:100',
            'vavg_ms' => 'nullable|string|max:100',
            'vavg_scale' => 'nullable|string|max:100',

            'ketsys' => 'nullable|string|max:500',
            'kethard' => 'nullable|string|max:500',
            'ketre' => 'nullable|string|max:500',
            'catatankp' => 'required|string|max:500',
            'ketfd' => 'nullable|string|max:500',
            'ketfts' => 'nullable|string|max:500',
            'ketftc' => 'nullable|string|max:500',
            'ketftm' => 'nullable|string|max:500',
            'ketpk' => 'nullable|string|max:500',
            'sys_comf_input' => 'nullable|string|max:100',
            'sys_lruf_input' => 'nullable|string|max:100',
            'sys_signs_input' => 'nullable|string|max:100',
            'sys_limitswith_input' => 'nullable|string|max:100',
            'hard_batere_input' => 'nullable|string|max:100',
            'hard_ps220_input' => 'nullable|string|max:100',
            'hard_charger_input' => 'nullable|string|max:100',
            'hard_limitswith_input' => 'nullable|string|max:100',
            'nama_user' => 'required|string|max:50',
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',

            // Telestatus AddMS fields
            'sacf_fail_addms' => 'nullable|string|max:100',
            'sacf_fail_addrtu' => 'nullable|string|max:100',
            'sacf_fail_objfrmt' => 'nullable|string|max:100',
            'sacf_normal_addms' => 'nullable|string|max:100',
            'sacf_normal_addrtu' => 'nullable|string|max:100',
            'sacf_normal_objfrmt' => 'nullable|string|max:100',
            'scb2_close_addms' => 'nullable|string|max:100',
            'scb2_close_addrtu' => 'nullable|string|max:100',
            'scb2_close_objfrmt' => 'nullable|string|max:100',
            'scb2_open_addms' => 'nullable|string|max:100',
            'scb2_open_addrtu' => 'nullable|string|max:100',
            'scb2_open_objfrmt' => 'nullable|string|max:100',
            'scb_close_addms' => 'nullable|string|max:100',
            'scb_close_addrtu' => 'nullable|string|max:100',
            'scb_close_objfrmt' => 'nullable|string|max:100',
            'scb_open_addms' => 'nullable|string|max:100',
            'scb_open_addrtu' => 'nullable|string|max:100',
            'scb_open_objfrmt' => 'nullable|string|max:100',
            'sdcd_fail_addms' => 'nullable|string|max:100',
            'sdcd_fail_addrtu' => 'nullable|string|max:100',
            'sdcd_fail_objfrmt' => 'nullable|string|max:100',
            'sdcd_normal_addms' => 'nullable|string|max:100',
            'sdcd_normal_addrtu' => 'nullable|string|max:100',
            'sdcd_normal_objfrmt' => 'nullable|string|max:100',
            'sdcf_fail_addms' => 'nullable|string|max:100',
            'sdcf_fail_addrtu' => 'nullable|string|max:100',
            'sdcf_fail_objfrmt' => 'nullable|string|max:100',
            'sdcf_normal_addms' => 'nullable|string|max:100',
            'sdcf_normal_addrtu' => 'nullable|string|max:100',
            'sdcf_normal_objfrmt' => 'nullable|string|max:100',
            'sdoor_close_addms' => 'nullable|string|max:100',
            'sdoor_close_addrtu' => 'nullable|string|max:100',
            'sdoor_close_objfrmt' => 'nullable|string|max:100',
            'sdoor_open_addms' => 'nullable|string|max:100',
            'sdoor_open_addrtu' => 'nullable|string|max:100',
            'sdoor_open_objfrmt' => 'nullable|string|max:100',
            'sfin_fail_addms' => 'nullable|string|max:100',
            'sfin_fail_addrtu' => 'nullable|string|max:100',
            'sfin_fail_objfrmt' => 'nullable|string|max:100',
            'sfin_normal_addms' => 'nullable|string|max:100',
            'sfin_normal_addrtu' => 'nullable|string|max:100',
            'sfin_normal_objfrmt' => 'nullable|string|max:100',
            'sfir_fail_addms' => 'nullable|string|max:100',
            'sfir_fail_addrtu' => 'nullable|string|max:100',
            'sfir_fail_objfrmt' => 'nullable|string|max:100',
            'sfir_normal_addms' => 'nullable|string|max:100',
            'sfir_normal_addrtu' => 'nullable|string|max:100',
            'sfir_normal_objfrmt' => 'nullable|string|max:100',
            'sfis_fail_addms' => 'nullable|string|max:100',
            'sfis_fail_addrtu' => 'nullable|string|max:100',
            'sfis_fail_objfrmt' => 'nullable|string|max:100',
            'sfis_normal_addms' => 'nullable|string|max:100',
            'sfis_normal_addrtu' => 'nullable|string|max:100',
            'sfis_normal_objfrmt' => 'nullable|string|max:100',
            'sfit_fail_addms' => 'nullable|string|max:100',
            'sfit_fail_addrtu' => 'nullable|string|max:100',
            'sfit_fail_objfrmt' => 'nullable|string|max:100',
            'sfit_normal_addms' => 'nullable|string|max:100',
            'sfit_normal_addrtu' => 'nullable|string|max:100',
            'sfit_normal_objfrmt' => 'nullable|string|max:100',
            'shlt_off_addms' => 'nullable|string|max:100',
            'shlt_off_addrtu' => 'nullable|string|max:100',
            'shlt_off_objfrmt' => 'nullable|string|max:100',
            'shlt_on_addms' => 'nullable|string|max:100',
            'shlt_on_addrtu' => 'nullable|string|max:100',
            'shlt_on_objfrmt' => 'nullable|string|max:100',
            'slr_local_addms' => 'nullable|string|max:100',
            'slr_local_addrtu' => 'nullable|string|max:100',
            'slr_local_objfrmt' => 'nullable|string|max:100',
            'slr_remote_addms' => 'nullable|string|max:100',
            'slr_remote_addrtu' => 'nullable|string|max:100',
            'slr_remote_objfrmt' => 'nullable|string|max:100',
            'ssf6_fail_addms' => 'nullable|string|max:100',
            'ssf6_fail_addrtu' => 'nullable|string|max:100',
            'ssf6_fail_objfrmt' => 'nullable|string|max:100',
            'ssf6_normal_addms' => 'nullable|string|max:100',
            'ssf6_normal_addrtu' => 'nullable|string|max:100',
            'ssf6_normal_objfrmt' => 'nullable|string|max:100',
            'ccb_open_addms' => 'nullable|string|max:100',
            'ccb_open_addrtu' => 'nullable|string|max:100',
            'ccb_open_objfrmt' => 'nullable|string|max:100',
            'ccb_close_addms' => 'nullable|string|max:100',
            'ccb_close_addrtu' => 'nullable|string|max:100',
            'ccb_close_objfrmt' => 'nullable|string|max:100',
            'ccb2_open_addms' => 'nullable|string|max:100',
            'ccb2_open_addrtu' => 'nullable|string|max:100',
            'ccb2_open_objfrmt' => 'nullable|string|max:100',
            'ccb2_close_addms' => 'nullable|string|max:100',
            'ccb2_close_addrtu' => 'nullable|string|max:100',
            'ccb2_close_objfrmt' => 'nullable|string|max:100',
            'chlt_on_addms' => 'nullable|string|max:100',
            'chlt_on_addrtu' => 'nullable|string|max:100',
            'chlt_on_objfrmt' => 'nullable|string|max:100',
            'chlt_off_addms' => 'nullable|string|max:100',
            'chlt_off_addrtu' => 'nullable|string|max:100',
            'chlt_off_objfrmt' => 'nullable|string|max:100',
            'crst_addms' => 'nullable|string|max:100',
            'crst_addrtu' => 'nullable|string|max:100',
            'crst_objfrmt' => 'nullable|string|max:100',

            // Custom ID validations
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
        ];

        // 4. Add Checkbox Array Validations Dynamically
        $checkboxFields = [
            's_cb',
            's_cb2',
            's_lr',
            's_door',
            's_acf',
            's_dcf',
            's_dcd',
            's_hlt',
            's_sf6',
            's_fir',
            's_fis',
            's_fit',
            's_fin',
            'sys_comf',
            'sys_lruf',
            'sys_signs',
            'sys_limitswith',
            'hard_batere',
            'hard_ps220',
            'hard_charger',
            'hard_limitswith',
            're_ar_on',
            're_ar_off',
            're_ctrl_ar_on',
            're_ctrl_ar_off',
            'c_cb',
            'c_cb2',
            'c_hlt',
            'c_rst',
            // New Telemetering & Psuedo Checkboxes
            't_ir',
            't_is',
            't_it',
            't_in',
            't_vrin',
            't_vsin',
            't_vtin',
            't_vrout',
            't_vsout',
            't_vtout',
            't_vavg',
            't_ifr',
            't_ifs',
            't_ift',
            't_ifn',
            't_ifr_psuedo',
            't_ifs_psuedo',
            't_ift_psuedo',
            't_ifn_psuedo',
            't_hz',
            't_iavg',
            't_pf',
        ];

        foreach ($checkboxFields as $field) {
            $rules[$field] = 'nullable|array';
            $rules[$field . '.*'] = 'string|in:' . implode(',', $validCheckboxValues);
        }

        // 5. Run Validation
        $validated = $request->validate($rules);

        // 6. Post-Processing: Convert Arrays to Comma-Separated Strings
        foreach ($checkboxFields as $field) {
            $validated[$field] = ($request->has($field) && is_array($request->input($field)))
                ? implode(',', array_filter($request->input($field)))
                : '';
        }

        // 7. Handle Sectoral Logic (nama_sec -> id_sec)
        if (!empty($request->nama_sec)) {
            $validated['id_sec'] = $request->nama_sec;
        }
        unset($validated['nama_sec']);

        // 8. Handle JSON encoded IDs
        $validated['id_pelms'] = json_encode($idPelmsArray);
        $validated['id_pelrtu'] = json_encode($idPelrtuArray);

        // 9. Save to Database (Create New)
        Keypoint::create($validated);

        return redirect()->route('keypoint.index')->with('success', 'Keypoint cloned successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $keypoint = Keypoint::findOrFail($id);
        $keypoint->delete();

        return redirect()->route('keypoint.index')->with('success', 'Keypoint deleted successfully!');
    }
}