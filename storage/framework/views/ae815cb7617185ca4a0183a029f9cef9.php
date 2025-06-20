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
    <div class="container mt-5">
        <div class="card shadow-lg">
            <!-- Header -->
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title text-white">Course Details</h3>
                <div class="card-toolbar">
                    <a href="<?php echo e(route('courses.index')); ?>" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Back to course list">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <a href="<?php echo e(route('courses.edit', $course->id)); ?>" class="btn btn-light-primary btn-sm ms-2" data-bs-toggle="tooltip" title="Edit this course">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body">
                <!-- Tabs -->
                <div class="row">
                    <ul class="nav nav-tabs mb-3" id="courseTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Course Info</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="sessions-tab" data-bs-toggle="tab" data-bs-target="#sessions" type="button" role="tab" aria-controls="sessions" aria-selected="false">Sessions</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="courseTabsContent">
                        <!-- Course Info Tab -->
                        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <h6 class="text-primary mb-3"><i class="bi bi-info-circle"></i> Basic Information</h6>
                                            <table class="table table-borderless table-sm mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="fw-bold text-gray-700">Name</td>
                                                        <td><?php echo e($course->name); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-gray-700">Type</td>
                                                        <td><span class="badge bg-warning"><?php echo e(ucfirst($course->type)); ?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-gray-700">Venue</td>
                                                        <td><?php echo e($course->venue->name ?? 'N/A'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-gray-700">Price</td>
                                                        <td>Rp. <?php echo e(number_format($course->price)); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <h6 class="text-primary mb-2"><i class="bi bi-calendar-range"></i> Course Duration</h6>
                                            <table class="table table-borderless table-sm mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="fw-bold text-gray-700">Start</td>
                                                        <td><?php echo e($course->start_date ? $course->start_date->translatedFormat('l, d F Y') : 'N/A'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-gray-700">End</td>
                                                        <td><?php echo e($course->valid_until ? $course->valid_until->translatedFormat('l, d F Y') : 'N/A'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                            $max = $course->max_sessions ?? 0;
                                                            $scheduled = $course->sessions->count();
                                                            $completed = $course->sessions->where('status', 'completed')->count();
                                                            $unscheduled = max(0, $max - $scheduled);
                                                        ?>
                                                        <td class="fw-bold text-gray-700">Sesi</td>
                                                        <td>
                                                            <span class="text-success"> <?php echo e($completed); ?> </span> / 
                                                            <span class="text-info"> <?php echo e($course->max_sessions ?? 'N/A'); ?> </span> Sesi Pertemuan
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-gray-700">Trainer</td>
                                                        <td>
                                                            <?php if($course->trainers->count() > 0): ?>
                                                                <ul class="list-group list-group-flush mb-3">
                                                                    <?php $__currentLoopData = $course->trainers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <li class="list-group-item"><?php echo e($trainer->user->name); ?></li>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </ul>
                                                            <?php else: ?>
                                                                <span class="text-muted">No trainer assigned</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Students -->
                            <div class="col-md-12 mb-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h6 class="text-primary mb-2"><i class="bi bi-people"></i> Students</h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>#</th>
                                                        <th>Foto</th>
                                                        <th>Nama</th>
                                                        <th>Kehadiran</th>
                                                        <th>Nilai Rata-Rata</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__empty_1 = true; $__currentLoopData = $course->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <?php
                                                            $attendanceCount = $student->sessions->where('course_id', $course->id)->count();
                                                            $maxSessions = $course->max_sessions ?? 0;
                                                            // Hitung rata-rata nilai dari seluruh materi kursus untuk siswa ini
                                                            $materialIds = $course->materials->pluck('id');
                                                            $totalScore = \DB::table('student_grades')
                                                                ->where('student_id', $student->id)
                                                                ->whereIn('material_id', $materialIds)
                                                                ->avg('score');
                                                            $averageScore = $totalScore ? number_format($totalScore, 1) : '-';
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                                            <td class="text-center">
                                                                <img src="<?php echo e($student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png')); ?>" alt="Avatar" class="rounded-circle" width="50" height="50">
                                                            </td>
                                                            <td>
                                                                <a href="<?php echo e(route('students.show', $student->id)); ?>" class="text-primary fw-bold">
                                                                    <?php echo e($student->user->name); ?>

                                                                </a>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php echo e($attendanceCount); ?> / <?php echo e($maxSessions); ?>

                                                            </td>
                                                            <td class="text-center">
                                                                <?php echo e($averageScore); ?>

                                                            </td>
                                                            <td class="text-center">
                                                                <button class="btn btn-light-primary btn-sm" data-bs-toggle="modal" data-bs-target="#gradeModal<?php echo e($student->id); ?>">
                                                                    <i class="fas fa-edit"></i> Penilaian
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <tr>
                                                            <td colspan="6" class="text-center text-muted">No students enrolled in this course.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sessions Tab -->
                        <div class="tab-pane fade" id="sessions" role="tabpanel" aria-labelledby="sessions-tab">
                            <div class="col-md-12 mb-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h6 class="text-primary mb-3"><i class="bi bi-calendar-check"></i> Sessions</h6>
                                        <div class="d-flex justify-content-between mb-3">
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addScheduleModal"
                                                <?php echo e($course->sessions->count() >= $course->max_sessions ? 'disabled' : ''); ?>>
                                                + Tambah Jadwal
                                            </button>
                                            <?php if($course->sessions->count() >= $course->max_sessions): ?>
                                                <small class="text-danger">Max sessions reached (<?php echo e($course->max_sessions); ?>)</small>
                                            <?php endif; ?>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="sessionsTable" class="table align-middle table-row-dashed fs-6 gy-4">
                                                <thead>
                                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                        <th class="min-w-50px">#</th>
                                                        <th class="min-w-150px">Date</th>
                                                        <th class="min-w-100px">Start Time</th>
                                                        <th class="min-w-100px">End Time</th>
                                                        <th class="min-w-100px">Status</th>
                                                        <th class="min-w-150px text-end">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-semibold text-gray-700">
                                                    <?php $__currentLoopData = $course->sessions->whereIn('status', ['scheduled', 'completed','rescheduled','canceled']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr id="sessionRow<?php echo e($session->id); ?>">
                                                            <td></td>
                                                            <td>
                                                                <span class="badge badge-light-primary fs-7">
                                                                    <?php echo e(\Carbon\Carbon::parse($session->session_date)->translatedFormat('l, d F Y')); ?>

                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-light-info fs-7">
                                                                    <?php echo e(\Carbon\Carbon::parse($session->start_time)->format('H:i')); ?>

                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-light-info fs-7">
                                                                    <?php echo e(\Carbon\Carbon::parse($session->end_time)->format('H:i')); ?>

                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span id="sessionsStatus<?php echo e($session->id); ?>" class="badge badge-<?php echo e($session->status === 'scheduled' ? 'info' : ($session->status === 'rescheduled' ? 'warning' : 'success')); ?> fs-7">
                                                                    <?php echo e(ucfirst($session->status)); ?>

                                                                </span>
                                                            </td>
                                                            <td class="text-end">
                                                                <div class="d-flex justify-content-end gap-2">
                                                                    <button class="btn btn-icon btn-sm btn-light-primary btnAttendance" data-session-id="<?php echo e($session->id); ?>" title="Absen">
                                                                        <i class="fas fa-clipboard-check"></i>
                                                                    </button>
                                                                    <?php if($session->status === 'scheduled'): ?>
                                                                        <button class="btn btn-icon btn-sm btn-light-warning btnEditSession" data-session-id="<?php echo e($session->id); ?>" title="Edit">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>
                                                                    <?php endif; ?>
                                                                    <button class="btn btn-icon btn-sm btn-light-danger btnDeleteSession" data-session-id="<?php echo e($session->id); ?>" title="Delete">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals Section -->

    
    <?php $__currentLoopData = $course->sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('courses.partials.attendance-modal', ['session' => $session, 'course' => $course], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php if($session->status === 'scheduled'): ?>
            <?php echo $__env->make('courses.partials.edit-schedule-modal', ['session' => $session, 'course' => $course], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        <?php echo $__env->make('courses.partials.edit-schedule-modal', ['session' => $session, 'course' => $course], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = $course->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('courses.partials.score-student-modal', ['student' => $student, 'course' => $course], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make('courses.partials.add-schedule-modal', ['course' => $course], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $attributes = $__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $component = $__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views/courses/show.blade.php ENDPATH**/ ?>