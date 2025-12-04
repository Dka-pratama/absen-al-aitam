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
                                <td class="p-3 flex gap-3 justify-center">
                                    <a href="/akun-walikelas/${w.id}/edit" class="text-blue-600">✏️</a>
                                    <button class="text-red-600">🗑️</button>
                                </td>
                            </tr>
                        `;
                    });

                    tableBody.innerHTML = html;
                });
        }, 400)
    );
});
