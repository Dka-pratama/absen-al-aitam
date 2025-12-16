@extends('layouts.admin')

@section('content')
    <div class="p-6">
        {{-- SEARCH + BUTTON --}}
        <div class="mb-4 flex items-center justify-end">
            {{-- Button Tambah --}}
            <a
                href="{{ route('tahun.create') }}"
                class="flex items-center rounded-lg bg-green-600 px-4 py-2 text-white shadow hover:bg-green-700"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="lucide lucide-circle-plus-icon lucide-circle-plus mr-2 text-white"
                >
                    <circle cx="12" cy="12" r="10" />
                    <path d="M8 12h8" />
                    <path d="M12 8v8" />
                </svg>
                Tambah
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
                    @foreach ($semester as $i => $t)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $i + 1 }}</td>
                            <td class="p-3">{{ $t->tahunAjar->tahun }}</td>
                            <td class="p-3">{{ $t->name }}</td>
                            <td>
    @if ($t->status === 'aktif' && $t->tahunAjar->status === 'aktif')
        <span class="text-green-600 font-semibold">Aktif</span>
    @else
        <span class="text-gray-400">Non-Aktif</span>
    @endif
</td>
                            {{-- ACTION --}}
                            <td class="flex justify-center gap-3 p-3">
                                {{-- Info --}}
                                <div class="group relative">
                                    <a href="{{ route('tahun.show', $t->id) }}">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="lucide lucide-info-icon lucide-info"
                                        >
                                            <circle cx="12" cy="12" r="10" />
                                            <path d="M12 16v-4" />
                                            <path d="M12 8h.01" />
                                        </svg>
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
                {{ $semester->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/tahun-ajar-search.js') }}"></script>
@endsection
