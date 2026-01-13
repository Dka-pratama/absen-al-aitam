function debounce(func, delay = 350) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), delay);
    };
}

document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchSiswa");
    const tableBody = document.getElementById("absensiTable");
    const pagination = document.getElementById("paginationContainer");

    if (!searchInput) return;

    searchInput.addEventListener(
        "input",
        debounce(() => {
            const keyword = searchInput.value;

            if (keyword !== "") {
                pagination.style.display = "none";
            } else {
                pagination.style.display = "block";
            }

            fetch(`/admin/absensi-search?search=${keyword}`)
                .then(res => res.json())
                .then(data => {
    let html = "";

    data.forEach((a, i) => {
        html += `
        <tr class="border-b hover:bg-gray-50">
            <td class="p-3">${i + 1}</td>
            <td class="p-3">${a.nama}</td>
            <td class="p-3">${a.kelas}</td>
            <td class="p-3">
                <select name="status[${a.id}]" class="w-full rounded-lg border px-2 py-1">
                    <option value="">-- pilih --</option>
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="alpa">Alpa</option>
                </select>
            </td>
            <td class="p-3">
                <input type="text"
                    name="keterangan[${a.id}]"
                    class="w-full rounded-lg border px-2 py-1"
                    placeholder="Opsional">
            </td>
        </tr>
        `;
    });

    tableBody.innerHTML = html;
});
        }, 400)
    );
});
