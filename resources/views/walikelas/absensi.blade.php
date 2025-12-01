@extends('layouts.walikelas')

@section('content')

{{-- HEADER USER --}}
<div class="flex justify-end items-center gap-3 mb-6">
    <img src="/img/guru.jpg" class="w-12 h-12 rounded-full object-cover">
    <div class="text-right">
        <h4 class="font-bold">Drs Sri Wahyuni, M. Ag.</h4>
        <p class="text-sm text-gray-600">SriWahyuni23@gmail.com</p>
    </div>
</div>

{{-- TITLE --}}
<h2 class="text-3xl font-bold text-center mb-6">SISTEM ABSENSI SISWA</h2>

<form method="POST" action="{{ route('walikelas.absensi.store') }}">
    @csrf

    {{-- TOP STATUS CARD --}}
    <div class="bg-white shadow rounded-2xl p-6 flex items-center gap-8 mb-8 border">

        {{-- LEFT STATUS LIST --}}
        <div class="flex flex-col gap-3">
            <div class="flex items-center gap-2 bg-green-100 px-4 py-2 rounded-full w-44">
                <span class="w-3 h-3 rounded-full bg-green-500"></span>
                <span class="text-sm">Hadir</span>
                <span class="ml-auto font-bold">{{ $hadir }}</span>
            </div>

            <div class="flex items-center gap-2 bg-yellow-100 px-4 py-2 rounded-full w-44">
                <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                <span class="text-sm">Sakit</span>
                <span class="ml-auto font-bold">{{ $sakit }}</span>
            </div>

            <div class="flex items-center gap-2 bg-blue-100 px-4 py-2 rounded-full w-44">
                <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                <span class="text-sm">Izin</span>
                <span class="ml-auto font-bold">{{ $izin }}</span>
            </div>

            <div class="flex items-center gap-2 bg-red-100 px-4 py-2 rounded-full w-44">
                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                <span class="text-sm">Alpha</span>
                <span class="ml-auto font-bold">{{ $alpha }}</span>
            </div>
        </div>

        {{-- MIDDLE RING --}}
        <div class="flex-1 flex justify-center">
            <div class="bg-gray-100 rounded-xl p-6 w-[360px] flex gap-6 items-center shadow-inner">

                {{-- RING --}}
                <div class="relative w-32 h-32 flex items-center justify-center">
                    @php
                        $percent = $hadir / $total * 360;
                    @endphp

                    <div class="absolute inset-0 rounded-full"
                        style="background: conic-gradient(#21A16B {{ $percent }}deg, #e5e7eb 0deg);">
                    </div>

                    <div class="absolute bg-white w-20 h-20 rounded-full flex flex-col items-center justify-center shadow-inner">
                        <span class="text-xl font-bold">{{ $hadir }}/{{ $total }}</span>
                        <span class="text-xs text-gray-600">Hadir</span>
                    </div>
                </div>

                {{-- BUTTONS --}}
                <div class="flex flex-col gap-4">
                    <button type="button"
                        class="bg-yellow-400 px-5 py-3 rounded-lg font-semibold shadow hover:bg-yellow-500 flex items-center gap-2">
                        📷 Tampilkan QrCode
                    </button>

                    <button type="button"
                        class="bg-blue-500 text-white px-5 py-3 rounded-lg font-semibold shadow hover:bg-blue-600">
                        Presensi Mandiri
                    </button>
                </div>
            </div>
        </div>

        {{-- SAVE --}}
        <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold shadow">
            <i class="fa fa-save"></i> Simpan
        </button>
    </div>

    {{-- TABLE --}}
    <div class="bg-white p-6 shadow rounded-2xl border">

        <table class="w-full table-auto text-sm">
            <thead>
                <tr class="border-b bg-gray-100 text-gray-700">
                    <th class="py-3 text-left w-10">No</th>
                    <th class="py-3 text-left w-20">NIS</th>
                    <th class="py-3 text-left">Nama Siswa/Siswi</th>
                    <th class="py-3 text-center w-60">Absensi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($siswa as $i => $st)
                <tr class="border-b">
                    <td class="py-3">{{ $i + 1 }}</td>
                    <td>{{ $st['nis'] }}</td>
                    <td class="font-medium">{{ $st['nama'] }}</td>

                    <td class="py-3">
                        <div class="flex justify-center gap-3">

                            {{-- RADIO BUTTON FIX STATIC COLOR --}}
                            @foreach(['H','S','I','A'] as $kode)
                                @php
                                    $active = isset($st['absen']) && $st['absen'] == $kode;
                                @endphp

                                <label class="
                                    w-8 h-8 flex items-center justify-center rounded-full border text-sm font-semibold cursor-pointer transition

                                    {{-- ACTIVE COLORS --}}
                                    @if($active && $kode=='H') bg-green-500 text-white border-green-500 @endif
                                    @if($active && $kode=='S') bg-yellow-500 text-white border-yellow-500 @endif
                                    @if($active && $kode=='I') bg-blue-500 text-white border-blue-500 @endif
                                    @if($active && $kode=='A') bg-red-500 text-white border-red-500 @endif

                                    {{-- INACTIVE --}}
                                    @if(!$active)
                                        text-gray-700 border-gray-300
                                        @if($kode=='H') hover:bg-green-100 @endif
                                        @if($kode=='S') hover:bg-yellow-100 @endif
                                        @if($kode=='I') hover:bg-blue-100 @endif
                                        @if($kode=='A') hover:bg-red-100 @endif
                                    @endif
                                ">
                                    <input type="radio" name="absen[{{ $i }}]" class="hidden" value="{{ $kode }}">
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
