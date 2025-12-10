@extends('layouts.walikelas')

@section('content')
    <div class="p-2 sm:p-4 lg:p-8">
        <div class="mb-4">
            <p class="text-xl font-semibold text-gray-800 sm:text-2xl">Halo, {{ $wali->user->name }}!</p>
        </div>
        <div class="mb-6 flex flex-col gap-4 border-b pb-3 text-gray-700 sm:flex-row sm:items-center sm:justify-start">
            <div>
                <span class="text-sm font-semibold">Hari Ini:</span>
                <span class="text-base font-medium">
                    {{ \Carbon\Carbon::parse($hariIni)->translatedFormat('l, d F Y') }}
                </span>
            </div>
            <div>
                <span class="text-sm font-semibold">Kelas:</span>
                <span class="text-base font-medium">{{ $kelas->nama_kelas }}</span>
            </div>
            <div>
                <span class="text-sm font-semibold">Tahun Ajar:</span>
                <span class="text-base font-medium">{{ $tahunAjar->tahun }}</span>
            </div>
        </div>
        <!-- CARD WRAPPER -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4">
            @php
                $cards = [
                    [
                        'value' => $totalSiswa,
                        'label' => 'Total Siswa',
                        'bg' => 'bg-[#673ab7]',
                        'shadow' => 'hover:shadow-[0_-8px_0px_0px_#2196f3]',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-round-icon lucide-users-round text-white"><path d="M18 21a8 8 0 0 0-16 0"/><circle cx="10" cy="8" r="5"/><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/></svg>',
                    ],
                    [
                        'value' => $hadir,
                        'label' => 'Hadir',
                        'bg' => 'bg-green-600',
                        'shadow' => 'hover:shadow-[0_-8px_0px_0px_#22c55e]',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big-icon lucide-circle-check-big text-white"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg>',
                    ],
                    [
                        'value' => $izin + $sakit + $alpa,
                        'label' => 'Tidak Hadir',
                        'bg' => 'bg-red-500',
                        'shadow' => 'hover:shadow-[0_-8px_0px_0px_#ef4444]',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white lucide lucide-circle-x-icon lucide-circle-x"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>',
                    ],
                    [
                        'value' => $persentaseHadir . '%',
                        'label' => 'Persentase Hadir',
                        'bg' => 'bg-blue-600',
                        'shadow' => 'hover:shadow-[0_-8px_0px_0px_#3b82f6]',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-percent-icon lucide-circle-percent text-white"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="M9 9h.01"/><path d="M15 15h.01"/></svg>',
                    ],
                ];
            @endphp

            @foreach ($cards as $card)
                <div
                    class="{{ $card['bg'] }} {{ $card['shadow'] }} group relative w-full cursor-pointer rounded-lg p-5 transition duration-300 hover:translate-y-[3px]"
                >
                    <p class="text-2xl font-bold text-white">{{ $card['value'] }}</p>
                    <p class="text-sm text-white">{{ $card['label'] }}</p>

                    <!-- SVG icon unik -->
                    <div
                        class="absolute right-5 top-1/2 -translate-y-1/2 opacity-20 transition duration-300 group-hover:scale-110 group-hover:opacity-100"
                    >
                        {!! $card['icon'] !!}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- CHART TITLE -->
        <h2 class="mb-6 mt-6 text-xl font-semibold">Aktivitas web per jam</h2>

        <!-- CHART BOX -->
        <div class="w-full rounded-xl border bg-white p-6 shadow md:p-8">
            <canvas id="myChart" class="h-64 w-full md:h-80"></canvas>
        </div>
    </div>
@endsection
