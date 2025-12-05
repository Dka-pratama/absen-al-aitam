@extends('layouts.admin')

@section('content')
<div class="p-4">
    <div class="bg-white border rounded-xl shadow-md p-6 max-w-xl mx-auto">

        <h2 class="text-2xl font-bold mb-6">Tambah Kelas</h2>

        <form action="{{ route('kelas.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="font-semibold">Nama Kelas</label>
                <input type="text" name="nama_kelas" class="border rounded-lg p-2 w-full focus:ring" required>
            </div>

            <div>
                <label class="font-semibold">Jurusan</label>
                <input type="text" name="jurusan" class="border rounded-lg p-2 w-full focus:ring" required>
            </div>

            <button class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-lg w-full">
                Simpan
            </button>

        </form>

    </div>
</div>
@endsection
