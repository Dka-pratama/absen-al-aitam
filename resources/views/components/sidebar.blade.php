<div class="w-64 bg-green-700 text-white min-h-screen p-6">

    <h2 class="text-xl font-bold mb-10">SMK AL-AITAAM</h2>

    <nav class="space-y-6">

        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 hover:text-gray-200 font-medium">
            <img src="{{ asset('icons/dashboard.svg') }}" class="w-5">
            Dashboard
        </a>

        <a href="{{ route('admin.siswa') }}"
           class="flex items-center gap-3 hover:text-gray-200 font-medium">
            <img src="{{ asset('icons/student.svg') }}" class="w-5">
            Data Siswa
        </a>

        <a href="{{ route('admin.walikelas') }}"
           class="flex items-center gap-3 hover:text-gray-200 font-medium">
            <img src="{{ asset('icons/teacher.svg') }}" class="w-5">
            Data Wali Kelas
        </a>

        <a href="{{ route('admin.kelas') }}"
           class="flex items-center gap-3 hover:text-gray-200 font-medium">
            <img src="{{ asset('icons/class.svg') }}" class="w-5">
            Data Kelas
        </a>

        <div class="pt-10 border-t border-white/30 mt-10">

            <a href="#"
               class="flex items-center gap-3 hover:text-gray-200 font-medium">
                <img src="{{ asset('icons/setting.svg') }}" class="w-5">
                Pengaturan Akun
            </a>

            <a href="#"
               class="flex items-center gap-3 hover:text-gray-200 font-medium mt-4">
                <img src="{{ asset('icons/logout.svg') }}" class="w-5">
                Keluar
            </a>

        </div>

    </nav>
</div>
