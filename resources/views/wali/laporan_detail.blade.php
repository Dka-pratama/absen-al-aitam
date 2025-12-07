@extends('layouts.walikelas')

@section('content')
    <div class="p-6">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detail Absensi Kelas {{ $wali->kelas->nama_kelas }}</h1>
            <p class="text-gray-500">Wali Kelas: {{ $wali->user->name }}</p>
            <p class="text-gray-500">Tanggal: {{ $tanggal }}</p>
            <p class="text-gray-500">Tahun Ajar: {{ $wali->tahunAjar->tahun }} ({{ $wali->tahunAjar->semester }})</p>
        </div>

        {{-- Tabel Absensi --}}
        <div class="overflow-x-auto rounded-lg border bg-white shadow">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">No</th>
                        <th class="p-3 text-left">Nama Siswa</th>
                        <th class="p-3 text-left">NISN</th>
                        <th class="p-3 text-center">Status</th>
                        <th class="p-3 text-left">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($absensi as $i => $a)
                        <tr class="border-b hover:bg-gray-50 text-center">
                            <td class="p-3 text-left">{{ $i + 1 }}</td>
                            <td class="p-3 text-left">
                                {{ $a->kelasSiswa?->siswa?->user?->name ?? 'Data siswa tidak tersedia' }}
                            </td>
                            <td class="p-3 text-left">
                                {{ $a->kelasSiswa?->siswa?->NISN ?? '-' }}
                            </td>

                            <td class="p-3">
                                @php
                                    $statusColor = match ($a->status) {
                                        'hadir' => 'bg-green-200 text-green-800',
                                        'izin' => 'bg-yellow-200 text-yellow-800',
                                        'sakit' => 'bg-orange-200 text-orange-800',
                                        'alpa' => 'bg-red-200 text-red-800',
                                        default => 'bg-gray-200 text-gray-800',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded {{ $statusColor }}">
                                    {{ ucfirst($a->status) }}
                                </span>
                            </td>
                            <td class="p-3 text-left">{{ $a->keterangan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-3 text-center text-gray-500">
                                Tidak ada data absensi untuk tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Tombol Kembali --}}
        <div class="mt-4">
            <a href="{{ route('wali.laporan') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                ← Kembali
            </a>
        </div>
    </div>
@endsection
