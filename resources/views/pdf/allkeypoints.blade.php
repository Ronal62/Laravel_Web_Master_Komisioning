<!-- resources/views/pdf/allkeypoints.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Data Keypoint</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 5px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    h2 {
        text-align: center;
    }
    </style>
</head>

<body>
    <h2>Data Keypoint</h2>
    <table>
        <thead>
            <tr>
                <th>Tgl Komisioning</th>
                <th>Nama Keypoint</th>
                <th>GI & Penyulang</th>
                <th>Merk Modem & RTU</th>
                <th>Keterangan</th>
                <th>Master</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($keypoints as $keypoint)
            <tr>
                <td>{{ $keypoint->tgl_komisioning }}</td>
                <td>{{ $keypoint->nama_keypoint }}</td>
                <td>{{ $keypoint->gi_penyulang }}</td>
                <td>{{ $keypoint->merk_modem_rtu ?? 'N/A' }}</td>
                <td>{{ $keypoint->keterangan }}</td>
                <td>{{ $keypoint->master }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>