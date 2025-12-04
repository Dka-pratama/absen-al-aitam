function debounce(func, delay = 350) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), delay);
    };
}

document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchSiswa");
    const tableBody = document.getElementById("siswaTable");

    if (!searchInput) return;

    searchInput.addEventListener(
        "input",
        debounce(() => {
            const keyword = searchInput.value;

            fetch(`/siswa-search?search=${keyword}`)
                .then(res => res.json())
                .then(data => {
                    let html = "";

                    data.forEach((s, i) => {
                        html += `
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">${i + 1}</td>
                                <td class="p-3">${s.NISN}</td>
                                <td class="p-3">${s.user?.name ?? '-'}</td>
                                <td class="p-3">${s.kelas?.nama_kelas ?? '-'}</td>
                                <td class="p-3 flex gap-3 justify-center">
                                    <a href="/akun-siswa/${s.id}/edit" class="text-blue-600">✏️</a>
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
