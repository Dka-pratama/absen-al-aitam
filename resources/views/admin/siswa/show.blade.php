@extends('layouts.admin')

@section('content')
<div class="max-w-3xl my-5 mx-5">

    <div class="bg-white shadow-md rounded-lg p-6 space-y-4">
        <h2 class="text-2xl font-bold mb-6">Detail Siswa</h2>

        <div>
            <p class="text-gray-600 text-sm">Nama</p>
            <p class="font-semibold text-lg">{{ $siswa->user->name }}</p>
        </div>

        <div>
            <p class="text-gray-600 text-sm">Username</p>
            <p class="font-semibold text-lg">{{ $siswa->user->username }}</p>
        </div>

        <div>
            <p class="text-gray-600 text-sm">NISN</p>
            <p class="font-semibold text-lg">{{ $siswa->NISN }}</p>
        </div>

        <div>
            <p class="text-gray-600 text-sm">Kelas</p>
            <p class="font-semibold text-lg">
                {{ $siswa->kelas->nama_kelas ?? '-' }}
            </p>
        </div>
        <div>
            <p class="text-gray-600 text-sm">Jurusan</p>
            <p class="font-semibold text-lg">
                {{ $siswa->kelas->jurusan ?? '-' }}
            </p>
        </div>

        <hr class="my-4">

        <h3 class="text-xl font-bold">Rekap Absensi</h3>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <div class="p-4 bg-green-100 text-center rounded-lg">
                <p class="text-gray-600 text-sm">Hadir</p>
                <p class="text-xl font-semibold text-green-700">{{ $hadir }}</p>
            </div>

            <div class="p-4 bg-yellow-100 text-center rounded-lg">
                <p class="text-gray-600 text-sm">Sakit</p>
                <p class="text-xl font-semibold text-yellow-700">{{ $sakit }}</p>
            </div>

            <div class="p-4 bg-blue-100 text-center rounded-lg">
                <p class="text-gray-600 text-sm">Izin</p>
                <p class="text-xl font-semibold text-blue-700">{{ $izin }}</p>
            </div>

            <div class="p-4 bg-red-100 text-center rounded-lg">
                <p class="text-gray-600 text-sm">Alpa</p>
                <p class="text-xl font-semibold text-red-700">{{ $alpa }}</p>
            </div>

        </div>

    </div>
</div>
@endsection
