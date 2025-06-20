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
                <span class="badge badge-light-primary fs-6"><?php echo e($courses->count()); ?> Total</span>
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

        <!-- Course Cards -->
        <div class="row g-8">
            <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $payment = $course->payment;
                $sessionsCompleted = $course->sessions->where('status', 'completed')->count();
                $totalSessions = $course->max_sessions;
                $isExpired = now()->greaterThan($course->valid_until);
                $now = now();
                $start = $course->start_date;
                $end = $course->valid_until;
                $progress = $now->lt($start) ? 0 : ($now->gt($end) ? 100 : round($now->diffInDays($start, false) >= 0 ? ($now->diffInDays($start) / max(1, $end->diffInDays($start))) * 100 : 0));
                $isGroup = $course->type === 'group';
            ?>
            <div class="col-xl-4 col-md-6 mb-6">
                <div class="card card-flush shadow-sm h-100 rounded-4 overflow-hidden d-flex flex-column">
                    <!-- Card Header -->
                    <div class="card-header bg-white py-4 px-0 position-relative rounded-0 w-100 border-bottom">
                        <div class="d-flex flex-wrap align-items-center justify-content-between w-100 px-6">
                            <div class="d-flex flex-column flex-grow-1 w-100">
                                <div class="d-flex align-items-center justify-content-between mb-1 w-100">
                                    <span class="fw-bold fs-6 text-dark text-truncate" title="<?php echo e($course->name ?? '-'); ?>">
                                        <?php echo e($course->name ?? '-'); ?>

                                    </span>
                                    <?php
                                        $isActive = false;
                                        $statusText = '';
                                        $statusClass = '';
                                        $now = now();
                                        $expired = $now->greaterThan($course->valid_until);
                                        $maxSessionReached = $course->max_sessions ? ($sessionsCompleted >= $course->max_sessions) : false;

                                        if ($payment && $payment->status === 'paid' && !$expired && !$maxSessionReached) {
                                            $isActive = true;
                                            $statusText = 'Aktif';
                                            $statusClass = 'badge-light-success';
                                        } elseif ($expired || $maxSessionReached) {
                                            $statusText = 'Expired';
                                            $statusClass = 'badge-light-danger';
                                        } else {
                                            $statusText = 'Unpaid';
                                            $statusClass = 'badge-light-warning';
                                        }
                                    ?>
                                    <?php if($statusText === 'Unpaid'): ?>
                                        <button type="button"
                                            class="btn btn-light-warning btn-sm fw-bold px-4 py-2 btnPayNow"
                                            style="font-size: 0.85rem; line-height: 1; padding: 0.25rem 0.75rem; border-radius: 0.475rem; height: 25px; min-width: 70px;"
                                            data-course-id="<?php echo e($course->id); ?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#paymentModal">
                                            <i class="bi bi-cash-coin me-2"></i> Pay Now
                                        </button>
                                    <?php else: ?>
                                        <span class="badge <?php echo e($statusClass); ?> fs-8 fw-semibold px-4 py-2"
                                            style="font-size: 0.85rem; line-height: 1; border-radius: 0.475rem; height: 25px; min-width: 70px; display: inline-flex; align-items: center; justify-content: center;">
                                            <?php echo e($statusText); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex align-items-center flex-wrap gap-2 text-gray-600 fs-8 w-100 justify-content-between">
                                    <span class="d-flex align-items-center" title="Lokasi">
                                        <i class="bi bi-geo-alt-fill me-1 text-primary"></i>
                                        <span class="fw-semibold"><?php echo e($course->venue->name ?? '-'); ?></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Separator -->
                    <div class="card-separator bg-white">
                        <div>
                            <?php
                                $today = now();
                                $start = $course->start_date;
                                $end = $course->valid_until;
                                $totalDays = $start->diffInDays($end) ?: 1;
                                $elapsedDays = $start->lte($today) ? $start->diffInDays(min($today, $end)) : 0;
                                $progress = min(100, max(0, round(($elapsedDays / $totalDays) * 100)));
                                $daysLeft = $today->lte($end) ? $today->diffInDays($end) : 0;

                                // Progress bar color logic (saran #3)
                                if ($today->gt($end)) {
                                    $progressBg = 'background-color: rgba(255,76,81,0.15);';
                                    $progressBarBg = 'background: #F1416C; color: #fff;';
                                } elseif ($progress >= 1) {
                                    $progressBg = 'background-color: rgba(80,205,137,0.15);';
                                    $progressBarBg = 'background: #50CD89; color: #fff;';
                                } else {
                                    $progressBg = 'background-color: rgba(0,158,247,0.15);';
                                    $progressBarBg = 'background: #009EF7; color: #fff;';
                                }
                            ?>
                            <div class="d-flex align-items-center gap-2">
                                <div class="flex-grow-1 mx-0" style="min-width: 0;">
                                    <div class="position-relative" style="height: 25px;">
                                        <div class="progress" style="<?php echo e($progressBg); ?> height: 100%; border-radius: 0;">
                                            <div class="progress-bar" 
                                                role="progressbar"
                                                style="width: <?php echo e($progress); ?>%; <?php echo e($progressBarBg); ?>; border-radius: 0;"
                                                aria-valuenow="<?php echo e($progress); ?>" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body py-4 px-6">
                        <div class="d-flex flex-column gap-3">
                            <!-- Murid -->
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold text-gray-700">
                                    <i class="bi bi-people me-1"></i> Murid
                                </span>
                                <span class="ms-2 text-end d-flex align-items-center flex-wrap">
                                    <?php if($course->students->count() > 0): ?>
                                        <?php
                                            $maxAvatars = 3;
                                            $students = $course->students->take($maxAvatars);
                                        ?>
                                        <?php if($course->type === 'group'): ?>
                                            <div class="d-flex align-items-center" style="margin-right: 8px;">
                                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <img 
                                                        src="<?php echo e($student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png')); ?>" 
                                                        alt="<?php echo e($student->user->name); ?>" 
                                                        class="rounded-circle border border-2 border-white"
                                                        style="width: 32px; height: 32px; object-fit: cover; background: #f1f1f1; margin-left: <?php echo e($i === 0 ? '0' : '-12px'); ?>;"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="<?php echo e($student->user->name); ?>"
                                                    >
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($course->students->count() > $maxAvatars): ?>
                                                    <span class="rounded-circle bg-light d-flex align-items-center justify-content-center border border-2 border-white"
                                                        style="width: 32px; height: 32px; margin-left: -12px; font-size: 0.95rem;">
                                                        +<?php echo e($course->students->count() - $maxAvatars); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <?php
                                                $studentNames = $course->students->pluck('user.name')->implode(', ');
                                            ?>
                                            <span 
                                                class="badge badge-light-info ms-2"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="<?php echo e($studentNames); ?>"
                                            >
                                                <?php echo e($course->students->count()); ?> murid
                                            </span>
                                        <?php else: ?>
                                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <img 
                                                    src="<?php echo e($student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png')); ?>" 
                                                    alt="<?php echo e($student->user->name); ?>" 
                                                    class="rounded-circle border border-2 border-white shadow"
                                                    style="width: 32px; height: 32px; object-fit: cover; background: #f1f1f1; margin-right: 6px;"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="<?php echo e($student->user->name); ?>"
                                                >
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($course->students->count() > $maxAvatars): ?>
                                                <span class="rounded-circle bg-light d-flex align-items-center justify-content-center border border-2 border-white shadow"
                                                    style="width: 32px; height: 32px; font-size: 0.95rem;">
                                                    +<?php echo e($course->students->count() - $maxAvatars); ?>

                                                </span>
                                            <?php endif; ?>
                                            <?php if($course->type === 'private' && $course->students->count() === 1): ?>
                                                <span class="badge badge-light-primary ms-2"><?php echo e($course->students->first()->user->name); ?></span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted" style="font-size: 1rem;">-</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <!-- Pelatih -->
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold text-gray-700"><i class="bi bi-person-badge me-1"></i> Pelatih</span>
                                <span class="ms-2 text-end">
                                    <?php if($course->trainers->count()): ?>
                                        <?php $__currentLoopData = $course->trainers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="d-inline-flex align-items-center mb-1 me-1">
                                                <img 
                                                    src="<?php echo e($trainer->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png')); ?>" 
                                                    alt="<?php echo e($trainer->user->name); ?>" 
                                                    class="rounded-circle border border-2 border-white shadow" 
                                                    style="width: 32px; height: 32px; object-fit: cover; background: #f1f1f1; margin-right: 6px;">
                                                <span class="badge badge-light-success"><?php echo e($trainer->user->name); ?></span>
                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <span class="text-muted"></span>
                                        <button type="button" class="btn btn-sm btn-light-warning ms-2" data-bs-toggle="modal" data-bs-target="#assignTrainerModal-<?php echo e($course->id); ?>">
                                            <i class="bi bi-person-plus"></i> Pilih Pelatih
                                        </button>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <!-- Materi -->
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold text-gray-700">
                                    <i class="bi bi-journal-text me-1"></i> Materi
                                </span>
                                <span class="ms-2 text-end">
                                    <?php if($course->materials->isEmpty()): ?>
                                        <span class="text-muted"></span>
                                        <button type="button" class="btn btn-sm btn-light-warning ms-2" data-bs-toggle="modal" data-bs-target="#assignMaterialsModal-<?php echo e($course->id); ?>">
                                            <i class="bi bi-journal-plus"></i> Assign Materi
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-sm btn-light-success ms-2" data-bs-toggle="modal" data-bs-target="#assignMaterialsModal-<?php echo e($course->id); ?>">
                                            <i class="bi bi-journal-text"></i>
                                            <?php echo e($course->materials->count()); ?> Materi
                                        </button>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Card Footer -->
                    <div class="bg-white px-0">
                        <div class="d-flex align-items-center justify-content-between px-6 py-0">
                            <span class="d-flex align-items-center text-gray-600 fs-8" title="durasi kursus">
                                <i class="bi bi-clock-fill me-1 text-primary"></i>
                                <span class="fw-semibold"><?php echo e($course->start_date->format('d M Y')); ?> - <?php echo e($course->valid_until->format('d M Y')); ?></span>
                                        
                            </span>                 
                            <span class="fs-8 fw-normal text-gray-700 px-2 py-1  d-flex align-items-center" title="Jumlah sesi selesai">
                                        <i class="bi bi-calendar-check me-1 text-success"></i>
                                        <?php echo e($sessionsCompleted); ?>/<?php echo e($course->max_sessions); ?> sesi
                            </span>         
                        </div>
                    </div>
                    <!-- card lower footer -->
                    <div class="border-top px-0">
                        <div class="d-flex align-items-stretch gap-0">
                            <!-- Jadwal Sesi Button (left) -->
                            <button 
                                type="button"
                                class="btn btn-light-info btn-lg flex-grow-1 rounded-0 rounded-start d-flex align-items-center justify-content-center border-end"
                                style="font-size:1.05rem; font-weight:600; border-top: none; border-bottom: none;"
                                data-bs-toggle="modal"
                                data-bs-target="#sessionsModal-<?php echo e($course->id); ?>"
                            >
                                <i class="bi bi-calendar-event me-2"></i>
                                Jadwal Sesi
                            </button>
                            <!-- Vertical Divider -->
                            <div style="width:1px; background:#e5e9f2;"></div>
                            <!-- Detail Kursus Button (right) -->
                            <a href="<?php echo e(route('courses.show', $course->id)); ?>"
                                class="btn btn-light-primary btn-lg flex-grow-1 rounded-0 rounded-end d-flex align-items-center justify-content-center"
                                style="font-size:1.05rem; font-weight:600; border-top: none; border-bottom: none;">
                                <span class="bi bi-eye me-2"></span> Lihat Detail
                            </a>
                        </div>

                        <!-- Modal Jadwal Sesi -->
                        <div class="modal fade" id="sessionsModal-<?php echo e($course->id); ?>" tabindex="-1" aria-labelledby="sessionsModalLabel-<?php echo e($course->id); ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-light-info">
                                        <h5 class="modal-title" id="sessionsModalLabel-<?php echo e($course->id); ?>">
                                            Jadwal Sesi Kursus: <?php echo e($course->name); ?>

                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                            $sessions = $course->sessions->sortBy('date');
                                        ?>
                                        <?php if($sessions->count()): ?>
                                            <ul class="list-group list-group-flush">
                                                <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="list-group-item d-flex align-items-center justify-content-between px-3 py-3">
                                                        <div>
                                                            <span class="fw-semibold">Sesi <?php echo e($idx+1); ?>:</span>
                                                            <?php echo e(\Carbon\Carbon::parse($session->date)->format('d M Y H:i')); ?>

                                                        </div>
                                                        <span class="badge 
                                                            <?php if($session->status === 'completed'): ?> badge-light-success
                                                            <?php elseif($session->status === 'scheduled'): ?> badge-light-warning
                                                            <?php else: ?> badge-light-secondary
                                                            <?php endif; ?>
                                                            px-3 py-2">
                                                            <?php echo e(ucfirst($session->status)); ?>

                                                        </span>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        <?php else: ?>
                                            <div class="alert alert-info mb-0">
                                                <i class="bi bi-info-circle me-2"></i>
                                                Belum ada sesi dijadwalkan untuk kursus ini.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Assign Trainer Modal -->
            <div class="modal fade" id="assignTrainerModal-<?php echo e($course->id); ?>" tabindex="-1" aria-labelledby="assignTrainerModalLabel-<?php echo e($course->id); ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="<?php echo e(route('courses.assign', $course->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="modal-header">
                                <h5 class="modal-title" id="assignTrainerModalLabel-<?php echo e($course->id); ?>">Pilih Pelatih</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="trainers-<?php echo e($course->id); ?>" class="form-label">Pelatih</label>
                                    <select name="trainers[]" id="trainers-<?php echo e($course->id); ?>" class="form-select" multiple required>
                                        <?php $__currentLoopData = $allTrainers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($trainer->id); ?>" <?php echo e($course->trainers->contains($trainer->id) ? 'selected' : ''); ?>>
                                                <?php echo e($trainer->user->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <small class="text-muted">Pilih satu atau lebih pelatih untuk kursus ini.</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Assign Materials Modal -->
            <div class="modal fade" id="assignMaterialsModal-<?php echo e($course->id); ?>" tabindex="-1" aria-labelledby="assignMaterialsModalLabel-<?php echo e($course->id); ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="<?php echo e(route('courses.assign', $course->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="modal-header">
                                <h5 class="modal-title" id="assignMaterialsModalLabel-<?php echo e($course->id); ?>">Pilih Materi Kursus</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-12 mb-4">
                                    <div class="fs-6">
                                        <div class="fw-bold">Catatan terkait murid:</div>
                                    </div>
                                    <i class="fs-6"><?php echo e($course->basic_skills ?: '-'); ?></i>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Pilih Materi:</strong></label>
                                    <div class="accordion accordion-icon-toggle" id="materialsAccordion-<?php echo e($course->id); ?>">
                                        <?php
                                            $groupedMaterials = $allMaterials->groupBy('level');
                                            $selectedMaterialIds = $course->materials->pluck('id')->toArray();
                                        ?>
                                        <?php $__currentLoopData = $groupedMaterials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level => $materials): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading-<?php echo e($course->id); ?>-<?php echo e($level); ?>">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo e($course->id); ?>-<?php echo e($level); ?>" aria-expanded="false" aria-controls="collapse-<?php echo e($course->id); ?>-<?php echo e($level); ?>">
                                                        <span class="fw-bold">Level <?php echo e($level); ?></span>
                                                    </button>
                                                </h2>
                                                <div id="collapse-<?php echo e($course->id); ?>-<?php echo e($level); ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo e($course->id); ?>-<?php echo e($level); ?>" data-bs-parent="#materialsAccordion-<?php echo e($course->id); ?>">
                                                    <div class="accordion-body p-0">
                                                        <div class="list-group list-group-flush">
                                                            <?php $__empty_2 = true; $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                <label class="list-group-item d-flex align-items-center py-3 px-3" style="border-bottom: 1px solid #f1f1f1;">
                                                                    <input 
                                                                        type="checkbox" 
                                                                        name="materials[]" 
                                                                        value="<?php echo e($material->id); ?>" 
                                                                        class="form-check-input material-checkbox-<?php echo e($course->id); ?> me-3 ms-1"
                                                                        style="margin-left: 0.5rem; margin-right: 1rem;"
                                                                        data-estimasi="<?php echo e($material->estimated_sessions); ?>"
                                                                        data-minscore="<?php echo e($material->minimum_score); ?>"
                                                                        <?php echo e(in_array($material->id, $selectedMaterialIds) ? 'checked' : ''); ?>

                                                                    >
                                                                    <div class="flex-grow-1">
                                                                        <div class="fw-semibold fs-6 mb-1"><?php echo e($material->name); ?></div>
                                                                        <div class="d-flex flex-wrap gap-3 small text-muted">
                                                                            <span><i class="bi bi-clock me-1"></i> Estimasi: <span class="fw-bold"><?php echo e($material->estimated_sessions); ?></span> sesi</span>
                                                                            <span><i class="bi bi-star me-1"></i> Min. Skor: <span class="fw-bold"><?php echo e($material->minimum_score); ?></span></span>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                                <div class="text-muted px-3 py-2">Tidak ada materi pada level ini.</div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <div class="border-top pt-3 mt-3">
                                    <div class="row text-center">
                                        <div class="col">
                                            <div class="fw-bold fs-6">Materi Terpilih</div>
                                            <div id="selectedCount-<?php echo e($course->id); ?>" class="fs-5">0</div>
                                        </div>
                                        <div class="col">
                                            <div class="fw-bold fs-6">Total Estimasi Sesi</div>
                                            <div id="totalSessions-<?php echo e($course->id); ?>" class="fs-5">0</div>
                                        </div>
                                        <div class="col">
                                            <div class="fw-bold fs-6">Rata-rata Min. Skor</div>
                                            <div id="avgMinScore-<?php echo e($course->id); ?>" class="fs-5">0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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

    <?php $__env->startPush('scripts'); ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tooltip for avatars and badges
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Material stats update
        function updateMaterialStats(courseId) {
            let checkboxes = document.querySelectorAll('.material-checkbox-' + courseId);
            let selected = 0, totalSessions = 0, totalMinScore = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    selected++;
                    totalSessions += parseInt(cb.getAttribute('data-estimasi')) || 0;
                    totalMinScore += parseFloat(cb.getAttribute('data-minscore')) || 0;
                }
            });
            document.getElementById('selectedCount-' + courseId).textContent = selected;
            document.getElementById('totalSessions-' + courseId).textContent = totalSessions;
            document.getElementById('avgMinScore-' + courseId).textContent = selected ? (totalMinScore / selected).toFixed(2) : 0;
        }

        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            updateMaterialStats(<?php echo e($course->id); ?>);
            document.querySelectorAll('.material-checkbox-<?php echo e($course->id); ?>').forEach(cb => {
                cb.addEventListener('change', function () {
                    updateMaterialStats(<?php echo e($course->id); ?>);
                });
            });
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        // Pay Now button
        let selectedCourseId = null;
        document.querySelectorAll('.btnPayNow').forEach(button => {
            button.addEventListener('click', function () {
                selectedCourseId = this.getAttribute('data-course-id');
                fetch(`/course-payments/invoice/${selectedCourseId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'paid' || data.status === 'expired') {
                            alert('Pembayaran tidak dapat dilakukan. Kursus sudah paid atau expired.');
                            return;
                        }
                        document.getElementById('paymentModalBody').innerHTML = `
                            <div class="mb-2"><strong>Invoice Number:</strong> ${data.invoice_number}</div>
                            <div class="mb-2"><strong>Amount:</strong> Rp. ${data.amount.toLocaleString()}</div>
                            <div class="mb-2"><strong>Status:</strong> ${data.status}</div>
                            <div class="mb-3">
                                <label for="actualPaymentMethod" class="form-label">Payment Method</label>
                                <select id="actualPaymentMethod" class="form-select">
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="credit_card">Credit Card</option>
                                </select>
                            </div>
                        `;
                        // Reset confirm button state
                        const confirmBtn = document.getElementById('confirmPaymentButton');
                        confirmBtn.disabled = false;
                        // Show modal using getOrCreateInstance to avoid duplicate instance
                        const modalEl = document.getElementById('paymentModal');
                        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                        modal.show();
                    });
            });
        });

        // Confirm Payment
        document.getElementById('confirmPaymentButton').addEventListener('click', function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const actualPaymentMethod = document.getElementById('actualPaymentMethod')?.value;

            if (!actualPaymentMethod) {
                alert('Pilih metode pembayaran.');
                return;
            }

            // Disable button to prevent double submit
            this.disabled = true;

            fetch(`/course-payments/process/${selectedCourseId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ payment_method: actualPaymentMethod }),
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || 'Pembayaran berhasil.');
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while processing the payment.');
            })
            .finally(() => {
                // Selalu enable button kembali
                this.disabled = false;
                // Tutup modal dengan aman
                const modalEl = document.getElementById('paymentModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            });
        });

        // Optional: Reset modal content when closed (prevent stale data)
        document.getElementById('paymentModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('paymentModalBody').innerHTML = '';
        });
    });
    </script>
    <?php $__env->stopPush(); ?>

    <!-- Pay Now Modal (global, isi invoice & konfirmasi) -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="paymentModalBody">
                    <!-- Akan diisi via JS -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmPaymentButton">Confirm</button>
                </div>
            </div>
        </div>
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
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views\courses\index.blade.php ENDPATH**/ ?>