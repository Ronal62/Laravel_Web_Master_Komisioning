<!-- bydatepenyulangan_dompdf.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Penyulangan By Date - {{ $fromDate ?? 'All' }} to {{ $toDate ?? 'All' }}</title>
    <style>
    @page {
        margin: 5mm;
        size: A4 landscape;
    }

    /* Same styles as in singlepenyulangan_dompdf.blade.php */
    </style>
</head>

<body>
    @foreach($data as $index => $item)
    @php $row = $item['row']; @endphp
    @php $pelaksanaMs = $item['pelaksanaMs']; @endphp
    @php $pelaksanaRtu = $item['pelaksanaRtu']; @endphp
    @php $statusData = $item['statusData']; @endphp
    @php $controlData = $item['controlData']; @endphp
    @php $meteringData = $item['meteringData']; @endphp

    <!-- Copy the entire content from singlepenyulangan_dompdf.blade.php here, replacing variables accordingly -->
    {{-- ===== HEADER ===== --}}
    <table class="header-table border" style="margin-bottom: 8px;">
        <!-- ... (same as single) -->
    </table>

    {{-- ===== TITLE ===== --}}
    <div class="text-center" style="margin-bottom: 8px;">
        <!-- ... (same as single) -->
    </div>

    {{-- ===== DEVICE INFO ===== --}}
    <table class="device-info border" style="margin-bottom: 6px;">
        <!-- ... (same as single) -->
    </table>

    {{-- ===== MAIN CONTENT ===== --}}
    <table class="main-table">
        <!-- ... (same as single, including left and right columns) -->
    </table>

    {{-- ===== FOOTER ===== --}}
    <div class="border text-center italic" style="font-size: 8px; padding: 5px; margin-top: 6px;">
        <!-- ... (same as single) -->
    </div>

    @if(!$loop->last)
    <div style="page-break-after: always;"></div>
    @endif
    @endforeach
</body>

</html>
