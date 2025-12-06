@extends('layouts.admin')

@section('content')
    <div class="mx-5 my-6">
        <div class="mx-auto max-w-4xl space-y-6 rounded-lg bg-white p-6 shadow-md">
            <!-- Header -->
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Detail Kelas</h2>
                <p class="mt-1 text-gray-600">
                    <span class="font-semibold">{{ $kelas->nama_kelas }}</span>
                    • Tahun Ajar Aktif:
                    <span class="font-semibold">
                        {{ $tahunAjarAktif->tahun }} ({{ ucfirst($tahunAjarAktif->semester) }})
                    </span>
                </p>
            </div>

            <hr class="my-4" />

            <!-- Daftar Siswa -->
            <div>
                <h3 class="mb-4 text-xl font-bold text-gray-800">Daftar Siswa</h3>

                @if ($siswa->count() == 0)
                    <p class="text-gray-600">Tidak ada siswa dalam kelas ini untuk tahun ajar aktif.</p>
                @else
                    <div class="overflow-x-auto rounded-lg border">
                        <table class="min-w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-left text-gray-700">
                                    <th class="border px-4 py-2">#</th>
                                    <th class="border px-4 py-2">NISN</th>
                                    <th class="border px-4 py-2">Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $index => $ks)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="border px-4 py-2">{{ $ks->siswa->NISN }}</td>
                                        <td class="border px-4 py-2">{{ $ks->siswa->user->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <hr class="my-4" />

            <!-- Tombol Naik Kelas -->
            <div class="mt-6 rounded-lg bg-gray-50 p-4">
                <h3 class="mb-2 text-lg font-bold">Naikkan Siswa Ke Kelas:</h3>

                <form action="{{ route('kelas.naik', $kelas->id) }}" method="POST">
                    @csrf

                    <select name="kelas_tujuan" class="mb-3 w-full rounded-lg border p-2">
                        <option value="">-- Pilih Kelas Tujuan --</option>
                        @foreach ($daftarKelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>

                    <button
                        class="w-full rounded-lg bg-blue-600 px-5 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                    >
                        Naikkan Semua
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
