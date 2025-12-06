function debounce(func, delay = 350) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), delay);
    };
}

const searchKelas = debounce(function () {
    const keyword = document.getElementById('searchInput').value.trim();
    const pagination = document.getElementById('paginationContainer');

    // Hide paginate saat search
    if (pagination) {
        pagination.style.display = keyword === "" ? "block" : "none";
    }

    fetch(`/admin/kelas-search?search=` + keyword)
        .then(res => res.json())
        .then(data => {
            let rows = "";

            data.forEach((k, i) => {
                rows += `
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">${i + 1}</td>
                        <td class="p-3">${k.nama_kelas}</td>
                        <td class="p-3">${k.siswa_count}</td>
                        <td class="p-3">${k.jurusan ?? '-'}</td>
                        <td class="p-3">${k.angkatan ?? '-'}</td>

                        <td class="flex justify-center gap-3 p-3">
                            <!-- EDIT -->
                            <a href="${k.url_edit}" class="group relative">
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
                                            class="h-6 w-6 text-blue-600"
                                        >
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path
                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"
                                            />
                                            <path d="M16 5l3 3" />
                                        </svg>
                                <div class="pointer-events-none absolute left-1/2 mt-2 -translate-x-1/2 
                                    whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white 
                                    opacity-0 shadow transition group-hover:opacity-100">
                                    Edit Kelas
                                </div>
                            </a>

                            <!-- HAPUS -->
                            <form action="${k.url_delete}" method="POST" class="inline group relative form-hapus">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit">
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
                                                class="lucide lucide-trash2-icon lucide-trash-2 text-red-600"
                                            >
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                </button>
                                <div class="pointer-events-none absolute left-1/2 mt-2 -translate-x-1/2 
                                    whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white 
                                    opacity-0 shadow transition group-hover:opacity-100">
                                    Hapus Kelas
                                </div>
                            </form>

                            <!-- DETAIL -->
                            <a href="${k.url_show}" class="group relative">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info-icon lucide-info"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                                <div class="pointer-events-none absolute left-1/2 mt-2 -translate-x-1/2 
                                    whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white 
                                    opacity-0 shadow transition group-hover:opacity-100">
                                    Detail Kelas
                                </div>
                            </a>
                        </td>
                    </tr>
                `;
            });

            document.getElementById('kelasTable').innerHTML = rows;
        });
}, 400);

document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('searchInput');
    if (input) {
        input.addEventListener('input', searchKelas);
    }
});