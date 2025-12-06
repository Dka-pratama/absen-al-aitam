function debounce(func, delay = 350) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), delay);
    };
}

document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchWali");
    const tableBody = document.getElementById("waliTable");

    if (!searchInput) return;

    searchInput.addEventListener(
        "input",
        debounce(() => {
            const keyword = searchInput.value;

            fetch(`/wali-search?search=${keyword}`)
                .then((res) => res.json())
                .then((data) => {
                    let html = "";

                    data.forEach((w, i) => {
                        html += `
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">${i + 1}</td>
                            <td class="p-3">${w.NUPTK}</td>
                            <td class="p-3">${w.user?.name}</td>
                            <td class="p-3">${w.kelas?.nama_kelas ?? '-'}</td>

                            <td class="p-3 flex justify-center gap-3">

                                <!-- EDIT -->
                                <a href="${w.url_edit}" class="group relative">
                                    <i class="fa-solid fa-pen-to-square fa-lg" style="color:#0045bd"></i>
                                    <div class="pointer-events-none absolute left-1/2 mt-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 shadow transition group-hover:opacity-100">
                                        Edit Akun
                                    </div>
                                </a>

                                <!-- DELETE -->
                                <form action="${w.url_delete}" method="POST" class="inline group relative form-hapus">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">

                                    <button type="submit">
                                        <i class="fa-solid fa-trash fa-lg" style="color:#e00000"></i>
                                    </button>

                                    <div class="pointer-events-none absolute left-1/2 mt-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 shadow transition group-hover:opacity-100">
                                        Hapus Akun
                                    </div>
                                </form>

                                <!-- DETAIL -->
                                <a href="${w.url_show}" class="group relative">
                                    <i class="fa-solid fa-info fa-lg"></i>
                                    <div class="pointer-events-none absolute left-1/2 mt-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 shadow transition group-hover:opacity-100">
                                        Detail Akun
                                    </div>
                                </a>
                            </td>
                        </tr>
                        `;
                    });

                    tableBody.innerHTML = html;
                });
        }, 400)
    );
});
