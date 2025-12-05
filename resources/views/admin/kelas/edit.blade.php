@extends('layouts.admin')

@section('content')
<div class="p-4">
    <div class="bg-white border rounded-xl shadow-md p-6 max-w-xl mx-auto">

        <h2 class="text-2xl font-bold mb-6">Edit Kelas</h2>

        <form action="{{ route('kelas.update', $kelas->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="font-semibold">Nama Kelas</label>
                <input type="text" name="nama_kelas" value="{{ $kelas->nama_kelas }}"
                    class="border rounded-lg p-2 w-full focus:ring" required>
            </div>

            <div>
                <label class="font-semibold">Jurusan</label>
                <input type="text" name="jurusan" value="{{ $kelas->jurusan }}"
                    class="border rounded-lg p-2 w-full focus:ring" required>
            </div>

            <button class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg w-full">
                Update
            </button>

        </form>

    </div>
</div>
@endsection
