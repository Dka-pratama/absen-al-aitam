<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-2 text-center">Enter Verification Code</h2>
        <p class="text-sm text-gray-600 text-center mb-6">
            We have sent a 6-digit code to your email.
        </p>

        <form method="POST" action="{{ route('password.verify') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Verification Code</label>
                <input 
                    type="text"
                    name="code"
                    maxlength="6"
                    placeholder="123456"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                           text-center tracking-widest text-lg font-bold
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    required
                />
            </div>

            @error('code')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

            <button 
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition"
            >
                Verify Code
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-600">
            Didn’t receive the code?
            <a href="{{ route('password.email') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">
                Resend
            </a>
        </div>
    </div>

</body>
</html>
