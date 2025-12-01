@extends('layouts.walikelas')

@section('content')

<div class="mb-6">
  <h2 class="text-4xl font-bold text-gray-800">Dashboard</h2>
  <p class="text-sm text-gray-400 mt-1">Welcome back, {{ $nama_wali ?? 'Wali Kelas' }}.</p>
</div>

<!-- cards centered like figma -->
<div class="flex items-center justify-start gap-6">
  <div class="bg-green-600 text-white rounded-lg px-8 py-6 shadow-md w-64">
    <div class="text-xs opacity-90">Kelas</div>
    <div class="text-2xl font-semibold mt-3">{{ $kelas ?? 'Belum di-set' }}</div>
  </div>

  <div class="bg-green-600 text-white rounded-lg px-8 py-6 shadow-md w-64">
    <div class="text-xs opacity-90">Total Siswa</div>
    <div class="text-2xl font-semibold mt-3">{{ $total_siswa ?? '0' }}</div>
  </div>

  <div class="bg-green-600 text-white rounded-lg px-8 py-6 shadow-md w-64">
    <div class="text-xs opacity-90">Presentase hadir</div>
    <div class="text-2xl font-semibold mt-3">{{ $presentase_hadir ?? '0 %' }}</div>
  </div>
</div>

@endsection
