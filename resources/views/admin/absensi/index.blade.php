@extends('layouts.admin')

@section('content')
    <div class="p-6">
        {{-- Button aktif, Non-aktif --}}
        @php
            use Illuminate\Support\Facades\Cache;
            $absensiGlobal = Cache::get('absensi_mandiri_global', false);
        @endphp
<div x-data="{ open: false }" class="mb-6">

    <!-- HEADER COLLAPSE -->
    <button
        @click="open = !open"
        class="flex w-full items-center justify-between rounded-lg bg-white p-4 shadow hover:bg-gray-50"
    >
        <div>
            <h3 class="text-lg font-semibold">Pengaturan Absensi Mandiri</h3>
            <p class="text-xs text-gray-500">
                Status Global & Lokasi Absensi
            </p>
        </div>
        <span
            class="text-xl transition-transform duration-200"
            :class="open ? 'rotate-180' : ''"
        >
            ▼
        </span>
    </button>

    <!-- ISI COLLAPSE -->
    <div
        x-show="open"
        x-transition
        class="mt-3 space-y-4 rounded-lg bg-white p-4 shadow"
    >

        <!-- ABSENSI MANDIRI GLOBAL -->
        <div class="border-b pb-4">
            <h4 class="mb-2 font-semibold">Absensi Mandiri Global</h4>

            <p class="mb-3 text-sm">
                Status:
                @if ($absensiGlobal)
                    <span class="font-bold text-green-600">AKTIF</span>
                @else
                    <span class="font-bold text-red-600">NON-AKTIF</span>
                @endif
            </p>

            <form method="POST" action="{{ route('admin.absensi.mandiri.global') }}">
                @csrf
                <button
                    class="{{ $absensiGlobal ? 'bg-red-600' : 'bg-green-600' }} rounded px-4 py-2 text-white"
                >
                    {{ $absensiGlobal ? 'NONAKTIFKAN' : 'AKTIFKAN' }}
                </button>
            </form>
        </div>

        <!-- LOKASI ABSENSI -->
        <div>
            <h4 class="mb-3 font-semibold">Lokasi Absensi Mandiri</h4>

            <form method="POST" action="{{ route('admin.absensi.lokasi') }}" class="space-y-3">
                @csrf

                <div>
                    <label class="text-sm font-medium">Latitude Sekolah</label>
                    <input
                        type="text"
                        name="lat_sekolah"
                        value="{{ old('lat_sekolah', $settingLokasi->lat_sekolah ?? '') }}"
                        class="w-full rounded border p-2"
                        required
                    >
                    <p class="mt-1 text-xs text-gray-500">
                        Digunakan saat ini:
                        <span class="font-semibold">{{ $settingLokasi->lat_sekolah ?? '-' }}</span>
                    </p>
                </div>

                <div>
                    <label class="text-sm font-medium">Longitude Sekolah</label>
                    <input
                        type="text"
                        name="lng_sekolah"
                        value="{{ old('lng_sekolah', $settingLokasi->lng_sekolah ?? '') }}"
                        class="w-full rounded border p-2"
                        required
                    >
                    <p class="mt-1 text-xs text-gray-500">
                        Digunakan saat ini:
                        <span class="font-semibold">{{ $settingLokasi->lng_sekolah ?? '-' }}</span>
                    </p>
                </div>

                <div>
                    <label class="text-sm font-medium">Radius Absensi (meter)</label>
                    <input
                        type="number"
                        name="radius_meter"
                        value="{{ old('radius_meter', $settingLokasi->radius_meter ?? 20) }}"
                        class="w-full rounded border p-2"
                        min="1"
                        required
                    >
                    <p class="mt-1 text-xs text-gray-500">
                        Digunakan saat ini:
                        <span class="font-semibold">{{ $settingLokasi->radius_meter ?? '-' }} m</span>
                    </p>
                </div>

                <p class="text-xs text-orange-600">
                    ⚠ Perubahan lokasi langsung mempengaruhi absensi siswa
                </p>

                <button class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                    Simpan Lokasi
                </button>
            </form>
        </div>

    </div>
</div>


        <div class="mb-4 flex items-center justify-between">
            <form class="form relative">
                <button type="button" class="absolute left-2 top-1/2 -translate-y-1/2 p-1">
                    <svg
                        width="17"
                        height="16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        role="img"
                        aria-labelledby="search"
                        class="h-5 w-5 text-gray-700"
                    >
                        <path
                            d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9"
                            stroke="currentColor"
                            stroke-width="1.333"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        ></path>
                    </svg>
                </button>
                <input
                    id="searchSiswa"
                    class="input rounded-full border-2 border-transparent px-8 py-2 placeholder-gray-400 shadow-md transition-all duration-300 focus:border-blue-500 focus:outline-none"
                    placeholder="Search..."
                    required=""
                    type="text"
                />
                <button type="reset" class="absolute right-3 top-1/2 -translate-y-1/2 p-1">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-gray-700"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </form>

        </div>

        <form action="{{ route('admin.absensi.manual.simpan') }}" method="POST">
            @csrf
            {{-- TABLE --}}
            <div class="overflow-hidden rounded-xl border bg-white shadow">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">No</th>
                            <th class="p-3 text-left">Nama Siswa</th>
                            <th class="p-3 text-left">Kelas</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody id="absensiTable">
                        @foreach ($kelasSiswa as $i => $ks)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $i + 1 }}</td>
                                <td class="p-3">
                                    {{ $ks->siswa->user->name ?? '-' }}
                                </td>
                                <td class="p-3">
                                    {{ $ks->kelas->nama_kelas ?? '-' }}
                                </td>
                                <td class="p-3">
                                    @php
                                        $absenHariIni = $ks->absensi->first();
                                    @endphp
                                    <select name="status[{{ $ks->id }}]" class="w-full rounded-lg border px-2 py-1">
                                        <option value="">-- pilih --</option>
                                        <option
                                            value="hadir"
                                            {{ $absenHariIni?->status === 'hadir' ? 'selected' : '' }}
                                        >
                                            Hadir
                                        </option>
                                        <option value="izin" {{ $absenHariIni?->status === 'izin' ? 'selected' : '' }}>
                                            Izin
                                        </option>
                                        <option
                                            value="sakit"
                                            {{ $absenHariIni?->status === 'sakit' ? 'selected' : '' }}
                                        >
                                            Sakit
                                        </option>
                                        <option value="alpa" {{ $absenHariIni?->status === 'alpa' ? 'selected' : '' }}>
                                            Alpa
                                        </option>
                                    </select>
                                </td>
                                <td class="p-3">
                                    <input
                                        type="text"
                                        name="keterangan[{{ $ks->id }}]"
                                        class="w-full rounded-lg border px-2 py-1 focus:border-green-500 focus:outline-none"
                                        placeholder="Opsional"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4 px-4" id="paginationContainer">
                    {{ $kelasSiswa->appends(request()->query())->links() }}
                </div>
            </div>

            {{-- SUBMIT --}}
            <div class="mt-4">
                <button type="submit" class="rounded-lg bg-green-600 px-6 py-2 text-white shadow hover:bg-green-700">
                    Simpan Absensi
                </button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        const csrfToken = '{{ csrf_token() }}';
    </script>
    <script src="{{ asset('js/absensi-search.js') }}"></script>
@endsection
