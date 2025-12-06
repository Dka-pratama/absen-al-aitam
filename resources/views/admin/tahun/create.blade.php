@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="mx-auto max-w-xl rounded-xl border bg-white p-6 shadow-md">
            <form action="{{ route('tahun.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="font-semibold">Tahun Ajar</label>
                    <input type="text" name="tahun" placeholder="2024/2025"
                        class="w-full rounded-lg border p-2 focus:ring" required />
                </div>

                <div>
                    <label class="font-semibold">Semester</label>
                    <select name="semester" class="w-full rounded-lg border p-2 focus:ring" required>
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                </div>

                <div>
                    <label class="font-semibold">Status</label>
                    <select name="status" class="w-full rounded-lg border p-2 focus:ring" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Non-Aktif">Non-Aktif</option>
                    </select>
                </div>

                <button class="w-full rounded-lg bg-green-600 p-2 text-white hover:bg-green-700">
                    Simpan
                </button>
            </form>

            <div class="mt-6">
                <a href="{{ route('tahun.index') }}"
                    class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold hover:bg-gray-300">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
