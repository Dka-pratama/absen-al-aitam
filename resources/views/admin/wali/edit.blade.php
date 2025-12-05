@extends('layouts.admin')

@section('content')
<div class="p-4">
    <div class="bg-white border rounded-xl shadow-md p-6 max-w-xl mx-auto">

        <h2 class="text-2xl font-bold mb-6">Edit Wali Kelas</h2>

        <form action="{{ route('akun-walikelas.update', $wali->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="font-semibold">Nama</label>
                <input type="text" name="nama" value="{{ $wali->user->nama }}"
                    class="border rounded-lg p-2 w-full focus:ring" required>
            </div>

            <div>
                <label class="font-semibold">NUPTK</label>
                <input type="text" name="NUPTK" value="{{ $wali->NUPTK }}"
                    class="border rounded-lg p-2 w-full focus:ring" required>
            </div>

            <div>
                <label class="font-semibold">Username</label>
                <input type="text" name="username" value="{{ $wali->user->username }}"
                    class="border rounded-lg p-2 w-full focus:ring" required>
            </div>

            <div>
                <label class="font-semibold">Password (opsional)</label>
                <input type="password" name="password" placeholder="Biarkan kosong jika tidak mengganti"
                    class="border rounded-lg p-2 w-full focus:ring">
            </div>

            <div>
                <label class="font-semibold">Kelas</label>
                <select name="kelas_id" class="border rounded-lg p-2 w-full focus:ring">
                    <option value="">-- Tidak Menjadi Wali --</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}"
                            {{ $wali->kelas_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg p-2 w-full">
                Update
            </button>

        </form>

    </div>
</div>
@endsection
