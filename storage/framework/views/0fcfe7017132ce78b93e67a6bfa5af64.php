<div class="row g-8">
    <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php echo $__env->make('courses.partials.course-card', ['course' => $course], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 text-center text-muted">
            <div class="alert alert-info py-10">
                <i class="bi bi-info-circle fs-2x mb-2"></i>
                <div class="fs-5">No courses available.</div>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="d-flex justify-content-center mt-4">
    <nav>
        <?php echo e($courses->withQueryString()->links('vendor.pagination.bootstrap-5')); ?>

    </nav>
</div>

    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('courses.partials.assign-trainer-modal', ['course' => $course, 'allTrainers' => $allTrainers], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('courses.partials.assign-materials-modal', ['course' => $course, 'allMaterials' => $allMaterials], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('courses.partials.sessions-modal', ['course' => $course], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php echo $__env->make('courses.partials.invoice-course-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\JITU\swim\resources\views/courses/partials/course-list.blade.php ENDPATH**/ ?>