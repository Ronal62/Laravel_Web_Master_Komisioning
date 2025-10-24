<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class AbsenController extends Controller
{
    public function index()
    {
        return view('pages.absen.index');
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
        $fromDate = $request->dari_tanggal;
        $toDate = $request->sampai_tanggal;

        $columnMap = [
            0 => 'tb_absensi.tgl_absen',
            1 => 'tb_absensi.tgl_absen',
            2 => 'tb_absensi.nama_absen',
            3 => 'tb_absensi.jenis_absen',
            4 => 'tb_absensi.ket_absen',
        ];
        $orderColumn = $columnMap[$orderColumnIndex] ?? 'tb_absensi.tgl_absen';

        $query = DB::table('tb_absensi')
            ->select(
                'tb_absensi.id_absens',
                'tb_absensi.tgl_absen',
                'tb_absensi.nama_absen',
                'tb_absensi.jenis_absen',
                'tb_absensi.ket_absen'
            );

        if ($fromDate && $toDate) {
            $query->whereBetween('tb_absensi.tgl_absen', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59']);
        } elseif ($fromDate) {
            $query->where('tb_absensi.tgl_absen', '>=', $fromDate . ' 00:00:00');
        } elseif ($toDate) {
            $query->where('tb_absensi.tgl_absen', '<=', $toDate . ' 23:59:59');
        }

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('tb_absensi.nama_absen', 'like', "%{$searchValue}%")
                    ->orWhere('tb_absensi.jenis_absen', 'like', "%{$searchValue}%")
                    ->orWhere('tb_absensi.ket_absen', 'like', "%{$searchValue}%")
                    ->orWhere('tb_absensi.tgl_absen', 'like', "%{$searchValue}%");
            });
        }

        foreach ($columns as $index => $col) {
            $colSearchValue = $col['search']['value'];
            if (!empty($colSearchValue) && $col['searchable'] == 'true') {
                switch ($index) {
                    case 0:
                        $query->where(DB::raw('DATE(tb_absensi.tgl_absen)'), 'like', "%{$colSearchValue}%");
                        break;
                    case 1:
                        $query->where(DB::raw('TIME(tb_absensi.tgl_absen)'), 'like', "%{$colSearchValue}%");
                        break;
                    case 2:
                        $query->where('tb_absensi.nama_absen', 'like', "%{$colSearchValue}%");
                        break;
                    case 3:
                        $query->where('tb_absensi.jenis_absen', 'like', "%{$colSearchValue}%");
                        break;
                    case 4:
                        $query->where('tb_absensi.ket_absen', 'like', "%{$colSearchValue}%");
                        break;
                }
            }
        }

        $totalRecords = DB::table('tb_absensi')->count();
        $totalFiltered = $query->count();
        $query->orderBy($orderColumn, $orderDir);
        $records = $query->offset($start)->limit($length)->get();

        $data = $records->map(function ($row) {
            $parsed = Carbon::parse($row->tgl_absen);
            $row->tgl_absen = $parsed->format('d-m-Y');
            $row->waktu = $parsed->format('H:i:s');
            return $row;
        })->toArray();

        return response()->json([
            'draw' => (int)$draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }


    public function create()
    {
        $jenisAbsens = collect([
            (object) ['jenis_absen' => 'Clock In'],
            (object) ['jenis_absen' => 'Clock Out'],
        ]);

        return view('pages.absen.add', compact('jenisAbsens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tgl_absen' => 'required|date',
            'jenis_absen' => 'required|in:Clock In,Clock Out',
            'ket_absen' => 'required|string|max:50',
            'nama_absen' => 'required|string|max:25',  // Add validation for the submitted field
        ]);

        // Use the submitted nama_absen (from the form) instead of re-fetching from Auth::user()
        // This prevents override issues and allows validation to catch empty values
        $absensi = new Absen();
        $absensi->nama_absen = $validated['nama_absen'];
        $absensi->tgl_absen = $validated['tgl_absen'];
        $absensi->jenis_absen = $validated['jenis_absen'];
        $absensi->ket_absen = $validated['ket_absen'];
        $absensi->save();

        return redirect()->route('absen.index')->with('success', 'Absensi created successfully.');
    }



}
