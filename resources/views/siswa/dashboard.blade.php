@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('content')
    <div class="min-h-screen px-0 py-2 md:p-6">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-6 lg:grid-cols-5">
            <div class="col-span-2 space-y-6">
                <div class="flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm">
                    <div class=""></div>
                    <div>
                        <h3 class="text-lg font-bold leading-tight text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $kelas->kelas->nama_kelas }}</p>
                    </div>
                </div>
                <div x-data="scanQr()" x-cloak class="rounded-2xl bg-white p-6 shadow-md">
                    <h2 class="mb-1 text-xl font-bold">Presensi Hari Ini</h2>
                    <p class="mb-5 text-sm opacity-90">
                        Status:
                        <span class="font-semibold">{{ $absenHariIni->status ?? 'Belum Absensi' }}</span>
                    </p>
                    <div class="flex gap-2">
                        <button onclick="ambilLokasi()" class="mt-2 rounded-lg bg-blue-600 px-4 py-2 text-white">
                            Absen Mandiri
                        </button>

                        <form id="formAbsen" action="{{ route('siswa.absenMandiri') }}" method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="lat" id="lat" />
                            <input type="hidden" name="lng" id="lng" />
                        </form>
                        <div class="mt-2">
                            <button @click="openModal" class="rounded-lg bg-blue-600 px-4 py-2 text-white">
                                Scan QR Absensi
                            </button>
                            <div
                                x-show="show"
                                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 p-4"
                            >
                                <div class="relative w-full max-w-md rounded-xl bg-white p-4">
                                    <button
                                        class="absolute right-4 top-4 text-gray-500 hover:text-black"
                                        @click="closeModal"
                                    >
                                        ✖
                                    </button>
                                    <h2 class="mb-3 text-center text-lg font-bold">Scan QR Absensi</h2>
                                    <div id="reader" class="w-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-4 gap-3">
                    <div class="rounded-xl bg-white p-4 text-center shadow-sm">
                        <p class="text-xs font-medium text-gray-600">Hadir</p>
                        <p class="text-2xl font-extrabold text-gray-900">{{ $absen['hadir'] ?? 0 }}</p>
                    </div>
                    <div class="rounded-xl bg-white p-4 text-center shadow-sm">
                        <p class="text-xs font-medium text-gray-600">Izin</p>
                        <p class="text-2xl font-extrabold text-gray-900">{{ $absen['izin'] ?? 0 }}</p>
                    </div>
                    <div class="rounded-xl bg-white p-4 text-center shadow-sm">
                        <p class="text-xs font-medium text-gray-600">Sakit</p>
                        <p class="text-2xl font-extrabold text-gray-900">{{ $absen['sakit'] ?? 0 }}</p>
                    </div>
                    <div class="rounded-xl bg-white p-4 text-center shadow-sm">
                        <p class="text-xs font-medium text-gray-600">Alpa</p>
                        <p class="text-2xl font-extrabold text-gray-900">{{ $absen['alpa'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-span-2 space-y-6 lg:col-span-3">
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900">Rekap Absen 1 Semester</h3>
                    <a
                        href="{{ route('siswa.rekap') }}"
                        class="mt-4 inline-block w-full rounded-lg bg-green-600 py-2.5 text-center font-semibold text-white shadow transition hover:bg-green-700 lg:w-64"
                    >
                        Lihat Rekap Detail >
                    </a>
                </div>
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Riwayat</h3>
                        <a href="#" class="text-sm font-semibold text-green-600 hover:underline">Lihat semua ></a>
                    </div>

                    <div class="overflow-hidden rounded-xl border border-gray-200">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-green-600 text-left text-white">
                                    <th class="px-3 py-2">Hari</th>
                                    <th class="px-3 py-2">Kehadiran</th>
                                </tr>
                            </thead>

                            <tbody class="text-gray-800">
                                @foreach ($riwayat as $item)
                                    @php
                                        $status = $item['status'];
                                        $color = match ($status) {
                                            'hadir' => 'text-green-600',
                                            'izin' => 'text-yellow-600',
                                            'sakit' => 'text-blue-600',
                                            'alpa' => 'text-red-600',
                                            default => 'text-gray-500',
                                        };
                                    @endphp

                                    <tr class="border-b">
                                        <td class="px-3 py-2">{{ $item['hari'] }}</td>
                                        <td class="{{ $color }} px-3 py-2 font-semibold">
                                            {{ $status }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-auto mb-6 mt-10 max-w-7xl px-2 md:hidden">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="w-full rounded-lg bg-red-500 py-2.5 text-center font-semibold text-white shadow transition hover:bg-red-600 lg:w-64"
                >
                    Keluar Akun
                </button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        function scanQr() {
            return {
                show: false,
                qrScanner: null,
                scanned: false,

                openModal() {
                    this.scanned = false;
                    this.show = true;
                    setTimeout(() => this.startScanner(), 300);
                },

                startScanner() {
                    this.qrScanner = new Html5Qrcode('reader');

                    this.qrScanner.start(
                        {
                            facingMode: 'environment',
                        },
                        {
                            fps: 10,
                            qrbox: 250,
                        },
                        (decodedText) => {
                            if (this.scanned) return;
                            this.scanned = true;
                            this.onSuccess(decodedText);
                        },
                    );
                },

                onSuccess(token) {
    this.stopScanner();

    fetch('{{ route('siswa.scan') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ token }),
    })
    .then(res => res.json())
    .then(data => {
        Swal.fire({
            icon: data.status === 'success' ? 'success' : 'error',
            title: data.status === 'success' ? 'Berhasil' : 'Gagal',
            text: data.message,
        }).then(() => {
            if (data.status === 'success') {
                window.location.reload();
            }
        });
    })
    .catch(err => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Gagal menghubungi server',
        });
        console.error(err);
    });

    this.show = false;
},

                stopScanner() {
                    if (this.qrScanner) {
                        this.qrScanner
                            .stop()
                            .then(() => this.qrScanner.clear())
                            .catch(() => {});
                    }
                },

                closeModal() {
                    this.stopScanner();
                    this.show = false;
                },
            };
        }

        function ambilLokasi() {
            navigator.geolocation.getCurrentPosition(
                function (pos) {
                    document.getElementById('lat').value = pos.coords.latitude;
                    document.getElementById('lng').value = pos.coords.longitude;
                    document.getElementById('formAbsen').submit();
                },
                function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'GPS Tidak Aktif',
                        text: 'Izinkan lokasi untuk melakukan absensi.',
                    });
                },
            );
        }
    </script>
@endsection
