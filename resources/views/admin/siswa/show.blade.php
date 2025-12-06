@extends('layouts.admin')

@section('content')
<div class="flex justify-center mt-10">
    <div class="w-full max-w-3xl">
        <div class="rounded-lg bg-white p-8 shadow-lg">
            <h2 class="mb-6 text-center text-3xl font-bold">{{ $Header }}</h2>

            {{-- Informasi Siswa --}}
            <div class="space-y-6">

                <div>
                    <p class="text-sm text-gray-600">Nama</p>
                    <p class="text-lg font-semibold">{{ $siswa->user->name }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Username</p>
                    <p class="text-lg font-semibold">{{ $siswa->user->username }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">NISN</p>
                    <p class="text-lg font-semibold">{{ $siswa->NISN }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Kelas</p>
                    <p class="text-lg font-semibold">
                        {{ $kelasAktif->nama_kelas ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Jurusan</p>
                    <p class="text-lg font-semibold">
                        {{ $kelasAktif->jurusan ?? '-' }}
                    </p>
                </div>
            </div>

            <hr class="my-6" />

            {{-- Rekap Absensi --}}
            <h3 class="text-xl font-bold text-center mb-4">Rekap Absensi</h3>

            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">

                <div class="rounded-lg bg-green-100 p-4 text-center">
                    <p class="text-sm text-gray-600">Hadir</p>
                    <p class="text-xl font-semibold text-green-700">{{ $hadir }}</p>
                </div>

                <div class="rounded-lg bg-yellow-100 p-4 text-center">
                    <p class="text-sm text-gray-600">Sakit</p>
                    <p class="text-xl font-semibold text-yellow-700">{{ $sakit }}</p>
                </div>

                <div class="rounded-lg bg-blue-100 p-4 text-center">
                    <p class="text-sm text-gray-600">Izin</p>
                    <p class="text-xl font-semibold text-blue-700">{{ $izin }}</p>
                </div>

                <div class="rounded-lg bg-red-100 p-4 text-center">
                    <p class="text-sm text-gray-600">Alpa</p>
                    <p class="text-xl font-semibold text-red-700">{{ $alpa }}</p>
                </div>
            </div>

            <div class="mt-8 flex justify-center">
                <a href="{{ route('akun-siswa.index') }}"
                    class="rounded-lg bg-gray-200 px-6 py-2 text-sm font-semibold hover:bg-gray-300">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
