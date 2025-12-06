@extends('layouts.admin')

@section('content')
<div class="mx-5 my-6">

    <div class="rounded-lg bg-white p-6 shadow-md max-w-4xl mx-auto space-y-6">

        <!-- Header -->
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Detail Kelas</h2>
            <p class="text-gray-600 mt-1">
                <span class="font-semibold">{{ $kelas->nama_kelas }}</span> • 
                Tahun Ajar Aktif: 
                <span class="font-semibold">{{ $tahunAjarAktif->tahun }} ({{ ucfirst($tahunAjarAktif->semester) }})</span>
            </p>
        </div>

        <hr class="my-4">

        <!-- Daftar Siswa -->
        <div>
            <h3 class="text-xl font-bold text-gray-800 mb-4">Daftar Siswa</h3>

            @if ($siswa->count() == 0)
                <p class="text-gray-600">Tidak ada siswa dalam kelas ini untuk tahun ajar aktif.</p>
            @else
                <div class="overflow-x-auto rounded-lg border">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-left">
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">NISN</th>
                                <th class="px-4 py-2 border">Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $index => $ks)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border">{{ $ks->siswa->NISN }}</td>
                                    <td class="px-4 py-2 border">{{ $ks->siswa->user->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <hr class="my-4">

        <!-- Tombol Naik Kelas -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
    <h3 class="font-bold text-lg mb-2">Naikkan Siswa Ke Kelas:</h3>

    <form action="{{ route('kelas.naik', $kelas->id) }}" method="POST">
        @csrf

        <select name="kelas_tujuan" class="border rounded-lg p-2 w-full mb-3">
            <option value="">-- Pilih Kelas Tujuan --</option>
            @foreach ($daftarKelas as $k)
                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
            @endforeach
        </select>

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold w-full">
            Naikkan Semua
        </button>
    </form>
</div>


    </div>

</div>
@endsection
