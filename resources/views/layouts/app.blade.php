<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ $title ?? 'Dashboard' }}</title>

        <!-- Font Poppins -->
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
            rel="stylesheet"
        />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Poppins', sans-serif;
            }
        </style>
    </head>

    <body class="flex min-h-screen bg-[#F5F6EE]">
        <!-- BACKDROP (HP MODE) -->
        <div id="backdrop" class="fixed inset-0 z-30 hidden bg-black/40 md:hidden"></div>

        <!-- SIDEBAR -->
        <aside
            id="sidebar"
            class="fixed left-0 top-0 z-40 h-full w-64 -translate-x-full transform rounded-br-[80px] bg-gradient-to-b from-green-600 to-green-700 p-6 text-white shadow-lg transition-transform duration-300 md:static md:h-screen md:w-72 md:translate-x-0"
        >
            <!-- LOGO -->
            <div class="mb-10 flex items-center gap-3">
                <img src="{{ asset('logo.png') }}" class="w-14 drop-shadow-lg" />
                <div class="text-2xl font-bold leading-tight">
                    <div>SMK AL-</div>
                    <div>AITAAM</div>
                </div>
            </div>

            <!-- MENU -->
            <nav class="mt-4 space-y-6">
                <a
                    href="/admin/dashboard"
                    class="flex items-center gap-3 rounded-lg bg-white/20 p-3 font-semibold transition hover:bg-white/25"
                >
                    <img src="{{ asset('icons/dashboard.svg') }}" class="w-5" />
                    Dashboard
                </a>

                <a href="/admin/siswa" class="flex items-center gap-3 rounded-lg p-3 transition hover:bg-white/20">
                    <img src="{{ asset('icons/student.svg') }}" class="w-5" />
                    Siswa
                </a>

                <a href="/admin/walikelas" class="flex items-center gap-3 rounded-lg p-3 transition hover:bg-white/20">
                    <img src="{{ asset('icons/teacher.svg') }}" class="w-5" />
                    Wali Kelas
                </a>

                <a href="/admin/kelas" class="flex items-center gap-3 rounded-lg p-3 transition hover:bg-white/20">
                    <img src="{{ asset('icons/class.svg') }}" class="w-5" />
                    Kelas
                </a>

                <div class="border-t border-white/40 pt-5">
                    <a
                        href="/admin/profile"
                        class="flex items-center gap-3 rounded-lg p-3 transition hover:bg-white/20"
                    >
                        <img src="{{ asset('icons/setting.svg') }}" class="w-5" />
                        Profile
                    </a>

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                        class="flex items-center gap-3 rounded-lg p-3 transition hover:bg-white/20"
                    >
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex flex-1 flex-col">
            <!-- TOPBAR -->
            <header class="flex items-center justify-between bg-white p-5 shadow-sm">
                <!-- HAMBURGER BUTTON -->
                <button id="toggleSidebar" class="rounded p-2 hover:bg-gray-200 md:hidden">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-7 w-7"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                </button>

                <h1 class="text-xl font-semibold tracking-wide md:text-2xl">SISTEM ABSENSI SISWA</h1>

                <div class="flex items-center gap-3">
                    <img
                        src="https://via.placeholder.com/40"
                        class="h-10 w-10 rounded-full border object-cover shadow-sm md:h-11 md:w-11"
                    />

                    <div class="hidden leading-tight sm:block">
                        <p class="text-sm font-bold">Admin</p>
                        <p class="text-xs text-gray-600">admin@gmail.com</p>
                    </div>
                </div>
            </header>

            <!-- CONTENT -->
            <div class="p-6 md:p-8">
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
