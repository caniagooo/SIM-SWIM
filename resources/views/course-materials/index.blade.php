<x-default-layout>
    <div class="container">
        <h1 class="mb-4">Course Materials</h1>
        <a href="{{ route('course-materials.create') }}" class="btn btn-primary mb-3">Add Material</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Level</th>
                    <th>Name</th>
                    <th>Estimated Sessions</th>
                    <th>Minimum Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($materials as $material)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $material->level }}</td>
                        <td>{{ $material->name }}</td>
                        <td>{{ $material->estimated_sessions }}</td>
                        <td>{{ $material->minimum_score }}</td>
                        <td>
                            <a href="{{ route('course-materials.edit', $material->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm btnDeleteMaterial" data-id="{{ $material->id }}">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No materials available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Dialog Box untuk Konfirmasi Delete -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this material?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan CSRF Token untuk AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</x-default-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let materialIdToDelete = null; // Simpan ID materi yang akan dihapus

    // Event listener untuk tombol Delete
    document.querySelectorAll('.btnDeleteMaterial').forEach(button => {
        button.addEventListener('click', function () {
            materialIdToDelete = this.getAttribute('data-id'); // Ambil ID materi
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            modal.show(); // Tampilkan modal konfirmasi
        });
    });

    // Event listener untuk tombol konfirmasi Delete
    document.getElementById('confirmDeleteButton').addEventListener('click', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Kirim permintaan DELETE menggunakan fetch API
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
                alert('Material deleted successfully.');
                location.reload(); // Reload halaman untuk memuat data terbaru
            } else {
                alert('Failed to delete material.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the material.');
        });

        // Tutup modal setelah konfirmasi
        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal'));
        modal.hide();
    });
});
</script>