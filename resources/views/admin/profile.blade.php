@extends('layouts.admin')

@section('content')
    <div class="mx-auto mt-10 max-w-3xl rounded-lg bg-white p-6 shadow-md">
        {{-- Info Profil --}}
        <div class="space-y-4">
            <div>
                <label class="block text-sm text-gray-600">Nama</label>
                <p class="font-medium">{{ $user->name }}</p>
            </div>

            <div>
                <label class="block text-sm text-gray-600">Username</label>
                <p class="font-medium">{{ $user->username }}</p>
            </div>
            <div>
                <label class="block text-sm text-gray-600">Email</label>
                <p class="font-medium">{{ $user->email }}</p>
            </div>

            <div>
                <label class="block text-sm text-gray-600">Role</label>
                <p class="font-medium capitalize">{{ $user->role }}</p>
            </div>
        </div>

        {{-- Tombol --}}
        <div class="mt-8 flex gap-3">
            <a
                href="{{ route('admin.profile.edit') }}"
                class="rounded bg-green-700 px-4 py-2 text-white transition hover:bg-green-800"
            >
                Edit Profil
            </a>

            <a
                href="{{ route('admin.profile.password') }}"
                class="rounded bg-yellow-500 px-4 py-2 text-white transition hover:bg-yellow-600"
            >
                Ganti Password
            </a>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // jika butuh script tambahan
    </script>
@endsection
