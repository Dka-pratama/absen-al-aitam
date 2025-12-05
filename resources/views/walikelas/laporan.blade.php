@extends('layouts.walikelas')

@section('content')
    {{-- TITLE --}}
    <h2 class="mb-8 text-center text-3xl font-bold">SISTEM ABSENSI SISWA</h2>

    {{-- TOP ACTION BUTTONS --}}
    <div class="mb-6 flex justify-end gap-3">
        <a
            href="{{ route('walikelas.laporan.export.pdf') }}"
            class="flex items-center gap-2 rounded-xl bg-green-600 px-5 py-2 text-white shadow hover:bg-green-700"
        >
            <i class="fa-solid fa-file-pdf"></i>
            Export ke PDF
        </a>

        <a
            href="{{ route('walikelas.laporan.export.excel') }}"
            class="flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2 text-white shadow hover:bg-emerald-700"
        >
            <i class="fa-solid fa-file-excel"></i>
            Export ke Excel
        </a>

        <a
            href="{{ route('walikelas.laporan.print') }}"
            class="flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2 text-white shadow hover:bg-blue-700"
        >
            <i class="fa-solid fa-print"></i>
            Print
        </a>
    </div>

    {{-- MAIN WRAPPER --}}
    <div class="max-w-full overflow-auto rounded-2xl border bg-white p-6 shadow">
        <table class="w-full table-auto text-sm">
            <thead>
                <tr class="border-b bg-gray-100 text-gray-700">
                    <th class="px-3 py-3 text-left">No</th>
                    <th class="px-3 py-3 text-left">Hari</th>
                    <th class="px-3 py-3 text-left">Tanggal</th>
                    <th class="px-3 py-3 text-center">Jumlah siswa</th>
                    <th class="px-3 py-3 text-center">Hadir</th>
                    <th class="px-3 py-3 text-center">Sakit</th>
                    <th class="px-3 py-3 text-center">Izin</th>
                    <th class="px-3 py-3 text-center">Alfa</th>
                    <th class="px-3 py-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($laporan as $i => $row)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-3 py-3">{{ $i + 1 }}</td>
                        <td class="px-3 py-3">{{ $row->hari }}</td>
                        <td class="px-3 py-3">
                            {{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}
                        </td>
                        <td class="px-3 py-3 text-center">
                            {{ $row->jumlah }}
                        </td>
                        <td class="px-3 py-3 text-center">
                            {{ $row->hadir }}
                        </td>
                        <td class="px-3 py-3 text-center">
                            {{ $row->sakit }}
                        </td>
                        <td class="px-3 py-3 text-center">{{ $row->izin }}</td>
                        <td class="px-3 py-3 text-center">{{ $row->alfa }}</td>

                        <td class="px-3 py-3 text-center">
                            {{-- Edit --}}
                            <a
                                href="{{ route('walikelas.laporan.edit', $row->id) }}"
                                class="inline-flex h-8 w-8 items-center justify-center rounded bg-blue-500 text-white hover:bg-blue-600"
                            >
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>

                            {{-- Delete --}}
                            <form
                                action="{{ route('walikelas.laporan.delete', $row->id) }}"
                                method="POST"
                                class="inline-block"
                                onsubmit="return confirm('Yakin ingin menghapus laporan ini?');"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    class="inline-flex h-8 w-8 items-center justify-center rounded bg-red-500 text-white hover:bg-red-600"
                                >
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="py-4 text-center text-gray-500">Tidak ada data absensi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
