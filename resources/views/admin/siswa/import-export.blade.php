@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-5xl space-y-8 p-6">
        {{-- ERROR IMPORT --}}
        @if (session('import_errors'))
            <div class="rounded bg-red-100 p-3 text-sm text-red-700">
                <ul class="list-disc pl-5">
                    @foreach (session('import_errors') as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ================= EXPORT SISWA ================= --}}
        <div class="rounded-xl bg-white p-6 shadow">
            <h2 class="mb-4 text-lg font-semibold">Export Data Siswa</h2>

            <form method="GET" action="{{ route('siswa.export') }}" class="space-y-4">
                <div>
                    <label class="font-semibold">Pilih Kelas</label>
                    <select name="kelas_id" class="mt-1 w-full rounded border px-3 py-2" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="rounded-lg bg-green-600 px-6 py-2 text-white hover:bg-green-700">Export Excel</button>
            </form>
        </div>

        {{-- ================= IMPORT SISWA ================= --}}
        <div class="rounded-xl bg-white p-6 shadow">
            <h2 class="mb-2 text-lg font-semibold">Import Data Siswa</h2>
            <p class="mb-4 text-sm text-gray-600">Download template Excel, isi data siswa, lalu upload kembali.</p>

            <div class="flex flex-col gap-4 md:flex-row md:items-end">
                <a
                    href="{{ route('siswa.template') }}"
                    class="inline-block rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700"
                >
                    Download Template Excel
                </a>
            </div>

            <form
                method="POST"
                action="{{ route('siswa.import') }}"
                enctype="multipart/form-data"
                class="mt-6 space-y-4"
            >
                @csrf

                <div>
                    <label class="font-semibold">Kelas Tujuan</label>
                    <select name="kelas_id" class="mt-1 w-full rounded border px-3 py-2" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-semibold">File Excel (.xlsx)</label>
                    <input
                        type="file"
                        name="file"
                        accept=".xlsx"
                        class="mt-1 w-full rounded border px-3 py-2"
                        required
                    />
                </div>

                <button class="rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700">Import Siswa</button>
            </form>

            <div class="mt-4 rounded-lg bg-yellow-50 p-4 text-sm text-yellow-800">
                ⚠️ Siswa dengan NISN yang sudah ada akan dilewati otomatis. Data absensi lama tidak akan terhapus.
            </div>
        </div>

        {{-- ================= UPDATE SISWA ================= --}}
        <div class="rounded-xl border border-yellow-200 bg-white p-6 shadow">
            <h2 class="mb-2 text-lg font-semibold">Update Data Siswa per Kelas</h2>
            <p class="mb-4 text-sm text-gray-600">
                Gunakan fitur ini untuk memperbarui nama, username, atau password siswa tanpa mengubah kelas dan
                absensi.
            </p>

            {{-- EXPORT UPDATE --}}
            <form method="GET" action="{{ route('siswa.export-update') }}" class="space-y-4">
                <div>
                    <label class="font-semibold">Pilih Kelas</label>
                    <select name="kelas_id" class="mt-1 w-full rounded border px-3 py-2" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="rounded-lg bg-yellow-600 px-6 py-2 text-white hover:bg-yellow-700">
                    Download Excel Update
                </button>
            </form>

            {{-- IMPORT UPDATE --}}
            <form
                method="POST"
                action="{{ route('siswa.import-update') }}"
                enctype="multipart/form-data"
                class="mt-6 space-y-4"
            >
                @csrf

                <div>
                    <label class="font-semibold">Upload Excel Update</label>
                    <input
                        type="file"
                        name="file"
                        accept=".xlsx"
                        class="mt-1 w-full rounded border px-3 py-2"
                        required
                    />
                </div>

                <button class="rounded-lg bg-yellow-500 px-6 py-2 text-white hover:bg-yellow-600">
                    Update Data Siswa
                </button>
            </form>

            <div class="mt-4 rounded-lg bg-yellow-50 p-4 text-sm text-yellow-800">
                ⚠️ Jangan ubah
                <b>siswa_id</b>
                dan
                <b>user_id</b>
                . Password boleh dikosongkan jika tidak ingin diubah.
            </div>
        </div>
    </div>
@endsection
