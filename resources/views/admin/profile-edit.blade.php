@extends('layouts.admin')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Edit Profil</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full mt-1 p-2 border rounded">
        </div>

        <div>
            <label class="block font-medium">Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                   class="w-full mt-1 p-2 border rounded">
        </div>

        <div>
            <label class="block font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full mt-1 p-2 border rounded">
        </div>

        <div>
            <label class="block font-medium">Role</label>
            <input type="text" value="{{ $user->role }}" disabled
                   class="w-full mt-1 p-2 bg-gray-100 border rounded cursor-not-allowed">
        </div>

        <div class="flex justify-end">
            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection


@section('script')
@endsection
