@extends('layouts.admin')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    {{-- SEARCH & BUTTON --}}
    <div class="flex justify-between items-center mb-5">
        <div class="w-1/3">
            <div class="relative">
                <input type="text"
                       placeholder="cari berdasarkan nama kelas / jurusan"
                       class="w-full px-4 py-2 rounded-full border border-gray-300 focus:outline-none pl-10">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 absolute left-3 top-2.5 text-gray-500"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M21 21l-4.35-4.35M9.5 17A7.5 7.5 0 109.5 2a7.5 7.5 0 000 15z" />
                </svg>
            </div>
        </div>

        <a href="#" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold shadow">
            + Tambah
        </a>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-200 font-semibold text-gray-700">
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Kelas</th>
                    <th class="px-4 py-3 text-left">Jurusan</th>
                    <th class="px-4 py-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody class="bg-white">
                @foreach ($kelasList as $i => $k)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $i + 1 }}</td>
                    <td class="px-4 py-3">{{ $k['kelas'] }}</td>
                    <td class="px-4 py-3">{{ $k['jurusan'] }}</td>

                    <td class="px-4 py-3 text-center flex justify-center gap-4">

                        {{-- EDIT --}}
                        <a href="#" class="text-blue-600 hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </a>

                        {{-- DELETE --}}
                        <a href="#" class="text-red-600 hover:text-red-800">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M6 7h12M10 11v6M14 11v6M9 7l1-3h4l1 3M5 7h14l-1 14H6L5 7z" />
                            </svg>
                        </a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection
