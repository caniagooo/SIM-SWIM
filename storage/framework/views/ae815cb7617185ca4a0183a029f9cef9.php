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
                                                        <td class="fw-bold text-gray-700">Sessions</td>
                                                        <td>
                                                            <span class="text-success"> <?php echo e($completed); ?> </span> / 
                                                            <span class="text-info"> <?php echo e($course->max_sessions ?? 'N/A'); ?> </span> Max Session
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
                                        <div class="row">
                                            <?php $__empty_1 = true; $__currentLoopData = $course->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <div class="col-md-4 mb-4">
                                                    <div class="card shadow-sm h-100">
                                                        <div class="card-body text-center">
                                                            <div class="symbol symbol-100px mb-3">
                                                                <img src="<?php echo e($student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png')); ?>" alt="Avatar" class="rounded-circle">
                                                            </div>
                                                            <h5 class="text-gray-800 fw-bold"><?php echo e($student->user->name); ?></h5>
                                                            <p class="text-gray-600"><?php echo e(\Carbon\Carbon::parse($student->birth_date)->age); ?> tahun</p>
                                                            <button class="btn btn-light-primary btn-sm" data-bs-toggle="modal" data-bs-target="#studentDetailModal<?php echo e($student->id); ?>">
                                                                <i class="fas fa-eye"></i> View Details
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Modal Detail Murid -->
                                                <div class="modal fade" id="studentDetailModal<?php echo e($student->id); ?>" tabindex="-1" aria-labelledby="studentDetailModalLabel<?php echo e($student->id); ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="studentDetailModalLabel<?php echo e($student->id); ?>">Detail Murid: <?php echo e($student->user->name); ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Email:</strong> <?php echo e($student->user->email); ?></p>
                                                                <p><strong>Phone Number:</strong> <?php echo e($student->user->phone_number ?? '-'); ?></p>
                                                                <p><strong>Address:</strong> <?php echo e($student->user->address ?? '-'); ?></p>
                                                                <p><strong>Usia:</strong> <?php echo e(\Carbon\Carbon::parse($student->birth_date)->age); ?> tahun</p>
                                                                <p><strong>Attendance:</strong> <?php echo e($student->sessions->count()); ?></p>
                                                                <a href="<?php echo e(route('students.show', $student->id)); ?>" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-link"></i> Go to Student Details
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <div class="col-12">
                                                    <p class="text-muted">No students enrolled in this course.</p>
                                                </div>
                                                    <?php endif; ?>
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

                                        <!-- Button Tambah Jadwal -->
                                        <div class="d-flex justify-content-between mb-3">
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addScheduleModal"
                                                <?php echo e($course->sessions->count() >= $course->max_sessions ? 'disabled' : ''); ?>>
                                                + Tambah Jadwal
                                            </button>
                                            <?php if($course->sessions->count() >= $course->max_sessions): ?>
                                                <small class="text-danger">Max sessions reached (<?php echo e($course->max_sessions); ?>)</small>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Tabel Jadwal Sesi -->
                                        <?php if($course->sessions && $course->sessions->count() > 0): ?>
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
                                                        <?php $__currentLoopData = $course->sessions->whereIn('status', ['scheduled', 'completed']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr id="sessionRow<?php echo e($session->id); ?>">
                                                                <td><?php echo e($loop->iteration); ?></td>
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
                                                                    <span id="sessionsStatus<?php echo e($session->id); ?>" class="badge badge-<?php echo e($session->status == 'completed' ? 'success' : 'info'); ?> fs-7">
                                                                        <?php echo e(ucfirst($session->status)); ?>

                                                                    </span>
                                                                </td>
                                                                <td class="text-end">
                                                                    <div class="d-flex justify-content-end gap-2">
                                                                        <!-- Button Absen -->
                                                                        <button class="btn btn-icon btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#attendanceModal<?php echo e($session->id); ?>" title="Absen">
                                                                            <i class="fas fa-clipboard-check"></i>
                                                                        </button>
                                                                        <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal<?php echo e($session->id); ?>" title="Edit">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        <form action="<?php echo e(route('sessions.destroy', [$course->id, $session->id])); ?>" method="POST" style="display:inline;">
                                                                            <?php echo csrf_field(); ?>
                                                                            <?php echo method_field('DELETE'); ?>
                                                                            <button type="submit" class="btn btn-icon btn-sm btn-light-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                                                <i class="fas fa-trash-alt"></i>
                                                                            </form>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                            
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-info d-flex align-items-center p-4">
                                                <i class="bi bi-info-circle fs-2x me-3"></i>
                                                <div>
                                                    <span class="fw-semibold">No sessions scheduled.</span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Alert Container -->
                    <div id="alertContainer" class="alert d-none alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i id="alertIcon" class="bi me-2"></i>
                            <span id="alertMessage"></span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <!-- end Alert Container -->
            </div>
        </div>
    </div>

    <!-- Attendance Modal -->
    
<?php $__currentLoopData = $course->sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="attendanceModal<?php echo e($session->id); ?>" tabindex="-1" aria-labelledby="attendanceModalLabel<?php echo e($session->id); ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel<?php echo e($session->id); ?>">Attendance for Session: <?php echo e($session->session_date->format('d M Y')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="attendanceForm<?php echo e($session->id); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <table class="table table-bordered table-hover">
                            <caption>Attendance for Session: <?php echo e(\Carbon\Carbon::parse($session->session_date)->translatedFormat('l, d F Y')); ?></caption>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Murid</th>
                                    <th>Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $course->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $attendance = $session->attendances ? $session->attendances->where('student_id', $student->id)->first() : null;
                                    ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo e($student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png')); ?>" alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                                                <span><?php echo e($student->user->name); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Attendance Status">
                                                <input type="radio" class="btn-check" name="attendance[<?php echo e($student->id); ?>][status]" id="hadir-<?php echo e($student->id); ?>" value="hadir"
                                                    <?php echo e($attendance && $attendance->status == 'hadir' ? 'checked' : ''); ?>>
                                                <label class="btn btn-sm btn-light-success" for="hadir-<?php echo e($student->id); ?>">
                                                    <i class="bi bi-check-circle"></i> Hadir
                                                </label>

                                                <input type="radio" class="btn-check" name="attendance[<?php echo e($student->id); ?>][status]" id="tidak-hadir-<?php echo e($student->id); ?>" value="tidak hadir"
                                                    <?php echo e($attendance && $attendance->status == 'tidak hadir' ? 'checked' : ''); ?>>
                                                <label class="btn btn-sm btn-light-danger" for="tidak-hadir-<?php echo e($student->id); ?>">
                                                    <i class="bi bi-x-circle"></i> Tidak Hadir
                                                </label>

                                                <input type="radio" class="btn-check" name="attendance[<?php echo e($student->id); ?>][status]" id="terlambat-<?php echo e($student->id); ?>" value="terlambat"
                                                    <?php echo e($attendance && $attendance->status == 'terlambat' ? 'checked' : ''); ?>>
                                                <label class="btn btn-sm btn-light-warning" for="terlambat-<?php echo e($student->id); ?>">
                                                    <i class="bi bi-clock"></i> Terlambat
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-success">Save Attendance</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <!-- Modal Tambah Jadwal -->
    <div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addScheduleModalLabel">Tambah Jadwal Sesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addScheduleForm">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="session_date" class="form-label">Tanggal Sesi</label>
                            <input type="date" class="form-control" id="session_date" name="session_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Waktu Mulai</label>
                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_time" class="form-label">Waktu Selesai</label>
                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-- Edit Schedule Modal -->
<?php $__currentLoopData = $course->sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="editScheduleModal<?php echo e($session->id); ?>" tabindex="-1" aria-labelledby="editScheduleModalLabel<?php echo e($session->id); ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editScheduleModalLabel<?php echo e($session->id); ?>">Edit Jadwal Sesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editScheduleForm<?php echo e($session->id); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="mb-3">
                            <label for="session_date_<?php echo e($session->id); ?>" class="form-label">Tanggal Sesi</label>
                            <input type="date" class="form-control" id="session_date_<?php echo e($session->id); ?>" name="session_date"
                                value="<?php echo e($session->session_date ? $session->session_date->format('Y-m-d') : ''); ?>"
                                placeholder="<?php echo e($session->session_date ? $session->session_date->format('d M Y') : '-'); ?>" required>
                            <small class="text-muted">Tanggal sebelumnya: <?php echo e($session->session_date ? \Carbon\Carbon::parse($session->session_date)->translatedFormat('l, d F Y') : '-'); ?></small>
                        </div>
                        <div class="mb-3">
                            <label for="start_time_<?php echo e($session->id); ?>" class="form-label">Waktu Mulai</label>
                            <input type="time" class="form-control" id="start_time_<?php echo e($session->id); ?>" name="start_time"
                                value="<?php echo e($session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : ''); ?>"
                                placeholder="<?php echo e($session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '-'); ?>" required>
                            <small class="text-muted">Waktu sebelumnya: <?php echo e($session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '-'); ?></small>
                        </div>
                        <div class="mb-3">
                            <label for="end_time_<?php echo e($session->id); ?>" class="form-label">Waktu Selesai</label>
                            <input type="time" class="form-control" id="end_time_<?php echo e($session->id); ?>" name="end_time"
                                value="<?php echo e($session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : ''); ?>"
                                placeholder="<?php echo e($session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '-'); ?>" required>
                            <small class="text-muted">Waktu sebelumnya: <?php echo e($session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '-'); ?></small>
                        </div>
                        <div class="mb-3">
                            <label for="status_<?php echo e($session->id); ?>" class="form-label">Status</label>
                            <select class="form-select" id="status_<?php echo e($session->id); ?>" name="status" required>
                                <option value="scheduled" <?php echo e($session->status == 'scheduled' ? 'selected' : ''); ?>>Scheduled</option>
                                <option value="cancelled" <?php echo e($session->status == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                            </select>
                            <small class="text-muted">Status sebelumnya: <?php echo e(ucfirst($session->status)); ?></small>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<!-- Javascript -->

<script src="<?php echo e(asset('assets/plugins/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<!-- DataTables Initialization -->
<script>
    $(document).ready(function () {
        $('#sessionsTable').DataTable();
        $('#materialsTable').DataTable();
        $('#studentsTable').DataTable();
    });
</script>

<!-- Attendance Modal Logging -->
<script>
    $(document).ready(function () {
        setTimeout(function () {
            $('#attendanceModal<?php echo e($session->id); ?>').on('show.bs.modal', function () {
                console.log('Modal box for session <?php echo e($session->id); ?> is opening after delay.');
            });
        }, 500); // Delay 500ms sebelum modal box diinisialisasi
    });
</script>

<!-- Attendance Form Submission -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $(document).ready(function () {
            <?php $__currentLoopData = $course->sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                $('#attendanceForm<?php echo e($session->id); ?>').on('submit', function (e) {
                    e.preventDefault();

                    $.ajax({
                        url: "<?php echo e(route('sessions.attendance.save', ['course' => $course->id, 'session' => $session->id])); ?>",
                        method: "POST",
                        data: $(this).serialize(),
                        success: function (response) {
                            showAlert('success', response.message);
                            $('#attendanceModal<?php echo e($session->id); ?>').modal('hide');

                            const statusBadge = $('#sessionsStatus<?php echo e($session->id); ?>');
                            statusBadge.removeClass('badge-info').addClass('badge-success').text('Completed');
                        },
                        error: function () {
                            showAlert('danger', 'An error occurred while saving attendance. Please try again.');
                        }
                    });
                });
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        });
    });
</script>

<!-- Add Schedule Form Submission -->
<script>
    $(document).ready(function () {
        $('#addScheduleForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo e(route('sessions.store', ['course' => $course->id])); ?>",
                method: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    showAlert('success', 'Jadwal sesi berhasil ditambahkan.');
                    $('#addScheduleModal').modal('hide');

                    $('#sessionsTable tbody').append(`
                        <tr>
                            <td>${response.data.id}</td>
                            <td><span class="badge badge-light-primary fs-7">${response.data.session_date}</td>
                            <td><span class="badge badge-light-info fs-7">${response.data.start_time}</td>
                            <td><span class="badge badge-light-info fs-7">${response.data.end_time}</td>
                            <td><span class="badge badge-info fs-7">Scheduled</span></td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-icon btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#attendanceModal${response.data.id}" title="Absen">
                                        <i class="fas fa-clipboard-check"></i>
                                    </button>
                                    <a href="#" class="btn btn-icon btn-sm btn-light-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-icon btn-sm btn-light-danger" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `);
                },
                error: function () {
                    showAlert('danger', 'Terjadi kesalahan saat menambahkan jadwal. Silakan coba lagi.');
                }
            });
        });
    });
