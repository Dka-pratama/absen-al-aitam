<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login</title>
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
    </head>

    <body class="flex min-h-screen bg-gray-100">
        <!-- LEFT SECTION -->
        <div
            class="hidden min-h-screen w-1/2 items-center justify-center bg-gradient-to-br from-[#01AF61] to-[#3CB043] text-white md:flex"
        >
            <div class="flex h-full w-full items-center justify-center">
                <div class="h-3/4 max-w-md rounded-es-[4.5rem] rounded-tr-[4.5rem] bg-[#FFFFFF]/20 p-14 text-center">
                    <h1 class="mb-4 text-4xl font-bold">A valuable tool for your classroom</h1>
                    <p class="text-lg">
                        Track attendance students easily and efficiently with our modern, user-friendly platform.
                    </p>
                </div>
            </div>
        </div>

        <!-- RIGHT SECTION (LOGIN FORM) -->
        <div class="flex w-full items-center justify-center bg-white p-8 md:w-1/2">
            <div class="w-full max-w-md bg-white">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">Sign in</h2>
                <!-- LOGIN FORM -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="mb-1 block text-gray-700">Username</label>
                        <input
                            type="text"
                            name="username"
                            class="w-full rounded-lg border p-2 focus:ring focus:ring-purple-300"
                            required
                            autofocus
                        />
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label class="mb-1 block text-gray-700">Password</label>

                        <div class="relative">
                            <input id="password" type="password" name="password" class="w-full rounded border p-2" />

                            <!-- Eye Open -->
                            <div
                                id="eyeOpenPassword"
                                onclick="togglePassword('password', 'eyeOpenPassword', 'eyeClosePassword')"
                                class="absolute right-3 top-3 cursor-pointer"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="22"
                                    height="22"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-eye-icon"
                                >
                                    <path
                                        d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"
                                    />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </div>

                            <!-- Eye Closed -->
                            <div
                                id="eyeClosePassword"
                                onclick="togglePassword('password', 'eyeOpenPassword', 'eyeClosePassword')"
                                class="absolute right-3 top-3 hidden cursor-pointer"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="22"
                                    height="22"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-eye-closed-icon"
                                >
                                    <path d="m15 18-.722-3.25" />
                                    <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                                    <path d="m20 15-1.726-2.05" />
                                    <path d="m4 15 1.726-2.05" />
                                    <path d="m9 18 .722-3.25" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    @error('username')
                        <div class="text-sm text-red-500">{{ $message }}</div>
                    @enderror

                    @error('email')
                        <div class="text-sm text-red-500">{{ $message }}</div>
                    @enderror

                    @error('username')
                        <div class="text-sm text-red-500">{{ $message }}</div>
                    @enderror

                    <!-- SUBMIT -->
                    <button
                        type="submit"
                        class="w-full rounded-lg bg-[#23DB2E] py-2 text-white transition hover:bg-[#22C52C]"
                    >
                        Sign In
                    </button>
                </form>
            </div>
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
