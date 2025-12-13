@extends('layouts.walikelas')

@section('content')
    <div class="mx-auto max-w-xl rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-2xl font-bold">Edit Profil</h2>

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 p-3 text-red-700">
                <ul class="list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('wali.profile.update') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium">Nama</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="mt-1 w-full rounded border p-2"
                />
            </div>

            <div>
                <label class="block font-medium">Username</label>
                <input
                    type="text"
                    name="username"
                    value="{{ old('username', $user->username) }}"
                    class="mt-1 w-full rounded border p-2"
                />
            </div>

            <div>
                <label class="block font-medium">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="mt-1 w-full rounded border p-2"
                />
            </div>

            <div>
                <label class="block font-medium">Role</label>
                <input
                    type="text"
                    value="{{ $user->role }}"
                    disabled
                    class="mt-1 w-full cursor-not-allowed rounded border bg-gray-100 p-2"
                />
            </div>

            <div class="flex justify-end">
                <button class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    
@endsection
