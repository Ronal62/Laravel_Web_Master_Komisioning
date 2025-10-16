<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Data Penyulangan</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body>
    <h2>Data Penyulangan</h2>
    <table>
        <thead>
            <tr>
                <th>Tgl Komisioning</th>
                <th>Nama Penyulang</th>
                <th>Gardu Induk</th>
                <th>Wilayah DCC</th>
                <th>Keterangan</th>
                <th>PIC Master</th>
                <th>PIC RTU</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penyulangans as $penyulang)
            <tr>
                <td>{{ $penyulang->tgl_kom }}</td>
                <td>{{ $penyulang->nama_peny }}</td>
                <td>{{ $penyulang->id_gi }}</td>
                <td>{{ $penyulang->id_rtugi }}</td>
                <td>{{ $penyulang->ketpeny }}</td>
                <td>{{ $penyulang->nama_user }}</td>
                <td>{{ $penyulang->pelrtu }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
