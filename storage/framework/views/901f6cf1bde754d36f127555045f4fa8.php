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
                                                                <button class="btn btn-light-primary btn-sm" data-bs-toggle="modal" data-bs-target="#studentDetailModal<?php echo e($student->id); ?>">
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
                                                                    <button class="btn btn-icon btn-sm btn-light-primary btnAttendance" data-session-id="<?php echo e($session->id); ?>" title="Absen">
                                                                        <i class="fas fa-clipboard-check"></i>
                                                                    </button>
                                                                    <button class="btn btn-icon btn-sm btn-light-warning btnEditSession" data-session-id="<?php echo e($session->id); ?>" data-bs-toggle="modal" data-bs-target="#editScheduleModal<?php echo e($session->id); ?>" title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
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
                                        <!-- Alert Container -->
                                        <div id="alertContainer" class="alert d-none alert-dismissible fade show mt-4" role="alert">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Container untuk modal dinamis -->
    <div id="dynamicModals"></div>

    <?php $__currentLoopData = $course->sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('courses.partials.attendance-modal', ['session' => $session], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('courses.partials.edit-modal', ['session' => $session, 'course' => $course], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <script>
    $(document).ready(function () {
        // DataTable init
        const sessionsTable = $('#sessionsTable').DataTable();

        // Tambah Jadwal Sesi AJAX
        $('#addScheduleForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo e(route('sessions.store', ['course' => $course->id])); ?>",
                method: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    showAlert('success', 'Jadwal sesi berhasil ditambahkan.');
                    $('#addScheduleModal').modal('hide');
                    $('#addScheduleForm')[0].reset();

                    // Format tanggal
                    const date = new Date(response.data.session_date);
                    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    const months = [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ];
                    const formattedDate = `${days[date.getDay()]}, ${date.getDate().toString().padStart(2, '0')} ${months[date.getMonth()]} ${date.getFullYear()}`;

                    // Tambahkan baris baru ke DataTable
                    const newRow = sessionsTable.row.add([
                        sessionsTable.rows().count() + 1,
                        `<span class="badge badge-light-primary fs-7">${formattedDate}</span>`,
                        `<span class="badge badge-light-info fs-7">${response.data.start_time}</span>`,
                        `<span class="badge badge-light-info fs-7">${response.data.end_time}</span>`,
                        `<span class="badge badge-info fs-7">Scheduled</span>`,
                        `<div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-icon btn-sm btn-light-primary btnAttendance" data-session-id="${response.data.id}" title="Absen">
                                <i class="fas fa-clipboard-check"></i>
                            </button>
                            <button class="btn btn-icon btn-sm btn-light-warning btnEditSession" data-session-id="${response.data.id}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-icon btn-sm btn-light-danger btnDeleteSession" data-session-id="${response.data.id}" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>`
                    ]).draw(false).node();

                    // Tambahkan id pada tr
                    $(newRow).attr('id', 'sessionRow' + response.data.id);

                    // Generate modal absen & edit dinamis
                    generateAttendanceModal(response.data);
                    console.log('Modal attendanceModal' + response.data.id + ' dibuat:', $('#attendanceModal' + response.data.id).length);
                    generateEditModal(response.data);

                    
                },
                error: function () {
                    showAlert('danger', 'Terjadi kesalahan saat menambahkan jadwal. Silakan coba lagi.');
                }
            });
        });

        // Fungsi generate modal absen dinamis
        function generateAttendanceModal(session) {
            let modalHtml = `
            <div class="modal fade" id="attendanceModal${session.id}" tabindex="-1" aria-labelledby="attendanceModalLabel${session.id}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-light-primary">
                            <h5 class="modal-title" id="attendanceModalLabel${session.id}">
                                <i class="bi bi-clipboard-check text-primary me-2"></i>
                                Attendance for Session:
                                <span class="fw-bold text-primary">${session.formatted_date || session.session_date}</span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="attendanceForm${session.id}">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="course_id" value="<?php echo e($course->id); ?>">
                                <input type="hidden" name="course_session_id" value="${session.id}">
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed gy-3">
                                        <thead class="bg-light">
                                            <tr class="text-center text-gray-600 fw-bold">
                                                <th class="min-w-50px">#</th>
                                                <th class="min-w-200px">Nama Murid</th>
                                                <th class="min-w-300px">Status Kehadiran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $course->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="symbol symbol-40px me-3">
                                                            <img src="<?php echo e($student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png')); ?>" alt="Avatar" class="rounded-circle" width="40" height="40">
                                                        </div>
                                                        <span class="fw-semibold text-gray-800"><?php echo e($student->user->name); ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group w-100" role="group" aria-label="Status Kehadiran">
                                                        <input type="radio" class="btn-check" name="attendance[<?php echo e($student->id); ?>][status]" id="hadir-${session.id}-<?php echo e($student->id); ?>" value="hadir" autocomplete="off">
                                                        <label class="btn btn-sm btn-light-success fw-bold px-4" for="hadir-${session.id}-<?php echo e($student->id); ?>">
                                                            <i class="bi bi-check-circle me-1"></i> Hadir
                                                        </label>
                                                        <input type="radio" class="btn-check" name="attendance[<?php echo e($student->id); ?>][status]" id="tidak-hadir-${session.id}-<?php echo e($student->id); ?>" value="tidak hadir" autocomplete="off">
                                                        <label class="btn btn-sm btn-light-danger fw-bold px-4" for="tidak-hadir-${session.id}-<?php echo e($student->id); ?>">
                                                            <i class="bi bi-x-circle me-1"></i> Tidak Hadir
                                                        </label>
                                                        <input type="radio" class="btn-check" name="attendance[<?php echo e($student->id); ?>][status]" id="terlambat-${session.id}-<?php echo e($student->id); ?>" value="terlambat" autocomplete="off">
                                                        <label class="btn btn-sm btn-light-warning fw-bold px-4" for="terlambat-${session.id}-<?php echo e($student->id); ?>">
                                                            <i class="bi bi-clock-history me-1"></i> Terlambat
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mt-4">
                                    <i class="bi bi-save me-2"></i> Simpan Kehadiran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>`;
            $('#dynamicModals').append(modalHtml);
        }

        // Fungsi generate modal edit dinamis
        function generateEditModal(session) {
            let modalHtml = `
            <div class="modal fade" id="editScheduleModal${session.id}" tabindex="-1" aria-labelledby="editScheduleModalLabel${session.id}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editScheduleModalLabel${session.id}">Edit Jadwal Sesi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editScheduleForm${session.id}">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="_method" value="PUT">
                                <div class="mb-3">
                                    <label for="session_date_${session.id}" class="form-label">Tanggal Sesi</label>
                                    <input type="date" class="form-control" id="session_date_${session.id}" name="session_date"
                                        value="${session.session_date}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="start_time_${session.id}" class="form-label">Waktu Mulai</label>
                                    <input type="time" class="form-control" id="start_time_${session.id}" name="start_time"
                                        value="${session.start_time}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="end_time_${session.id}" class="form-label">Waktu Selesai</label>
                                    <input type="time" class="form-control" id="end_time_${session.id}" name="end_time"
                                        value="${session.end_time}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status_${session.id}" class="form-label">Status</label>
                                    <select class="form-select" id="status_${session.id}" name="status" required>
                                        <option value="scheduled" selected>Scheduled</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>`;
            $('#dynamicModals').append(modalHtml);
        }

        // Event delegation untuk tombol absen
        $('#sessionsTable').on('click', '.btnAttendance', function () {
            const sessionId = $(this).data('session-id');
            const modalId = `attendanceModal${sessionId}`;
            if ($('#' + modalId).length) {
                setTimeout(function() {
                    let bsModal = bootstrap.Modal.getOrCreateInstance(document.getElementById(modalId));
                    bsModal.show();
                }, 100);
            } else {
                showAlert('danger', 'Modal belum siap. Silakan coba lagi.');
            }
        });

        // Event delegation untuk tombol edit
        $('#sessionsTable').on('click', '.btnEditSession', function () {
            const sessionId = $(this).data('session-id');
            $(`#editScheduleModal${sessionId}`).modal('show');
        });

        // Event delegation untuk tombol hapus
        $('#sessionsTable').on('click', '.btnDeleteSession', function () {
            const sessionId = $(this).data('session-id');
            if (confirm('Yakin ingin menghapus sesi ini?')) {
                $.ajax({
                    url: `/courses/<?php echo e($course->id); ?>/sessions/${sessionId}`,
                    type: 'DELETE',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function () {
                        $(`#sessionRow${sessionId}`).remove();
                        $(`#attendanceModal${sessionId}`).remove();
                        $(`#editScheduleModal${sessionId}`).remove();
                        showAlert('success', 'Sesi berhasil dihapus.');
                    },
                    error: function () {
                        showAlert('danger', 'Gagal menghapus sesi.');
                    }
                });
            }
        });

        // Event delegation untuk submit edit form
        $('#dynamicModals').on('submit', '[id^=editScheduleForm]', function (e) {
            e.preventDefault();
            const sessionId = $(this).attr('id').replace('editScheduleForm', '');
            $.ajax({
                url: `/courses/<?php echo e($course->id); ?>/sessions/${sessionId}`,
                type: 'POST',
                data: $(this).serialize(),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (response) {
                    showAlert('success', 'Jadwal sesi berhasil diperbarui.');
                    $(`#editScheduleModal${sessionId}`).modal('hide');
                    // Update row di tabel
                    const date = new Date(response.data.session_date);
                    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    const months = [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ];
                    const formattedDate = `${days[date.getDay()]}, ${date.getDate().toString().padStart(2, '0')} ${months[date.getMonth()]} ${date.getFullYear()}`;
                    const row = $(`#sessionRow${sessionId}`);
                    row.find('td:nth-child(2) span').text(formattedDate);
                    row.find('td:nth-child(3) span').text(response.data.start_time);
                    row.find('td:nth-child(4) span').text(response.data.end_time);
                    row.find('td:nth-child(5) span').text(response.data.status);
                },
                error: function () {
                    showAlert('danger', 'Terjadi kesalahan saat memperbarui jadwal.');
                }
            });
        });

        // Event delegation untuk submit absen form
        $('#dynamicModals').on('submit', '[id^=attendanceForm]', function (e) {
            e.preventDefault();
            const sessionId = $(this).attr('id').replace('attendanceForm', '');
            $.ajax({
                url: `/courses/<?php echo e($course->id); ?>/sessions/${sessionId}/attendance`,
                type: 'POST',
                data: $(this).serialize(),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (response) {
                    showAlert('success', 'Kehadiran berhasil disimpan.');
                    $(`#attendanceModal${sessionId}`).modal('hide');
                },
                error: function () {
                    showAlert('danger', 'Terjadi kesalahan saat menyimpan kehadiran.');
                }
            });
        });

        // Alert helper
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
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views\courses\show.blade.php ENDPATH**/ ?>