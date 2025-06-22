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
        <!-- Header Card (Selaras dengan students index) -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 p-4">
                <div>
                    <h4 class="mb-1 fw-bold text-gray-900">
                        Manajemen Kursus
                    </h4>
                    <div class="d-flex flex-wrap gap-2 small mb-1">
                        <span class="badge badge-light-info fw-semibold">
                            <i class="bi bi-journal-bookmark me-1"></i> Total: <?php echo e($courses->count()); ?> Kursus
                        </span>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <!-- Status Filter Dropdown -->
                    <div class="dropdown mb-2 mb-md-0">
                        <button class="btn btn-light-primary btn-sm dropdown-toggle d-flex align-items-center shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-filter me-1"></i>
                            <?php
                                $countTotal = $allCourses->count();
                                $countActive = $allCourses->filter(fn($c) => optional($c->payment)->status === 'paid' && now()->lte($c->valid_until) && (!$c->max_sessions || $c->sessions->where('status','completed')->count() < $c->max_sessions))->count();
                                $countExpired = $allCourses->filter(fn($c) => optional($c->payment)->status === 'paid' && (now()->gt($c->valid_until) || ($c->max_sessions && $c->sessions->where('status','completed')->count() >= $c->max_sessions)))->count();
                                $countUnpaid = $allCourses->filter(fn($c) => optional($c->payment)->status === 'pending')->count();

                                $statusLabel = 'Total';
                                $statusCount = $countTotal;
                                $statusBadgeClass = 'bg-light text-dark';
                                if(request('status') == 'active') {
                                    $statusLabel = 'Aktif';
                                    $statusCount = $countActive;
                                    $statusBadgeClass = 'bg-success';
                                } elseif(request('status') == 'expired') {
                                    $statusLabel = 'Expired';
                                    $statusCount = $countExpired;
                                    $statusBadgeClass = 'bg-danger';
                                } elseif(request('status') == 'unpaid') {
                                    $statusLabel = 'Unpaid';
                                    $statusCount = $countUnpaid;
                                    $statusBadgeClass = 'bg-warning text-dark';
                                }
                            ?>
                            <span class="fw-semibold"><?php echo e($statusLabel); ?></span>
                            <span class="badge <?php echo e($statusBadgeClass); ?> ms-2 px-2 py-1 rounded-pill"><?php echo e($statusCount); ?></span>
                        </button>
                        <ul class="dropdown-menu shadow-sm">
                            <li>
                                <a class="dropdown-item d-flex justify-content-between align-items-center status-filter-link <?php echo e(!request('status') ? 'active fw-bold' : ''); ?>"
                                href="<?php echo e(route('courses.index', request()->except('status'))); ?>">
                                    Total
                                    <span class="badge bg-primary text-white ms-2 px-2 py-1 rounded-pill"><?php echo e($countTotal); ?></span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex justify-content-between align-items-center status-filter-link <?php echo e(request('status') == 'active' ? 'active fw-bold' : ''); ?>"
                                href="?status=active">
                                    Aktif
                                    <span class="badge bg-success text-white ms-2 px-2 py-1 rounded-pill"><?php echo e($countActive); ?></span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex justify-content-between align-items-center status-filter-link <?php echo e(request('status') == 'expired' ? 'active fw-bold' : ''); ?>"
                                href="?status=expired">
                                    Expired
                                    <span class="badge bg-danger text-white ms-2 px-2 py-1 rounded-pill"><?php echo e($countExpired); ?></span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex justify-content-between align-items-center status-filter-link <?php echo e(request('status') == 'unpaid' ? 'active fw-bold' : ''); ?>"
                                href="?status=unpaid">
                                    Unpaid
                                    <span class="badge bg-warning text-dark ms-2 px-2 py-1 rounded-pill"><?php echo e($countUnpaid); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <?php if(request('status')): ?>
                        <a href="<?php echo e(route('courses.index', request()->except('status'))); ?>"
                            class="btn btn-light btn-sm border ms-1 shadow-sm" title="Clear Selection">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    <?php endif; ?>

                    <!-- Advanced Filter Dropdown -->
                    <div class="dropdown ms-0 ms-md-3 mt-2 mt-md-0">
                        <button class="btn btn-light-primary btn-sm shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-funnel-fill me-1"></i> Filter
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
                                    <button type="submit" class="btn btn-primary fw-bold flex-fill shadow-sm">Terapkan</button>
                                    <a href="<?php echo e(route('courses.index')); ?>" class="btn btn-light fw-bold flex-fill shadow-sm">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <a href="<?php echo e(route('courses.create')); ?>" class="btn btn-primary btn-sm mt-2 mt-md-0 shadow-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Kursus
                    </a>
                </div>
            </div>
        </div>

        <!-- Course List -->
        <div id="courseList">
            <?php echo $__env->make('courses.partials.course-list', ['courses' => $courses], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <!-- Success Message -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mb-6" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
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