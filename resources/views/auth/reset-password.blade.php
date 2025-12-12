<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-2 text-center">Reset Password</h2>
        <p class="text-sm text-gray-600 text-center mb-6">
            Enter your new password below.
        </p>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf

            <!-- Token dari URL -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}" />

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input 
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required 
                />
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input 
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required
                />
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input 
                    type="password"
                    name="password_confirmation"
                    placeholder="••••••••"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required
                />
            </div>

            <!-- Error -->
            @foreach ($errors->all() as $error)
                <p class="text-sm text-red-500">{{ $error }}</p>
            @endforeach

            <!-- Submit -->
            <button 
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition"
            >
                Reset Password
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
