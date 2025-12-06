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
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        class="icon icon-tabler icons-tabler-filled icon-tabler-layout-dashboard"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M9 3a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2zm0 12a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-2a2 2 0 0 1 2 -2zm10 -4a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2zm0 -8a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-2a2 2 0 0 1 2 -2z"
                        />
                    </svg>
                    Dashboard
                </a>

                <a
                    href="{{ route('akun-siswa.index') }}"
                    class="{{ Route::is('akun-siswa.*') ? 'bg-white/25 font-bold' : 'hover:bg-white/20' }} flex items-center gap-3 rounded-lg p-3 transition"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-users"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                    </svg>
                    Siswa
                </a>

                <a
                    href="{{ route('akun-walikelas.index') }}"
                    class="{{ Route::is('akun-walikelas.*') ? 'bg-white/25 font-bold' : 'hover:bg-white/20' }} flex items-center gap-3 rounded-lg p-3 transition"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="lucide lucide-user-icon lucide-user"
                    >
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Wali Kelas
                </a>

                <a
                    href="{{ route('kelas.index') }}"
                    class="{{ Route::is('kelas.*') ? 'bg-white/25 font-bold' : 'hover:bg-white/20' }} flex items-center gap-3 rounded-lg p-3 transition"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-door"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M14 12v.01" />
                        <path d="M3 21h18" />
                        <path d="M6 21v-16a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v16" />
                    </svg>
                    Kelas
                </a>
                <a
                    href="{{ route('tahun.index') }}"
                    class="{{ Route::is('tahun.*') ? 'bg-white/25 font-bold' : 'hover:bg-white/20' }} flex items-center gap-3 rounded-lg p-3 transition"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="lucide lucide-calendar-days-icon lucide-calendar-days"
                    >
                        <path d="M8 2v4" />
                        <path d="M16 2v4" />
                        <rect width="18" height="18" x="3" y="4" rx="2" />
                        <path d="M3 10h18" />
                        <path d="M8 14h.01" />
                        <path d="M12 14h.01" />
                        <path d="M16 14h.01" />
                        <path d="M8 18h.01" />
                        <path d="M12 18h.01" />
                        <path d="M16 18h.01" />
                    </svg>
                    Tahun Ajar
                </a>

                <a
                    href="{{ route('absen.index') }}"
                    class="{{ Route::is('absen.*') ? 'bg-white/25 font-bold' : 'hover:bg-white/20' }} flex items-center gap-3 rounded-lg p-3 transition"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="lucide lucide-file-user-icon lucide-file-user"
                    >
                        <path
                            d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"
                        />
                        <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                        <path d="M16 22a4 4 0 0 0-8 0" />
                        <circle cx="12" cy="15" r="3" />
                    </svg>
                    Absensi
                </a>

                <div class="space-y-2 border-t border-white/40 py-5">
                    <a
                        href="/admin/profile"
                        class="{{ request()->is('admin/profile') ? 'bg-white/25 font-bold' : 'hover:bg-white/20' }} flex items-center gap-3 rounded-lg p-3 transition"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-circle-user-round-icon lucide-circle-user-round"
                        >
                            <path d="M18 20a6 6 0 0 0-12 0" />
                            <circle cx="12" cy="10" r="4" />
                            <circle cx="12" cy="12" r="10" />
                        </svg>
                        Profile
                    </a>

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                        class="flex items-center gap-3 rounded-lg p-3 transition hover:bg-white/20"
                    >
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 text-left">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-log-out-icon lucide-log-out"
                            >
                                <path d="m16 17 5-5-5-5" />
                                <path d="M21 12H9" />
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            </svg>
                            Logout
                        </button>
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
                    <i class="fa-solid fa-bars fa-xl"></i>
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
        <!-- Toggle Password Visibility -->
        <script>
            function togglePassword(inputId, eyeOpenId, eyeCloseId) {
                const input = document.getElementById(inputId);
                const eyeOpen = document.getElementById(eyeOpenId);
                const eyeClose = document.getElementById(eyeCloseId);

                if (input.type === 'password') {
                    input.type = 'text';
                    eyeOpen.classList.add('hidden');
                    eyeClose.classList.remove('hidden');
                } else {
                    input.type = 'password';
                    eyeOpen.classList.remove('hidden');
                    eyeClose.classList.add('hidden');
                }
            }
        </script>
    </body>
</html>
