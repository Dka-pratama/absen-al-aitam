<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Data Siswa Kelas {{ $wali->kelas->nama_kelas }}</title>
        <style>
            body {
                font-family:
                    DejaVu Sans,
                    sans-serif;
                font-size: 12px;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                margin-top: 20px;
            }
            th,
            td {
                border: 1px solid #333;
                padding: 5px;
                text-align: center;
            }
            th {
                background-color: #eee;
            }
            td.text-left {
                text-align: left;
            }
        </style>
    </head>
    <body>
        <h2>Data Siswa Kelas {{ $wali->kelas->nama_kelas }}</h2>
        <p>Wali Kelas: {{ $wali->user->name }}</p>
        <p>
            Tahun Ajar:
            {{ $tahunAjarAktif->tahun }}
            / {{ ucfirst($semesterAktif->name) }}
        </p>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th class="text-left">Nama Siswa</th>
                    <th>NISN</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alpa</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataSiswa as $index => $s)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-left">{{ $s['nama'] }}</td>
                        <td>{{ $s['nisn'] }}</td>
                        <td>{{ $s['hadir'] }}</td>
                        <td>{{ $s['izin'] }}</td>
                        <td>{{ $s['sakit'] }}</td>
                        <td>{{ $s['alpa'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
