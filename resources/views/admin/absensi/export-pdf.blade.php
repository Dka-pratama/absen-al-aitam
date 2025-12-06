<!DOCTYPE html>
<html>
<head>
    <title>Export PDF Absensi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 6px; text-align: left; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="title">Detail Absensi</div>

    <p><strong>Tanggal:</strong> {{ $absen->tanggal }}</p>
    <p><strong>Kelas:</strong> {{ $absen->nama_kelas }}</p>
    <p><strong>Tahun Ajar:</strong> {{ $absen->tahun }} - {{ $absen->semester }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $i => $d)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->NISN }}</td>
                <td>{{ ucfirst($d->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
