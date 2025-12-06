@extends('layouts.admin')

@section('content')
    <div class="p-6">
        <div class="mb-4 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            {{-- ======================= --}}
            {{-- FORM FILTER ABSENSI --}}
            {{-- ======================= --}}
            <form
                method="GET"
                action="{{ route('absen.index') }}"
                class="flex w-full flex-col gap-4 rounded-lg bg-white p-4 shadow md:flex-row md:items-end"
            >
                {{-- Grid Input --}}
                <div class="grid w-full grid-cols-1 gap-4 md:grid-cols-3">
                    {{-- Filter Tanggal --}}
                    <div class="flex flex-col">
                        <label class="mb-1 text-sm font-semibold">Tanggal</label>
                        <input
                            type="date"
                            name="tanggal"
                            value="{{ request('tanggal') }}"
                            class="rounded-lg border px-3 py-2 focus:ring focus:ring-blue-200"
                        />
                    </div>

                    {{-- Filter Kelas --}}
                    <div class="flex flex-col">
                        <label class="mb-1 text-sm font-semibold">Kelas</label>
                        <select name="kelas_id" class="rounded-lg border px-3 py-2 focus:ring focus:ring-blue-200">
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
                        <label class="mb-1 text-sm font-semibold">Tahun Ajar</label>
                        <select name="tahun_ajar_id" class="rounded-lg border px-3 py-2 focus:ring focus:ring-blue-200">
                            <option value="">Semua Tahun</option>
                            @foreach ($tahunAjar as $t)
                                <option
                                    value="{{ $t->id }}"
                                    {{ request('tahun_ajar_id') == $t->id ? 'selected' : '' }}
                                >
                                    {{ $t->tahun }} - {{ $t->semester }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex flex-row gap-2 md:ml-2">
                    {{-- Tombol Filter --}}
                    <button class="rounded-lg bg-blue-600 px-4 py-2 text-white shadow hover:bg-blue-700">Filter</button>

                    {{-- Tombol Reset --}}
                    <a
                        href="{{ route('absen.index') }}"
                        class="rounded-lg bg-gray-300 px-4 py-2 text-gray-800 shadow hover:bg-gray-400"
                    >
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
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="h-6 w-6 text-blue-600"
                                        >
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path
                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"
                                            />
                                            <path d="M16 5l3 3" />
                                        </svg>
                                    </a>
                                    <div
                                        class="pointer-events-none absolute left-1/2 z-50 mt-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 shadow transition group-hover:opacity-100"
                                    >
                                        Edit Absensi
                                    </div>
                                </div>

                                {{-- Hapus --}}
                                <div class="group relative">
                                    <form
                                        action="{{ route('absen.destroy', $absen->id) }}"
                                        method="POST"
                                        class="form-hapus inline"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-hapus">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="lucide lucide-trash2-icon lucide-trash-2 text-red-600"
                                            >
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                    </form>
                                    <div
                                        class="pointer-events-none absolute left-1/2 z-50 mt-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 shadow transition group-hover:opacity-100"
                                    >
                                        Hapus Absensi
                                    </div>
                                </div>

                                {{-- Info --}}
                                <div class="group relative">
                                    <a href="{{ route('absen.show', $absen->id) }}">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="lucide lucide-info-icon lucide-info"
                                        >
                                            <circle cx="12" cy="12" r="10" />
                                            <path d="M12 16v-4" />
                                            <path d="M12 8h.01" />
                                        </svg>
                                    </a>
                                    <div
                                        class="pointer-events-none absolute left-1/2 z-50 mt-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 shadow transition group-hover:opacity-100"
                                    >
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
