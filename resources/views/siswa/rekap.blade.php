@extends('layouts.siswa')

@section('content')
    <div class="p-6">
        {{-- Filter --}}
        <form method="GET" action="{{ route('siswa.rekap') }}" class="mb-4 flex flex-wrap gap-3">
            <div class="flex flex-col">
                <label class="text-sm font-semibold">Dari Tanggal</label>
                <input
                    type="date"
                    name="start_date"
                    value="{{ request('start_date') }}"
                    class="rounded border px-3 py-2"
                />
            </div>

            <div class="flex flex-col">
                <label class="text-sm font-semibold">Sampai Tanggal</label>
                <input
                    type="date"
                    name="end_date"
                    value="{{ request('end_date') }}"
                    class="rounded border px-3 py-2"
                />
            </div>
            <div class="mt-4 flex items-end gap-2 md:mt-0">
                <button class="rounded bg-blue-600 px-4 py-2 text-white">Filter</button>
                <a href="{{ route('siswa.rekap') }}" class="rounded bg-gray-300 px-4 py-2 text-gray-800">Reset</a>
            </div>
        </form>

        {{-- Tabel --}}
        <div class="overflow-x-auto rounded-lg border bg-white shadow">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-center">No</th>
                        <th class="p-3 text-center">Tanggal</th>
                        <th class="p-3 text-center">Status</th>
                        <th class="p-3 text-center">Metode</th>
                        <th class="p-3 text-center">Waktu</th>
                        <th class="p-3 text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekap as $i => $a)
                        <tr class="border-b text-center hover:bg-gray-50">
                            <td class="p-3">{{ $rekap->firstItem() + $i }}</td>
                            <td class="p-3">{{ $a->tanggal }}</td>
                            <td class="p-3">{{ ucfirst($a->status) }}</td>
                            <td class="p-3">{{ $a->method }}</td>
                            <td class="p-3">{{ $a->waktu_absen }}</td>
                            <td class="p-3">{{ $a->keterangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 px-4">
                {{ $rekap->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
