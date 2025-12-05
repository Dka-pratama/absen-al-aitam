@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('content')
    <div class="mx-auto min-h-screen max-w-sm overflow-hidden rounded-3xl bg-white shadow-lg">
        {{-- HEADER --}}
        <div class="bg-green-600 p-5 text-white">
            <h1 class="text-lg font-bold leading-tight">AL-AITAAM PRESENSI MANAGEMENT SYSTEM</h1>
        </div>

        {{-- USER INFO --}}
        <div class="flex items-center gap-3 p-4">
            <img src="https://via.placeholder.com/60" class="h-14 w-14 rounded-full object-cover" />
            <div>
                <h3 class="font-bold text-gray-800">Ari Rudianyah</h3>
                <p class="text-sm text-gray-600">XII RPL 1</p>
            </div>
        </div>

        {{-- PRESENSI CARD --}}
        <div class="px-4">
            <div class="rounded-xl bg-green-600 p-4 text-white">
                <h2 class="mb-1 text-xl font-bold">Presensi Hari Ini</h2>
                <p class="mb-4 text-sm">
                    Status :
                    <span class="font-semibold">Belum Presensi</span>
                </p>

                <div class="flex flex-col items-center gap-3">
                    {{-- Tombol Scan QR --}}
                    <button
                        class="flex w-64 items-center justify-center gap-2 rounded-lg bg-gray-300 py-2 font-semibold text-gray-800"
                    >
                        <span>📷</span>
                        Scan QR Sekarang
                    </button>

                    {{-- Tombol Presensi Mandiri --}}
                    <button
                        class="flex w-64 items-center justify-center gap-2 rounded-lg bg-gray-300 py-2 font-semibold text-gray-800"
                    >
                        <span>✔️</span>
                        Presensi Mandiri
                    </button>
                </div>
            </div>
        </div>

        {{-- STATISTIK --}}
        <div class="mt-4 flex justify-between px-6">
            <div class="w-20 rounded-xl bg-white p-2 text-center shadow">
                <p class="text-sm font-semibold text-gray-700">Alpa</p>
                <p class="text-lg font-bold text-gray-800">3</p>
            </div>

            <div class="w-20 rounded-xl bg-white p-2 text-center shadow">
                <p class="text-sm font-semibold text-gray-700">Izin</p>
                <p class="text-lg font-bold text-gray-800">3</p>
            </div>

            <div class="w-20 rounded-xl bg-white p-2 text-center shadow">
                <p class="text-sm font-semibold text-gray-700">Sakit</p>
                <p class="text-lg font-bold text-gray-800">1</p>
            </div>
        </div>

        {{-- REKAP --}}
        <div class="mt-6 px-4">
            <h3 class="text-lg font-bold text-gray-800">Rekap Absen 1 Semester</h3>

            <button class="mt-3 w-full rounded-lg bg-green-500 py-2 font-semibold text-white">
                Lihat Rekap Detail >
            </button>
        </div>

        {{-- RIWAYAT --}}
        <div class="mb-5 mt-6 px-4">
            <div class="mb-2 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-800">Riwayat</h3>
                <a href="#" class="text-sm font-semibold text-green-600">Lihat semua ></a>
            </div>

            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="bg-green-600 text-white">
                        <th class="py-2">Hari</th>
                        <th class="py-2">Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    <tr class="border-b">
                        <td class="py-2">Senin</td>
                        <td class="py-2 font-semibold text-green-600">Hadir</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2">Selasa</td>
                        <td class="py-2 font-semibold text-green-600">Hadir</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2">Rabu</td>
                        <td class="py-2 font-semibold text-green-600">Hadir</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2">Kamis</td>
                        <td class="py-2 font-semibold text-yellow-600">Izin</td>
                    </tr>
                    <tr>
                        <td class="py-2">Jumat</td>
                        <td class="py-2 font-semibold text-red-600">Alpa</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
