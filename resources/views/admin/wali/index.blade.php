@extends('layouts.admin')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    {{-- HEADER TITLE --}}
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-xl font-bold">SISTEM ABSENSI SISWA</h2>

        <a href="/admin/walikelas/create"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <span>➕</span> Tambah
        </a>
    </div>

    {{-- SEARCH --}}
    <div class="mb-5">
        <input type="text"
               placeholder="cari berdasarkan nama / NUPTK"
               class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500">
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">NUPTK</th>
                    <th class="p-3 text-left">Nama Wali Kelas</th>
                    <th class="p-3 text-left">Kelas</th>
                    <th class="p-3 text-left">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($walikelas as $index => $wk)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $index + 1 }}</td>
                    <td class="p-3">{{ $wk->nuptk }}</td>
                    <td class="p-3">{{ $wk->nama }}</td>
                    <td class="p-3">{{ $wk->kelas }}</td>

                    {{-- ACTION ICONS --}}
                    <td class="p-3 flex items-center gap-4">

                        {{-- EDIT --}}
                        <a href="/admin/walikelas/{{ $wk->id }}/edit" class="text-blue-600 hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M16.862 3.487l3.651 3.65-9.91 9.912L6.95 13.4l9.912-9.912zM6.5 13.5l-1 4.5 4.5-1" />
                            </svg>
                        </a>

                        {{-- DELETE --}}
                        <form action="/admin/walikelas/{{ $wk->id }}" method="POST"
                              onsubmit="return confirm('Hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:text-red-800">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M6 7h12M9 7V4h6v3m1 0v10a2 2 0 01-2 2H9a2 2 0 01-2-2V7h10z" />
                                </svg>
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>

@endsection
