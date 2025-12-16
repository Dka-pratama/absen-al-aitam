@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-3xl p-4 sm:p-6">

    {{-- HEADER --}}
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800 sm:text-2xl">
            Promosi / Kenaikan Kelas
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Tahun ajar aktif: 
            <span class="font-semibold text-green-700">
                {{ $tahunAktif->nama }}
            </span>
        </p>
    </div>

    {{-- CARD --}}
    <div class="rounded-xl border bg-white p-5 shadow-sm">

        <form method="POST" action="{{ route('promosi.store') }}" class="space-y-5">
            @csrf

            {{-- KELAS ASAL --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Kelas Asal (Tahun Sebelumnya)
                </label>
                <select
                    name="kelas_asal_id"
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-green-500 focus:ring-green-500"
                    required
                >
                    <option value="">-- Pilih kelas asal --</option>
                    @foreach ($kelasAsal as $kelas)
                        <option value="{{ $kelas->id }}">
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                @error('kelas_asal_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- KELAS TUJUAN --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Kelas Tujuan (Tahun Aktif)
                </label>
                <select
                    name="kelas_tujuan_id"
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-green-500 focus:ring-green-500"
                    required
                >
                    <option value="">-- Pilih kelas tujuan (harus kosong) --</option>
                    @foreach ($kelasTujuan as $kelas)
                        <option value="{{ $kelas->id }}">
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                @error('kelas_tujuan_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- INFO --}}
            <div class="rounded-lg bg-yellow-50 p-3 text-sm text-yellow-800">
                <ul class="list-disc pl-5 space-y-1">
                    <li>Kelas tujuan harus masih kosong</li>
                    <li>Absensi tahun sebelumnya tidak akan berubah</li>
                    <li>Data promosi tidak bisa dibatalkan otomatis</li>
                </ul>
            </div>

            {{-- ACTION --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                <a
                    href="{{ route('kelas.index') }}"
                    class="rounded-lg border px-4 py-2 text-center text-sm text-gray-700 hover:bg-gray-100"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700"
                    onclick="return confirm('Yakin ingin mempromosikan semua siswa di kelas ini?')"
                >
                    Promosikan Siswa
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
