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
    <div class="container">
        <!-- Header -->
        <div class="d-flex flex-wrap flex-stack mb-6">
            <div class="d-flex align-items-center">
                <h1 class="fw-bold mb-0 me-4">Courses</h1>
                <span class="badge badge-light-primary fs-7 me-2 py-2 px-3" style="font-size:0.95rem;">
                    Total <span class="fw-bold ms-1"><?php echo e($courses->count()); ?></span>
                </span>
                <a href="?status=active" class="badge badge-light-success fs-7 me-1 py-2 px-3 <?php echo e(request('status') == 'active' ? 'border border-success' : ''); ?>" style="font-size:0.95rem; cursor:pointer;">
                    Aktif <span class="fw-bold ms-1">
                        <?php echo e($courses->filter(fn($c) => optional($c->payment)->status === 'paid' && now()->lte($c->valid_until) && (!$c->max_sessions || $c->sessions->where('status','completed')->count() < $c->max_sessions))->count()); ?>

                    </span>
                </a>
                <a href="?status=expired" class="badge badge-light-danger fs-7 me-1 py-2 px-3 <?php echo e(request('status') == 'expired' ? 'border border-danger' : ''); ?>" style="font-size:0.95rem; cursor:pointer;">
                    Expired <span class="fw-bold ms-1">
                        <?php echo e($courses->filter(fn($c) => optional($c->payment)->status === 'paid' && (now()->gt($c->valid_until) || ($c->max_sessions && $c->sessions->where('status','completed')->count() >= $c->max_sessions)))->count()); ?>

                    </span>
                </a>
                <a href="?status=unpaid" class="badge badge-light-warning fs-7 py-2 px-3 <?php echo e(request('status') == 'unpaid' ? 'border border-warning' : ''); ?>" style="font-size:0.95rem; cursor:pointer;">
                    Unpaid <span class="fw-bold ms-1">
                        <?php echo e($courses->filter(fn($c) => optional($c->payment)->status === 'pending')->count()); ?>

                    </span>
                </a>
                <!-- Advanced Filter Dropdown -->
                <div class="dropdown ms-3">
                    <button class="btn btn-light-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-funnel-fill me-1"></i> Filter Lanjutan
                    </button>
                    <div class="dropdown-menu p-4 shadow-lg" style="min-width:320px;">
                        <form method="GET" id="advancedFilterForm">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Pelatih</label>
                                <select name="trainer_id" class="form-select">
                                    <option value="">Semua Pelatih</option>
                                    <?php $__currentLoopData = $allTrainers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($trainer->id); ?>" <?php echo e(request('trainer_id') == $trainer->id ? 'selected' : ''); ?>>
                                            <?php echo e($trainer->user->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Venue</label>
                                <select name="venue_id" class="form-select">
                                    <option value="">Semua Venue</option>
                                    <?php $__currentLoopData = $courses->pluck('venue')->unique('id')->filter(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($venue->id); ?>" <?php echo e(request('venue_id') == $venue->id ? 'selected' : ''); ?>>
                                            <?php echo e($venue->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary fw-bold flex-fill">Terapkan</button>
                                <a href="<?php echo e(route('courses.index')); ?>" class="btn btn-light fw-bold flex-fill">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <a href="<?php echo e(route('courses.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Course
            </a>
        </div>

        <!-- Success Message -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mb-6" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

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
    </div>

    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('courses.partials.assign-trainer-modal', ['course' => $course, 'allTrainers' => $allTrainers], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('courses.partials.assign-materials-modal', ['course' => $course, 'allMaterials' => $allMaterials], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('courses.partials.sessions-modal', ['course' => $course], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php echo $__env->make('courses.partials.invoice-course-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $attributes = $__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $component = $__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views/courses/index.blade.php ENDPATH**/ ?>