@extends('layouts.walikelas')

@section('content')
    <div class="mx-auto max-w-xl rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-2xl font-bold">Ganti Password</h2>

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 p-3 text-red-700">
                <ul class="list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('wali.profile.password.update') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium">Password Lama</label>
                <div class="relative">
                    <input name="old_password" id="old_password" type="password" class="w-full rounded border p-2" />

                    <div
                        id="eyeOpenOld"
                        class="absolute right-3 top-3 cursor-pointer"
                        onclick="togglePassword('old_password', 'eyeOpenOld', 'eyeCloseOld')"
                    >
                        <!-- SVG eye open -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="22"
                            height="22"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-eye-icon"
                        >
                            <path
                                d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"
                            />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </div>

                    <div
                        id="eyeCloseOld"
                        class="absolute right-3 top-3 hidden cursor-pointer"
                        onclick="togglePassword('old_password', 'eyeOpenOld', 'eyeCloseOld')"
                    >
                        <!-- SVG eye closed -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="22"
                            height="22"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-eye-closed-icon"
                        >
                            <path d="m15 18-.722-3.25" />
                            <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                            <path d="m20 15-1.726-2.05" />
                            <path d="m4 15 1.726-2.05" />
                            <path d="m9 18 .722-3.25" />
                        </svg>
                    </div>
                </div>
            </div>

            <div>
                <label class="block font-medium">Password Baru</label>
                <div class="relative">
                    <input name="new_password" id="new_password" type="password" class="w-full rounded border p-2" />

                    <div
                        id="eyeOpenNew"
                        onclick="togglePassword('new_password', 'eyeOpenNew', 'eyeCloseNew')"
                        class="absolute right-3 top-3 cursor-pointer"
                    >
                        <!-- SVG -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="22"
                            height="22"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-eye-icon"
                        >
                            <path
                                d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"
                            />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </div>

                    <div
                        id="eyeCloseNew"
                        onclick="togglePassword('new_password', 'eyeOpenNew', 'eyeCloseNew')"
                        class="absolute right-3 top-3 hidden cursor-pointer"
                    >
                        <!-- SVG -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="22"
                            height="22"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-eye-closed-icon"
                        >
                            <path d="m15 18-.722-3.25" />
                            <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                            <path d="m20 15-1.726-2.05" />
                            <path d="m4 15 1.726-2.05" />
                            <path d="m9 18 .722-3.25" />
                        </svg>
                    </div>
                </div>
            </div>

            <div>
                <label class="block font-medium">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input
                        id="new_password"
                        type="password"
                        class="w-full rounded border p-2"
                        name="new_password_confirmation"
                    />

                    <div
                        id="eyeOpenNew"
                        onclick="togglePassword('new_password', 'eyeOpenNew', 'eyeCloseNew')"
                        class="absolute right-3 top-3 cursor-pointer"
                    >
                        <!-- SVG -->
                    </div>

                    <div
                        id="eyeCloseNew"
                        onclick="togglePassword('new_password', 'eyeOpenNew', 'eyeCloseNew')"
                        class="absolute right-3 top-3 hidden cursor-pointer"
                    >
                        <!-- SVG -->
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Ganti Password</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    
@endsection
