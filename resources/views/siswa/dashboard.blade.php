@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="max-w-sm mx-auto bg-white min-h-screen rounded-3xl shadow-lg overflow-hidden">

    {{-- HEADER --}}
    <div class="bg-green-600 text-white p-5">
        <h1 class="text-lg font-bold leading-tight">
            AL-AITAAM PRESENSI MANAGEMENT SYSTEM
        </h1>
    </div>

    {{-- USER INFO --}}
    <div class="flex items-center gap-3 p-4">
        <img src="https://via.placeholder.com/60"
             class="w-14 h-14 rounded-full object-cover">
        <div>
            <h3 class="font-bold text-gray-800">Ari Rudianyah</h3>
            <p class="text-sm text-gray-600">XII RPL 1</p>
        </div>
    </div>

    {{-- PRESENSI CARD --}}
    <div class="px-4">
        <div class="bg-green-600 text-white rounded-xl p-4">

            <h2 class="text-xl font-bold mb-1">Presensi Hari Ini</h2>
            <p class="text-sm mb-4">
                Status :
                <span class="font-semibold">Belum Presensi</span>
            </p>

          <div class="flex flex-col items-center gap-3">

   {{-- Tombol Scan QR --}}
    <button
        class="w-64 bg-gray-300 text-gray-800 font-semibold py-2 rounded-lg flex items-center justify-center gap-2">
        <span>📷</span> Scan QR Sekarang
    </button>

    {{-- Tombol Presensi Mandiri --}}
    <button
        class="w-64 bg-gray-300 text-gray-800 font-semibold py-2 rounded-lg flex items-center justify-center gap-2">
        <span>✔️</span> Presensi Mandiri
    </button>

</div>



        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="flex justify-between px-6 mt-4">
        <div class="text-center bg-white p-2 shadow rounded-xl w-20">
            <p class="text-sm font-semibold text-gray-700">Alpa</p>
            <p class="text-lg font-bold text-gray-800">3</p>
        </div>

        <div class="text-center bg-white p-2 shadow rounded-xl w-20">
            <p class="text-sm font-semibold text-gray-700">Izin</p>
            <p class="text-lg font-bold text-gray-800">3</p>
        </div>

        <div class="text-center bg-white p-2 shadow rounded-xl w-20">
            <p class="text-sm font-semibold text-gray-700">Sakit</p>
            <p class="text-lg font-bold text-gray-800">1</p>
        </div>
    </div>

    {{-- REKAP --}}
    <div class="px-4 mt-6">
        <h3 class="font-bold text-lg text-gray-800">
            Rekap Absen 1 Semester
        </h3>

        <button class="w-full mt-3 bg-green-500 text-white py-2 rounded-lg font-semibold">
            Lihat Rekap Detail >
        </button>
    </div>

    {{-- RIWAYAT --}}
    <div class="px-4 mt-6 mb-5">
        <div class="flex justify-between items-center mb-2">
            <h3 class="font-bold text-lg text-gray-800">Riwayat</h3>
            <a href="#" class="text-sm text-green-600 font-semibold">
                Lihat semua >
            </a>
        </div>

        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-green-600 text-white">
                    <th class="py-2">Hari</th>
                    <th class="py-2">Kehadiran</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                <tr class="border-b">
                    <td class="py-2">Senin</td>
                    <td class="py-2 text-green-600 font-semibold">Hadir</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2">Selasa</td>
                    <td class="py-2 text-green-600 font-semibold">Hadir</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2">Rabu</td>
                    <td class="py-2 text-green-600 font-semibold">Hadir</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2">Kamis</td>
                    <td class="py-2 text-yellow-600 font-semibold">Izin</td>
                </tr>
                <tr>
                    <td class="py-2">Jumat</td>
                    <td class="py-2 text-red-600 font-semibold">Alpa</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection
