@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-4xl rounded-lg bg-white p-6 shadow">
        <div class="mb-4 flex gap-3">
            <a
                href="{{ route('absen.export.excel', $absen->id) }}"
                class="rounded bg-green-600 px-4 py-2 text-white shadow hover:bg-green-700"
            >
                Export Excel
            </a>

            <a
                href="{{ route('absen.export.pdf', $absen->id) }}"
                class="rounded bg-red-600 px-4 py-2 text-white shadow hover:bg-red-700"
            >
                Export PDF
            </a>
        </div>

        {{-- Informasi Dasar --}}
        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="rounded border bg-gray-50 p-4 shadow">
                <p class="text-sm text-gray-500">Tanggal</p>
                <p class="text-lg font-semibold">{{ $absen->tanggal }}</p>
            </div>

            <div class="rounded border bg-gray-50 p-4 shadow">
                <p class="text-sm text-gray-500">Kelas</p>
                <p class="text-lg font-semibold">{{ $absen->nama_kelas }}</p>
            </div>

            <div class="rounded border bg-gray-50 p-4 shadow">
                <p class="text-sm text-gray-500">Tahun Ajar</p>
                <p class="text-lg font-semibold">{{ $absen->tahun }} - {{ $absen->semester }}</p>
            </div>
        </div>

        {{-- Tabel Siswa --}}
        <h3 class="mb-3 text-xl font-semibold">Daftar Siswa & Kehadiran</h3>

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
                                        <span class="rounded bg-green-200 px-2 py-1 text-green-800">Hadir</span>

                                        @break
                                    @case('izin')
                                        <span class="rounded bg-yellow-200 px-2 py-1 text-yellow-800">Izin</span>

                                        @break
                                    @case('sakit')
                                        <span class="rounded bg-blue-200 px-2 py-1 text-blue-800">Sakit</span>

                                        @break
                                    @default
                                        <span class="rounded bg-red-200 px-2 py-1 text-red-800">Alpha</span>
                                @endswitch
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('absen.index') }}" class="rounded bg-gray-600 px-4 py-2 text-white">Kembali</a>
        </div>
    </div>
@endsection
