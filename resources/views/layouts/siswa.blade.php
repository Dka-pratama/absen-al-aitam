<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Dashboard Siswa' }}</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="flex min-h-screen bg-[#F5F6EE]">
    {{-- TOAST CONTAINER --}}
    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if (session('error'))
        <x-alert type="danger" :message="session('error')" />
    @endif

    @if (session('info'))
        <x-alert type="info" :message="session('info')" />
    @endif

    @if ($errors->any())
        <x-alert type="danger" :message="$errors->first()" />
    @endif

    <!-- BACKDROP FOR MOBILE -->
    <div id="backdrop" class="fixed inset-0 z-30 hidden bg-black/40 md:hidden"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed left-0 top-0 z-40 h-screen w-60 -translate-x-full transform bg-gradient-to-b from-green-600 to-green-700 text-white shadow-lg transition-transform duration-300 md:translate-x-0">
        <!-- LOGO -->
        <div class="mb-6 flex items-center gap-3 px-4 pt-6">
            <img src="{{ asset('logo.png') }}" class="w-12 drop-shadow-lg" />
            <div class="text-base font-bold leading-tight">
                <div>SMK AL-AITAAM</div>
                <div>Siswa</div>
            </div>
        </div>

        <!-- MENU -->
        <nav class="mt-4 space-y-1 p-5">
            <a href="{{ route('siswa.dashboard') }}"
                class="{{ request()->routeIs('siswa.dashboard') ? 'bg-white/25 font-semibold' : 'hover:bg-white/20' }} flex items-center gap-3 rounded-lg p-3 transition">
                <i class="fa-solid fa-chart-simple"></i>
                Dashboard
            </a>

            <a href="#"
                class="{{ request()->routeIs('siswa.rekap') ? 'bg-white/25 font-semibold' : 'hover:bg-white/20' }} flex items-center gap-3 rounded-lg p-3 transition">
                <i class="fa-solid fa-calendar-days"></i>
                Rekap Absensi
            </a>

            <div class="mt-4 border-t border-white/30 pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex w-full items-center gap-3 rounded-lg p-3 text-left hover:bg-white/20">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex flex-1 flex-col md:ml-60">
        <!-- TOPBAR -->
        <header class="sticky top-0 z-20 flex items-center justify-between bg-white px-5 py-3 shadow-sm">
            <!-- HAMBURGER -->
            <button id="toggleSidebar" class="rounded p-2 hover:bg-gray-200 md:hidden">
                <i class="fa-solid fa-bars fa-xl"></i>
            </button>

            <h1 class="text-lg font-semibold tracking-wide md:text-xl">
                {{ $Header ?? 'Dashboard' }}
            </h1>
        </header>

        <!-- CONTENT -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden p-4">
            @yield('content')
        </div>
    </div>

    <!-- SIDEBAR SCRIPT -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const backdrop = document.getElementById('backdrop');

        toggleSidebar?.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
        });

        backdrop.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        });
    </script>

    @yield('script')
    <script src="{{ asset('js/Sweet-Alert.js') }}"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>
