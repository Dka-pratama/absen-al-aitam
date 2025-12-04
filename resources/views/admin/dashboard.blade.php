@extends('layouts.admin')

@section('content')

<div class="p-2 sm:p-4 lg:p-8">

    <!-- CARD WRAPPER -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
        <!-- CARD 1 -->
        <div class="bg-[#17A85B] text-white p-3 rounded-lg shadow-md flex flex-col items-center">
            <div class="text-2xl mb-2">🖼️</div>
            <p class="text-3xl font-bold">{{ $totalSiswa }}</p>
            <p class="text-sm mt-1 opacity-90">total siswa</p>
        </div>

        <!-- CARD 2 -->
        <div class="bg-[#17A85B] text-white p-3 rounded-lg shadow-md flex flex-col items-center">
            <div class="text-2xl mb-2">👨‍🎓</div>
            <p class="text-3xl font-bold">{{ $totalKelas }}</p>
            <p class="text-sm mt-1 opacity-90">total kelas</p>
        </div>

        <!-- CARD 3 -->
        <div class="bg-[#17A85B] text-white p-3 rounded-lg shadow-md flex flex-col items-center">
            <div class="text-2xl mb-2">🧑‍🏫</div>
            <p class="text-3xl font-bold">{{ $totalWali }}</p>
            <p class="text-sm mt-1 opacity-90">total wali kelas</p>
        </div>

        <!-- CARD 4 -->
        <div class="bg-[#17A85B] text-white p-3 rounded-lg shadow-md flex flex-col items-center">
            <div class="text-2xl mb-2">🎓</div>
            <p class="text-3xl font-bold">{{ $totalJurusan }}</p>
            <p class="text-sm mt-1 opacity-90">total Jurusan</p>
        </div>
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
            "07:00","08:00","09:00","10:00","11:00",
            "12:00","13:00","14:00","15:00","16:00",
            "17:00","18:00"
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
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>

@endsection
