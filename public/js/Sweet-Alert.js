document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.form-hapus').forEach(form => {
        form.addEventListener('submit', function(e) {

            // Jika sudah dikonfirmasi, langsung submit (biarkan Laravel memproses)
            if (form.dataset.confirmed === "true") {
                return; 
            }

            // Hentikan submit pertama
            e.preventDefault();

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#e00000',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set flag agar submit kedua tidak dicegat SweetAlert
                    form.dataset.confirmed = "true";

                    // Lanjutkan submit
                    form.submit();
                }
            });
        });
    });
});
