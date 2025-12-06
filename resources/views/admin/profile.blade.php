@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white shadow-md rounded-lg p-6">
    {{-- Info Profil --}}
    <div class="space-y-4">
        <div>
            <label class="block text-gray-600 text-sm">Nama</label>
            <p class="font-medium">{{ $user->name }}</p>
        </div>

        <div>
            <label class="block text-gray-600 text-sm">Username</label>
            <p class="font-medium">{{ $user->username }}</p>
        </div>

        <div>
            <label class="block text-gray-600 text-sm">Email</label>
            <p class="font-medium">{{ $user->email }}</p>
        </div>

        <div>
            <label class="block text-gray-600 text-sm">Role</label>
            <p class="font-medium capitalize">{{ $user->role }}</p>
        </div>
    </div>

    {{-- Tombol --}}
    <div class="flex gap-3 mt-8">
        <a href="{{ route('admin.profile.edit') }}"
            class="px-4 py-2 bg-green-700 text-white rounded hover:bg-green-800 transition">
            Edit Profil
        </a>

        <a href="{{ route('admin.profile.password') }}"
            class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
            Ganti Password
        </a>

        <a href="{{ route('admin.profile.logs') }}"
            class="px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-800 transition">
            Log Aktivitas
        </a>
    </div>

</div>
@endsection


@section('script')
<script>
// jika butuh script tambahan
</script>
@endsection
