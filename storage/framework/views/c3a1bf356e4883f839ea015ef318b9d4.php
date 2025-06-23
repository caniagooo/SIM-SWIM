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
                        Manajemen Trainer
                    </h4>
                    <div class="d-flex flex-wrap gap-2 small mb-1">
                        <span class="badge badge-light-info fw-semibold">
                            <i class="bi bi-person-badge me-1"></i> Total: <?php echo e($trainers->count()); ?> Trainer
                        </span>
                    </div>
                </div>
                <div>
                    <a href="<?php echo e(route('trainers.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Trainer
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
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Tipe</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $trainers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center text-gray-500 fs-8"><?php echo e($loop->iteration); ?></td>
                                <td class="fs-8"><?php echo e($trainer->user->name); ?></td>
                                <td class="fs-8"><?php echo e($trainer->user->email); ?></td>
                                <td class="fs-8"><?php echo e(ucfirst($trainer->type)); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('trainers.edit', $trainer->id)); ?>" class="btn btn-light-warning btn-sm rounded-pill px-3 me-1">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="<?php echo e(route('trainers.destroy', $trainer->id)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-light-danger btn-sm rounded-pill px-3" onclick="return confirm('Yakin ingin menghapus trainer ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <style>
        .fs-8 { font-size: 0.88rem !important; }
        .rounded-pill { border-radius: 2rem !important; }
        .btn-light-warning { background: #fff8dd; color: #ffc700; border: none; }
        .btn-light-warning:hover { background: #ffe082; color: #7a5700; }
        .btn-light-danger { background: #fff5f8; color: #f1416c; border: none; }
        .btn-light-danger:hover { background: #ffe5ea; color: #a8072c; }
    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $attributes = $__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $component = $__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views\trainers\index.blade.php ENDPATH**/ ?>