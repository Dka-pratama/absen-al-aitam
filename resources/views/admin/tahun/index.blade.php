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
                href="{{ route('tahun.create') }}"
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
                        <th class="p-3 text-left">Tahun Ajar</th>
                        <th class="p-3 text-left">Semester</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-center">Action</th>
                    </tr>
                </thead>

                <tbody id="tahunAjarTable" class="bg-white">
                    @foreach ($tahun as $i => $t)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $i + 1 }}</td>
                            <td class="p-3">{{ $t->tahun }}</td>
                            <td class="p-3">{{ $t->semester }}</td>
                            <td class="p-3">
                                @if ($t->status == 'aktif')
                                    <span class="rounded bg-green-100 px-2 py-1 text-xs text-green-700">Aktif</span>
                                @else
                                    <span class="rounded bg-gray-200 px-2 py-1 text-xs text-gray-700">Tidak Aktif</span>
                                @endif
                            </td>

                            {{-- ACTION --}}
                            <td class="flex justify-center gap-3 p-3">
                                {{-- Edit --}}
                                <div class="group relative">
                                    <a href="{{ route('tahun.edit', $t->id) }}">
                                        <i class="fa-solid fa-pen-to-square fa-lg" style="color: #0045bd"></i>
                                    </a>
                                    <div
                                        class="pointer-events-none absolute left-1/2 z-50 mt-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 shadow transition group-hover:opacity-100"
                                    >
                                        Edit Tahun Ajar
                                    </div>
                                </div>

                                {{-- Hapus --}}
                                <div class="group relative">
                                    <form
                                        action="{{ route('tahun.destroy', $t->id) }}"
                                        method="POST"
                                        class="form-hapus inline"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <i class="fa-solid fa-trash fa-lg" style="color: #e00000"></i>
                                        </button>
                                    </form>
                                    <div
                                        class="pointer-events-none absolute left-1/2 z-50 mt-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 shadow transition group-hover:opacity-100"
                                    >
                                        Hapus Tahun Ajar
                                    </div>
                                </div>

                                {{-- Info --}}
                                <div class="group relative">
                                    <a href="{{ route('tahun.show', $t->id) }}">
                                        <i class="fa-solid fa-info fa-lg"></i>
                                    </a>
                                    <div
                                        class="pointer-events-none absolute left-1/2 z-50 mt-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 shadow transition group-hover:opacity-100"
                                    >
                                        Detail Tahun Ajar
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 px-4">
                {{ $tahun->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/tahun-ajar-search.js') }}"></script>
@endsection
