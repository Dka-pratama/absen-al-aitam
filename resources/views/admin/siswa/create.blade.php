@extends('layouts.admin')

@section('content')
<div class="p-4">
    <div class="bg-white border rounded-xl shadow-md p-6 max-w-xl w-full mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Akun Siswa</h2>
        <form action="{{ route('akun-siswa.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="flex flex-col">
                <label class="font-semibold mb-1">Nama</label>
                <input type="text" name="name"
                    class="border rounded-lg p-2 focus:ring focus:ring-blue-200 outline-none"
                    required>
            </div>

            <div class="flex flex-col">
                <label class="font-semibold mb-1">NISN</label>
                <input type="text" name="NISN"
                    class="border rounded-lg p-2 focus:ring focus:ring-blue-200 outline-none"
                    required>
            </div>

            <div class="flex flex-col">
                <label class="font-semibold mb-1">Username</label>
                <input type="text" name="username"
                    class="border rounded-lg p-2 focus:ring focus:ring-blue-200 outline-none"
                    required>
            </div>

            <div class="flex flex-col">
                <label class="font-semibold mb-1">Password</label>
                <input type="password" name="password"
                    class="border rounded-lg p-2 focus:ring focus:ring-blue-200 outline-none"
                    required>
            </div>

            <div class="flex flex-col">
                <label class="font-semibold mb-1">Kelas</label>
                <select name="kelas_id"
                    class="border rounded-lg p-2 focus:ring focus:ring-blue-200 outline-none" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <button
                class="bg-green-600 hover:bg-green-700 transition text-white px-4 py-2 rounded-lg w-full">
                Simpan
            </button>

        </form>
    </div>

</div>
@endsection
