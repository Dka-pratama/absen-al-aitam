@extends("layouts.walikelas")

@section("content")
    {{-- HEADER USER --}}
    <div class="mb-6 flex items-center justify-end gap-3">
        <img src="/img/guru.jpg" class="h-12 w-12 rounded-full object-cover" />
        <div class="text-right">
            <h4 class="font-bold">Drs Sri Wahyuni, M. Ag.</h4>
            <p class="text-sm text-gray-600">SriWahyuni23@gmail.com</p>
        </div>
    </div>

    {{-- TITLE --}}
    <h2 class="mb-6 text-center text-3xl font-bold">SISTEM ABSENSI SISWA</h2>

    <form method="POST" action="{{ route("walikelas.absensi.store") }}">
        @csrf

        {{-- TOP STATUS CARD --}}
        <div class="mb-8 flex items-center gap-8 rounded-2xl border bg-white p-6 shadow">
            {{-- LEFT STATUS LIST --}}
            <div class="flex flex-col gap-3">
                <div class="flex w-44 items-center gap-2 rounded-full bg-green-100 px-4 py-2">
                    <span class="h-3 w-3 rounded-full bg-green-500"></span>
                    <span class="text-sm">Hadir</span>
                    <span class="ml-auto font-bold">{{ $hadir }}</span>
                </div>

                <div class="flex w-44 items-center gap-2 rounded-full bg-yellow-100 px-4 py-2">
                    <span class="h-3 w-3 rounded-full bg-yellow-500"></span>
                    <span class="text-sm">Sakit</span>
                    <span class="ml-auto font-bold">{{ $sakit }}</span>
                </div>

                <div class="flex w-44 items-center gap-2 rounded-full bg-blue-100 px-4 py-2">
                    <span class="h-3 w-3 rounded-full bg-blue-500"></span>
                    <span class="text-sm">Izin</span>
                    <span class="ml-auto font-bold">{{ $izin }}</span>
                </div>

                <div class="flex w-44 items-center gap-2 rounded-full bg-red-100 px-4 py-2">
                    <span class="h-3 w-3 rounded-full bg-red-500"></span>
                    <span class="text-sm">Alpha</span>
                    <span class="ml-auto font-bold">{{ $alpha }}</span>
                </div>
            </div>

            {{-- MIDDLE RING --}}
            <div class="flex flex-1 justify-center">
                <div class="flex w-[360px] items-center gap-6 rounded-xl bg-gray-100 p-6 shadow-inner">
                    {{-- RING --}}
                    <div class="relative flex h-32 w-32 items-center justify-center">
                        @php
                            $percent = ($hadir / $total) * 360;
                        @endphp

                        <div
                            class="absolute inset-0 rounded-full"
                            style="background: conic-gradient(#21a16b {{ $percent }}deg, #e5e7eb 0deg)"
                        ></div>

                        <div
                            class="absolute flex h-20 w-20 flex-col items-center justify-center rounded-full bg-white shadow-inner"
                        >
                            <span class="text-xl font-bold">{{ $hadir }}/{{ $total }}</span>
                            <span class="text-xs text-gray-600">Hadir</span>
                        </div>
                    </div>

                    {{-- BUTTONS --}}
                    <div class="flex flex-col gap-4">
                        <button
                            type="button"
                            class="flex items-center gap-2 rounded-lg bg-yellow-400 px-5 py-3 font-semibold shadow hover:bg-yellow-500"
                        >
                            📷 Tampilkan QrCode
                        </button>

                        <button
                            type="button"
                            class="rounded-lg bg-blue-500 px-5 py-3 font-semibold text-white shadow hover:bg-blue-600"
                        >
                            Presensi Mandiri
                        </button>
                    </div>
                </div>
            </div>

            {{-- SAVE --}}
            <button class="rounded-xl bg-green-600 px-6 py-3 font-semibold text-white shadow hover:bg-green-700">
                <i class="fa fa-save"></i>
                Simpan
            </button>
        </div>

        {{-- TABLE --}}
        <div class="rounded-2xl border bg-white p-6 shadow">
            <table class="w-full table-auto text-sm">
                <thead>
                    <tr class="border-b bg-gray-100 text-gray-700">
                        <th class="w-10 py-3 text-left">No</th>
                        <th class="w-20 py-3 text-left">NIS</th>
                        <th class="py-3 text-left">Nama Siswa/Siswi</th>
                        <th class="w-60 py-3 text-center">Absensi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($siswa as $i => $st)
                        <tr class="border-b">
                            <td class="py-3">{{ $i + 1 }}</td>
                            <td>{{ $st["nis"] }}</td>
                            <td class="font-medium">{{ $st["nama"] }}</td>

                            <td class="py-3">
                                <div class="flex justify-center gap-3">
                                    {{-- RADIO BUTTON FIX STATIC COLOR --}}
                                    @foreach (["H", "S", "I", "A"] as $kode)
                                        @php
                                            $active = isset($st["absen"]) && $st["absen"] == $kode;
                                        @endphp

                                        <label
                                            class="{{-- ACTIVE COLORS --}} @if($active && $kode=='H') bg-green-500 text-white border-green-500 @endif @if($active && $kode=='S') bg-yellow-500 text-white border-yellow-500 @endif @if($active && $kode=='I') bg-blue-500 text-white border-blue-500 @endif @if($active && $kode=='A') bg-red-500 text-white border-red-500 @endif {{-- INACTIVE --}} @if (! $active)
                                                text-gray-700
                                                border-gray-300
                                                @if ($kode == "H")
                                                    hover:bg-green-100
                                                @endif

                                                @if ($kode == "S")
                                                    hover:bg-yellow-100
                                                @endif

                                                @if ($kode == "I")
                                                    hover:bg-blue-100
                                                @endif

                                                @if ($kode == "A")
                                                    hover:bg-red-100
                                                @endif
                                            @endif flex h-8 w-8 cursor-pointer items-center justify-center rounded-full border text-sm font-semibold transition"
                                        >
                                            <input
                                                type="radio"
                                                name="absen[{{ $i }}]"
                                                class="hidden"
                                                value="{{ $kode }}"
                                            />
                                            {{ $kode }}
                                        </label>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
@endsection
