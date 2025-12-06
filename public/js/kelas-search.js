// Debounce function
function debounce(func, delay = 350) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), delay);
    };
}

// Main search handler
const searchKelas = debounce(function () {
    const keyword = document.getElementById('searchInput').value;

    fetch(`/kelas-search?search=` + keyword)
        .then(res => res.json())
        .then(data => {
            let rows = '';

            data.forEach((k, i) => {
                rows += `
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">${i + 1}</td>
                        <td class="p-3">${k.nama_kelas}</td>
                        <td class="p-3">${k.siswa_count}</td>
                        <td class="p-3">${k.jurusan ?? '-'}</td>
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
                `;
            });

            document.getElementById('kelasTable').innerHTML = rows;
        });
}, 400);

// Event listener input
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('searchInput');
    if (input) {
        input.addEventListener('input', searchKelas);
    }
});
