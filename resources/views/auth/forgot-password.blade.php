<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-2 text-center">Forgot Password</h2>
        <p class="text-sm text-gray-600 text-center mb-6">
            Enter your email and we will send you a verification code.
        </p>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input 
                    type="email"
                    name="email"
                    placeholder="your@email.com"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required
                />
            </div>

            @error('email')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <button 
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition"
            >
                Send Code
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-600">
            Remember your password?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">
                Sign in
            </a>
        </div>
    </div>

</body>
</html>
