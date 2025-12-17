@extends('layouts.walikelas')

@section('content')
    <div class="p-6">
        <!-- HEADER & EXPORT WRAPPER -->
        <div class="flex w-full flex-row items-center justify-between">
            <!-- Header -->
            <div class="mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Siswa Kelas {{ $wali->kelas->nama_kelas }}</h1>
                <p class="mt-1 text-gray-600">
                    Wali Kelas:
                    <span class="font-medium">{{ $wali->user->name }}</span>
                </p>
                <p class="text-gray-600">
                    Tahun Ajar:
                    <span class="font-medium">
                        {{ $tahunAjarAktif->tahun }} ({{ ucfirst($semesterAktif->name) }})
                    </span>
                </p>
            </div>

            <!-- Export Buttons -->
            <div class="mt-3 flex flex-wrap gap-3">
                <a
                    href="{{ route('siswa.export.excel', $wali->id) }}"
                    class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                >
                    Export Excel
                </a>

                <a
                    href="{{ route('siswa.export.pdf') }}"
                    class="rounded bg-blue-600 px-4 py-2 text-white transition hover:bg-blue-700"
                >
                    Export PDF
                </a>
            </div>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto rounded-lg bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">#</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nama Siswa</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">NISN</th>
                        <th class="px-4 py-2 text-center text-sm font-medium text-gray-500">Hadir</th>
                        <th class="px-4 py-2 text-center text-sm font-medium text-gray-500">Izin</th>
                        <th class="px-4 py-2 text-center text-sm font-medium text-gray-500">Sakit</th>
                        <th class="px-4 py-2 text-center text-sm font-medium text-gray-500">Alpa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($dataSiswa as $index => $siswa)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-600">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $siswa['nama'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $siswa['nisn'] }}</td>
                            <td class="px-4 py-2 text-center font-semibold text-green-600">{{ $siswa['hadir'] }}</td>
                            <td class="px-4 py-2 text-center font-semibold text-yellow-500">{{ $siswa['izin'] }}</td>
                            <td class="px-4 py-2 text-center font-semibold text-blue-500">{{ $siswa['sakit'] }}</td>
                            <td class="px-4 py-2 text-center font-semibold text-red-500">{{ $siswa['alpa'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
