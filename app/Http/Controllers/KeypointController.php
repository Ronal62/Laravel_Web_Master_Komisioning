<?php

namespace App\Http\Controllers;

use App\Models\Keypoint;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use TCPDF; // Assuming TCPDF is installed via composer or available
use Illuminate\Support\Facades\Response; // For potential CSV/excel fallback

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
            4 => 'tb_formkp.ketkp',
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
                'tb_formkp.ketkp as keterangan',
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
                    ->orWhere('tb_formkp.ketkp', 'like', "%{$searchValue}%")
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
                        $query->where('tb_formkp.ketkp', 'like', "%{$colSearchValue}%");
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
            <a href="' . route('keypoint.exportpdf', $row->id_formkp) . '" target="_blank" class="btn btn-icon btn-round btn-danger">
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
                'tb_formkp.ketkp as keterangan',
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
                'tb_formkp.ketkp as keterangan',
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
            ->select('nama_keypoint as id', DB::raw("CONCAT(type_keypoint, ' ', nama_keypoint) as name"))
            ->get()
            ->pluck('name', 'id');
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
            ->select('sektoral as id', DB::raw("CONCAT(up3, ' ', sektoral) as name"))
            ->distinct()
            ->get()
            ->pluck('name', 'id');
        return response()->json($sektoral);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $idPelmsInput = $request->input('id_pelms', '');
        $idPelmsArray = !empty($idPelmsInput) ? array_filter(array_map('trim', explode(',', $idPelmsInput))) : [];

        $idPelrtuInput = $request->input('id_pelrtu', '');
        $idPelrtuArray = !empty($idPelrtuInput) ? array_filter(array_map('trim', explode(',', $idPelrtuInput))) : [];

        // Define array fields that come from checkboxes
        $arrayFields = [
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
            's_comf',
            's_lruf',
            'c_cb',
            'c_cb2',
            'c_hlt',
            'c_rst'
        ];

        // Define valid checkbox values
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
            'normal',
            'ok',
            'nok',
            'log',
            'sld',
            'tidak_uji'
        ];

        // Validation rules
        $validated = $request->validate([
            'tgl_komisioning' => 'required|date',
            'nama_lbs' => ['required', 'string', 'max:50', function ($attribute, $value, $fail) use ($request) {
                if (!$request->mode_input) {
                    $gi = $request->id_gi;
                    $peny = $request->nama_peny;
                    if (!DB::connection('masterdata')->table('dg_keypoint')->where('gardu_induk', $gi)->where('penyulang', $peny)->where('nama_keypoint', $value)->exists()) {
                        $fail('Invalid Nama Keypoint.');
                    }
                }
            }],
            'id_merkrtu' => 'required|integer|exists:tb_merklbs,id_merkrtu',
            'id_modem' => 'required|integer|exists:tb_modem,id_modem',
            'rtu_addrs' => 'required|string|max:255',
            'id_medkom' => 'required|integer|exists:tb_medkom,id_medkom',
            'ip_kp' => 'required|string|max:255',
            // 'id_gi' => 'required|string|max:25',
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
            'nama_sec' => ['required_if:mode_input,false', 'string', 'max:255', function ($attribute, $value, $fail) use ($request) {
                if (!$request->mode_input) {
                    $gi = $request->id_gi;
                    $peny = $request->nama_peny;
                    if (!DB::connection('masterdata')->table('dg_keypoint')->where('gardu_induk', $gi)->where('penyulang', $peny)->where('sektoral', $value)->exists()) {
                        $fail('Invalid Sectoral.');
                    }
                }
            }],
            'ir_rtu' => 'required|integer',
            'ir_ms' => 'required|integer',
            'ir_scale' => 'required|string|max:10',
            'is_rtu' => 'required|integer',
            'is_ms' => 'required|integer',
            'is_scale' => 'required|string|max:10',
            'it_rtu' => 'required|integer',
            'it_ms' => 'required|integer',
            'it_scale' => 'required|string|max:10',
            'vr_rtu' => 'required|string|max:10',
            'vr_ms' => 'required|string|max:10',
            'vr_scale' => 'required|string|max:10',
            'vs_rtu' => 'required|string|max:10',
            'vs_ms' => 'required|string|max:10',
            'vs_scale' => 'required|string|max:10',
            'vt_rtu' => 'required|string|max:10',
            'vt_ms' => 'required|string|max:10',
            'vt_scale' => 'required|string|max:10',
            'sign_kp' => 'required|string|max:10',
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',
            'nama_user' => 'required|string|max:10',
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
            'scomf_addms' => 'nullable|string|max:100',
            'scomf_addrtu' => 'nullable|string|max:100',
            'scomf_objfrmt' => 'nullable|string|max:100',
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
            'slruf_addms' => 'nullable|string|max:100',
            'slruf_addrtu' => 'nullable|string|max:100',
            'slruf_objfrmt' => 'nullable|string|max:100',
            'ssf6_fail_addms' => 'nullable|string|max:100',
            'ssf6_fail_addrtu' => 'nullable|string|max:100',
            'ssf6_fail_objfrmt' => 'nullable|string|max:100',
            'ssf6_normal_addms' => 'nullable|string|max:100',
            'ssf6_normal_addrtu' => 'nullable|string|max:100',
            'ssf6_normal_objfrmt' => 'nullable|string|max:100',

            // Add control field validations (from Document 2)
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
            'ketkp' => 'required|string|max:500',
        ]);

        // Validate array fields separately
        foreach ($arrayFields as $field) {
            $request->validate([
                $field => 'nullable|array',
                $field . '.*' => 'string|in:' . implode(',', $validCheckboxValues),
            ]);
            // Set empty string for array fields if not present or empty
            $validated[$field] = $request->has($field) && is_array($request->input($field)) && !empty($request->input($field))
                ? implode(',', array_filter($request->input($field)))
                : '';
        }
        // Convert nama_sec (string from select2/AJAX) → id_sec (integer FK)
        if (!empty($request->nama_sec)) {
            $namaSec = $request->nama_sec;
            $idSec = DB::table('tb_sectoral')
                ->where('nama_sec', $namaSec)  // Changed from 'sektoral' to 'nama_sec' to match likely table schema
                ->value('id_sec');

            if (!$idSec) {
                // For manual input mode, insert new sectoral if not exists
                $idSec = DB::table('tb_sectoral')->insertGetId(['nama_sec' => $namaSec]);  // Assuming 'nama_sec' is the name column; add other required fields if any
            }

            // This is the only thing we save to tb_formkp
            $validated['id_sec'] = $idSec;
        }

        // Completely remove nama_sec from the insert (it doesn't exist in the table anyway)
        unset($validated['nama_sec']);

        // Merge preprocessed id_pelms array into validated data
        $validated['id_pelms'] = json_encode(array_filter(explode(',', $request->input('id_pelms', ''))));
        $validated['id_pelrtu'] = json_encode(array_filter(explode(',', $request->input('id_pelrtu', ''))));

        // Log validated data before creating the record

        // Create the record
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
        // $garduinduk = DB::table('tb_garduinduk')->get();
        $garduinduk = DB::connection('masterdata')->table('dg_keypoint')->select('gardu_induk')->distinct()->get();
        $sectoral = DB::table('tb_sectoral')->get();
        $komkp = DB::table('tb_komkp')->get();
        $pelms = DB::table('tb_picmaster')->get();
        $pelrtus = DB::table('tb_pelaksana_rtu')->get();

        $decoded = json_decode($keypoint->id_pelms, true);
        $selectedPelms = is_array($decoded) ? $decoded : ($decoded ? [$decoded] : []);
        $decodedRtu = json_decode($keypoint->id_pelrtu, true);
        $selectedPelrtus = is_array($decodedRtu) ? $decodedRtu : ($decodedRtu ? [$decodedRtu] : []);

        return view('pages.keypoint.edit', compact('keypoint', 'merklbs', 'modems', 'medkom', 'garduinduk', 'sectoral', 'komkp', 'pelms', 'selectedPelms', 'pelrtus', 'selectedPelrtus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the keypoint record
        $keypoint = Keypoint::findOrFail($id);

        // Preprocess id_picms to ensure it's an array
        $idPelmsInput = $request->input('id_pelms', '');
        $idPelmsArray = !empty($idPelmsInput) ? array_filter(array_map('trim', explode(',', $idPelmsInput))) : [];

        $idPelrtuInput = $request->input('id_pelrtu', '');
        $idPelrtuArray = !empty($idPelrtuInput) ? array_filter(array_map('trim', explode(',', $idPelrtuInput))) : [];

        // Define array fields that come from checkboxes
        $arrayFields = [
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
            's_comf',
            's_lruf',
            'c_cb',
            'c_cb2',
            'c_hlt',
            'c_rst'
        ];

        // Define valid checkbox values
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
            'normal',
            'ok',
            'nok',
            'log',
            'sld',
            'tidak_uji'
        ];

        // Validation rules
        $validated = $request->validate([
            'id_formkp' => 'required|integer|exists:tb_formkp,id_formkp',
            'tgl_komisioning' => 'required|date',
            'nama_lbs' => ['required', 'string', 'max:50', function ($attribute, $value, $fail) use ($request) {
                if (!$request->mode_input) {
                    $gi = $request->id_gi;
                    $peny = $request->nama_peny;
                    if (!DB::connection('masterdata')->table('dg_keypoint')->where('gardu_induk', $gi)->where('penyulang', $peny)->where('nama_keypoint', $value)->exists()) {
                        $fail('Invalid Nama Keypoint.');
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
            'nama_sec' => ['required_if:mode_input,false', 'string', 'max:255', function ($attribute, $value, $fail) use ($request) {
                if (!$request->mode_input) {
                    $gi = $request->id_gi;
                    $peny = $request->nama_peny;
                    if (!DB::connection('masterdata')->table('dg_keypoint')->where('gardu_induk', $gi)->where('penyulang', $peny)->where('sektoral', $value)->exists()) {
                        $fail('Invalid Sectoral.');
                    }
                }
            }],
            'ir_rtu' => 'required|integer',
            'ir_ms' => 'required|integer',
            'ir_scale' => 'required|string|max:10',
            'is_rtu' => 'required|integer',
            'is_ms' => 'required|integer',
            'is_scale' => 'required|string|max:10',
            'it_rtu' => 'required|integer',
            'it_ms' => 'required|integer',
            'it_scale' => 'required|string|max:10',
            'vr_rtu' => 'required|string|max:10',
            'vr_ms' => 'required|string|max:10',
            'vr_scale' => 'required|string|max:10',
            'vs_rtu' => 'required|string|max:10',
            'vs_ms' => 'required|string|max:10',
            'vs_scale' => 'required|string|max:10',
            'vt_rtu' => 'required|string|max:10',
            'vt_ms' => 'required|string|max:10',
            'vt_scale' => 'required|string|max:10',
            'sign_kp' => 'required|string|max:10',
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',
            'nama_user' => 'required|string|max:10',
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
            'scomf_addms' => 'nullable|string|max:100',
            'scomf_addrtu' => 'nullable|string|max:100',
            'scomf_objfrmt' => 'nullable|string|max:100',
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
            'slruf_addms' => 'nullable|string|max:100',
            'slruf_addrtu' => 'nullable|string|max:100',
            'slruf_objfrmt' => 'nullable|string|max:100',
            'ssf6_fail_addms' => 'nullable|string|max:100',
            'ssf6_fail_addrtu' => 'nullable|string|max:100',
            'ssf6_fail_objfrmt' => 'nullable|string|max:100',
            'ssf6_normal_addms' => 'nullable|string|max:100',
            'ssf6_normal_addrtu' => 'nullable|string|max:100',
            'ssf6_normal_objfrmt' => 'nullable|string|max:100',

            // Add control field validations (from Document 2)
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
            'id_pelrtu' => 'required|string|max:25',
            'ketkp' => 'required|string|max:500',

        ]);

        // Validate array fields separately
        foreach ($arrayFields as $field) {
            $request->validate([
                $field => 'nullable|array',
                $field . '.*' => 'string|in:' . implode(',', $validCheckboxValues),
            ]);
            // Set empty string for array fields if not present or empty
            $validated[$field] = $request->has($field) && is_array($request->input($field)) && !empty($request->input($field))
                ? implode(',', array_filter($request->input($field)))
                : '';
        }

        // Convert nama_sec (string from select2/AJAX) → id_sec (integer FK)
        if (!empty($request->nama_sec)) {
            $namaSec = $request->nama_sec;
            $idSec = DB::table('tb_sectoral')
                ->where('nama_sec', $namaSec)  // Changed from 'sektoral' to 'nama_sec' to match likely table schema
                ->value('id_sec');

            if (!$idSec) {
                // For manual input mode, insert new sectoral if not exists
                $idSec = DB::table('tb_sectoral')->insertGetId(['nama_sec' => $namaSec]);  // Assuming 'nama_sec' is the name column; add other required fields if any
            }

            // This is the only thing we save to tb_formkp
            $validated['id_sec'] = $idSec;
        }

        // Completely remove nama_sec from the insert (it doesn't exist in the table anyway)
        unset($validated['nama_sec']);


        // Merge preprocessed id_picms array into validated data
        $validated['id_pelms'] = json_encode(array_filter(explode(',', $request->input('id_pelms', ''))));
        $validated['id_pelrtu'] = json_encode(array_filter(explode(',', $request->input('id_pelrtu', ''))));

        // Update the record
        $keypoint->update($validated);

        return redirect()->route('keypoint.index')->with('success', 'Keypoint updated successfully!');
    }


    public function clone($id)
    {
        $keypoint = Keypoint::findOrFail($id);
        $merklbs = DB::table('tb_merklbs')->get();
        $modems = DB::table('tb_modem')->get();
        $medkom = DB::table('tb_medkom')->get();
        // $garduinduk = DB::table('tb_garduinduk')->get();
        $garduinduk = DB::connection('masterdata')->table('dg_keypoint')->select('gardu_induk')->distinct()->get();
        $sectoral = DB::table('tb_sectoral')->get();
        $komkp = DB::table('tb_komkp')->get();
        $pelms = DB::table('tb_picmaster')->get();
        $pelrtus = DB::table('tb_pelaksana_rtu')->get();

        $decoded = json_decode($keypoint->id_pelms, true);
        $selectedPelms = is_array($decoded) ? $decoded : ($decoded ? [$decoded] : []);
        $decodedRtu = json_decode($keypoint->id_pelrtu, true);
        $selectedPelrtus = is_array($decodedRtu) ? $decodedRtu : ($decodedRtu ? [$decodedRtu] : []);

        return view('pages.keypoint.clone', compact('keypoint', 'merklbs', 'modems', 'medkom', 'garduinduk', 'sectoral', 'komkp', 'pelms', 'selectedPelms', 'pelrtus', 'selectedPelrtus'));
    }

    /**
     * Store a cloned resource in storage.
     */
    public function storeClone(Request $request)
    {
        // Preprocess id_pelms to ensure it's an array
        $idPelmsInput = $request->input('id_pelms', '');
        $idPelmsArray = !empty($idPelmsInput) ? array_filter(array_map('trim', explode(',', $idPelmsInput))) : [];

        $idPelrtuInput = $request->input('id_pelrtu', '');
        $idPelrtuArray = !empty($idPelrtuInput) ? array_filter(array_map('trim', explode(',', $idPelrtuInput))) : [];

        // Define array fields that come from checkboxes
        $arrayFields = [
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
            's_comf',
            's_lruf',
            'c_cb',
            'c_cb2',
            'c_hlt',
            'c_rst'
        ];

        // Define valid checkbox values
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
            'normal',
            'ok',
            'nok',
            'log',
            'sld',
            'tidak_uji'
        ];

        // Validation rules
        $validated = $request->validate([
            'id_formkp' => 'required|integer|exists:tb_formkp,id_formkp',
            'tgl_komisioning' => 'required|date',
            'nama_lbs' => ['required', 'string', 'max:50', function ($attribute, $value, $fail) use ($request) {
                if (!$request->mode_input) {
                    $gi = $request->id_gi;
                    $peny = $request->nama_peny;
                    if (!DB::connection('masterdata')->table('dg_keypoint')->where('gardu_induk', $gi)->where('penyulang', $peny)->where('nama_keypoint', $value)->exists()) {
                        $fail('Invalid Nama Keypoint.');
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
            'nama_sec' => ['required_if:mode_input,false', 'string', 'max:255', function ($attribute, $value, $fail) use ($request) {
                if (!$request->mode_input) {
                    $gi = $request->id_gi;
                    $peny = $request->nama_peny;
                    if (!DB::connection('masterdata')->table('dg_keypoint')->where('gardu_induk', $gi)->where('penyulang', $peny)->where('sektoral', $value)->exists()) {
                        $fail('Invalid Sectoral.');
                    }
                }
            }],
            'ir_rtu' => 'required|integer',
            'ir_ms' => 'required|integer',
            'ir_scale' => 'required|string|max:10',
            'is_rtu' => 'required|integer',
            'is_ms' => 'required|integer',
            'is_scale' => 'required|string|max:10',
            'it_rtu' => 'required|integer',
            'it_ms' => 'required|integer',
            'it_scale' => 'required|string|max:10',
            'vr_rtu' => 'required|string|max:10',
            'vr_ms' => 'required|string|max:10',
            'vr_scale' => 'required|string|max:10',
            'vs_rtu' => 'required|string|max:10',
            'vs_ms' => 'required|string|max:10',
            'vs_scale' => 'required|string|max:10',
            'vt_rtu' => 'required|string|max:10',
            'vt_ms' => 'required|string|max:10',
            'vt_scale' => 'required|string|max:10',
            'sign_kp' => 'required|string|max:10',
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',
            'nama_user' => 'required|string|max:10',
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
            'scomf_addms' => 'nullable|string|max:100',
            'scomf_addrtu' => 'nullable|string|max:100',
            'scomf_objfrmt' => 'nullable|string|max:100',
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
            'slruf_addms' => 'nullable|string|max:100',
            'slruf_addrtu' => 'nullable|string|max:100',
            'slruf_objfrmt' => 'nullable|string|max:100',
            'ssf6_fail_addms' => 'nullable|string|max:100',
            'ssf6_fail_addrtu' => 'nullable|string|max:100',
            'ssf6_fail_objfrmt' => 'nullable|string|max:100',
            'ssf6_normal_addms' => 'nullable|string|max:100',
            'ssf6_normal_addrtu' => 'nullable|string|max:100',
            'ssf6_normal_objfrmt' => 'nullable|string|max:100',

            // Add control field validations (from Document 2)
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
            'ketkp' => 'required|string|max:500',

        ]);

        // Validate array fields separately
        foreach ($arrayFields as $field) {
            $request->validate([
                $field => 'nullable|array',
                $field . '.*' => 'string|in:' . implode(',', $validCheckboxValues),
            ]);
            // Set empty string for array fields if not present or empty
            $validated[$field] = $request->has($field) && is_array($request->input($field)) && !empty($request->input($field))
                ? implode(',', array_filter($request->input($field)))
                : '';
        }

        // Convert nama_sec (string from select2/AJAX) → id_sec (integer FK)
        if (!empty($request->nama_sec)) {
            $namaSec = $request->nama_sec;
            $idSec = DB::table('tb_sectoral')
                ->where('nama_sec', $namaSec)  // Changed from 'sektoral' to 'nama_sec' to match likely table schema
                ->value('id_sec');

            if (!$idSec) {
                // For manual input mode, insert new sectoral if not exists
                $idSec = DB::table('tb_sectoral')->insertGetId(['nama_sec' => $namaSec]);  // Assuming 'nama_sec' is the name column; add other required fields if any
            }

            // This is the only thing we save to tb_formkp
            $validated['id_sec'] = $idSec;
        }

        // Completely remove nama_sec from the insert (it doesn't exist in the table anyway)
        unset($validated['nama_sec']);


        // Merge preprocessed id_pelms array into validated data
        $validated['id_pelms'] = json_encode(array_filter(explode(',', $request->input('id_pelms', ''))));
        $validated['id_pelrtu'] = json_encode(array_filter(explode(',', $request->input('id_pelrtu', ''))));

        // Create the new record
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