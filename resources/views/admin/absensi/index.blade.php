@extends('layouts.admin')

@section('content')
    <div class="p-6">
        <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            {{-- ======================= --}}
            {{-- FORM FILTER ABSENSI     --}}
            {{-- ======================= --}}
            <form method="GET" action="{{ route('absen.index') }}"
                class="w-full bg-white p-4 rounded-lg shadow flex flex-col md:flex-row md:items-end gap-4">

                {{-- Grid Input --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full">

                    {{-- Filter Tanggal --}}
                    <div class="flex flex-col">
                        <label class="text-sm font-semibold mb-1">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                            class="border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                    </div>

                    {{-- Filter Kelas --}}
                    <div class="flex flex-col">
                        <label class="text-sm font-semibold mb-1">Kelas</label>
                        <select name="kelas_id" class="border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                            <option value="">Semua Kelas</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Tahun Ajar --}}
                    <div class="flex flex-col">
                        <label class="text-sm font-semibold mb-1">Tahun Ajar</label>
                        <select name="tahun_ajar_id" class="border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                            <option value="">Semua Tahun</option>
                            @foreach ($tahunAjar as $t)
                                <option value="{{ $t->id }}"
                                    {{ request('tahun_ajar_id') == $t->id ? 'selected' : '' }}>
                                    {{ $t->tahun }} - {{ $t->semester }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                {{-- Tombol Aksi --}}
                <div class="flex flex-row gap-2 md:ml-2">

                    {{-- Tombol Filter --}}
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 shadow">
                        Filter
                    </button>

                    {{-- Tombol Reset --}}
                    <a href="{{ route('absen.index') }}"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 shadow">
                        Reset
                    </a>

                </div>

            </form>

        </div>


        {{-- TABLE --}}
        <div class="overflow-hidden rounded-xl border bg-white shadow">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">No</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Kelas</th>
                        <th class="p-3 text-left">Tahun Ajar</th>
                        <th class="p-3 text-center">Action</th>
                    </tr>
                </thead>

                <tbody class="bg-white" id="kelasTable">
                    @foreach ($absensi as $i => $absen)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $absensi->firstItem() + $i }}</td>
                            <td class="p-3">{{ $absen->tanggal }}</td>
                            <td class="p-3">{{ $absen->nama_kelas }}</td>
                            <td class="p-3">{{ $absen->tahun }} - {{ $absen->semester }}</td>
                            {{-- ACTION --}}
                            <td class="flex justify-center gap-3 p-3">
                                {{-- Edit --}}
                                <div class="group relative">
                                    <a href="{{ route('absen.edit', $absen->id) }}">
                                        <i class="fa-solid fa-pen-to-square fa-lg" style="color: #0045bd"></i>
                                    </a>
                                    <div
                                        class="pointer-events-none absolute left-1/2 z-50 mt-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 shadow transition group-hover:opacity-100">
                                        Edit Absensi
                                    </div>
                                </div>

                                {{-- Hapus --}}
                                <div class="group relative">
                                    <form action="{{ route('absen.destroy', $absen->id) }}" method="POST"
                                        class="form-hapus inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-hapus">
                                            <i class="fa-solid fa-trash fa-lg" style="color: #e00000"></i>
                                        </button>
                                    </form>
                                    <div
                                        class="pointer-events-none absolute left-1/2 z-50 mt-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 shadow transition group-hover:opacity-100">
                                        Hapus Absensi
                                    </div>
                                </div>

                                {{-- Info --}}
                                <div class="group relative">
                                    <a href="{{ route('absen.show', $absen->id) }}">
                                        <i class="fa-solid fa-info fa-lg"></i>
                                    </a>
                                    <div
                                        class="pointer-events-none absolute left-1/2 z-50 mt-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 shadow transition group-hover:opacity-100">
                                        Detail Absensi
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 px-4" id="paginationContainer">
                {{ $absensi->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/kelas-search.js') }}"></script>
@endsection
