@extends('layouts.admin')

@section('content')
<div class="mx-5 my-5 max-w-3xl">
    <div class="space-y-4 rounded-lg bg-white p-6 shadow-md">
        <h2 class="mb-6 text-2xl font-bold">Detail Kelas</h2>

        <div>
            <p class="text-sm text-gray-600">Nama Kelas</p>
            <p class="text-lg font-semibold">{{ $kelas->nama_kelas }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-600">Jurusan</p>
            <p class="text-lg font-semibold">{{ $kelas->jurusan }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-600">Jumlah Siswa (Tahun {{ $tahunAktif->tahun }})</p>
            <p class="text-lg font-semibold">{{ $jumlahSiswa }}</p>
        </div>

        <hr class="my-4">

        {{-- NAIKKAN KELAS --}}
        <h3 class="text-xl font-bold">Naik Kelas Massal</h3>

        <form action="{{ route('kelas.naik', $kelas->id) }}" method="POST" class="space-y-3">
            @csrf

            <label class="block">
                <span class="text-sm text-gray-600">Pilih Kelas tujuan</span>
                <select name="kelas_tujuan_id"
                    class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->id }}">
                            {{ $k->nama_kelas }} ({{ $k->jurusan }})
                        </option>
                    @endforeach
                </select>
            </label>

            <button
                class="rounded-lg bg-blue-600 px-4 py-2 text-white font-semibold hover:bg-blue-700 shadow">
                Naikkan Semua Siswa
            </button>
        </form>

        <hr class="my-4">

        {{-- LIST SISWA --}}
        <h3 class="text-xl font-bold mb-3">Daftar Siswa</h3>

        @if ($siswaList->count() == 0)
            <p class="text-gray-500">Belum ada siswa di kelas ini untuk tahun ajar ini.</p>
        @else
            <table class="w-full text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">No</th>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">NISN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswaList as $i => $pivot)
                        <tr>
                            <td class="p-2 border">{{ $i + 1 }}</td>
                            <td class="p-2 border">{{ $pivot->siswa->user->name }}</td>
                            <td class="p-2 border">{{ $pivot->siswa->NISN }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="mt-6">
            <a href="{{ route('kelas.index') }}"
                class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold hover:bg-gray-300">
                ← Kembali
            </a>
        </div>

    </div>
</div>
@endsection
