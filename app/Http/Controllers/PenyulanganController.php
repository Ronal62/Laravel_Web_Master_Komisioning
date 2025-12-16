<?php

namespace App\Http\Controllers;

use App\Models\Penyulangan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use TCPDF;
use Illuminate\Support\Facades\Response;

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

        if ($fromDate && $toDate) {
            $query->whereBetween('tb_formpeny.tgl_kom', [$fromDate, $toDate]);
        } elseif ($fromDate) {
            $query->whereDate('tb_formpeny.tgl_kom', '>=', $fromDate);
        } elseif ($toDate) {
            $query->whereDate('tb_formpeny.tgl_kom', '<=', $toDate);
        }

        $records = $query->get();

        $records = $records->map(function ($row) use ($pelrtuMap) {
            $ids = json_decode($row->id_pelrtu, true) ?? [];
            $names = [];
            foreach ($ids as $id) {
                $id = trim($id, '"'); // Clean up any extra quotes if present
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


    public function exportPdfFiltered(Request $request)
    {
        $fromDate = $request->query('from');
        $toDate = $request->query('to');

        $query = DB::table('tb_formpeny')
            ->leftJoin('tb_garduinduk', 'tb_formpeny.id_gi', '=', 'tb_garduinduk.id_gi')
            ->leftJoin('tb_merkrtugi', 'tb_formpeny.id_rtugi', '=', 'tb_merkrtugi.id_rtugi')
            ->select(
                'tb_formpeny.tgl_kom',
                'tb_formpeny.nama_peny',
                'tb_garduinduk.nama_gi as id_gi',
                'tb_merkrtugi.merk_rtugi as id_rtugi',
                'tb_formpeny.catatanpeny',
                'tb_formpeny.nama_user',
                'tb_formpeny.id_pelrtu'
            );

        if ($fromDate && $toDate) {
            $query->whereBetween('tb_formpeny.tgl_kom', [$fromDate, $toDate]);
        }

        $penyulangans = $query->get();

        $pelrtuMap = DB::table('tb_pelaksana_rtu')->pluck('nama_pelrtu', 'id_pelrtu')->toArray();

        $penyulangans = $penyulangans->map(function ($row) use ($pelrtuMap) {
            $row->tgl_kom = Carbon::parse($row->tgl_kom)->format('l, d-m-Y');

            $ids = json_decode($row->id_pelrtu, true) ?? [];
            $names = [];
            foreach ($ids as $id) {
                if (isset($pelrtuMap[$id])) {
                    $names[] = $pelrtuMap[$id];
                }
            }
            $row->id_pelrtu = implode(', ', $names);

            return $row;
        });

        $data = ['penyulangans' => $penyulangans];
        $html = view('pdf.allpenyulangans', $data)->render();

        $filename = "Data_Penyulangan_" . now()->format('d-m-Y') . ".pdf";
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

    public function exportExcelFiltered(Request $request)
    {
        $fromDate = $request->query('from');
        $toDate = $request->query('to');

        $query = DB::table('tb_formpeny')
            ->leftJoin('tb_garduinduk', 'tb_formpeny.id_gi', '=', 'tb_garduinduk.id_gi')
            ->leftJoin('tb_merkrtugi', 'tb_formpeny.id_rtugi', '=', 'tb_merkrtugi.id_rtugi')
            ->select(
                DB::raw("DATE_FORMAT(tb_formpeny.tgl_kom, '%d-%m-%Y') as tgl_kom"),
                'tb_formpeny.nama_peny',
                'tb_garduinduk.nama_gi as id_gi',
                'tb_merkrtugi.merk_rtugi as id_rtugi',
                'tb_formpeny.catatanpeny',
                'tb_formpeny.nama_user',
                'tb_formpeny.id_pelrtu'
            );

        if ($fromDate && $toDate) {
            $query->whereBetween('tb_formpeny.tgl_kom', [$fromDate, $toDate]);
        }

        $penyulangans = $query->get();

        $pelrtuMap = DB::table('tb_pelaksana_rtu')->pluck('nama_pelrtu', 'id_pelrtu')->toArray();

        $penyulangans = $penyulangans->map(function ($row) use ($pelrtuMap) {
            $ids = json_decode($row->id_pelrtu, true) ?? [];
            $names = [];
            foreach ($ids as $id) {
                if (isset($pelrtuMap[$id])) {
                    $names[] = $pelrtuMap[$id];
                }
            }
            $row->id_pelrtu = implode(', ', $names);
            return $row;
        })->toArray();

        $filename = "Data_Penyulangan_" . now()->format('d-m-Y') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        return response()->streamDownload(function () use ($penyulangans) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Tgl Komisioning', 'Nama Penyulang', 'Gardu Induk', 'Wilayah DCC', 'Keterangan', 'PIC Master', 'PIC RTU']);
            foreach ($penyulangans as $row) {
                fputcsv($handle, [
                    $row->tgl_kom,
                    $row->nama_peny,
                    $row->id_gi,
                    $row->id_rtugi,
                    $row->catatanpeny,
                    $row->nama_user,
                    $row->id_pelrtu
                ]);
            }
            fclose($handle);
        }, $filename, $headers);
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
            'c_tc'
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
            'ir_rtu' => 'nullable|string|max:10',
            'is_rtu' => 'nullable|string|max:10',
            'it_rtu' => 'nullable|string|max:10',
            'ir_ms' => 'nullable|string|max:10',
            'is_ms' => 'nullable|string|max:10',
            'it_ms' => 'nullable|string|max:10',
            'ir_scale' => 'nullable|string|max:10',
            'is_scale' => 'nullable|string|max:10',
            'it_scale' => 'nullable|string|max:10',
            'fir_rtu' => 'nullable|string|max:50',
            'fis_rtu' => 'nullable|string|max:50',
            'fit_rtu' => 'nullable|string|max:50',
            'fin_rtu' => 'nullable|string|max:50',
            'fir_ms' => 'nullable|string|max:50',
            'fis_ms' => 'nullable|string|max:50',
            'fit_ms' => 'nullable|string|max:50',
            'fin_ms' => 'nullable|string|max:50',
            'fir_scale' => 'nullable|string|max:50',
            'fis_scale' => 'nullable|string|max:50',
            'fit_scale' => 'nullable|string|max:50',
            'fin_scale' => 'nullable|string|max:50',
            'v_rtu' => 'nullable|string|max:50',
            'v_ms' => 'nullable|string|max:50',
            'v_scale' => 'nullable|string|max:50',
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
            'c_tc'
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
            'ir_rtu' => 'nullable|string|max:10',
            'is_rtu' => 'nullable|string|max:10',
            'it_rtu' => 'nullable|string|max:10',
            'ir_ms' => 'nullable|string|max:10',
            'is_ms' => 'nullable|string|max:10',
            'it_ms' => 'nullable|string|max:10',
            'ir_scale' => 'nullable|string|max:10',
            'is_scale' => 'nullable|string|max:10',
            'it_scale' => 'nullable|string|max:10',
            'fir_rtu' => 'nullable|string|max:50',
            'fis_rtu' => 'nullable|string|max:50',
            'fit_rtu' => 'nullable|string|max:50',
            'fin_rtu' => 'nullable|string|max:50',
            'fir_ms' => 'nullable|string|max:50',
            'fis_ms' => 'nullable|string|max:50',
            'fit_ms' => 'nullable|string|max:50',
            'fin_ms' => 'nullable|string|max:50',
            'fir_scale' => 'nullable|string|max:50',
            'fis_scale' => 'nullable|string|max:50',
            'fit_scale' => 'nullable|string|max:50',
            'fin_scale' => 'nullable|string|max:50',
            'v_rtu' => 'nullable|string|max:50',
            'v_ms' => 'nullable|string|max:50',
            'v_scale' => 'nullable|string|max:50',
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
            'c_tc'
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
            'ir_rtu' => 'nullable|string|max:10',
            'is_rtu' => 'nullable|string|max:10',
            'it_rtu' => 'nullable|string|max:10',
            'ir_ms' => 'nullable|string|max:10',
            'is_ms' => 'nullable|string|max:10',
            'it_ms' => 'nullable|string|max:10',
            'ir_scale' => 'nullable|string|max:10',
            'is_scale' => 'nullable|string|max:10',
            'it_scale' => 'nullable|string|max:10',
            'fir_rtu' => 'nullable|string|max:50',
            'fis_rtu' => 'nullable|string|max:50',
            'fit_rtu' => 'nullable|string|max:50',
            'fin_rtu' => 'nullable|string|max:50',
            'fir_ms' => 'nullable|string|max:50',
            'fis_ms' => 'nullable|string|max:50',
            'fit_ms' => 'nullable|string|max:50',
            'fin_ms' => 'nullable|string|max:50',
            'fir_scale' => 'nullable|string|max:50',
            'fis_scale' => 'nullable|string|max:50',
            'fit_scale' => 'nullable|string|max:50',
            'fin_scale' => 'nullable|string|max:50',
            'v_rtu' => 'nullable|string|max:50',
            'v_ms' => 'nullable|string|max:50',
            'v_scale' => 'nullable|string|max:50',
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
