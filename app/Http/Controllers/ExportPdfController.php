<?php

namespace App\Http\Controllers;

use App\Models\Keypoint;
use Illuminate\Support\Facades\DB;
use TCPDF;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class ExportPdfController extends Controller
{
    public function exportpdf($id)
    {
        try {
            // Fetch the Keypoint record
            $keypoint = Keypoint::where('id_formkp', $id)->firstOrFail();

            // Fetch related data
            $merklbs = DB::table('tb_merklbs')->where('id_merkrtu', $keypoint->id_merkrtu)->value('nama_merklbs') ?? 'N/A';
            $modem = DB::table('tb_modem')->where('id_modem', $keypoint->id_modem)->value('nama_modem') ?? 'N/A';
            $medkom = DB::table('tb_medkom')->where('id_medkom', $keypoint->id_medkom)->value('nama_medkom') ?? 'N/A';
            $gi = DB::table('tb_garduinduk')->where('id_gi', $keypoint->id_gi)->value('nama_gi') ?? 'N/A';
            $sectoral = DB::table('tb_sectoral')->where('id_sec', $keypoint->id_sec)->value('nama_sec') ?? 'N/A';
            $komkp = DB::table('tb_komkp')->where('id_komkp', $keypoint->id_komkp)->value('jenis_komkp') ?? 'N/A';
            $picms = json_decode($keypoint->id_picms, true) ?? ['N/A'];

            // Prepare data for the view
            $data = [
                'formkp' => $keypoint,
                'merklbs' => $merklbs,
                'modem' => $modem,
                'medkom' => $medkom,
                'gi' => $gi,
                'sectoral' => $sectoral,
                'komkp' => $komkp,
                'picms' => $picms,
            ];

            // Generate filename with sanitized keypoint name
            $tanggal = now()->format('d-m-Y');
            $filename = "Hasil_Komisioning_Keypoint_" . str_replace(' ', '_', $keypoint->nama_lbs) . "_{$tanggal}.pdf";

            // Initialize TCPDF with landscape orientation
            $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetMargins(5, 5, 5, true);
            $pdf->SetFont('helvetica', '', 8);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage('L', 'A4');

            // Render the view to HTML
            $html = view('pdf.singlekeypoint', $data)->render();

            // Write HTML to PDF
            $pdf->writeHTML($html, true, false, true, false, '');

            // Stream the PDF as a download
            return response()->streamDownload(
                function () use ($pdf, $filename) {
                    $pdf->Output($filename, 'D');
                },
                $filename,
                ['Content-Type' => 'application/pdf']
            );
        } catch (Exception $e) {
            Log::error('Failed to generate PDF: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to generate PDF: ' . $e->getMessage(),
            ], 500);
        }
    }
}
