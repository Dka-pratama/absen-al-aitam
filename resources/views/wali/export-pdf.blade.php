<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <title>Rekap Absensi</title>
        <style>
            body {
                font-family:
                    DejaVu Sans,
                    sans-serif;
                font-size: 12px;
            }
            h1,
            h2 {
                text-align: center;
                margin: 0;
            }
            .info {
                margin: 15px 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }
            th,
            td {
                border: 1px solid #000;
                padding: 6px;
                text-align: center;
            }
            th {
                background: #f0f0f0;
            }
            .left {
                text-align: left;
            }
            .footer {
                margin-top: 20px;
                text-align: right;
            }
        </style>
    </head>
    <body>
        <h1>LAPORAN REKAP ABSENSI</h1>
        <h2>{{ $kelas->nama_kelas }}</h2>

        <div class="info">
            <strong>Periode:</strong>
            {{ $dari }} s/d {{ $sampai }}
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th class="left">Nama Siswa</th>
                    <th>NISN</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alpa</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekap as $i => $r)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="left">{{ $r->name }}</td>
                        <td>{{ $r->NISN }}</td>
                        <td>{{ $r->hadir }}</td>
                        <td>{{ $r->izin }}</td>
                        <td>{{ $r->sakit }}</td>
                        <td>{{ $r->alpa }}</td>
                        <td>{{ $r->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">Dicetak pada {{ now()->format('d-m-Y') }}</div>
    </body>
</html>
