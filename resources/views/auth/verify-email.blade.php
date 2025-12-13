<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Verify Code</title>
        @vite('resources/css/app.css')
    </head>

    <body class="flex min-h-screen items-center justify-center bg-gray-100 p-4">
        <div class="w-full max-w-md rounded-xl bg-white p-8 shadow-lg">
            <h2 class="mb-2 text-center text-2xl font-bold text-gray-900">Enter Verification Code</h2>
            <p class="mb-6 text-center text-sm text-gray-600">We have sent a 6-digit code to your email.</p>

            <form method="POST" action="{{ route('password.verify') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Verification Code</label>
                    <input
                        type="text"
                        name="code"
                        maxlength="6"
                        placeholder="123456"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-center text-lg font-bold tracking-widest focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                        required
                    />
                </div>

                @error('code')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror

                <button
                    type="submit"
                    class="w-full rounded-lg bg-indigo-600 py-2.5 font-medium text-white transition hover:bg-indigo-700"
                >
                    Verify Code
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600">
                Didn’t receive the code?
                <a href="{{ route('password.email') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Resend
                </a>
            </div>
        </div>
    </body>
</html>
