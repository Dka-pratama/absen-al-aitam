@extends('layouts.admin')

@section('content')
    <div class="p-6">

        {{-- SEARCH + BUTTON --}}
        <div class="flex justify-between items-center mb-4">

            {{-- Search --}}

            <form class="form relative">
                <button class="absolute left-2 -translate-y-1/2 top-1/2 p-1">
                    <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img"
                        aria-labelledby="search" class="w-5 h-5 text-gray-700">
                        <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9"
                            stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg>
                </button>
                <input
                    class="input rounded-full px-8 py-2 border-2 border-transparent focus:outline-none focus:border-blue-500 placeholder-gray-400 transition-all duration-300 shadow-md"
                    placeholder="Search..." required="" type="text" />
                <button type="reset" class="absolute right-3 -translate-y-1/2 top-1/2 p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </form>

            {{-- Button Tambah --}}
            <a href="{{ route('akun-siswa.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow flex items-center">
                ➕ Tambah
            </a>

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
                            <td class="p-3">{{ $wk->NUPTK }}</td>
                            <td class="p-3">{{ $wk->user->name }}</td>
                            <td class="p-3">{{ $wk->kelas->nama_kelas }}</td>

                            {{-- ACTION ICONS --}}
                            <td class="p-3 flex items-center gap-4">

                                {{-- EDIT --}}
                                <a href="/admin/walikelas/{{ $wk->id }}/edit"
                                    class="text-blue-600 hover:text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
