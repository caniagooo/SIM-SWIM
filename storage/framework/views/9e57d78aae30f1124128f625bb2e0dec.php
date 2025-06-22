<?php if (isset($component)) { $__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e = $attributes; } ?>
<?php $component = App\View\Components\DefaultLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('default-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\DefaultLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="container py-3">
        <!-- Header Card ala Metronic -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 p-4">
                <div>
                    <h4 class="mb-1 fw-bold text-gray-900">
                        Daftar Materi Kursus
                    </h4>
                    <div class="d-flex flex-wrap gap-2 small mb-1">
                        <span class="badge badge-light-info fw-semibold">
                            <i class="bi bi-journal-bookmark me-1"></i> Total: <?php echo e($materials->count()); ?> Materi
                        </span>
                    </div>
                </div>
                <div>
                    <a href="<?php echo e(route('course-materials.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Materi
                    </a>
                </div>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card card-flush border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-200 align-middle gy-2 mb-0">
                        <thead>
                            <tr class="text-center fw-semibold text-gray-600 fs-7">
                                <th>#</th>
                                <th>Level</th>
                                <th>Nama Materi</th>
                                <th>Estimasi Sesi</th>
                                <th>Nilai Minimum</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center text-gray-500 fs-8"><?php echo e($loop->iteration); ?></td>
                                    <td class="text-center fs-8"><?php echo e($material->level); ?></td>
                                    <td class="fs-8"><?php echo e($material->name); ?></td>
                                    <td class="text-center fs-8"><?php echo e($material->estimated_sessions); ?></td>
                                    <td class="text-center fs-8"><?php echo e($material->minimum_score); ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo e(route('course-materials.edit', $material->id)); ?>" class="btn btn-light-warning btn-sm rounded-pill px-3 me-1">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-light-danger btn-sm rounded-pill px-3 btnDeleteMaterial" data-id="<?php echo e($material->id); ?>">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada materi.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Delete -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus materi ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <style>
        .fs-8 { font-size: 0.88rem !important; }
        .rounded-pill { border-radius: 2rem !important; }
        .btn-light-warning { background: #fff8dd; color: #ffc700; border: none; }
        .btn-light-warning:hover { background: #ffe082; color: #7a5700; }
        .btn-light-danger { background: #fff5f8; color: #f1416c; border: none; }
        .btn-light-danger:hover { background: #ffe5ea; color: #a8072c; }
    </style>

    <script>
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
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $attributes = $__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $component = $__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views/course-materials/index.blade.php ENDPATH**/ ?>