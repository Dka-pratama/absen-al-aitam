<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Lupa Password</title>
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}" />
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}" />
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}" />
        @vite('resources/css/app.css')
    </head>

    <body class="flex min-h-screen items-center justify-center bg-gray-100 p-4">
        <div class="w-full max-w-md rounded-xl bg-white p-8 shadow-lg">
            <h2 class="mb-2 text-center text-2xl font-bold text-gray-900">Forgot Password</h2>
            <p class="mb-6 text-center text-sm text-gray-600">Masukan email anda</p>

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                    <input
                        type="email"
                        name="email"
                        placeholder="your@email.com"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                        required
                    />
                </div>

                @error('email')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror

                <button
                    type="submit"
                    class="w-full rounded-lg bg-indigo-600 py-2.5 font-medium text-white transition hover:bg-indigo-700"
                >
                    Send Code
                </button>
            </form>
            <p class="mb-2 text-center text-sm tracking-wide text-gray-500">
                *Note: fitur ini hanya bisa diakses oleh admin dan wali yang sudah mengisi email
            </p>

            <div class="mt-2 text-center text-sm text-gray-600">
                Inget Password nya?
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Log in</a>
            </div>
        </div>
    </body>
</html>
