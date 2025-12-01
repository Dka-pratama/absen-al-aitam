@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- TITLE --}}
    <h2 class="text-2xl font-bold mb-6">SISTEM ABSENSI SISWA</h2>

    {{-- SEARCH + BUTTON --}}
    <div class="flex justify-between items-center mb-4">

        {{-- Search --}}
        <div class="relative w-1/3">
            <input type="text"
                   class="w-full rounded-full border border-gray-300 px-4 py-2 pl-10 text-sm focus:ring-2 focus:ring-blue-400"
                   placeholder="Cari berdasarkan nama/NIS">
            <span class="absolute left-3 top-2.5 text-gray-500">
                🔍
            </span>
        </div>

        {{-- Button Tambah --}}
        <a href="{{ route('akun-siswa.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow flex items-center">
            ➕ Tambah
        </a>

    </div>

    {{-- TABLE --}}
    <div class="bg-white shadow rounded-xl overflow-hidden border">

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">NIS</th>
                    <th class="p-3 text-left">Nama Siswa/Siswi</th>
                    <th class="p-3 text-left">Kelas</th>
                    <th class="p-3 text-left">Jurusan</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($siswa as $i => $siswa)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $i + 1 }}</td>
                        <td class="p-3">{{ $siswa['nis'] }}</td>
                        <td class="p-3">{{ $siswa['nama'] }}</td>
                        <td class="p-3">{{ $siswa['kelas'] }}</td>
                        <td class="p-3">{{ $siswa['jurusan'] }}</td>

                        {{-- STATUS --}}

                        {{-- ACTION --}}
                        <td class="p-3 flex gap-3 justify-center">
                            <button class="text-blue-600 hover:text-blue-800 text-xl">✏️</button>
                            <button class="text-red-600 hover:text-red-800 text-xl">🗑️</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

@endsection
