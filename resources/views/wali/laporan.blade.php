@extends('layouts.walikelas')

@section('content')
    <div class="p-6">
        {{-- Header --}}
        <div class="mb-6">
            @if ($wali)
                <p class="text-gray-500">Wali Kelas: {{ $wali->user->name }}</p>
            @else
                <h1 class="text-2xl font-bold text-gray-700">Laporan Absensi</h1>
            @endif
            <p class="text-gray-500">Tahun Ajar: {{ $semesterAktif->tahunAjar?->tahun ?? '-' }}</p>
        </div>

        {{-- Filter --}}
        <form method="GET" action="{{ route('wali.laporan') }}" class="mb-4 flex flex-wrap gap-3">
            <div class="flex flex-col">
                <label class="text-sm font-semibold">Dari Tanggal</label>
                <input
                    type="date"
                    name="dari_tanggal"
                    value="{{ request('dari_tanggal') }}"
                    class="rounded border px-3 py-2"
                />
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-semibold">Sampai Tanggal</label>
                <input
                    type="date"
                    name="sampai_tanggal"
                    value="{{ request('sampai_tanggal') }}"
                    class="rounded border px-3 py-2"
                />
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-semibold">Semester</label>
                <select name="semester_id" class="rounded border py-2 pl-3">
                    @foreach ($semesters as $s)
                        <option value="{{ $s->id }}" @selected($s->id == $semesterAktif->id)>
                            {{ $s->name }} ({{ $s->tahunAjar->tahun }})
                            {{ $s->status === 'aktif' ? '— Aktif' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4 flex items-end gap-2 md:mt-0">
                <button class="rounded bg-blue-600 px-4 py-2 text-white">Filter</button>
                <a href="{{ route('wali.laporan') }}" class="rounded bg-gray-300 px-4 py-2 text-gray-800">Reset</a>
            </div>
        </form>

        {{-- Tabel --}}
        <div class="overflow-x-auto rounded-lg border bg-white shadow">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">No</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-center">Hadir</th>
                        <th class="p-3 text-center">Izin</th>
                        <th class="p-3 text-center">Sakit</th>
                        <th class="p-3 text-center">Alpa</th>
                        <th class="p-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absensi as $i => $a)
                        <tr class="border-b text-center hover:bg-gray-50">
                            <td class="p-3 text-left">{{ $absensi->firstItem() + $i }}</td>
                            <td class="p-3 text-left">{{ $a->tanggal }}</td>
                            <td class="p-3">{{ $a->hadir }}</td>
                            <td class="p-3">{{ $a->izin }}</td>
                            <td class="p-3">{{ $a->sakit }}</td>
                            <td class="p-3">{{ $a->alpa }}</td>
                            <td class="flex justify-center gap-3 p-3">
                                {{-- Info --}}
                                <div class="group relative">
                                    <a
                                        href="{{ route('wali.laporan.detail', ['tanggal' => $a->tanggal, 'semester_id' => $semesterAktif->id]) }}"
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

            <div class="mt-4 px-4">
                {{ $absensi->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
