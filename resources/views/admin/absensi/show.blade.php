@extends('layouts.admin')

@section('content')

<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
<div class="flex gap-3 mb-4">
    <a href="{{ route('absen.export.excel', $absen->id) }}" 
       class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700">
        Export Excel
    </a>

    <a href="{{ route('absen.export.pdf', $absen->id) }}" 
       class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700">
        Export PDF
    </a>
</div>

    {{-- Informasi Dasar --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        <div class="p-4 border rounded bg-gray-50 shadow">
            <p class="text-sm text-gray-500">Tanggal</p>
            <p class="font-semibold text-lg">{{ $absen->tanggal }}</p>
        </div>

        <div class="p-4 border rounded bg-gray-50 shadow">
            <p class="text-sm text-gray-500">Kelas</p>
            <p class="font-semibold text-lg">{{ $absen->nama_kelas }}</p>
        </div>

        <div class="p-4 border rounded bg-gray-50 shadow">
            <p class="text-sm text-gray-500">Tahun Ajar</p>
            <p class="font-semibold text-lg">{{ $absen->tahun }} - {{ $absen->semester }}</p>
        </div>

    </div>

    {{-- Tabel Siswa --}}
    <h3 class="text-xl font-semibold mb-3">Daftar Siswa & Kehadiran</h3>

    <div class="overflow-x-auto">
        <table class="min-w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">No</th>
                    <th class="border px-3 py-2 text-left">Nama</th>
                    <th class="border px-3 py-2 text-left">NISN</th>
                    <th class="border px-3 py-2 text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail as $i => $d)
                <tr>
                    <td class="border px-3 py-2">{{ $i + 1 }}</td>
                    <td class="border px-3 py-2">{{ $d->name }}</td>
                    <td class="border px-3 py-2">{{ $d->NISN }}</td>
                    <td class="border px-3 py-2 text-center">
                        @switch($d->status)
                            @case('hadir')
                                <span class="bg-green-200 text-green-800 px-2 py-1 rounded">Hadir</span>
                                @break
                            @case('izin')
                                <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded">Izin</span>
                                @break
                            @case('sakit')
                                <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded">Sakit</span>
                                @break
                            @default
                                <span class="bg-red-200 text-red-800 px-2 py-1 rounded">Alpha</span>
                        @endswitch
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('absen.index') }}"
           class="bg-gray-600 text-white px-4 py-2 rounded">
            Kembali
        </a>
    </div>

</div>

@endsection
