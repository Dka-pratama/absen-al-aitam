@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="mx-auto max-w-xl rounded-xl border bg-white p-6 shadow-md">
            <h2 class="mb-6 text-2xl font-bold">Edit Kelas</h2>
            <form action="{{ route('kelas.update', $kelas->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="font-semibold">Nama Kelas</label>
                    <input
                        type="text"
                        name="nama_kelas"
                        value="{{ $kelas->nama_kelas }}"
                        class="w-full rounded-lg border p-2 focus:ring"
                        required
                    />
                </div>

                <div>
                    <label class="font-semibold">Jurusan</label>
                    <input
                        type="text"
                        name="jurusan"
                        value="{{ $kelas->jurusan }}"
                        class="w-full rounded-lg border p-2 focus:ring"
                        required
                    />
                </div>
                <div>
                    <label class="font-semibold">Angkatan</label>
                    <input
                        type="text"
                        name="angkatan"
                        value="{{ $kelas->angkatan }}"
                        class="w-full rounded-lg border p-2 focus:ring"
                        required
                    />
                </div>

                <button class="w-full rounded-lg bg-blue-600 p-2 text-white hover:bg-blue-700">Update</button>
            </form>
            <div class="mt-6">
                <a
                    href="{{ route('kelas.index') }}"
                    class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold hover:bg-gray-300"
                >
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
