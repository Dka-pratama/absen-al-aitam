<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-gray-100 min-h-screen flex">

    <!-- LEFT SECTION -->
    <div
        class="min-h-screen hidden md:flex w-1/2 bg-gradient-to-br from-[#01AF61] to-[#3CB043] text-white items-center justify-center">
        <div class="flex h-full w-full items-center justify-center">
            <div class="rounded-es-[4.5rem] rounded-tr-[4.5rem] h-3/4 max-w-md bg-[#FFFFFF]/20 text-center p-14">
                <h1 class="text-4xl font-bold mb-4">A valuable tool for your classroom</h1>
                <p class="text-lg">
                    Track attendance students easily and efficiently with our modern, user-friendly platform.
                </p>
            </div>
        </div>
    </div>

    <!-- RIGHT SECTION (LOGIN FORM) -->
    <div class="w-full md:w-1/2 flex items-center justify-center p-8 bg-white">
        <div class="w-full max-w-md bg-white">

            <h2 class="text-2xl font-bold text-gray-900 mb-6">Sign in</h2>

            <!-- LOGIN FORM -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Username</label>
                    <input type="text" name="username"
                        class="w-full border rounded-lg p-2 focus:ring focus:ring-purple-300" required autofocus>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 mb-1">Password</label>

                    <div class="relative">
                        <input type="password" name="password" id="passwordInput"
                            class="w-full border rounded-lg p-2 pr-10 focus:ring focus:ring-purple-300" required>
                        <span id="togglePassword" class="absolute right-3 top-3 cursor-pointer text-gray-500">
                            👁
                        </span>
                    </div>
                </div>

                <!-- SUBMIT -->
                <button type="submit"
                    class="w-full bg-[#23DB2E] text-white py-2 rounded-lg hover:bg-[#22C52C] transition">
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
