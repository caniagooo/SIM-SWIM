document.addEventListener('DOMContentLoaded', function () {
    let materialIdToDelete = null;

    document.querySelectorAll('.btnDeleteMaterial').forEach(button => {
        button.addEventListener('click', function () {
            materialIdToDelete = this.getAttribute('data-id');
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            modal.show();
        });
    });

    document.getElementById('confirmDeleteButton').addEventListener('click', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch(`/course-materials/${materialIdToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal menghapus materi.');
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan saat menghapus materi.');
        });
        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal'));
        modal.hide();
    });
});