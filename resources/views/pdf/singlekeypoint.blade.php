<!DOCTYPE html>
<html>

<head>
    <title>Keypoint PDF</title>
</head>

<body>
    <h1>Keypoint: {{ $formkp->nama_lbs }}</h1>
    <p><strong>Tanggal Komisioning:</strong> {{ \Carbon\Carbon::parse($formkp->tgl_komisioning)->format('d-m-Y') }}</p>
    <p><strong>Keterangan:</strong> {{ $formkp->ketkp }}</p>
    <h3>PIC Master:</h3>
    <ul>
        @foreach($picmaster as $pic)
        <li>{{ $pic->nama_picmaster }}</li>
        @endforeach
    </ul>
</body>

</html>
