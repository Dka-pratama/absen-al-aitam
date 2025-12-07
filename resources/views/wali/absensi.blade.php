@extends('layouts.walikelas')

@section('content')
<div class="p-6">

    <!-- HEADER -->
    <div class="mb-6 flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Absensi Kelas {{ optional($wali->kelas)->nama_kelas }}</h1>
            <p class="text-gray-500">Wali Kelas: {{ optional($wali->user)->name }}</p>
            <p class="text-gray-500">Tahun Ajar: {{ optional($wali->tahunAjar)->tahun }} ({{ optional($wali->tahunAjar)->semester }})</p>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" onclick="openModal()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Tampilkan QR Code
            </button>
        </div>
    </div>

    <!-- PERSENTASE (progress bars) -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
        <div class="p-4 bg-white rounded shadow">
            <p class="font-semibold">Hadir</p>
            <div class="w-full bg-gray-200 h-4 rounded mt-2 overflow-hidden">
                <div class="bg-green-500 h-4" style="width: {{ $persentase['hadir'] ?? 0 }}%"></div>
            </div>
            <p class="text-sm mt-1">{{ $persentase['hadir'] ?? 0 }}%</p>
        </div>

        <div class="p-4 bg-white rounded shadow">
            <p class="font-semibold">Izin</p>
            <div class="w-full bg-gray-200 h-4 rounded mt-2 overflow-hidden">
                <div class="bg-yellow-400 h-4" style="width: {{ $persentase['izin'] ?? 0 }}%"></div>
            </div>
            <p class="text-sm mt-1">{{ $persentase['izin'] ?? 0 }}%</p>
        </div>

        <div class="p-4 bg-white rounded shadow">
            <p class="font-semibold">Sakit</p>
            <div class="w-full bg-gray-200 h-4 rounded mt-2 overflow-hidden">
                <div class="bg-red-500 h-4" style="width: {{ $persentase['sakit'] ?? 0 }}%"></div>
            </div>
            <p class="text-sm mt-1">{{ $persentase['sakit'] ?? 0 }}%</p>
        </div>

        <div class="p-4 bg-white rounded shadow">
            <p class="font-semibold">Alpa</p>
            <div class="w-full bg-gray-200 h-4 rounded mt-2 overflow-hidden">
                <div class="bg-gray-500 h-4" style="width: {{ $persentase['alpa'] ?? 0 }}%"></div>
            </div>
            <p class="text-sm mt-1">{{ $persentase['alpa'] ?? 0 }}%</p>
        </div>
    </div>

    <!-- QR MODAL (hidden by default) -->
    <div id="qrModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="bg-white rounded-lg p-6 w-80">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">QR Code Absensi</h3>
                <button type="button" onclick="closeModal()" class="text-gray-600 hover:text-gray-900">✕</button>
            </div>

            <div class="flex justify-center">
                {{-- qrcode diberikan oleh controller sebagai HTML (SVG) di variabel $qrcode --}}
                @if(!empty($qrcode))
                    {!! $qrcode !!}
                @else
                    <div class="p-6 text-center text-sm text-gray-500">QR Code belum tersedia.</div>
                @endif
            </div>

            <div class="mt-4 text-right">
                <button type="button" onclick="closeModal()" class="px-3 py-1 bg-gray-300 rounded">Tutup</button>
            </div>
        </div>
    </div>

    <!-- FORM ABSENSI -->
    <form action="{{ route('wali.absensi.simpan') }}" method="POST">
        @csrf

        <div class="overflow-hidden rounded-xl border bg-white shadow">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">No</th>
                        <th class="p-3 text-left">Nama Siswa</th>
                        <th class="p-3 text-left">NISN</th>
                        <th class="p-3 text-center">Hadir</th>
                        <th class="p-3 text-center">Izin</th>
                        <th class="p-3 text-center">Sakit</th>
                        <th class="p-3 text-center">Alpa</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($siswa as $index => $ks)
                        @php
                            // $ks = model KelasSiswa, punya ->id (kelas_siswa_id) dan ->siswa
                            $kelasSiswaId = $ks->id;
                            $siswaModel = $ks->siswa ?? null;
                            $userModel = optional($siswaModel)->user;
                            // Ambil status dari absensiMap (keyed by kelas_siswa_id)
                            $absRec = optional($absensiMap->get($kelasSiswaId));
                            $statusNow = $absRec->status ?? null;
                        @endphp

                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $absensiMap->count() ? ($absensiMap->keys()->first() ? $index + 1 : $index + 1) : $index + 1 }}</td>

                            <td class="p-3">{{ optional($userModel)->name ?? '—' }}</td>
                            <td class="p-3">{{ optional($siswaModel)->NISN ?? '—' }}</td>

                            {{-- important: input name uses siswa id (not kelas_siswa id) --}}
                            @php $inputName = 'status[' . (optional($siswaModel)->id ?? 'unknown') . ']'; @endphp

                            <td class="p-3 text-center">
                                <input type="radio" name="{{ $inputName }}" value="hadir"
                                    {{ $statusNow === 'hadir' ? 'checked' : '' }} required>
                            </td>
                            <td class="p-3 text-center">
                                <input type="radio" name="{{ $inputName }}" value="izin"
                                    {{ $statusNow === 'izin' ? 'checked' : '' }}>
                            </td>
                            <td class="p-3 text-center">
                                <input type="radio" name="{{ $inputName }}" value="sakit"
                                    {{ $statusNow === 'sakit' ? 'checked' : '' }}>
                            </td>
                            <td class="p-3 text-center">
                                <input type="radio" name="{{ $inputName }}" value="alpa"
                                    {{ $statusNow === 'alpa' ? 'checked' : '' }}>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-500">Tidak ada siswa di kelas ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex gap-3">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Simpan Absensi
            </button>

            <a href="{{ route('wali.laporan') }}" class="px-4 py-2 bg-gray-200 rounded">Lihat Laporan</a>
        </div>
    </form>

</div>
@endsection

@section('script')
<script>
function openModal() {
    document.getElementById('qrModal').classList.remove('hidden');
}
function closeModal() {
    document.getElementById('qrModal').classList.add('hidden');
}
</script>
@endsection
