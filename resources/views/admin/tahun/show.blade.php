@extends('layouts.admin')

@section('content')
    <div class="p-4 md:p-6">
        {{-- TITLE --}}
        <div class="mb-6 flex items-center justify-end">
            <div class="flex gap-2">
                <a
                    href="{{ route('tahun.edit', $semester->tahun_ajar_id) }}"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                >
                    Edit
                </a>

                @if ($semester->status === 'aktif' && $semester->tahunAjar->status === 'aktif')
                    <form action="{{ route('tahun.deactivate', $semester->id) }}" method="POST">
                        @csrf
                        <button class="rounded-lg bg-gray-500 px-4 py-2 text-white hover:bg-gray-600">
                            Nonaktifkan
                        </button>
                    </form>
                @else
                    <form action="{{ route('tahun.activate', $semester->id) }}" method="POST">
                        @csrf
                        <button class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                            Aktifkan
                        </button>
                    </form>
                @endif

                <form
                    action="{{ route('tahun.destroy', $semester->tahunAjar->id) }}"
                    method="POST"
                    class="inline"
                    data-confirm
                    data-title="Hapus Data Tahun?"
                    data-text=" ini akan menghapus 1 tahun 2 semester!!
                    Data yang terhapus tidak bisa di kembalikan"
                    data-icon="error"
                >
                    @csrf
                    @method('DELETE')
                    <button class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700">Hapus</button>
                </form>
            </div>
        </div>

        {{-- CARD INFORMASI --}}
        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-xl border bg-white p-4 shadow">
                <h2 class="mb-3 text-lg font-semibold">Informasi Tahun Ajar</h2>

                <div class="space-y-2 text-sm">
                    <div>
                        <strong>Tahun:</strong>
                        {{ $semester->tahunAjar->tahun }}
                    </div>
                    <div>
                        <strong>Semester:</strong>
                        {{ ucfirst($semester->name) }}
                    </div>
                    <div>
                        <strong>Status:</strong>
                        <span
                            class="{{ $semester->status === 'aktif' && $semester->tahunAjar->status === 'aktif' ? 'bg-green-600' : 'bg-gray-500' }} rounded px-2 py-1 text-white"
                        >
                            @if ($semester->status === 'aktif' && $semester->tahunAjar->status === 'aktif')
                                <span class="font-semibold">Aktif</span>
                            @else
                                <span class="">Non-Aktif</span>
                            @endif
                        </span>
                    </div>
                    <div>
                        <strong>Dibuat:</strong>
                        {{ $semester->created_at->format('d M Y') }}
                    </div>
                    <div>
                        <strong>Terakhir Update:</strong>
                        {{ $semester->updated_at->format('d M Y') }}
                    </div>
                </div>
            </div>

            {{-- STATISTIK --}}
            <div class="rounded-xl border bg-white p-4 shadow">
                <h2 class="mb-3 text-lg font-semibold">Statistik Absensi</h2>

                <div class="grid grid-cols-2 gap-3 text-center">
                    <div class="rounded-lg bg-green-50 p-3 shadow">
                        <div class="text-xl font-bold">{{ $stats['hadir'] }}</div>
                        <div class="text-sm text-gray-600">Hadir</div>
                    </div>

                    <div class="rounded-lg bg-blue-50 p-3 shadow">
                        <div class="text-xl font-bold">{{ $stats['izin'] }}</div>
                        <div class="text-sm text-gray-600">Izin</div>
                    </div>

                    <div class="rounded-lg bg-yellow-50 p-3 shadow">
                        <div class="text-xl font-bold">{{ $stats['sakit'] }}</div>
                        <div class="text-sm text-gray-600">Sakit</div>
                    </div>

                    <div class="rounded-lg bg-red-50 p-3 shadow">
                        <div class="text-xl font-bold">{{ $stats['alfa'] }}</div>
                        <div class="text-sm text-gray-600">Alfa</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- REKAP KELAS --}}
        <div class="mt-8">
            <h2 class="mb-3 text-lg font-semibold">Rekap Absensi Per Kelas</h2>

            <div class="overflow-hidden rounded-xl border bg-white shadow">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">No</th>
                            <th class="p-3 text-left">Nama Kelas</th>
                            <th class="p-3 text-left">Total Absensi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($rekapKelas as $i => $k)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $i + 1 }}</td>
                                <td class="p-3">{{ $k->nama_kelas }}</td>
                                <td class="p-3">{{ $k->absensi_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
