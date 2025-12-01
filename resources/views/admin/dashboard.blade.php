@extends('layouts.admin')

@section('content')

<div class="px-10 py-8">

    <!-- TITLE -->
    <h1 class="text-3xl font-bold mb-1">Dashboard</h1>
    <p class="text-gray-500 mb-8">Welcome back, Admin</p>

    <!-- CARD WRAPPER -->
    <div class="flex gap-6 mb-12">

        <!-- CARD 1 -->
        <div class="bg-[#17A85B] text-white w-[230px] p-6 rounded-lg shadow-md flex flex-col justify-center">
            <div class="text-3xl mb-2">🖼️</div>
            <p class="text-3xl font-bold leading-none">{{ $totalSiswa }}</p>
            <p class="text-sm mt-1 opacity-90">total siswa</p>
        </div>

        <!-- CARD 2 -->
        <div class="bg-[#17A85B] text-white w-[230px] p-6 rounded-lg shadow-md flex flex-col justify-center">
            <div class="text-3xl mb-2">👨‍🎓</div>
            <p class="text-3xl font-bold leading-none">{{ $totalKelas }}</p>
            <p class="text-sm mt-1 opacity-90">total kelas</p>
        </div>

        <!-- CARD 3 -->
        <div class="bg-[#17A85B] text-white w-[230px] p-6 rounded-lg shadow-md flex flex-col justify-center">
            <div class="text-3xl mb-2">🧑‍🏫</div>
            <p class="text-3xl font-bold leading-none">{{ $totalWali }}</p>
            <p class="text-sm mt-1 opacity-90">total wali kelas</p>
        </div>

        <!-- CARD 4 -->
        <div class="bg-[#17A85B] text-white w-[230px] p-6 rounded-lg shadow-md flex flex-col justify-center">
            <div class="text-3xl mb-2">🎓</div>
            <p class="text-3xl font-bold leading-none">{{ $totalJurusan }}</p>
            <p class="text-sm mt-1 opacity-90">total Jurusan</p>
        </div>

    </div>

    <!-- CHART TITLE -->
    <h2 class="text-xl font-semibold mb-4">Aktivitas web per jam</h2>

    <!-- CHART BOX -->
    <div class="bg-white border rounded-xl shadow p-8">
        <canvas id="myChart" height="90"></canvas>
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
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

@endsection
