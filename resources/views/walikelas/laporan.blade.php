@extends('layouts.walikelas')

@section('content')

{{-- TITLE --}}
<h2 class="text-3xl font-bold text-center mb-8">SISTEM ABSENSI SISWA</h2>

{{-- TOP ACTION BUTTONS --}}
<div class="flex justify-end gap-3 mb-6">

    <a href="{{ route('walikelas.laporan.export.pdf') }}"
       class="flex items-center gap-2 bg-green-600 text-white px-5 py-2 rounded-xl shadow hover:bg-green-700">
        <i class="fa-solid fa-file-pdf"></i> Export ke PDF
    </a>

    <a href="{{ route('walikelas.laporan.export.excel') }}"
       class="flex items-center gap-2 bg-emerald-600 text-white px-5 py-2 rounded-xl shadow hover:bg-emerald-700">
        <i class="fa-solid fa-file-excel"></i> Export ke Excel
    </a>

    <a href="{{ route('walikelas.laporan.print') }}"
       class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-xl shadow hover:bg-blue-700">
        <i class="fa-solid fa-print"></i> Print
    </a>

</div>

{{-- MAIN WRAPPER --}}
<div class="bg-white p-6 rounded-2xl shadow border max-w-full overflow-auto">

    <table class="w-full text-sm table-auto">
        <thead>
            <tr class="bg-gray-100 text-gray-700 border-b">
                <th class="py-3 px-3 text-left">No</th>
                <th class="py-3 px-3 text-left">Hari</th>
                <th class="py-3 px-3 text-left">Tanggal</th>
                <th class="py-3 px-3 text-center">Jumlah siswa</th>
                <th class="py-3 px-3 text-center">Hadir</th>
                <th class="py-3 px-3 text-center">Sakit</th>
                <th class="py-3 px-3 text-center">Izin</th>
                <th class="py-3 px-3 text-center">Alfa</th>
                <th class="py-3 px-3 text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($laporan as $i => $row)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-3">{{ $i + 1 }}</td>
                <td class="py-3 px-3">{{ $row->hari }}</td>
                <td class="py-3 px-3">{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
                <td class="py-3 px-3 text-center">{{ $row->jumlah }}</td>
                <td class="py-3 px-3 text-center">{{ $row->hadir }}</td>
                <td class="py-3 px-3 text-center">{{ $row->sakit }}</td>
                <td class="py-3 px-3 text-center">{{ $row->izin }}</td>
                <td class="py-3 px-3 text-center">{{ $row->alfa }}</td>

                <td class="py-3 px-3 text-center">

                    {{-- Edit --}}
                    <a href="{{ route('walikelas.laporan.edit', $row->id) }}"
                        class="inline-flex items-center justify-center w-8 h-8 bg-blue-500 hover:bg-blue-600 text-white rounded">
                        <i class="fa-solid fa-pen text-xs"></i>
                    </a>

                    {{-- Delete --}}
                    <form action="{{ route('walikelas.laporan.delete', $row->id) }}"
                          method="POST" class="inline-block"
                          onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded inline-flex items-center justify-center">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </form>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center py-4 text-gray-500">
                    Tidak ada data absensi.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
