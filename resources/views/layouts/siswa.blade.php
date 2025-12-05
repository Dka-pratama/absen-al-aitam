<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Siswa</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-gray-100">
        {{-- Tidak ada sidebar, tidak ada navbar Breeze --}}
        <div class="mx-auto min-h-screen max-w-sm overflow-hidden rounded-2xl bg-white shadow">
            @yield('content')
        </div>
    </body>
</html>
