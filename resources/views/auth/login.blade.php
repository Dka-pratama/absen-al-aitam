<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Masuk</title>
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}" />
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}" />
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}" />
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
    </head>

    <body class="flex min-h-screen items-center justify-center bg-gray-100 p-4">
        <div class="w-full max-w-md rounded-xl bg-white p-8 shadow-lg">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-semibold tracking-tight text-gray-900">Masuk</h2>
                <p class="mt-2 text-sm text-gray-500">
                    Selamat datang di sistem absensi Al-aitaam
                    <span class="block font-medium text-gray-700">Al-Aitaam</span>
                </p>
            </div>
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Username</label>
                    <input
                        type="text"
                        name="username"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 outline-none transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                        placeholder="Enter your username"
                        required
                    />
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 outline-none transition-all focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                            placeholder="••••••••"
                        />

                        <span
                            id="eyeOpenPassword"
                            onclick="togglePassword('password', 'eyeOpenPassword', 'eyeClosePassword')"
                            class="absolute right-3 top-2.5 cursor-pointer text-gray-600"
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
                                class="icon icon-tabler icons-tabler-outline icon-tabler-eye"
                            >
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path
                                    d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"
                                />
                            </svg>
                        </span>

                        <span
                            id="eyeClosePassword"
                            onclick="togglePassword('password', 'eyeOpenPassword', 'eyeClosePassword')"
                            class="absolute right-3 top-2.5 hidden cursor-pointer text-gray-600"
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
                                class="icon icon-tabler icons-tabler-outline icon-tabler-eye-closed"
                            >
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M21 9c-2.4 2.667 -5.4 4 -9 4c-3.6 0 -6.6 -1.333 -9 -4" />
                                <path d="M3 15l2.5 -3.8" />
                                <path d="M21 14.976l-2.492 -3.776" />
                                <path d="M9 17l.5 -4" />
                                <path d="M15 17l-.5 -4" />
                            </svg>
                        </span>
                    </div>
                </div>

                @error('username')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror

                @error('email')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror

                <div class="flex items-center justify-between">
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                        Lupa Passsword?
                    </a>
                </div>
                <button
                    type="submit"
                    class="w-full rounded-lg bg-indigo-600 py-2.5 font-medium text-white transition-colors hover:bg-indigo-700"
                >
                    Sign In
                </button>
            </form>
        </div>

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
