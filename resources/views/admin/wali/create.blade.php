@extends('layouts.admin')

@section('content')
<div class="p-4">
    <div class="bg-white border rounded-xl shadow-md p-6 max-w-xl w-full mx-auto">

        <h2 class="text-2xl font-bold mb-6">Tambah Wali Kelas</h2>

        <form action="{{ route('akun-walikelas.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="font-semibold">Nama</label>
                <input type="text" name="nama" class="border rounded-lg p-2 w-full focus:ring" required>
            </div>

            <div>
                <label class="font-semibold">NUPTK</label>
                <input type="text" name="NUPTK" class="border rounded-lg p-2 w-full focus:ring" required>
            </div>

            <div>
                <label class="font-semibold">Username</label>
                <input type="text" name="username" class="border rounded-lg p-2 w-full focus:ring" required>
            </div>

            <div>
                <label class="font-semibold">Password</label>
                <input type="password" name="password" class="border rounded-lg p-2 w-full focus:ring" required>
            </div>

            <div>
                <label class="font-semibold">Kelas</label>
                <select name="kelas_id" class="border rounded-lg p-2 w-full focus:ring">
                    <option value="">-- Belum Memegang Kelas --</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <button class="bg-green-600 hover:bg-green-700 text-white rounded-lg p-2 w-full">
                Simpan
            </button>
        </form>
    </div>
</div>
@endsection
