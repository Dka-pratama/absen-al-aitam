@extends('layouts.admin')

@section('content')
    <div class="p-2 sm:p-4 md:p-6 lg:p-8">
        <!-- CARD WRAPPER -->
        <div class="box-border grid w-full gap-2 px-3 md:grid-cols-2 xl:grid-cols-4">
            @php
                $cards = [
                    [
                        'value' => $totalSiswa,
                        'label' => 'Total Siswa',
                        'bg' => 'bg-green-600',
                        'shadow' => 'hover:shadow-[0_-8px_0px_0px_#2196f3]',
                        'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-user text-white"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2a5 5 0 1 1 -5 5l.005 -.217a5 5 0 0 1 4.995 -4.783z" /><path d="M14 14a5 5 0 0 1 5 5v1a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-1a5 5 0 0 1 5 -5h4z" /></svg>',
                    ],
                    [
                        'value' => $totalKelas,
                        'label' => 'Total Kelas',
                        'bg' => 'bg-[rgb(41,49,79)]',
                        'shadow' => 'hover:shadow-[0_-8px_0px_0px_#2196f3]',
                        'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white icon icon-tabler icons-tabler-outline icon-tabler-building-arch"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l18 0" /><path d="M4 21v-15a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v15" /><path d="M9 21v-8a3 3 0 0 1 6 0v8" /></svg>',
                    ],
                    [
                        'value' => $totalWali,
                        'label' => 'Total Wali Kelas',
                        'bg' => 'bg-[#673ab7]',
                        'shadow' => 'hover:shadow-[0_-8px_0px_0px_#2196f3]',
                        'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chalkboard-teacher text-white"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 19h-3a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v11a1 1 0 0 1 -1 1" /><path d="M12 14a2 2 0 1 0 4.001 -.001a2 2 0 0 0 -4.001 .001" /><path d="M17 19a2 2 0 0 0 -2 -2h-2a2 2 0 0 0 -2 2" /></svg>',
                    ],
                    [
                        'value' => $totalJurusan,
                        'label' => 'Total Jurusan',
                        'bg' => 'bg-[rgb(41,49,79)]',
                        'shadow' => 'hover:shadow-[0_-8px_0px_0px_#2196f3]',
                        'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-databricks text-white"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l9 5l9 -5v-3l-9 5l-9 -5v-3l9 5l9 -5v-3l-9 5l-9 -5l9 -5l5.418 3.01" /></svg>',
                    ],
                ];
            @endphp

            @foreach ($cards as $card)
                <div
                    class="{{ $card['bg'] }} {{ $card['shadow'] }} group relative w-full cursor-pointer rounded-lg p-5 transition duration-300 hover:translate-y-[3px]"
                >
                    <p class="text-2xl text-white">{{ $card['value'] }}</p>
                    <p class="text-sm text-white">{{ $card['label'] }}</p>

                    <!-- Contoh SVG kecil, bisa diganti sesuai kebutuhan -->
                    <div
                        class="absolute right-[10%] top-[50%] translate-y-[-50%] opacity-20 transition duration-300 group-hover:scale-110 group-hover:opacity-100"
                    >
                        {!! $card['svg'] !!}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- CHART TITLE -->
        <h2 class="mb-6 mt-6 text-xl font-semibold">Aktivitas web per jam</h2>

        <!-- CHART BOX -->
        <div class="w-full max-w-full overflow-x-auto rounded-xl border bg-white p-6 shadow md:p-8">
    <canvas
        id="loginChart" class="w-full"
        data-labels='@json($labels)'
        data-values='@json($values)'>
    </canvas>
</div>
    </div>

    <!-- CHART.JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const canvas = document.getElementById('loginChart');

        const labels = JSON.parse(canvas.dataset.labels);
        const values = JSON.parse(canvas.dataset.values);

        new Chart(canvas, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Login',
                    data: values,
                }]
            },
            options: {
                scales: {
                    x:{
                        ticks:{
                            maxRotation: 45,
                            minRotation: 45,
                            callback: function(value, index) {
                    // tampilkan hanya tiap 2 jam
                    return index % 2 === 0 ? this.getLabelForValue(value) : '';
                }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 2 }
                    }
                }
            }
        });
    </script>
@endsection
