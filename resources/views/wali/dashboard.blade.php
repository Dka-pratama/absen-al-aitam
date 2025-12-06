@extends('layouts.walikelas')

@section('title', 'Dashboard Wali Kelas')

@section('content')

    {{-- Header --}}
    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        Dashboard Wali Kelas
    </h2>

    {{-- Informasi Wali Kelas --}}
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4">Informasi Wali Kelas</h3>

        <p><b>Nama:</b> {{ $user->name }}</p>
        <p><b>NUPTK:</b> {{ $wali->NUPTK }}</p>
        <p><b>Kelas:</b> {{ $wali->kelas->nama_kelas }}</p>
        <p><b>Tahun Ajar:</b> {{ $wali->tahunAjar->tahun }} ({{ $wali->tahunAjar->semester }})</p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-blue-600 text-white p-6 rounded-lg shadow">
            <div class="text-3xl font-bold">{{ $jumlahSiswa }}</div>
            <div>Jumlah Siswa</div>
        </div>

        <div class="bg-green-600 text-white p-6 rounded-lg shadow">
            <div class="text-3xl font-bold">{{ $absensiHariIni }}</div>
            <div>Absensi Hari Ini</div>
        </div>

        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow">
            <div class="text-2xl font-bold">Kelas {{ $wali->kelas->nama_kelas }}</div>
            <div>Homeroom</div>
        </div>

    </div>

    {{-- Menu Aksi --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">

        <a href="#"
           class="bg-white border p-6 rounded-lg shadow hover:bg-gray-100 text-center">
            <h4 class="text-lg font-bold">Data Siswa</h4>
            <p class="text-gray-600 text-sm mt-2">Lihat daftar siswa</p>
        </a>

        <a href="#"
           class="bg-white border p-6 rounded-lg shadow hover:bg-gray-100 text-center">
            <h4 class="text-lg font-bold">Input Absensi</h4>
            <p class="text-gray-600 text-sm mt-2">Isi absensi hari ini</p>
        </a>

        <a href="#"
           class="bg-white border p-6 rounded-lg shadow hover:bg-gray-100 text-center">
            <h4 class="text-lg font-bold">Rekap Absensi</h4>
            <p class="text-gray-600 text-sm mt-2">Lihat laporan absensi</p>
        </a>

    </div>

@endsection
