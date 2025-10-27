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

        $columnMap = [
            0 => 'tb_formpeny.tgl_kom',
            1 => 'tb_formpeny.nama_peny',
            2 => 'tb_formpeny.id_gi',
            3 => 'tb_formpeny.id_rtugi',
            4 => 'tb_formpeny.ketpeny',
            5 => 'tb_formpeny.nama_user',
            6 => 'tb_formpeny.pelrtu',
        ];
        $orderColumn = $columnMap[$orderColumnIndex] ?? 'tb_formpeny.tgl_kom';

        $query = DB::table('tb_formpeny')
            ->select(
                'tb_formpeny.id_peny',
                'tb_formpeny.tgl_kom',
                'tb_formpeny.nama_peny',
                'tb_formpeny.id_gi',
                'tb_formpeny.id_rtugi',
                'tb_formpeny.ketpeny',
                'tb_formpeny.nama_user',
                'tb_formpeny.pelrtu'
            );

        if ($fromDate && $toDate) {
            $query->whereBetween('tb_formpeny.tgl_kom', [$fromDate, $toDate]);
        } elseif ($fromDate) {
            $query->whereDate('tb_formpeny.tgl_kom', '>=', $fromDate);
        } elseif ($toDate) {
            $query->whereDate('tb_formpeny.tgl_kom', '<=', $toDate);
        }

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('tb_formpeny.nama_peny', 'like', "%{$searchValue}%")
                    ->orWhere('tb_formpeny.id_gi', 'like', "%{$searchValue}%")
                    ->orWhere('tb_formpeny.id_rtugi', 'like', "%{$searchValue}%")
                    ->orWhere('tb_formpeny.ketpeny', 'like', "%{$searchValue}%")
                    ->orWhere('tb_formpeny.nama_user', 'like', "%{$searchValue}%")
                    ->orWhere('tb_formpeny.pelrtu', 'like', "%{$searchValue}%");
            });
        }

        foreach ($columns as $index => $col) {
            $colSearchValue = $col['search']['value'];
            if (!empty($colSearchValue) && $col['searchable'] == 'true') {
                switch ($index) {
                    case 0:
                        $query->whereDate('tb_formpeny.tgl_kom', 'like', "%{$colSearchValue}%");
                        break;
                    case 1:
                        $query->where('tb_formpeny.nama_peny', 'like', "%{$colSearchValue}%");
                        break;
                    case 2:
                        $query->where('tb_formpeny.id_gi', 'like', "%{$colSearchValue}%");
                        break;
                    case 3:
                        $query->where('tb_formpeny.id_rtugi', 'like', "%{$colSearchValue}%");
                        break;
                    case 4:
                        $query->where('tb_formpeny.ketpeny', 'like', "%{$colSearchValue}%");
                        break;
                    case 5:
                        $query->where('tb_formpeny.nama_user', 'like', "%{$colSearchValue}%");
                        break;
                    case 6:
                        $query->where('tb_formpeny.pelrtu', 'like', "%{$colSearchValue}%");
                        break;
                }
            }
        }

        $totalRecords = DB::table('tb_formpeny')->count();
        $totalFiltered = $query->count();
        $query->orderBy($orderColumn, $orderDir);
        $records = $query->offset($start)->limit($length)->get();

        $data = $records->map(function ($row) {
            $row->tgl_kom = Carbon::parse($row->tgl_kom)->format('l, d-m-Y');
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
            return $row;
        })->toArray();

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
            ->select(
                'tb_formpeny.tgl_kom',
                'tb_formpeny.nama_peny',
                'tb_formpeny.id_gi',
                'tb_formpeny.id_rtugi',
                'tb_formpeny.ketpeny',
                'tb_formpeny.nama_user',
                'tb_formpeny.pelrtu'
            );

        if ($fromDate && $toDate) {
            $query->whereBetween('tb_formpeny.tgl_kom', [$fromDate, $toDate]);
        }

        $penyulangans = $query->get()->map(function ($row) {
            $row->tgl_kom = Carbon::parse($row->tgl_kom)->format('l, d-m-Y');
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
            ->select(
                DB::raw("DATE_FORMAT(tb_formpeny.tgl_kom, '%d-%m-%Y') as tgl_kom"),
                'tb_formpeny.nama_peny',
                'tb_formpeny.id_gi',
                'tb_formpeny.id_rtugi',
                'tb_formpeny.ketpeny',
                'tb_formpeny.nama_user',
                'tb_formpeny.pelrtu'
            );

        if ($fromDate && $toDate) {
            $query->whereBetween('tb_formpeny.tgl_kom', [$fromDate, $toDate]);
        }

        $penyulangans = $query->get()->toArray();
        $filename = "Data_Penyulangan_" . now()->format('d-m-Y') . ".csv";

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Tgl Komisioning', 'Nama Penyulang', 'Gardu Induk', 'Wilayah DCC', 'Keterangan', 'PIC Master', 'PIC RTU']);

        foreach ($penyulangans as $row) {
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

    public function create()
    {
        $rtugi = DB::table('tb_merkrtugi')->get();
        $medkom = DB::table('tb_medkom')->get();
        $garduinduk = DB::table('tb_garduinduk')->get();
        $komkp = DB::table('tb_komkp')->get();
        $pelms = DB::table('tb_picmaster')->get();
        return view('pages.penyulangan.add', compact('rtugi', 'medkom', 'garduinduk', 'komkp', 'pelms'));
    }

    public function store(Request $request)
    {
        // Preprocess id_pelms to ensure it's an array
        $idPelmsInput = $request->input('id_pelms', '');
        $idPelmsArray = !empty($idPelmsInput) ? array_filter(array_map('trim', explode(',', $idPelmsInput))) : [];

        // Define array fields that come from checkboxes
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

        // Validation rules
        $validated = $request->validate([
            'tgl_kom' => 'required|date',
            'nama_peny' => 'required|string|max:50',
            'id_gi' => 'required|string|max:25',
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
            'p_rtu' => 'nullable|string|max:50',
            'p_ms' => 'nullable|string|max:50',
            'p_scale' => 'nullable|string|max:50',
            'v_rtu' => 'nullable|string|max:50',
            'v_ms' => 'nullable|string|max:50',
            'v_scale' => 'nullable|string|max:50',
            'f_rtu' => 'nullable|string|max:50',
            'f_ms' => 'nullable|string|max:50',
            'f_scale' => 'nullable|string|max:50',
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',
            'nama_user' => 'nullable|string|max:10',
            'id_pelms' => ['required', function ($attribute, $value, $fail) use ($idPelmsArray) {
                if (empty($idPelmsArray)) {
                    $fail('The id pelms field must be an array and cannot be empty.');
                }
            }],
            'pelrtu' => 'required|string|max:25',
            'ketpeny' => 'required|string|max:500',
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

        // Merge preprocessed id_pelms array into validated data
        $validated['id_pelms'] = json_encode($idPelmsArray);

        // Create the record
        Penyulangan::create($validated);

        return redirect()->route('penyulangan.index')->with('success', 'Penyulangan created successfully!');
    }

    public function edit(string $id)
    {
        $penyulang = Penyulangan::findOrFail($id);
        $rtugi = DB::table('tb_merkrtugi')->get();
        $medkom = DB::table('tb_medkom')->get();
        $garduinduk = DB::table('tb_garduinduk')->get();
        $komkp = DB::table('tb_komkp')->get();
        $pelms = DB::table('tb_picmaster')->get();
        $decoded = json_decode($penyulang->id_pelms, true);
        $selectedPelms = is_array($decoded) ? $decoded : ($decoded ? [$decoded] : []);

        return view('pages.penyulangan.edit', compact('penyulang', 'rtugi', 'medkom', 'garduinduk', 'komkp', 'pelms', 'selectedPelms'));
    }

    public function update(Request $request, string $id)
    {
        $penyulang = Penyulangan::findOrFail($id);
        $idPelmsInput = $request->input('id_pelms', '');
        $idPelmsArray = !empty($idPelmsInput) ? array_filter(array_map('trim', explode(',', $idPelmsInput))) : [];

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
            'ctcl_5'
        ];

        $validated = $request->validate([
            'id_peny' => 'required|integer|exists:tb_formpeny,id_peny',
            'tgl_kom' => 'required|date',
            'nama_peny' => 'required|string|max:50',
            'id_gi' => 'required|string|max:25',
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
            'p_rtu' => 'nullable|string|max:50',
            'p_ms' => 'nullable|string|max:50',
            'p_scale' => 'nullable|string|max:50',
            'v_rtu' => 'nullable|string|max:50',
            'v_ms' => 'nullable|string|max:50',
            'v_scale' => 'nullable|string|max:50',
            'f_rtu' => 'nullable|string|max:50',
            'f_ms' => 'nullable|string|max:50',
            'f_scale' => 'nullable|string|max:50',
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',
            'nama_user' => 'nullable|string|max:10',
            'id_pelms' => ['required', function ($attribute, $value, $fail) use ($idPelmsArray) {
                if (empty($idPelmsArray)) {
                    $fail('The id pelms field must be an array and cannot be empty.');
                }
            }],
            'pelrtu' => 'required|string|max:25',
            'ketpeny' => 'required|string|max:500',
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
        $penyulang->update($validated);

        return redirect()->route('penyulangan.index')->with('success', 'Penyulangan updated successfully!');
    }


    public function clone($id)
    {
        $penyulang = Penyulangan::findOrFail($id);
        $rtugi = DB::table('tb_merkrtugi')->get();
        $medkom = DB::table('tb_medkom')->get();
        $garduinduk = DB::table('tb_garduinduk')->get();
        $komkp = DB::table('tb_komkp')->get();
        $pelms = DB::table('tb_picmaster')->get();
        $decoded = json_decode($penyulang->id_pelms, true);
        $selectedPelms = is_array($decoded) ? $decoded : ($decoded ? [$decoded] : []);
        return view('pages.penyulangan.clone', compact('penyulang', 'rtugi', 'medkom', 'garduinduk', 'komkp', 'pelms', 'selectedPelms'));
    }

    public function storeClone(Request $request)
    {
        // Preprocess id_pelms to ensure it's an array
        $idPelmsInput = $request->input('id_pelms', '');
        $idPelmsArray = !empty($idPelmsInput) ? array_filter(array_map('trim', explode(',', $idPelmsInput))) : [];

        // Define array fields that come from checkboxes
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

        // Validation rules
        $validated = $request->validate([
            'tgl_kom' => 'required|date',
            'nama_peny' => 'required|string|max:50',
            'id_gi' => 'required|string|max:25',
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
            'p_rtu' => 'nullable|string|max:50',
            'p_ms' => 'nullable|string|max:50',
            'p_scale' => 'nullable|string|max:50',
            'v_rtu' => 'nullable|string|max:50',
            'v_ms' => 'nullable|string|max:50',
            'v_scale' => 'nullable|string|max:50',
            'f_rtu' => 'nullable|string|max:50',
            'f_ms' => 'nullable|string|max:50',
            'f_scale' => 'nullable|string|max:50',
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',
            'nama_user' => 'nullable|string|max:10',
            'id_pelms' => ['required', function ($attribute, $value, $fail) use ($idPelmsArray) {
                if (empty($idPelmsArray)) {
                    $fail('The id pelms field must be an array and cannot be empty.');
                }
            }],
            'pelrtu' => 'required|string|max:25',
            'ketpeny' => 'required|string|max:500',
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

        // Merge preprocessed id_pelms array into validated data
        $validated['id_pelms'] = json_encode($idPelmsArray);

        // Create the record
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
