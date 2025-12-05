@extends('layouts.admin')

@section('content')
    <div class="p-2 sm:p-4 lg:p-8">

<!-- CARD WRAPPER -->
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 mb-6 place-items-center">

    <!-- CARD TEMPLATE -->
    @php
        $cards = [
            ['value' => $totalSiswa, 'label' => 'Total Siswa'],
            ['value' => $totalKelas, 'label' => 'Total Kelas'],
            ['value' => $totalWali, 'label' => 'Total Wali Kelas'],
            ['value' => $totalJurusan, 'label' => 'Total Jurusan'],
        ];
    @endphp

    @foreach ($cards as $card)
    <div
        class="hover:-translate-y-2 group bg-neutral-50 duration-500
               w-36 h-36 flex text-neutral-700 flex-col justify-center items-center
               relative rounded-xl overflow-hidden shadow-md">

        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"
            class="absolute blur z-10 fill-red-300 duration-500 group-hover:blur-none group-hover:scale-105">
            <path transform="translate(100 100)"
                d="M39.5,-49.6C54.8,-43.2,73.2,-36.5,78.2,-24.6C83.2,-12.7,74.8,4.4,69,22.5C63.3,40.6,60.2,59.6,49.1,64.8C38.1,70,19,61.5,0.6,60.7C-17.9,59.9,-35.9,67,-47.2,61.9C-58.6,56.7,-63.4,39.5,-70,22.1C-76.6,4.7,-84.9,-12.8,-81.9,-28.1C-79,-43.3,-64.6,-56.3,-49.1,-62.5C-33.6,-68.8,-16.8,-68.3,-2.3,-65.1C12.1,-61.9,24.2,-55.9,39.5,-49.6Z">
            </path>
        </svg>

        <div class="z-20 flex flex-col justify-center items-center text-center">
            <span class="font-bold text-4xl">{{ $card['value'] }}</span>
            <p class="font-semibold text-sm mt-1">{{ $card['label'] }}</p>
        </div>

    </div>
    @endforeach

</div>


        <!-- CHART TITLE -->
        <h2 class="text-xl font-semibold mb-6">Aktivitas web per jam</h2>

        <!-- CHART BOX -->
        <div class="bg-white border rounded-xl shadow p-6 md:p-8 w-full">
            <canvas id="myChart" class="w-full h-64 md:h-80"></canvas>
        </div>

    </div>

    <!-- CHART.JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('myChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    "07:00", "08:00", "09:00", "10:00", "11:00",
                    "12:00", "13:00", "14:00", "15:00", "16:00",
                    "17:00", "18:00"
                ],
                datasets: [{
                    label: "Aktivitas",
                    data: [12, 16, 9, 12, 20, 18, 17, 14, 13, 10, 8, 18],
                    fill: true,
                    borderWidth: 3,
                    tension: 0.4,
                    borderColor: "rgba(0, 60, 255, 1)",
                    backgroundColor: "rgba(0, 60, 255, 0.12)"
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
