@extends('layouts.admin')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Ganti Password</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.profile.password.update') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium">Password Lama</label>
            <input type="password" name="old_password"
                   class="w-full mt-1 p-2 border rounded">
        </div>

        <div>
            <label class="block font-medium">Password Baru</label>
            <input type="password" name="new_password"
                   class="w-full mt-1 p-2 border rounded">
        </div>

        <div>
            <label class="block font-medium">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation"
                   class="w-full mt-1 p-2 border rounded">
        </div>

        <div class="flex justify-end">
            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Ganti Password
            </button>
        </div>
    </form>
</div>

@endsection

@section('script')
@endsection
