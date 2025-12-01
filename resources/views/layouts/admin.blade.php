<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>

    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-[#F5F6EE] min-h-screen flex">

    <!-- BACKDROP (HP MODE) -->
    <div id="backdrop" class="fixed inset-0 bg-black/40 hidden md:hidden z-30"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed md:static top-0 left-0 h-full md:h-screen w-64 md:w-72 z-40
               bg-gradient-to-b from-green-600 to-green-700 text-white p-6
               rounded-br-[80px] shadow-lg
               transform -translate-x-full md:translate-x-0 transition-transform duration-300">

        <!-- LOGO -->
        <div class="flex items-center gap-3 mb-10">
            <img src="{{ asset('logo.png') }}" class="w-14 drop-shadow-lg">
            <div class="text-2xl font-bold leading-tight">
                <div>SMK AL-</div>
                <div>AITAAM</div>
            </div>
        </div>

        <!-- MENU -->
        <nav class="space-y-6 mt-4">

            <a href="/admin/dashboard"
                class="flex items-center gap-3 p-3 rounded-lg bg-white/20 font-semibold hover:bg-white/25 transition">
                <img src="{{ asset('icons/dashboard.svg') }}" class="w-5"> Dashboard
            </a>

            <a href="/akun-siswa" class="flex items-center gap-3 p-3 rounded-lg hover:bg-white/20 transition">
                <img src="{{ asset('icons/student.svg') }}" class="w-5"> Siswa
            </a>

            <a href="/akun-walikelas" class="flex items-center gap-3 p-3 rounded-lg hover:bg-white/20 transition">
                <img src="{{ asset('icons/teacher.svg') }}" class="w-5"> Wali Kelas
            </a>

            <a href="/kelas" class="flex items-center gap-3 p-3 rounded-lg hover:bg-white/20 transition">
                <img src="{{ asset('icons/class.svg') }}" class="w-5"> Kelas
            </a>

            <div class="pt-5 border-t border-white/40">
                <a href="/admin/profile" class="flex items-center gap-3 p-3 rounded-lg hover:bg-white/20 transition">
                    <img src="{{ asset('icons/setting.svg') }}" class="w-5"> Profile
                </a>

                <form method="POST" action="{{ route('logout') }}"
                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-white/20 transition">
                    @csrf
                    <button type="submit">Logout</button>
                </form>

            </div>

        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <header class="bg-white shadow-sm p-5 flex justify-between items-center">

            <!-- HAMBURGER BUTTON -->
            <button id="toggleSidebar" class="md:hidden p-2 rounded hover:bg-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <h1 class="text-xl md:text-2xl font-semibold tracking-wide">SISTEM ABSENSI SISWA</h1>

            <div class="flex items-center gap-3">
                <img src="https://via.placeholder.com/40"
                    class="w-10 h-10 md:w-11 md:h-11 rounded-full object-cover border shadow-sm">

                <div class="leading-tight hidden sm:block">
                    <p class="font-bold text-sm">Admin</p>
                    <p class="text-xs text-gray-600">admin@gmail.com</p>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="">
            @yield('content')
        </div>

    </div>

    <!-- SIDEBAR SCRIPT -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const backdrop = document.getElementById('backdrop');

        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
        });

        backdrop.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        });
    </script>

</body>

</html>
