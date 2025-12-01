<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function exportPdf(Request $request)
    {
        try {
            // Get filter parameters
            $fromDate = $request->input('dari_tanggal');
            $toDate = $request->input('sampai_tanggal');

            // Build query with filters
            $query = $this->buildExportQuery($fromDate, $toDate);

            // Get all data (no pagination for export)
            $records = $query->get();

            // Check if data exists
            if ($records->isEmpty()) {
                return redirect()->back()->with('warning', 'Tidak ada data untuk diekspor.');
            }

            // Format data for PDF
            $formattedData = $this->formatDataForExport($records);

            // Generate period text
            $periodText = $this->generatePeriodText($fromDate, $toDate);

            // Prepare PDF data - make sure all variables are defined
            $pdfData = [
                'data' => $formattedData,
                'periodText' => $periodText ?? 'Semua Data',
                'totalRecords' => $formattedData->count(),
                'exportDate' => Carbon::now()->format('d-m-Y H:i:s'),
                'fromDate' => $fromDate ? Carbon::parse($fromDate)->format('d M Y') : null,
                'toDate' => $toDate ? Carbon::parse($toDate)->format('d M Y') : null,
            ];

            // Generate PDF
            $pdf = Pdf::loadView('pages.absen.pdf', $pdfData);
            $pdf->setPaper('A4', 'landscape');

            // Optional: Set options for better rendering
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

            // Generate filename
            $filename = $this->generateFilename($fromDate, $toDate);

            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error('PDF Export Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            // Return JSON for debugging
            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    /**
     * Build query for export with date filters
     */
    private function buildExportQuery($fromDate, $toDate)
    {
        $query = DB::table('tb_absensi')
            ->select(
                'tb_absensi.tgl_absen',
                'tb_absensi.nama_absen',
                'tb_absensi.jenis_absen',
                'tb_absensi.ket_absen'
            );

        // Apply date filters
        if ($fromDate && $toDate) {
            $query->whereBetween('tb_absensi.tgl_absen', [
                $fromDate . ' 00:00:00',
                $toDate . ' 23:59:59'
            ]);
        } elseif ($fromDate) {
            $query->where('tb_absensi.tgl_absen', '>=', $fromDate . ' 00:00:00');
        } elseif ($toDate) {
            $query->where('tb_absensi.tgl_absen', '<=', $toDate . ' 23:59:59');
        }

        $query->orderBy('tb_absensi.tgl_absen', 'desc');

        return $query;
    }

    /**
     * Format data for export
     */
    private function formatDataForExport($records)
    {
        return $records->map(function ($row) {
            $parsed = Carbon::parse($row->tgl_absen);
            return [
                'tgl_absen' => $parsed->format('d-m-Y'),
                'waktu' => $parsed->format('H:i:s'),
                'hari' => $parsed->locale('id')->isoFormat('dddd'),
                'nama_absen' => $row->nama_absen,
                'jenis_absen' => $row->jenis_absen,
                'ket_absen' => $row->ket_absen,
            ];
        });
    }

    /**
     * Generate period text for display
     */
    private function generatePeriodText($fromDate, $toDate)
    {
        if ($fromDate && $toDate) {
            return Carbon::parse($fromDate)->format('d M Y') . ' s/d ' . Carbon::parse($toDate)->format('d M Y');
        } elseif ($fromDate) {
            return 'Dari ' . Carbon::parse($fromDate)->format('d M Y');
        } elseif ($toDate) {
            return 'Sampai ' . Carbon::parse($toDate)->format('d M Y');
        }

        return 'Semua Data';
    }

    /**
     * Generate filename for export
     */
    private function generateFilename($fromDate, $toDate)
    {
        $timestamp = Carbon::now()->format('Ymd_His');

        if ($fromDate && $toDate) {
            $from = Carbon::parse($fromDate)->format('Ymd');
            $to = Carbon::parse($toDate)->format('Ymd');
            return "Absensi_{$from}_to_{$to}_{$timestamp}.pdf";
        }

        return "Absensi_Export_{$timestamp}.pdf";
    }

    public function create()
    {
        $jenisAbsens = collect([
            (object) ['jenis_absen' => 'Clock In'],
            (object) ['jenis_absen' => 'Clock Out'],
        ]);

        return view('pages.absen.add', compact('jenisAbsens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tgl_absen' => 'required|date',
            'jenis_absen' => 'required|in:Clock In,Clock Out',
            'ket_absen' => 'required|string|max:50',
            'nama_absen' => 'required|string|max:25',
        ]);

        $absensi = new Absen();
        $absensi->nama_absen = $validated['nama_absen'];
        $absensi->tgl_absen = $validated['tgl_absen'];
        $absensi->jenis_absen = $validated['jenis_absen'];
        $absensi->ket_absen = $validated['ket_absen'];
        $absensi->save();

        return redirect()->route('absen.index')->with('success', 'Absensi created successfully.');
    }
}
