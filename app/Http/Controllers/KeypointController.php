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
        ];

        $orderColumn = $columnMap[$orderColumnIndex] ?? 'tb_formkp.tgl_komisioning';

        // Base query with joins
        $query = DB::table('tb_formkp')
            ->leftJoin('tb_merklbs', 'tb_formkp.id_merkrtu', '=', 'tb_merklbs.id_merkrtu')
            ->leftJoin('tb_modem', 'tb_formkp.id_modem', '=', 'tb_modem.id_modem')
            ->select(
                'tb_formkp.id_formkp',
                'tb_formkp.tgl_komisioning',
                'tb_formkp.nama_lbs as nama_keypoint',
                DB::raw("CONCAT(tb_formkp.id_gi, ' - ', tb_formkp.nama_peny) as gi_penyulang"),
                DB::raw("CONCAT(COALESCE(tb_merklbs.nama_merklbs, 'N/A'), ' - ', COALESCE(tb_modem.nama_modem, 'N/A')) as merk_modem_rtu"),
                'tb_formkp.ketkp as keterangan',
                'tb_formkp.nama_user as master'
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
                    ->orWhereRaw("CONCAT(COALESCE(tb_merklbs.nama_merklbs, 'N/A'), ' - ', COALESCE(tb_modem.nama_modem, 'N/A')) LIKE ?", ["%{$searchValue}%"]);
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
                        $query->whereRaw("CONCAT(COALESCE(tb_merklbs.nama_merklbs, 'N/A'), ' - ', COALESCE(tb_modem.nama_modem, 'N/A')) LIKE ?", ["%{$colSearchValue}%"]);
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
            $query->orderByRaw("CONCAT(tb_formkp.id_gi, ' - ', tb_formkp.nama_peny) {$orderDir}");
        } elseif (strpos($orderColumn, 'merk_modem_rtu') !== false) {
            $query->orderByRaw("CONCAT(COALESCE(tb_merklbs.nama_merklbs, 'N/A'), ' - ', COALESCE(tb_modem.nama_modem, 'N/A')) {$orderDir}");
        } else {
            $query->orderBy($orderColumn, $orderDir);
        }

        // Pagination
        $records = $query->offset($start)->limit($length)->get();

        // Format data
        $data = $records->map(function ($row) {
            $row->tgl_komisioning = Carbon::parse($row->tgl_komisioning)->format('l, d-m-Y');
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
                DB::raw("CONCAT(tb_formkp.id_gi, ' - ', tb_formkp.nama_peny) as gi_penyulang"),
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
                DB::raw("CONCAT(tb_formkp.id_gi, ' - ', tb_formkp.nama_peny) as gi_penyulang"),
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
        $garduinduk = DB::table('tb_garduinduk')->get();
        $sectoral = DB::table('tb_sectoral')->get();
        $komkp = DB::table('tb_komkp')->get();
        $picmaster = DB::table('tb_picmaster')->get();

        return view('pages.keypoint.add', compact('merklbs', 'modems', 'medkom', 'garduinduk', 'sectoral', 'komkp', 'picmaster'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Preprocess id_picms to ensure it's an array
        $idPicmsInput = $request->input('id_picms', '');
        $idPicmsArray = !empty($idPicmsInput) ? array_filter(array_map('trim', explode(',', $idPicmsInput))) : [];

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
            'nama_lbs' => 'required|string|max:50',
            'id_merkrtu' => 'required|integer|exists:tb_merklbs,id_merkrtu',
            'id_modem' => 'required|integer|exists:tb_modem,id_modem',
            'rtu_addrs' => 'required|string|max:255',
            'id_medkom' => 'required|integer|exists:tb_medkom,id_medkom',
            'ip_kp' => 'required|string|max:255',
            'id_gi' => 'required|string|max:25',
            'nama_peny' => 'required|string|max:25',
            'id_sec' => 'required|integer|exists:tb_sectoral,id_sec',
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
            'id_picms' => ['required', function ($attribute, $value, $fail) use ($idPicmsArray) {
                if (empty($idPicmsArray)) {
                    $fail('The id picms field must be an array and cannot be empty.');
                }
            }],
            'pelrtu' => 'required|string|max:25',
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

        // Merge preprocessed id_picms array into validated data
        $validated['id_picms'] = json_encode($idPicmsArray);

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
        $garduinduk = DB::table('tb_garduinduk')->get();
        $sectoral = DB::table('tb_sectoral')->get();
        $komkp = DB::table('tb_komkp')->get();
        $picmaster = DB::table('tb_picmaster')->get();
        $selectedPicms = json_decode($keypoint->id_picms, true) ?? [];

        return view('pages.keypoint.edit', compact('keypoint', 'merklbs', 'modems', 'medkom', 'garduinduk', 'sectoral', 'komkp', 'picmaster', 'selectedPicms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the keypoint record
        $keypoint = Keypoint::findOrFail($id);

        // Preprocess id_picms to ensure it's an array
        $idPicmsInput = $request->input('id_picms', '');
        $idPicmsArray = !empty($idPicmsInput) ? array_filter(array_map('trim', explode(',', $idPicmsInput))) : [];

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
            'nama_lbs' => 'required|string|max:50',
            'id_merkrtu' => 'required|integer|exists:tb_merklbs,id_merkrtu',
            'id_modem' => 'required|integer|exists:tb_modem,id_modem',
            'rtu_addrs' => 'required|string|max:255',
            'id_medkom' => 'required|integer|exists:tb_medkom,id_medkom',
            'ip_kp' => 'required|string|max:255',
            'id_gi' => 'required|string|max:25',
            'nama_peny' => 'required|string|max:25',
            'id_sec' => 'required|integer|exists:tb_sectoral,id_sec',
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
            'id_picms' => ['required', function ($attribute, $value, $fail) use ($idPicmsArray) {
                if (empty($idPicmsArray)) {
                    $fail('The id picms field must be an array and cannot be empty.');
                }
            }],
            'pelrtu' => 'required|string|max:25',
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

        // Merge preprocessed id_picms array into validated data
        $validated['id_picms'] = json_encode($idPicmsArray);

        // Update the record
        $keypoint->update($validated);

        return redirect()->route('keypoint.index')->with('success', 'Keypoint updated successfully!');
    }


    public function clone($id)
    {
        try {
            $keypoint = Keypoint::findOrFail($id);
            $merklbs = DB::table('tb_merklbs')->get();
            $modems = DB::table('tb_modem')->get();
            $medkom = DB::table('tb_medkom')->get();
            $garduinduk = DB::table('tb_garduinduk')->get();
            $sectoral = DB::table('tb_sectoral')->get();
            $komkp = DB::table('tb_komkp')->get();
            $picmaster = DB::table('tb_picmaster')->get();
            $selectedPicms = json_decode($keypoint->id_picms, true) ?? [];

            return view('pages.keypoint.clone', compact(
                'keypoint',
                'merklbs',
                'modems',
                'medkom',
                'garduinduk',
                'sectoral',
                'komkp',
                'picmaster',
                'selectedPicms'
            ));
        } catch (\Exception $e) {
            Log::error('Error in clone method: ' . $e->getMessage());
            return redirect()->route('keypoint.index')->with('error', 'Failed to load clone form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly cloned keypoint in the database.
     */
    public function storeClone(Request $request)
    {
        // Preprocess id_picms to ensure it's an array
        $idPicmsInput = $request->input('id_picms', '');
        $idPicmsArray = !empty($idPicmsInput) ? array_filter(array_map('trim', explode(',', $idPicmsInput))) : [];

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

        // Validation rules (aligned with store/update)
        $validated = $request->validate([
            'tgl_komisioning' => 'required|date',
            'nama_lbs' => 'required|string|max:50',
            'id_merkrtu' => 'required|integer|exists:tb_merklbs,id_merkrtu',
            'id_modem' => 'required|integer|exists:tb_modem,id_modem',
            'rtu_addrs' => 'required|string|max:255',
            'id_medkom' => 'required|integer|exists:tb_medkom,id_medkom',
            'ip_kp' => 'required|string|max:255',
            'id_gi' => 'required|string|max:25',
            'nama_peny' => 'required|string|max:25',
            'id_sec' => 'required|integer|exists:tb_sectoral,id_sec',
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
            'id_picms' => ['required', function ($attribute, $value, $fail) use ($idPicmsArray) {
                if (empty($idPicmsArray)) {
                    $fail('The id picms field must be an array and cannot be empty.');
                }
            }],
            'pelrtu' => 'required|string|max:25',
            'ketkp' => 'required|string|max:500',
        ]);

        // Validate and process array fields
        foreach ($arrayFields as $field) {
            $request->validate([
                $field => 'nullable|array',
                $field . '.*' => 'string|in:' . implode(',', $validCheckboxValues),
            ]);
            $value = $request->input($field);
            $validated[$field] = (is_array($value) && !empty(array_filter($value)))
                ? implode(',', array_filter($value))
                : '';
        }

        // Merge preprocessed id_picms array into validated data
        $validated['id_picms'] = json_encode($idPicmsArray);
        $validated['nama_user'] = Auth::user()->nama_admin;

        try {
            Keypoint::create($validated); // Create new record instead of update
            return redirect()->route('keypoint.index')->with('success', 'Keypoint cloned successfully.');
        } catch (\Exception $e) {
            Log::error('Error in storeClone method: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to clone keypoint: ' . $e->getMessage());
        }
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