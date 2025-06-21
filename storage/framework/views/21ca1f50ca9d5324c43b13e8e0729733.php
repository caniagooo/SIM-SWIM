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
    <?php $__env->startSection('title'); ?>
        Dashboard
    <?php $__env->stopSection(); ?>

    <div class="container-xxl mt-8">
        <div class="row g-5 align-items-stretch">
            <!-- KIRI: Daftar Kursus Aktif -->
            <div class="col-12 col-lg-7 d-flex flex-column">
                <div class="card border-0 shadow-sm flex-grow-1 h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center border-0 pb-0">
                        <div>
                            <h3 class="card-title fw-bold mb-0">Kursus Aktif</h3>
                            <div class="fs-7 text-muted">5 kursus aktif terakhir</div>
                        </div>
                        <a href="<?php echo e(route('courses.index')); ?>" class="btn btn-sm btn-light-primary">
                            <i class="bi bi-list-task me-1"></i> Lihat Semua
                        </a>
                    </div>
                    <div class="card-body pt-3">
                        <?php $__empty_1 = true; $__currentLoopData = $activeCourses->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $start = \Carbon\Carbon::parse($course->start_date);
                                $end = \Carbon\Carbon::parse($course->valid_until);
                                $now = \Carbon\Carbon::now();
                                $totalDays = $start->diffInDays($end) ?: 1;
                                $elapsedDays = $start->diffInDays($now > $end ? $end : $now);
                                $progress = min(100, round(($elapsedDays / $totalDays) * 100));
                                $avatars = explode(',', $course->student_avatars ?? '');
                                $names = explode(',', $course->student_names ?? '');
                                $t_avatars = explode(',', $course->trainer_avatars ?? '');
                                $t_names = explode(',', $course->trainer_names ?? '');
                                $totalSessions = $course->max_sessions ?? 0;
                                $completeSessions = $course->complete_sessions ?? 0;
                            ?>
                            <div class="mb-5 pb-4 border-bottom">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div>
                                        <a href="<?php echo e(route('courses.show', $course->course_id)); ?>" class="fw-bold fs-5 text-primary text-hover-dark"><?php echo e($course->course_name); ?></a>
                                        <span class="badge badge-light-info ms-2"><?php echo e(ucfirst($course->type)); ?></span>
                                    </div>
                                    <div class="fs-7 text-gray-500">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        <span data-bs-toggle="tooltip" title="Sesi berikutnya: <?php echo e($course->next_session_date); ?>">
                                            <?php echo e($completeSessions); ?>/<?php echo e($totalSessions); ?>

                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-geo-alt fs-7 text-gray-500 me-2"></i>
                                    <span class="fs-8 text-gray-600"><?php echo e($course->venue_name ?? '-'); ?></span>
                                </div>
                                <div class="progress h-6px bg-light-primary mb-2" style="height:6px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo e($progress); ?>%;" aria-valuenow="<?php echo e($progress); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="fs-8 text-gray-500 mb-2">
                                    <?php echo e($start->format('d M')); ?> - <?php echo e($end->format('d M Y')); ?>

                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="me-4">
                                        <div class="symbol-group symbol-hover">
                                            <?php $__currentLoopData = array_slice($avatars,0,3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $avatar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="symbol symbol-30px symbol-circle me-n2" data-bs-toggle="tooltip" title="<?php echo e($names[$idx] ?? ''); ?>">
                                                    <img alt="img" src="<?php echo e($avatar ? asset('storage/'.$avatar) : asset('assets/media/avatars/default-avatar.png')); ?>" />
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(count($avatars) > 3): ?>
                                                <div class="symbol symbol-30px symbol-circle bg-light me-n2" data-bs-toggle="tooltip" title="<?php $__currentLoopData = array_slice($names,3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($n); ?><?php if(!$loop->last): ?>, <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>">
                                                    <span class="fs-8 fw-bold text-gray-600">+<?php echo e(count($avatars)-3); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="fs-8 text-gray-600 mt-1"><?php echo e(count($avatars)); ?> Murid</div>
                                    </div>
                                    <div>
                                        <div class="symbol-group symbol-hover">
                                            <?php $__currentLoopData = array_slice($t_avatars,0,2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $avatar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="symbol symbol-30px symbol-circle me-n2" data-bs-toggle="tooltip" title="<?php echo e($t_names[$idx] ?? ''); ?>">
                                                    <img alt="img" src="<?php echo e($avatar ? asset('storage/'.$avatar) : asset('assets/media/avatars/blank.png')); ?>" />
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(count($t_avatars) > 2): ?>
                                                <div class="symbol symbol-30px symbol-circle bg-light me-n2" data-bs-toggle="tooltip" title="<?php $__currentLoopData = array_slice($t_names,2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($n); ?><?php if(!$loop->last): ?>, <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>">
                                                    <span class="fs-8 fw-bold text-gray-600">+<?php echo e(count($t_avatars)-2); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="fs-8 text-gray-600 mt-1">
                                            <?php $__currentLoopData = array_slice($t_names,0,2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($n); ?><?php if(!$loop->last): ?>, <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(count($t_names) > 2): ?>
                                                , <span data-bs-toggle="tooltip" title="<?php $__currentLoopData = array_slice($t_names,2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($n); ?><?php if(!$loop->last): ?>, <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>">+<?php echo e(count($t_names)-2); ?> lainnya</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center text-muted py-10">Tidak ada kursus aktif.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- KANAN: Overview Dashboard -->
            <div class="col-12 col-lg-5 d-flex flex-column">
                <div class="row g-4 flex-grow-1">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm h-100 bg-gradient-primary bg-opacity-10">
                            <div class="card-body d-flex align-items-center">
                                <div class="flex-shrink-0 me-4">
                                    <i class="bi bi-journal-bookmark fs-1 text-primary"></i>
                                </div>
                                <div>
                                    <div class="fs-1 fw-bold text-primary mb-0"><?php echo e($overview->active_courses ?? 0); ?></div>
                                    <div class="fs-7 text-gray-700">Kursus Aktif</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 shadow-sm h-100 bg-gradient-success bg-opacity-10">
                            <div class="card-body d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-people fs-2 text-success"></i>
                                </div>
                                <div>
                                    <div class="fs-3 fw-bold text-success mb-0"><?php echo e($overview->total_students ?? 0); ?></div>
                                    <div class="fs-8 text-gray-700">Total Murid</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 shadow-sm h-100 bg-gradient-warning bg-opacity-10">
                            <div class="card-body d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-cash-stack fs-2 text-warning"></i>
                                </div>
                                <div>
                                    <div class="fs-3 fw-bold text-warning mb-0">Rp <?php echo e(number_format($overview->total_unpaid ?? 0,0,0,".")); ?></div>
                                    <div class="fs-8 text-gray-700">Belum Lunas</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm h-100 bg-gradient-info bg-opacity-10">
                            <div class="card-body d-flex align-items-center">
                                <div class="flex-shrink-0 me-4">
                                    <i class="bi bi-calendar fs-1 text-info"></i>
                                </div>
                                <div>
                                    <div class="fs-1 fw-bold text-info mb-0"><?php echo e($overview->total_unscheduled_sessions ?? 0); ?></div>
                                    <div class="fs-7 text-gray-700">Sesi Belum Terjadwal</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-auto pt-4">
                    <div class="alert alert-info d-flex align-items-center mb-0">
                        <i class="bi bi-info-circle fs-2x me-3"></i>
                        <div>
                            <div class="fw-semibold">Tips!</div>
                            <div class="fs-8">Klik nama kursus untuk melihat detail dan kelola sesi, murid, serta pelatih.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                })
            });
        </script>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $attributes = $__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $component = $__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views/dashboard/index.blade.php ENDPATH**/ ?>