</script>

<!-- Edit Schedule Form -->
<script>
    $(document).ready(function () {
        <?php $__currentLoopData = $course->sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            $('#editScheduleForm<?php echo e($session->id); ?>').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                // Get the form data
                var formData = $(this).serialize();

                // Menampilkan data existing
                console.log('Editing session:', <?php echo e($session->id); ?>, formData);

                


                // Send AJAX request
                $.ajax({
                    url: "<?php echo e(route('sessions.update', ['course' => $course->id, 'session' => $session->id])); ?>",
                    method: "PUT",
                    data: formData,
                    success: function (response) {
                        console.log(response); // Log respons JSON ke konsol
                        showAlert('success', 'Jadwal sesi berhasil diperbarui.');

                        // Close the modal
                        $('#editScheduleModal<?php echo e($session->id); ?>').modal('hide');

                        // Update the row in the table dynamically
                        const row = $(`#sessionRow${response.data.id}`);
                        // Format tanggal ke "Senin, 18 Januari 2025"
                        const date = new Date(response.data.session_date);
                        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        const months = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                        const formattedDate = `${days[date.getDay()]}, ${date.getDate().toString().padStart(2, '0')} ${months[date.getMonth()]} ${date.getFullYear()}`;
                        row.find('td:nth-child(2) span').text(formattedDate);
                        row.find('td:nth-child(3) span').text(response.data.start_time);
                        row.find('td:nth-child(4) span').text(response.data.end_time);
                        row.find('td:nth-child(5) span').text(response.data.status);
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText); // Log error ke konsol
                        showAlert('danger', 'Terjadi kesalahan saat memperbarui jadwal. Silakan coba lagi.');
                    }
                });
            });
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    });
</script>

<!-- Alert Handling Function -->
<script>
    function showAlert(type, message) {
        const alertContainer = $('#alertContainer');
        const alertIcon = $('#alertIcon');
        const alertMessage = $('#alertMessage');

        alertContainer.removeClass('d-none alert-success alert-danger alert-info alert-warning');
        alertContainer.addClass(`alert-${type}`);
        alertMessage.text(message);

        alertIcon.removeClass('bi-check-circle bi-x-circle bi-info-circle bi-exclamation-triangle');
        if (type === 'success') {
            alertIcon.addClass('bi-check-circle text-success');
        } else if (type === 'danger') {
            alertIcon.addClass('bi-x-circle text-danger');
        } else if (type === 'info') {
            alertIcon.addClass('bi-info-circle text-info');
        } else if (type === 'warning') {
            alertIcon.addClass('bi-exclamation-triangle text-warning');
        }

        alertContainer.fadeIn();
        setTimeout(() => alertContainer.fadeOut(), 3000);
    }
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
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views/courses/show.blade.php ENDPATH**/ ?>