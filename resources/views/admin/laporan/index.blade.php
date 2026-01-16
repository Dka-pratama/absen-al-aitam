@extends('layouts.admin')

@section('content')
    <div class="p-6">
<div class="mb-4 flex flex-col gap-4 lg:flex-row lg:items-stretch lg:justify-between">
    {{-- FILTER --}}
    <form
        method="GET"
        action="{{ route('laporan.index') }}"
        class="flex w-full flex-col gap-4 rounded-lg bg-white p-4 shadow md:flex-row md:items-end lg:w-[calc(100%-160px)]"
    >
        <div class="grid w-full grid-cols-1 gap-4 md:grid-cols-3">
            {{-- Dari Tanggal --}}
            <div class="flex flex-col">
                <label class="mb-1 text-sm font-semibold">Dari Tanggal</label>
                <input
                    type="date"
                    name="tanggal_dari"
                    value="{{ request('tanggal_dari') }}"
                    class="rounded-lg border px-3 py-2"
                />
            </div>

            {{-- Sampai Tanggal --}}
            <div class="flex flex-col">
                <label class="mb-1 text-sm font-semibold">Sampai Tanggal</label>
                <input
                    type="date"
                    name="tanggal_sampai"
                    value="{{ request('tanggal_sampai') }}"
                    class="rounded-lg border px-3 py-2"
                />
            </div>

            {{-- Kelas --}}
            <div class="flex flex-col">
                <label class="mb-1 text-sm font-semibold">Kelas</label>
                <select name="kelas_id" class="rounded-lg border px-3 py-2">
                    <option value="">Semua Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex gap-2">
            <button class="rounded-lg bg-blue-600 px-4 py-2 text-white">
                Filter
            </button>
            <a href="{{ route('laporan.index') }}" class="rounded-lg bg-gray-300 px-4 py-2">
                Reset
            </a>
        </div>
    </form>

    {{-- EXPORT --}}
    <div class="flex lg:items-center">
        <a
            href="{{ route('laporan.export', request()->query()) }}"
            class="flex items-center gap-2 rounded-lg bg-green-600 px-5 py-2 text-white shadow hover:bg-green-700"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4v12m0 0l-4-4m4 4l4-4M4 20h16" />
            </svg>
            Export
        </a>
    </div>

</div>


        {{-- TABLE --}}
        <div class="overflow-hidden rounded-xl border bg-white shadow">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class=" py-3 text-center">Tanggal</th>
                        <th class="text-center">Kelas</th>
                        <th class="text-center">Hadir</th>
                        <th class="text-center">Izin</th>
                        <th class="text-center">Sakit</th>
                        <th class="text-center">Alpa</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody class="bg-white" id="kelasTable">
                    @foreach ($absensi as $i => $absen)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="text-center">{{ $absen->tanggal }}</td>
                            <td class="text-center">{{ $absen->nama_kelas }}</td>
                            <td class="text-center">{{ $absen->hadir }}</td>
                            <td class="text-center">{{ $absen->izin }}</td>
                            <td class="text-center">{{ $absen->sakit }}</td>
                            <td class="text-center">{{ $absen->alpa }}</td>
                            {{-- ACTION --}}
                            <td class="flex justify-center gap-3 p-3">
                                {{-- Info --}}
                                <div class="group relative">
                                    <a
                                        href="{{
                                            route('laporan.detail', [
                                                'kelas_id' => $absen->kelas_id,
                                                'tanggal' => $absen->tanggal,
                                            ])
                                        }}"
                                    >
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
