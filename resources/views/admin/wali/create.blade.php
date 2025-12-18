@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="mx-auto w-full max-w-xl rounded-xl border bg-white p-6 shadow-md">
            <form action="{{ route('akun-walikelas.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="font-semibold">Nama</label>
                    <input type="text" name="name" class="w-full rounded-lg border p-2 focus:ring" required />
                </div>

                <div>
                    <label class="font-semibold">NUPTK</label>
                    <input type="text" name="NUPTK" class="w-full rounded-lg border p-2 focus:ring" required />
                </div>

                <div>
                    <label class="font-semibold">Username</label>
                    <input type="text" name="username" class="w-full rounded-lg border p-2 focus:ring" required />
                </div>
                <div>
                    <label class="font-semibold">Email</label>
                    <input type="email" name="email" class="w-full rounded-lg border p-2 focus:ring" required />
                </div>

                <div>
                    <label class="font-semibold">Password</label>
                    <input type="password" name="password" class="w-full rounded-lg border p-2 focus:ring" required />
                </div>

                <div>
                    <label class="font-semibold">Kelas</label>
                    <select name="kelas_id" class="w-full rounded-lg border p-2 focus:ring">
                        <option value="">-- Belum Memegang Kelas --</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}">
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="mb-1 block font-medium">Tahun Ajar</label>
                    <select name="tahun_ajar_id" class="w-full rounded border p-2" required>
                        @foreach ($tahunAjar as $t)
                            <option value="{{ $t->id }}">{{ $t->tahun }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="w-full rounded-lg bg-green-600 p-2 text-white hover:bg-green-700">Simpan</button>
            </form>
            <div class="mt-6">
                <a
                    href="{{ route('akun-walikelas.index') }}"
                    class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold hover:bg-gray-300"
                >
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
