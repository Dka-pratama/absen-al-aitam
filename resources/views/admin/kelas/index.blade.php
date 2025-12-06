@extends('layouts.admin')

@section('content')
    <div class="p-6">
        {{-- SEARCH + BUTTON --}}
        <div class="mb-4 flex items-center justify-between">
            {{-- Search --}}

            <form class="form relative">
                <button class="absolute left-2 top-1/2 -translate-y-1/2 p-1">
                    <svg
                        width="17"
                        height="16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        role="img"
                        aria-labelledby="search"
                        class="h-5 w-5 text-gray-700"
                    >
                        <path
                            d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9"
                            stroke="currentColor"
                            stroke-width="1.333"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        ></path>
                    </svg>
                </button>
                <input
                    id="searchInput"
                    class="input rounded-full border-2 border-transparent px-8 py-2 placeholder-gray-400 shadow-md transition-all duration-300 focus:border-blue-500 focus:outline-none"
                    placeholder="Search..."
                    required=""
                    type="text"
                />
                <button type="reset" class="absolute right-3 top-1/2 -translate-y-1/2 p-1">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-gray-700"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </form>

            {{-- Button Tambah --}}
            <a
                href="{{ route('kelas.create') }}"
                class="flex items-center rounded-lg bg-green-600 px-4 py-2 text-white shadow hover:bg-green-700"
            >
                ➕ Tambah
            </a>
        </div>

        {{-- TABLE --}}
        <div class="overflow-hidden rounded-xl border bg-white shadow">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">No</th>
                        <th class="p-3 text-left">Kelas</th>
                        <th class="p-3 text-left">Jumlah Siswa</th>
                        <th class="p-3 text-left">Jurusan</th>
                        <th class="p-3 text-left">Angkatan</th>
                        <th class="p-3 text-center">Action</th>
                    </tr>
                </thead>

                <tbody class="bg-white" id="kelasTable">
                    @foreach ($kelasList as $i => $k)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $i + 1 }}</td>
                            <td class="p-3">{{ $k['nama_kelas'] }}</td>
                            <td class="p-3">{{ $k->siswa_count }}</td>
                            <td class="p-3">{{ $k['jurusan'] }}</td>
                            <td class="p-3">{{ $k['angkatan'] }}</td>
                            {{-- ACTION --}}
                            <td class="flex justify-center gap-3 p-3">
                                {{-- Edit --}}
                                <div class="group relative">
                                    <a href="{{ route('kelas.edit', $k->id) }}">
                                        <i class="fa-solid fa-pen-to-square fa-lg" style="color: #0045bd"></i>
                                    </a>
                                    <div
                                        class="pointer-events-none absolute left-1/2 z-50 mt-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 shadow transition group-hover:opacity-100"
                                    >
                                        Edit Kelas
                                    </div>
                                </div>
                                {{-- Hapus --}}
                                <div class="group relative">
                                    <form
                                        action="{{ route('kelas.destroy', $k->id) }}"
                                        method="POST"
                                        class="form-hapus inline"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-hapus">
                                            <i class="fa-solid fa-trash fa-lg" style="color: #e00000"></i>
                                        </button>
                                    </form>
                                    <div
                                        class="pointer-events-none absolute left-1/2 z-50 mt-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 shadow transition group-hover:opacity-100"
                                    >
                                        Hapus Kelas
                                    </div>
                                </div>
                                {{-- Info --}}
                                <div class="group relative">
                                    <a href="{{ route('kelas.show', $k->id) }}">
                                        <i class="fa-solid fa-info fa-lg"></i>
                                    </a>
                                    <div
                                        class="pointer-events-none absolute left-1/2 z-50 mt-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 shadow transition group-hover:opacity-100"
                                    >
                                        Detail Kelas
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const csrfToken = '{{ csrf_token() }}';
    </script>
    <script src="{{ asset('js/kelas-search.js') }}"></script>
@endsection
