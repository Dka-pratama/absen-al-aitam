@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-3xl p-4 sm:p-6">
        {{-- HEADER --}}
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800 sm:text-2xl">Kenaikan Kelas</h2>
            <p class="mt-1 text-sm text-gray-600">
                Tahun ajar aktif:
                <span class="font-semibold text-green-700">
                    {{ $tahunAktif->tahun }}
                </span>
            </p>
        </div>

        {{-- CARD --}}
        <div class="rounded-xl border bg-white p-5 shadow-sm">
            {{-- PILIH TAHUN AJAR ASAL --}}
            <form method="GET" class="mb-4">
                <label class="mb-1 block text-sm font-medium text-gray-700">Tahun Ajar Asal</label>
                <select
                    name="tahun_asal"
                    onchange="this.form.submit()"
                    class="w-full rounded-lg border-gray-300 text-sm"
                >
                    <option value="">-- Pilih Tahun Ajar --</option>
                    @foreach ($listTahun as $tahun)
                        <option value="{{ $tahun->id }}" {{ request('tahun_asal') == $tahun->id ? 'selected' : '' }}>
                            {{ $tahun->tahun }}
                        </option>
                    @endforeach
                </select>
            </form>

            {{-- FORM PROMOSI --}}
            <form
                method="POST"
                action="{{ route('promosi.store') }}"
                class="space-y-5"
                data-confirm
                data-title="Promosikan siswa?"
                data-text="Semua siswa akan dipindahkan ke kelas baru."
                data-icon="question"
            >
                @csrf
                <input type="hidden" name="tahun_asal" value="{{ request('tahun_asal') }}" />

                {{-- KELAS ASAL --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Kelas Asal</label>
                    <select name="kelas_asal_id" class="w-full rounded-lg border-gray-300 text-sm" required>
                        <option value="">-- Pilih kelas asal --</option>
                        @foreach ($kelasAsal as $kelas)
                            <option value="{{ $kelas->id }}">
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- KELAS TUJUAN --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Kelas Tujuan (Tahun Aktif)</label>
                    <select name="kelas_tujuan_id" class="w-full rounded-lg border-gray-300 text-sm" required>
                        <option value="">-- Pilih kelas tujuan --</option>
                        @foreach ($kelasTujuan as $kelas)
                            <option value="{{ $kelas->id }}">
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ACTION --}}
                <div class="flex justify-end">
                    <button type="submit" class="rounded bg-green-600 px-4 py-2 text-white">Promosikan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
