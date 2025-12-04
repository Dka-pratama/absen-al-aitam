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
                        <td class="p-3 flex gap-3 justify-center">
                            <a href="/kelas/${k.id}/edit" class="text-blue-600 hover:text-blue-800 text-xl">✏️</a>
                            <button class="text-red-600 hover:text-red-800 text-xl">🗑️</button>
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
