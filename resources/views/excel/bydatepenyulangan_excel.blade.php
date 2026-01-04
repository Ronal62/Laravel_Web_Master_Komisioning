<!-- bydatepenyulangan_excel.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Penyulangan By Date - {{ $fromDate ?? 'All' }} to {{ $toDate ?? 'All' }}</title>
    <style>
    /* Same styles as in singlepenyulangan_excel.blade.php */
    </style>
</head>

<body>
    <h1 class="header-title">Penyulangan Report By Date: {{ $fromDate ?? 'All' }} - {{ $toDate ?? 'All' }}</h1>

    @foreach($data as $index => $item)
    <div style="page-break-after: always;">
        <!-- For print view, but in Excel it's approximate -->
        @php $row = $item['row']; @endphp
        @php $pelaksanaMs = $item['pelaksanaMs']; @endphp
        @php $pelaksanaRtu = $item['pelaksanaRtu']; @endphp
        @php $statusData = $item['statusData']; @endphp
        @php $controlData = $item['controlData']; @endphp
        @php $meteringData = $item['meteringData']; @endphp

        <!-- Copy the entire content from singlepenyulangan_excel.blade.php here, replacing variables accordingly -->
        {{-- ===== HEADER SECTION ===== --}}
        <table class="no-border" style="margin-bottom: 10px;">
            <!-- ... (same as single) -->
        </table>

        {{-- ===== TITLE ===== --}}
        <table class="no-border" style="margin-bottom: 10px;">
            <!-- ... (same as single) -->
        </table>

        {{-- ===== DEVICE INFO ===== --}}
        <table style="margin-bottom: 15px;">
            <!-- ... (same as single) -->
        </table>

        {{-- ===== STATUS TABLE ===== --}}
        <table style="margin-bottom: 15px;">
            <!-- ... (same as single, using $statusData) -->
        </table>

        {{-- ===== CONTROL TABLE ===== --}}
        <table style="margin-bottom: 15px;">
            <!-- ... (same as single, using $controlData) -->
        </table>

        {{-- ===== METERING TABLE ===== --}}
        <table style="margin-bottom: 15px;">
            <!-- ... (same as single, using $meteringData) -->
        </table>

        {{-- ===== ADDITIONAL INFO SECTION ===== --}}
        <table style="margin-bottom: 15px;">
            <!-- ... (same as single) -->
        </table>

        {{-- ===== PELAKSANA SECTION ===== --}}
        <table style="margin-bottom: 15px;">
            <!-- ... (same as single, using $pelaksanaMs and $pelaksanaRtu) -->
        </table>

        {{-- ===== FOOTER ===== --}}
        <table class="no-border">
            <!-- ... (same as single) -->
        </table>
    </div>
    @endforeach
</body>

</html>
