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
        <!-- FontAwesome 7 -->
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
            integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <!-- Sweet Allert -->
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

        <!-- BACKDROP (HP MODE) -->
        <div id="backdrop" class="fixed inset-0 z-30 hidden bg-black/40 md:hidden"></div>

        <!-- SIDEBAR -->
        <aside
            id="sidebar"
            class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full transform rounded-br-[80px] bg-gradient-to-b from-green-600 to-green-700 text-white shadow-lg transition-transform duration-300 md:translate-x-0"
        >
            <!-- LOGO -->
            <div class="mb-6 flex items-center gap-3 px-4 pt-6">
                <img src="{{ asset('logo.png') }}" class="w-14 drop-shadow-lg" />
                <div class="text-lg font-bold leading-tight">
                    <div>SMK AL-AITAAM</div>
                </div>
            </div>

            <!-- MENU -->
            <nav class="mt-4 space-y-2 p-6">
                <a
                    href="/admin/dashboard"
                    class="{{ request()->is('admin/dashboard') ? 'bg-white/25 font-bold' : 'hover:bg-white/20' }} flex items-center gap-3 rounded-lg p-3 transition"
                >
                    <img src="{{ asset('icons/dashboard.svg') }}" class="w-5" />
                    Dashboard
                </a>

                <a
                    href="{{ route('akun-siswa.index') }}"
                    class="{{ Route::is('akun-siswa.*') ? 'bg-white/25 font-bold' : 'hover:bg-white/20' }} flex items-center gap-3 rounded-lg p-3 transition"
                >
                    <img src="{{ asset('icons/student.svg') }}" class="w-5" />
                    Siswa
                </a>

                <a
                    href="{{ route('akun-walikelas.index') }}"
                    class="{{ Route::is('akun-walikelas.*') ? 'bg-white/25 font-bold' : 'hover:bg-white/20' }} flex items-center gap-3 rounded-lg p-3 transition"
                >
                    <img src="{{ asset('icons/teacher.svg') }}" class="w-5" />
                    Wali Kelas
                </a>

                <a
                    href="{{ route('kelas.index') }}"
                    class="{{ Route::is('kelas.*') ? 'bg-white/25 font-bold' : 'hover:bg-white/20' }} flex items-center gap-3 rounded-lg p-3 transition"
                >
                    <img src="{{ asset('icons/class.svg') }}" class="w-5" />
                    Kelas
                </a>
                <a
                    href="{{ route('tahun.index') }}"
                    class="{{ Route::is('tahun.*') ? 'bg-white/25 font-bold' : 'hover:bg-white/20' }} flex items-center gap-3 rounded-lg p-3 transition"
                >
                    <img src="{{ asset('icons/class.svg') }}" class="w-5" />
                    Tahun Ajar
                </a>

                <a
                    href="{{ route('absen.index') }}"
                    class="{{ Route::is('absen.*') ? 'bg-white/25 font-bold' : 'hover:bg-white/20' }} flex items-center gap-3 rounded-lg p-3 transition"
                >
                    <img src="{{ asset('icons/absensi.svg') }}" class="w-5" />
                    Absensi
                </a>

                <div class="border-t border-white/40 pt-5">
                    <a
                        href="/admin/profile"
                        class="{{ request()->is('admin/profile') ? 'bg-white/25 font-bold' : 'hover:bg-white/20' }} flex items-center gap-3 rounded-lg p-3 transition"
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
        <div class="flex flex-1 flex-col md:ml-64">
            <!-- TOPBAR -->
            <header class="sticky top-0 z-20 flex items-center justify-between bg-white px-5 py-3 shadow-sm">
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
                <h1 class="text-xl font-semibold tracking-wide md:text-2xl">
                    {{ $Header ?? '-' }}
                </h1>
                <div class="flex items-center gap-3">
                    <div class="hidden leading-tight sm:block">
                        <p class="text-sm font-bold">Admin</p>
                        <p class="text-xs text-gray-600">admin@gmail.com</p>
                    </div>
                </div>
            </header>

            <!-- CONTENT -->
            <div class="flex-1 overflow-auto">
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
        @yield('script')
        <script src="{{ asset('js/Sweet-Alert.js') }}"></script>
        <!-- Alpine JS -->
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.15.0/cdn.js"
            integrity="sha512-nHfCQtLDRfNgzsuMx2O2Joo3+xM8antMOBxo9GodZry1h33+lWa2Dd3a/lkVY4fHJK1CAkFcUrz2jilsaZFWeQ=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        ></script>
    </body>
</html>
