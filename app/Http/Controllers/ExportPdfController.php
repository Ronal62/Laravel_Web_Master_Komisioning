<?php

namespace App\Http\Controllers;

use App\Models\Keypoint;
use Illuminate\Support\Facades\DB;
use TCPDF;
use Illuminate\Http\Response;
use Exception;


class ExportPdfController extends Controller
{
    /**
     * Export a Keypoint record as a PDF.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function exportpdf($id)
    {
        try {
            // Fetch the Keypoint record
            $keypoint = Keypoint::where('id_formkp', $id)->firstOrFail();

            // Fetch picmaster data
            $picmaster = DB::table('tb_picmaster')->get();

            // Prepare data for the view
            $data = [
                'formkp' => $keypoint,
                'picmaster' => $picmaster,
            ];

            // Generate filename with sanitized keypoint name
            $tanggal = now()->format('d-m-Y');
            $filename = "Hasil_Komisioning_Keypoint_" . str_replace(' ', '_', $keypoint->nama_lbs) . "_{$tanggal}.pdf";

            // Initialize TCPDF
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetMargins(15, 10, 15, true);
            $pdf->SetFont('helvetica', '', 11);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage('P', 'A4');

            // Render the view to HTML
            $html = view('pdf.singlekeypoint', $data)->render();

            // Write HTML to PDF
            $pdf->writeHTML($html, true, false, true, false, '');

            // Stream the PDF as a download
            return response()->streamDownload(
                function () use ($pdf, $filename) {
                    $pdf->Output($filename, 'I'); // 'I' for inline display, use 'D' for download
                },
                $filename,
                ['Content-Type' => 'application/pdf']
            );
        } catch (Exception $e) {

            // Return a user-friendly error response
            return response()->json([
                'error' => 'Failed to generate PDF: ' . $e->getMessage(),
            ], 500);
        }
    }
}
