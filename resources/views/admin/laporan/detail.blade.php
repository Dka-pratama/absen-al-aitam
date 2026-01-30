@extends("layouts.admin")

@section("content")
    <div class="space-y-6 p-6">
        <div class="rounded-xl border bg-white p-5 shadow">
            <h2 class="text-xl font-bold text-gray-800">Detail Absensi</h2>
            <p class="text-sm text-gray-600">
                Kelas:
                <b>{{ $kelas->nama_kelas }}</b>
                | Tanggal:
                <b>{{ \Carbon\Carbon::parse($tanggal)->format("d M Y") }}</b>
            </p>
        </div>

        <div class="overflow-hidden rounded-xl border bg-white shadow">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">No</th>
                        <th class="p-3 text-left">Nama Siswa</th>
                        <th class="p-3 text-center">Status</th>
                        <th class="p-3 text-left">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($absensi as $i => $row)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $i + 1 }}</td>
                            <td class="p-3">
                                {{ $row->kelasSiswa->siswa->user->name ?? "-" }}
                            </td>
                            <td class="p-3 text-center">
                                <span
                                    class="@if ($row->status === "hadir")
                                        bg-green-100
                                        text-green-700
                                    @elseif ($row->status === "izin")
                                        bg-blue-100
                                        text-blue-700
                                    @elseif ($row->status === "sakit")
                                        bg-yellow-100
                                        text-yellow-700
                                    @else
                                        bg-red-100
                                        text-red-700
                                    @endif rounded px-2 py-1 text-xs font-semibold"
                                >
                                    {{ strtoupper($row->status) }}
                                </span>
                            </td>
                            <td class="p-3">
                                {{ $row->keterangan ?? "-" }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500">Tidak ada data absensi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            <a
                href="{{ url()->previous() }}"
                class="inline-block rounded bg-gray-600 px-4 py-2 text-white hover:bg-gray-700"
            >
                ← Kembali
            </a>
        </div>
    </div>
@endsection
