@extends('layouts.admin')

@section('content')
    <div class="mx-5 my-5">
        <div class="mx-auto max-w-4xl space-y-6 rounded-lg bg-white p-6 shadow-md">
            <div class="">                
                {{-- Data Wali --}}
            <div>
                <p class="text-sm text-gray-600">Nama Wali</p>
                <p class="text-lg font-semibold">{{ $wali->user->name }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600">Username</p>
                <p class="text-lg font-semibold">{{ $wali->user->username }}</p>
            </div>

            {{-- Data Kelas --}}
            <div class="mt-4">
                <p class="text-sm text-gray-600">Kelas yang Diampu</p>
                <p class="text-lg font-semibold">
                    {{ $wali->kelas->nama_kelas ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-600">Jurusan</p>
                <p class="text-lg font-semibold">
                    {{ $wali->kelas->jurusan ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-600">Tahun Ajar</p>
                <p class="text-lg font-semibold">
                    {{ $wali->tahunAjar->tahun ?? '-' }} ({{ $wali->tahunAjar->semester ?? '-' }})
                </p>
            </div>

            <hr class="my-4" />

            {{-- Rekap Siswa --}}
            <h3 class="text-xl font-bold">Rekap Siswa</h3>
            
            <div class="rounded-lg bg-blue-100 p-4 text-center">
                <p class="text-sm text-gray-600">Jumlah Siswa</p>
                <p class="text-2xl font-semibold text-blue-700">
                    {{ $wali->kelas->siswa->count() }}
                </p>
            </div>

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
    </div>
@endsection
