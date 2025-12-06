@extends('layouts.walikelas')

@section('content')
<div class="px-6 py-6">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Dashboard Wali Kelas
        </h1>
        <p class="text-gray-600">
            Tahun Ajar: <span class="font-semibold">{{ $tahunAjar->tahun }} ({{ $tahunAjar->semester }})</span> • 
            Kelas: <span class="font-semibold">{{ $kelas->nama_kelas }}</span>
        </p>
    </div>

    {{-- GRID STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        {{-- Total Siswa --}}
        <div class="bg-white shadow-md rounded-xl p-5">
            <p class="text-gray-500">Total Siswa</p>
            <h2 class="text-3xl font-bold text-blue-600">{{ $totalSiswa }}</h2>
        </div>

        {{-- Persentase Hadir --}}
        <div class="bg-white shadow-md rounded-xl p-5">
            <p class="text-gray-500">Persentase Hadir Hari Ini</p>
            <h2 class="text-3xl font-bold text-green-600">{{ $persentaseHadir }}%</h2>
        </div>

        {{-- Hadir --}}
        <div class="bg-white shadow-md rounded-xl p-5">
            <p class="text-gray-500">Hadir</p>
            <h2 class="text-3xl font-bold text-green-600">{{ $hadir }}</h2>
        </div>

        {{-- Izin --}}
        <div class="bg-white shadow-md rounded-xl p-5">
            <p class="text-gray-500">Izin</p>
            <h2 class="text-3xl font-bold text-yellow-500">{{ $izin }}</h2>
        </div>

        {{-- Sakit --}}
        <div class="bg-white shadow-md rounded-xl p-5">
            <p class="text-gray-500">Sakit</p>
            <h2 class="text-3xl font-bold text-blue-400">{{ $sakit }}</h2>
        </div>

        {{-- Alpa --}}
        <div class="bg-white shadow-md rounded-xl p-5">
            <p class="text-gray-500">Alpa</p>
            <h2 class="text-3xl font-bold text-red-500">{{ $alpa }}</h2>
        </div>

    </div>

    {{-- CHART SECTION --}}
    <div class="bg-white shadow-md rounded-xl p-5">
        <h2 class="text-xl font-bold mb-4 text-gray-700">Grafik Absensi 30 Hari Terakhir</h2>

        {{-- Canvas Chart (Chart.js Support) --}}
        <canvas id="chartAbsensi" class="w-full h-64"></canvas>

    </div>

</div>

@endsection

@section('scripts')
<script>
    // Data Variabel dari Controller
    const labels = @json($chartTanggal);
    const dataHadir = @json($chartHadir);
    const dataIzin = @json($chartIzin);
    const dataSakit = @json($chartSakit);
    const dataAlpa = @json($chartAlpa);

    // (Nanti saya isi Chart.js kalau kamu bilang lanjut)
</script>
@endsection
