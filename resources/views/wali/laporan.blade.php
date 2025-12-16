@extends('layouts.walikelas')

@section('content')
    <div class="p-6">
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Laporan Absensi Kelas {{ $wali->kelas->nama_kelas }}</h1>
            <p class="text-gray-500">Wali Kelas: {{ $wali->user->name }}</p>
            <p class="text-gray-500">Tahun Ajar: {{ $wali->tahunAjar->tahun }} ({{ $semesterAktif->name }})</p>
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
                <label class="text-sm font-semibold">Tahun Ajar</label>
                <select name="tahun_ajar_id" class="rounded border py-2 pl-3">
                    @foreach ($tahunAjar as $t)
                        <option value="{{ $t->id }}" {{ request('tahun_ajar_id') == $t->id ? 'selected' : '' }}>
                            {{ $t->tahun }} - {{ $semesterAktif->name }}
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
                            <td class="p-3">
                                <a
                                    href="{{ route('wali.laporan.detail', ['tanggal' => $a->tanggal]) }}"
                                    class="rounded bg-blue-600 px-3 py-1 text-white hover:bg-blue-700"
                                >
                                    Detail
                                </a>
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
