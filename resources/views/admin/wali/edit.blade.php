@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="mx-auto max-w-xl rounded-xl border bg-white p-6 shadow-md">
            <form action="{{ route('akun-walikelas.update', $wali->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="font-semibold">Nama</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ $wali->user->name }}"
                        class="w-full rounded-lg border p-2 focus:ring"
                        required
                    />
                </div>

                <div>
                    <label class="font-semibold">NUPTK</label>
                    <input
                        type="text"
                        name="NUPTK"
                        value="{{ $wali->NUPTK }}"
                        class="w-full rounded-lg border p-2 focus:ring"
                        required
                    />
                </div>

                <div>
                    <label class="font-semibold">Username</label>
                    <input
                        type="text"
                        name="username"
                        value="{{ $wali->user->username }}"
                        class="w-full rounded-lg border p-2 focus:ring"
                        required
                    />
                </div>
                <div>
                    <label class="font-semibold">email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ $wali->user->email }}"
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
                    <select name="kelas_id" class="w-full rounded-lg border p-2 focus:ring">
                        <option value="">-- Tidak Menjadi Wali --</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}" {{ $wali->kelas_id == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="mb-1 block font-medium">Tahun Ajar</label>
                    <p class="text-sm text-gray-500">Tahun ajar saat ini: {{ $wali->tahunAjar->tahun }}</p>

                    <select name="tahun_ajar_id" class="w-full rounded border p-2" required>
                        @foreach ($tahunAjar as $t)
                            <option value="{{ $t->id }}" {{ $wali->tahun_ajar_id == $t->id ? 'selected' : '' }}>
                                {{ $t->tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="w-full rounded-lg bg-blue-600 p-2 text-white hover:bg-blue-700">Update</button>
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
