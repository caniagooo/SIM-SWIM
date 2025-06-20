
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
        <!-- Summary Row -->
        <div class="row g-4 mb-7">
            <div class="col-6 col-lg-3">
                <div class="card border-0 bg-primary bg-opacity-10 shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <div class="mb-2">
                            <i class="bi bi-journal-bookmark fs-1 text-primary"></i>
                        </div>
                        <div class="fs-2 fw-bold text-primary"><?php echo e($overview->active_courses ?? 0); ?></div>
                        <div class="fs-8 text-gray-700">Total Kursus Aktif</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 bg-success bg-opacity-10 shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <div class="mb-2">
                            <i class="bi bi-people fs-1 text-success"></i>
                        </div>
                        <div class="fs-2 fw-bold text-success"><?php echo e($overview->total_students ?? 0); ?></div>
                        <div class="fs-8 text-gray-700">Total Murid</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 bg-warning bg-opacity-10 shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <div class="mb-2">
                            <i class="bi bi-cash-stack fs-1 text-warning"></i>
                        </div>
                        <div class="fs-2 fw-bold text-warning">Rp <?php echo e(number_format($overview->total_unpaid,0,0,"." ?? 0)); ?></div>
                        <div class="fs-8 text-gray-700">Belum Lunas</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 bg-info bg-opacity-10 shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <div class="mb-2">
                            <i class="bi bi-calendar fs-1 text-info"></i>
                        </div>
                        <div class="fs-2 fw-bold text-info"><?php echo e($overview->total_unscheduled_sessions); ?></div>
                        <div class="fs-8 text-gray-700">Sesi Belum Terjadwal</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row g-5 mb-7">
            <!-- Kursus Aktif Table -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h4 class="card-title fw-bold mb-0">Kursus Aktif</h4>
                        <a href="<?php echo e(route('courses.index')); ?>" class="btn btn-sm btn-light-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive rounded-3">
                            <table class="table align-middle border-1 table-row-dashed gy-3 mb-0">
                                <thead class="bg-light-primary">
                                    <tr class="fw-semibold text-gray-700 align-middle">
                                    </tr>
                                </thead>
                                <tbody>
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
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <span class="fw-bold text-primary me-2"><a href="<?php echo e(route('courses.show', $course->course_id)); ?>"><?php echo e($course->course_name); ?></a></span>
                                                        <span class="badge badge-light-info"><?php echo e(ucfirst($course->type)); ?></span>
                                                        <span class="bi-calendar-event fs-8 text-gray-500 ms-2 me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="sesi berikutnya : <?php echo e($course->next_session_date); ?>"></span><?php echo e($completeSessions); ?>/<?php echo e($totalSessions); ?>

                                                    </div>
                                                    <div class="fs-8 text-gray-600 mb-1">
                                                        <i class="bi bi-geo-alt"></i> <?php echo e($course->venue_name ?? '-'); ?>

                                                    </div>
                                                    
                                                    <div class="progress h-6px bg-light-primary" style="height:6px;">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo e($progress); ?>%;" aria-valuenow="<?php echo e($progress); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="fs-8 text-gray-500 mb-1">
                                                        <?php echo e($start->format('d M')); ?> - <?php echo e($end->format('d M Y')); ?>

                                                    </div>
                                                    
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="symbol-group symbol-hover mb-1">
                                                        <?php $__currentLoopData = array_slice($avatars,0,2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $avatar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="symbol symbol-30px symbol-circle me-n2" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e($names[$idx] ?? ''); ?>">
                                                                <img alt="img" src="<?php echo e($avatar ? asset('storage/'.$avatar) : asset('assets/media/avatars/default-avatar.png')); ?>" />
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if(count($avatars) > 2): ?>
                                                            <div class="symbol symbol-30px symbol-circle bg-light me-n2" data-bs-toggle="tooltip" data-bs-placement="top" title="
                                                                <?php $__currentLoopData = array_slice($names,2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($n); ?><?php if(!$loop->last): ?>, <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            ">
                                                                <span class="fs-8 fw-bold text-gray-600">+<?php echo e(count($avatars)-2); ?></span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="fs-8 text-gray-600">
                                                        <?php echo e(count($avatars)); ?> Murid
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="symbol-group symbol-hover mb-1">
                                                        <?php $__currentLoopData = array_slice($t_avatars,0,2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $avatar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="symbol symbol-30px symbol-circle me-n2" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e($t_names[$idx] ?? ''); ?>">
                                                                <img alt="img" src="<?php echo e($avatar ? asset('storage/'.$avatar) : asset('assets/media/avatars/blank.png')); ?>" />
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if(count($t_avatars) > 2): ?>
                                                            <div class="symbol symbol-30px symbol-circle bg-light me-n2" data-bs-toggle="tooltip" data-bs-placement="top" title="
                                                                <?php $__currentLoopData = array_slice($t_names,2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($n); ?><?php if(!$loop->last): ?>, <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            ">
                                                                <span class="fs-8 fw-bold text-gray-600">+<?php echo e(count($t_avatars)-2); ?></span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="fs-8 text-gray-600">
                                                        <?php $__currentLoopData = array_slice($t_names,0,2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php echo e($n); ?><?php if(!$loop->last): ?>, <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if(count($t_names) > 2): ?>
                                                            , <span data-bs-toggle="tooltip" title="<?php $__currentLoopData = array_slice($t_names,2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($n); ?><?php if(!$loop->last): ?>, <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>">+<?php echo e(count($t_names)-2); ?> lainnya</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Tidak ada kursus aktif.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kalender Jadwal Sesi -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light py-3">
                        <h5 class="card-title mb-0 fw-bold">Kalender Jadwal Sesi</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <?php $__empty_1 = true; $__currentLoopData = $sessionSchedules ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li class="list-group-item d-flex align-items-center px-0">
                                    <span class="badge badge-light-primary me-3"><?php echo e(\Carbon\Carbon::parse($session->session_date)->format('d M Y')); ?></span>
                                    <div>
                                        <div class="fw-bold"><?php echo e($session->course_name); ?></div>
                                        <div class="fs-8 text-gray-600"><?php echo e($session->venue_name ?? '-'); ?></div>
                                    </div>
                                    <span class="ms-auto badge badge-light-success"><?php echo e(ucfirst($session->status)); ?></span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li class="list-group-item text-muted">Tidak ada jadwal sesi.</li>
                            <?php endif; ?>
                        </ul>
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