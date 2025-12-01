<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    {{-- Tidak ada sidebar, tidak ada navbar Breeze --}}
    <div class="max-w-sm mx-auto min-h-screen bg-white shadow rounded-2xl overflow-hidden">
        @yield('content')
    </div>

</body>
</html>
