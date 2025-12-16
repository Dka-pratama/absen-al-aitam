@extends('layouts.walikelas')

@section('content')
    <div class="p-6">
        <!-- HEADER -->
        <div class="mb-6 flex flex-col items-start justify-between gap-6 lg:flex-row">
            <!-- KIRI: Info Kelas -->
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-800">
                    Absensi Kelas {{ optional($wali->kelas)->nama_kelas }}
                </h1>
                <p class="text-gray-500">Wali Kelas: {{ optional($wali->user)->name }}</p>
                <p class="text-gray-500">
                    Tahun Ajar: {{ optional($wali->tahunAjar)->tahun }} ({{ $semesterAktif->name }})
                </p>
            </div>

            <!-- KANAN: Tombol QR & Absensi Mandiri -->
            <div class="flex flex-col gap-3">
                <!-- Tombol QR -->
                <div x-data="qrAbsensiComponent({{ $wali->kelas_id }}, {{ $wali->tahun_ajar_id }})" class="relative">
                    <button @click="openModal" class="rounded bg-blue-600 px-4 py-2 text-white">Tampilkan QR</button>

                    <!-- MODAL -->
                    <div
                        x-show="open"
                        x-transition
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
                    >
                        <div class="relative w-96 rounded-xl bg-white p-6 shadow-lg">
                            <!-- CLOSE BUTTON -->
                            <button class="absolute right-3 top-3 text-gray-600 hover:text-black" @click="closeModal">
                                ✖
                            </button>

                            <h2 class="mb-3 text-center text-lg font-bold">QR Absensi</h2>

                            <!-- QR IMAGE -->
                            <div class="flex justify-center">
                                <template x-if="qr">
                                    <img :src="'data:image/svg+xml;base64,' + qr" />
                                </template>
                                <template x-if="!qr">
                                    <p class="text-gray-500">Memuat QR...</p>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Absensi Mandiri -->
                <form action="{{ route('wali.toggleMandiri', $wali->kelas->id) }}" method="POST">
                    @csrf
                    @if (Cache::get('absensi_mandiri_kelas_' . $wali->kelas->id, false))
                        <button class="rounded bg-red-600 px-4 py-2 text-white">Nonaktifkan Absensi Mandiri</button>
                    @else
                        <button class="rounded bg-green-600 px-4 py-2 text-white">Aktifkan Absensi Mandiri</button>
                    @endif
                </form>
            </div>
        </div>

        <!-- PERSENTASE (progress bars) -->
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-4">
            <div class="rounded bg-white p-4 shadow">
                <p class="font-semibold">Hadir</p>
                <div class="mt-2 h-4 w-full overflow-hidden rounded bg-gray-200">
                    <div class="h-4 bg-green-500" style="width: {{ $persentase['hadir'] ?? 0 }}%"></div>
                </div>
                <p class="mt-1 text-sm">{{ $persentase['hadir'] ?? 0 }}%</p>
            </div>

            <div class="rounded bg-white p-4 shadow">
                <p class="font-semibold">Izin</p>
                <div class="mt-2 h-4 w-full overflow-hidden rounded bg-gray-200">
                    <div class="h-4 bg-yellow-400" style="width: {{ $persentase['izin'] ?? 0 }}%"></div>
                </div>
                <p class="mt-1 text-sm">{{ $persentase['izin'] ?? 0 }}%</p>
            </div>

            <div class="rounded bg-white p-4 shadow">
                <p class="font-semibold">Sakit</p>
                <div class="mt-2 h-4 w-full overflow-hidden rounded bg-gray-200">
                    <div class="h-4 bg-red-500" style="width: {{ $persentase['sakit'] ?? 0 }}%"></div>
                </div>
                <p class="mt-1 text-sm">{{ $persentase['sakit'] ?? 0 }}%</p>
            </div>

            <div class="rounded bg-white p-4 shadow">
                <p class="font-semibold">Alpa</p>
                <div class="mt-2 h-4 w-full overflow-hidden rounded bg-gray-200">
                    <div class="h-4 bg-gray-500" style="width: {{ $persentase['alpa'] ?? 0 }}%"></div>
                </div>
                <p class="mt-1 text-sm">{{ $persentase['alpa'] ?? 0 }}%</p>
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
                                <td class="p-3">
                                    {{ $absensiMap->count() ? ($absensiMap->keys()->first() ? $index + 1 : $index + 1) : $index + 1 }}
                                </td>

                                <td class="p-3">{{ optional($userModel)->name ?? '—' }}</td>
                                <td class="p-3">{{ optional($siswaModel)->NISN ?? '—' }}</td>

                                {{-- important: input name uses siswa id (not kelas_siswa id) --}}
                                @php
                                    $inputName = 'status[' . (optional($siswaModel)->id ?? 'unknown') . ']';
                                @endphp

                                <td class="p-3 text-center">
                                    <input
                                        type="radio"
                                        name="{{ $inputName }}"
                                        value="hadir"
                                        {{ $statusNow === 'hadir' ? 'checked' : '' }}
                                        required
                                    />
                                </td>
                                <td class="p-3 text-center">
                                    <input
                                        type="radio"
                                        name="{{ $inputName }}"
                                        value="izin"
                                        {{ $statusNow === 'izin' ? 'checked' : '' }}
                                    />
                                </td>
                                <td class="p-3 text-center">
                                    <input
                                        type="radio"
                                        name="{{ $inputName }}"
                                        value="sakit"
                                        {{ $statusNow === 'sakit' ? 'checked' : '' }}
                                    />
                                </td>
                                <td class="p-3 text-center">
                                    <input
                                        type="radio"
                                        name="{{ $inputName }}"
                                        value="alpa"
                                        {{ $statusNow === 'alpa' ? 'checked' : '' }}
                                    />
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
                <button type="submit" class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                    Simpan Absensi
                </button>

                <a href="{{ route('wali.laporan') }}" class="rounded bg-gray-200 px-4 py-2">Lihat Laporan</a>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        function qrAbsensiComponent(kelasId, tahunAjarId) {
            return {
                open: false,
                qr: null, // <-- FIX DI SINI
                expires: '',
                intervalHandler: null,

                openModal() {
                    this.open = true;
                    this.loadQr();
                    this.startAutoRefresh();
                },

                closeModal() {
                    this.open = false;
                    this.qr = null; // <-- FIX DI SINI
                    clearInterval(this.intervalHandler);
                },

                loadQr() {
                    fetch('{{ route('wali.qr.generate') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            kelas_id: kelasId,
                            tahun_ajar_id: tahunAjarId,
                        }),
                    })
                        .then((res) => res.json())
                        .then((data) => {
                            this.qr = data.qr;
                            this.expires = data.expires;
                        })
                        .catch(() => {
                            this.qr = null; // <-- FIX
                        });
                },

                startAutoRefresh() {
                    this.intervalHandler = setInterval(() => {
                        this.loadQr();
                    }, 60000);
                },
            };
        }
    </script>
@endsection
