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

    fetch(`/kelas-search?search=` + keyword)
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
                                <i class="fa-solid fa-pen-to-square fa-lg" style="color:#0045bd"></i>
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
                                    <i class="fa-solid fa-trash fa-lg" style="color:#e00000"></i>
                                </button>
                                <div class="pointer-events-none absolute left-1/2 mt-2 -translate-x-1/2 
                                    whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white 
                                    opacity-0 shadow transition group-hover:opacity-100">
                                    Hapus Kelas
                                </div>
                            </form>

                            <!-- DETAIL -->
                            <a href="${k.url_show}" class="group relative">
                                <i class="fa-solid fa-info fa-lg"></i>
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