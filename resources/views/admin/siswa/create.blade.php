@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="mx-auto w-full max-w-xl rounded-xl border bg-white p-6 shadow-md">
            <h2 class="mb-6 text-2xl font-bold text-gray-800">Tambah Akun Siswa</h2>
            <form action="{{ route('akun-siswa.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="flex flex-col">
                    <label class="mb-1 font-semibold">Nama</label>
                    <input
                        type="text"
                        name="name"
                        class="rounded-lg border p-2 outline-none focus:ring focus:ring-blue-200"
                        required
                    />
                </div>

                <div class="flex flex-col">
                    <label class="mb-1 font-semibold">NISN</label>
                    <input
                        type="text"
                        name="NISN"
                        class="rounded-lg border p-2 outline-none focus:ring focus:ring-blue-200"
                        required
                    />
                </div>

                <div class="flex flex-col">
                    <label class="mb-1 font-semibold">Username</label>
                    <input
                        type="text"
                        name="username"
                        class="rounded-lg border p-2 outline-none focus:ring focus:ring-blue-200"
                        required
                    />
                </div>

                <div class="flex flex-col">
                    <label class="mb-1 font-semibold">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="rounded-lg border p-2 outline-none focus:ring focus:ring-blue-200"
                        required
                    />
                </div>

                <div class="flex flex-col">
                    <label class="mb-1 font-semibold">Kelas</label>
                    <select
                        name="kelas_id"
                        class="rounded-lg border p-2 outline-none focus:ring focus:ring-blue-200"
                        required
                    >
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}">
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="w-full rounded-lg bg-green-600 px-4 py-2 text-white transition hover:bg-green-700">
                    Simpan
                </button>
            </form>
        </div>
    </div>
@endsection
