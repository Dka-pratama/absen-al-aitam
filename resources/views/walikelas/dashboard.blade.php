@extends('layouts.walikelas')

@section('content')
    <div class="mb-6">
        <h2 class="text-4xl font-bold text-gray-800">Dashboard</h2>
        <p class="mt-1 text-sm text-gray-400">Welcome back, {{ $nama_wali ?? 'Wali Kelas' }}.</p>
    </div>

    <!-- cards centered like figma -->
    <div class="flex items-center justify-start gap-6">
        <div class="w-64 rounded-lg bg-green-600 px-8 py-6 text-white shadow-md">
            <div class="text-xs opacity-90">Kelas</div>
            <div class="mt-3 text-2xl font-semibold">
                {{ $kelas ?? 'Belum di-set' }}
            </div>
        </div>

        <div class="w-64 rounded-lg bg-green-600 px-8 py-6 text-white shadow-md">
            <div class="text-xs opacity-90">Total Siswa</div>
            <div class="mt-3 text-2xl font-semibold">
                {{ $total_siswa ?? '0' }}
            </div>
        </div>

        <div class="w-64 rounded-lg bg-green-600 px-8 py-6 text-white shadow-md">
            <div class="text-xs opacity-90">Presentase hadir</div>
            <div class="mt-3 text-2xl font-semibold">
                {{ $presentase_hadir ?? '0 %' }}
            </div>
        </div>
    </div>
@endsection
