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
                            <input
                                type="password"
                                name="password"
                                id="passwordInput"
                                class="w-full rounded-lg border p-2 pr-10 focus:ring focus:ring-purple-300"
                                required
                            />
                            <span id="togglePassword" class="absolute right-3 top-3 cursor-pointer text-gray-500">
                                👁
                            </span>
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
            const toggle = document.getElementById('togglePassword');
            const input = document.getElementById('passwordInput');

            toggle.addEventListener('click', () => {
                input.type = input.type === 'password' ? 'text' : 'password';
            });
        </script>
    </body>
</html>
