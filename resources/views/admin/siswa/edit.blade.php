@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="mx-auto max-w-xl rounded-xl border bg-white p-6 shadow-md">
            <h2 class="mb-6 text-2xl font-bold">Edit Akun Siswa</h2>

            <form action="{{ route('akun-siswa.update', $siswa->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="font-semibold">Nama</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ $siswa->user->name }}"
                        class="w-full rounded-lg border p-2 focus:ring"
                        required
                    />
                </div>

                <div>
                    <label class="font-semibold">NISN</label>
                    <input
                        type="text"
                        name="NISN"
                        value="{{ $siswa->NISN }}"
                        class="w-full rounded-lg border p-2 focus:ring"
                        required
                    />
                </div>

                <div>
                    <label class="font-semibold">Username</label>
                    <input
                        type="text"
                        name="username"
                        value="{{ $siswa->user->username }}"
                        class="w-full rounded-lg border p-2 focus:ring"
                        required
                    />
                </div>

                <div>
                    <label class="font-semibold">Password (opsional)</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Biarkan kosong jika tidak mengganti"
                        class="w-full rounded-lg border p-2 focus:ring"
                    />
                </div>

                <div>
                    <label class="font-semibold">Kelas</label>
                    <select name="kelas_id" class="w-full rounded border p-2">
                        @foreach ($kelasList as $k)
                            <option value="{{ $k->id }}" {{ $kelasAktif == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="w-full rounded-lg bg-blue-600 p-2 text-white hover:bg-blue-700">Update</button>
            </form>
        </div>
    </div>
@endsection
