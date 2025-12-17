@extends('layouts.admin')

@section('content')
    <div class="mx-5 my-8 max-w-6xl space-y-8">
        <!-- Header -->
        <div class="rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 p-6 text-white shadow-lg">
            <h1 class="text-3xl font-bold">{{ $kelas->nama_kelas }}</h1>
            <p class="mt-2 text-lg opacity-90">
                Tahun Ajar Aktif:
                <span class="font-semibold">
                    {{ $tahunAjarAktif->tahun }} ({{ ucfirst($tahunAjarAktif->semester) }})
                </span>
            </p>
        </div>

        <!-- Card Utama -->
        <div class="rounded-xl bg-white p-6 shadow-md">
            <!-- Naik Kelas -->
            <div class="mb-10 rounded-xl bg-gray-50 p-6 shadow-inner">
                <h3 class="mb-4 text-2xl font-bold text-gray-800">Pindahkan Semua Siswa ke Kelas Lain</h3>

                <form action="{{ route('kelas.naik', $kelas->id) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">Pilih Kelas Tujuan</label>
                        <select name="kelas_tujuan" class="w-full rounded-lg border p-3 focus:ring focus:ring-blue-300">
                            <option value="">-- Pilih Kelas Tujuan --</option>
                            @foreach ($daftarKelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button
                        class="w-full rounded-lg bg-blue-600 px-5 py-3 text-base font-semibold text-white transition hover:bg-blue-700"
                    >
                        Pindahkan Semua Siswa
                    </button>
                </form>
            </div>
            <!-- Daftar Siswa -->
            <div class="">
                <h3 class="mb-4 text-2xl font-bold text-gray-800">Daftar Siswa</h3>

                @if ($siswa->count() == 0)
                    <p class="rounded-lg bg-gray-50 p-4 text-gray-600">
                        Belum ada siswa pada kelas ini di tahun ajar aktif.
                    </p>
                @else
                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="min-w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-left text-sm text-gray-700">
                                    <th class="border px-4 py-3">#</th>
                                    <th class="border px-4 py-3">NISN</th>
                                    <th class="border px-4 py-3">Nama Lengkap</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $index => $ks)
                                    <tr class="transition hover:bg-gray-50">
                                        <td class="border px-4 py-3 font-medium">{{ $index + 1 }}</td>
                                        <td class="border px-4 py-3">{{ $ks->siswa->NISN }}</td>
                                        <td class="border px-4 py-3">{{ $ks->siswa->user->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
