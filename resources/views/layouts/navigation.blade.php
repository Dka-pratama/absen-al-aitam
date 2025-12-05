<nav x-data="{ open: false }" class="border-b border-gray-100 bg-white">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <!-- Left Section -->
            <div class="flex">
                <!-- Logo -->
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto text-gray-800" />
                    </a>
                </div>

                <!-- Main Navigation -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    {{-- Tambah menu lain di sini kalau perlu --}}
                    {{--
                        <x-nav-link :href="route('admin.siswa')" :active="request()->routeIs('admin.siswa')">
                        Data Siswa
                        </x-nav-link>
                    --}}
                </div>
            </div>

            <!-- Right Section: Settings -->
            <div class="hidden sm:ms-6 sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 hover:text-gray-900 focus:outline-none"
                        >
                            <div>{{ Auth::user()->name ?? 'Guest' }}</div>

                            <div class="ms-2">
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.3 7.3a1 1 0 011.4 0L10 10.6l3.3-3.3a1 1 0 111.4 1.4l-4 4a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Profile -->
                        <x-dropdown-link :href="route('profile.edit')">Profil</x-dropdown-link>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="
                                    event.preventDefault();
                                    this.closest('form').submit();
                                "
                            >
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    @click="open = ! open"
                    class="rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100"
                >
                    <svg class="h-6 w-6" viewBox="0 0 24 24">
                        <path
                            :class="{ 'hidden': open, 'block': !open }"
                            class="block"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            :class="{ 'hidden': !open, 'block': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <!-- Mobile Nav -->
        <div class="space-y-1 pb-3 pt-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
        </div>

        <!-- Mobile User Info -->
        <div class="border-t border-gray-200 pb-1 pt-4">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800">
                    {{ Auth::user()->name ?? 'Guest' }}
                </div>
                <div class="text-sm font-medium text-gray-500">
                    {{ Auth::user()->email ?? 'No email' }}
                </div>
            </div>

            <!-- Mobile Settings -->
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profil</x-responsive-nav-link>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link
                        :href="route('logout')"
                        onclick="
                            event.preventDefault();
                            this.closest('form').submit();
                        "
                    >
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
