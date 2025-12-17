document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('form[data-confirm]').forEach(form => {

        form.addEventListener('submit', function (e) {

            // Sudah dikonfirmasi → lanjut submit
            if (form.dataset.confirmed === 'true') return;

            e.preventDefault();

            Swal.fire({
                title: form.dataset.title ?? 'Yakin?',
                text: form.dataset.text ?? 'Aksi ini tidak bisa dibatalkan.',
                icon: form.dataset.icon ?? 'warning',
                showCancelButton: true,
                confirmButtonText: form.dataset.confirm || 'Ya, lanjutkan',
                cancelButtonText: form.dataset.cancel || 'Batal',
                reverseButtons: true,
            }).then(result => {
                if (result.isConfirmed) {
                    form.dataset.confirmed = 'true';
                    form.submit();
                }
            });
        });

    });

});
