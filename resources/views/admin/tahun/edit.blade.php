@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="mx-auto max-w-xl rounded-xl border bg-white p-6 shadow-md">
            <h2 class="mb-6 text-2xl font-bold">Tambah Kelas</h2>

            <form action="{{ route('tahun.update', $tahunAjar->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="font-semibold">Tahun Ajar</label>
                    <input
                        type="text"
                        name="tahun"
                        value="{{ $tahunAjar->tahun }}"
                        class="w-full rounded-lg border p-2 focus:ring"
                        required
                    />
                </div>

                <div>
                    <label class="font-semibold">Semester</label>
                    <select name="semester" class="w-full rounded-lg border p-2 focus:ring" required>
                        <option value="Ganjil" {{ $tahunAjar->semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ $tahunAjar->semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>

                <div>
                    <label class="font-semibold">Status</label>
                    <select name="status" class="w-full rounded-lg border p-2 focus:ring" required>
                        <option value="Aktif" {{ $tahunAjar->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non-Aktif" {{ $tahunAjar->status == 'Non-Aktif' ? 'selected' : '' }}>
                            Non-Aktif
                        </option>
                    </select>
                </div>

                <button class="w-full rounded-lg bg-blue-600 p-2 text-white hover:bg-blue-700">Update</button>
            </form>

            <div class="mt-6">
                <a
                    href="{{ route('tahun.index') }}"
                    class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold hover:bg-gray-300"
                >
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
