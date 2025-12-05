<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>Wali - {{ $title ?? 'Dashboard' }}</title>

        @vite('resources/css/app.css')
        <style>
            /* small helper for the big rounded sidebar bottom-right like design */
            .sidebar-curve {
                border-bottom-right-radius: 80px;
            }
        </style>
    </head>
    <body class="min-h-screen bg-[#F2F3F0] font-sans">
        <div class="flex min-h-screen">
            <!-- SIDEBAR -->
            <aside
                class="sidebar-curve flex w-72 flex-col justify-between bg-gradient-to-b from-green-600 to-green-500 text-white shadow-lg"
            >
                <div>
                    <div class="flex items-center gap-3 px-6 py-8">
                        <img src="{{ asset('logo.png') }}" alt="logo" class="h-12 w-12 object-contain" />
                        <div class="text-white">
                            <div class="text-lg font-bold leading-tight">SMK AL-</div>
                            <div class="text-lg font-bold leading-tight">AITAAM</div>
                        </div>
                    </div>

                    <nav class="mt-2 space-y-4 px-4">
                        <a
                            href="{{ route('walikelas.dashboard') }}"
                            class="flex items-center gap-3 rounded-md px-3 py-2 text-white/90 hover:text-white"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 12h18M6 6h12M6 18h12" />
                            </svg>
                            <span class="text-sm">Dashboard</span>
                        </a>

                        <a
                            href="{{ route('walikelas.absensi') }}"
                            class="flex items-center gap-3 rounded-md px-3 py-2 text-white/80 hover:text-white"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 3h14v18H5z" />
                            </svg>
                            <span class="text-sm">Absensi</span>
                        </a>

                        <a
                            href="{{ route('walikelas.laporan') }}"
                            class="flex items-center gap-3 rounded-md px-3 py-2 text-white/80 hover:text-white"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 11H5M19 17H5M19 5H5" />
                            </svg>
                            <span class="text-sm">Laporan</span>
                        </a>

                        <a
                            href="{{ route('walikelas.profile') }}"
                            class="flex items-center gap-3 rounded-md px-3 py-2 text-white/80 hover:text-white"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 12a5 5 0 100-10 5 5 0 000 10zM3 21a9 9 0 0118 0" />
                            </svg>
                            <span class="text-sm">Profile</span>
                        </a>
                    </nav>
                </div>

                <div class="px-6 pb-6">
                    <form action="/logout" method="POST">
                        @csrf
                        <button class="flex items-center gap-3 text-sm text-white/80 hover:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M15 3h4v18h-4M10 17l5-5-5-5m5 5H3" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </aside>

            <!-- MAIN -->
            <div class="flex min-h-screen flex-1 flex-col">
                <!-- TOPBAR: centered title, avatar on right -->
                <header class="bg-white shadow-sm">
                    <div class="mx-auto flex max-w-[1200px] items-center justify-between px-8 py-6">
                        <h1 class="text-2xl font-extrabold tracking-wide">SISTEM ABSENSI SISWA</h1>

                        <div class="flex items-center gap-3">
                            <img
                                src="{{ asset('profile.jpg') }}"
                                alt="profile"
                                class="h-11 w-11 rounded-full border-2 border-white object-cover shadow-sm"
                            />
                            <div class="text-right">
                                <div class="text-sm font-semibold text-gray-800">
                                    {{ $nama_wali ?? 'Wali Kelas' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $email ?? 'email@example.com' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- CONTENT AREA -->
                <main class="flex-1">
                    <div class="mx-auto max-w-[1200px] px-10 py-8">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
