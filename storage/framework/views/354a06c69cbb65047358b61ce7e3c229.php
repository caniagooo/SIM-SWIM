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
    <?php
        // Statistik
        $stats = [
            'last_month' => $sessions->where('session_date', '<', now()->startOfMonth())->count(),
            'this_month' => $sessions->where('session_date', '>=', now()->startOfMonth())->where('session_date', '<=', now()->endOfMonth())->count(),
            'next_month' => $sessions->where('session_date', '>', now()->endOfMonth())->count(),
        ];
        // Sesi completed untuk datatables
        $completedSessions = $sessions->where('status', 'completed')->sortByDesc('session_date')->values();
        $perPage = 10;
        $page = request('page', 1);
        $filterCourse = request('filter_course');
        $filterTrainer = request('filter_trainer');
        $filteredSessions = $completedSessions;
        if ($filterCourse) {
            $filteredSessions = $filteredSessions->filter(function($s) use ($filterCourse) {
                return $s->course->id == $filterCourse;
            });
        }
        if ($filterTrainer) {
            $filteredSessions = $filteredSessions->filter(function($s) use ($filterTrainer) {
                $trainer = $s->course->trainers->first();
                return $trainer && $trainer->id == $filterTrainer;
            });
        }
        $total = $filteredSessions->count();
        $logSessions = $filteredSessions->slice(($page-1)*$perPage, $perPage);
        $paginator = new Illuminate\Pagination\LengthAwarePaginator(
            $logSessions,
            $total,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        // Untuk filter dropdown
        $allCourses = $sessions->pluck('course')->unique('id')->values();
        $allTrainers = $sessions->map(function($s){ return $s->course->trainers->first(); })->filter()->unique('id')->values();
    ?>

    <div class="container py-3">
        <!-- Header Card ala Students Show -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center p-4">
                <div>
                    <h4 class="mb-1 fw-bold text-gray-900">
                        Jadwal Umum Sesi
                    </h4>
                    <div class="d-flex flex-wrap gap-2 small mb-1">
                        <span class="badge badge-light-info fw-semibold">
                            <i class="bi bi-calendar3-event me-1"></i> Total: <?php echo e($sessions->count()); ?> Sesi
                        </span>
                        <span class="badge badge-light-success fw-semibold">
                            <i class="bi bi-calendar2-week me-1"></i> Bulan Ini: <?php echo e($stats['this_month'] ?? 0); ?>

                        </span>
                        <span class="badge badge-light-primary fw-semibold">
                            <i class="bi bi-calendar2-plus me-1"></i> Bulan Depan: <?php echo e($stats['next_month'] ?? 0); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-primary text-white rounded-top-4 py-3 px-4">
                        <h5 class="card-title mb-0 fw-bold"><i class="bi bi-calendar3-event me-2"></i>Kalender Sesi</h5>
                    </div>
                    <div class="card-body p-4">
                        <div id="kt_fullcalendar" style="min-height: 500px;"></div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow-sm h-100 bg-light-primary">
                            <div class="card-body text-center py-4">
                                <i class="bi bi-calendar2-check fs-2 text-primary mb-2"></i>
                                <div class="fs-3 fw-bold text-primary"><?php echo e($stats['last_month'] ?? 0); ?></div>
                                <div class="fs-8 text-gray-700">Sesi Bulan Lalu</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow-sm h-100 bg-light-success">
                            <div class="card-body text-center py-4">
                                <i class="bi bi-calendar2-week fs-2 text-success mb-2"></i>
                                <div class="fs-3 fw-bold text-success"><?php echo e($stats['this_month'] ?? 0); ?></div>
                                <div class="fs-8 text-gray-700">Sesi Bulan Ini</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow-sm h-100 bg-light-info">
                            <div class="card-body text-center py-4">
                                <i class="bi bi-calendar2-plus fs-2 text-info mb-2"></i>
                                <div class="fs-3 fw-bold text-info"><?php echo e($stats['next_month'] ?? 0); ?></div>
                                <div class="fs-8 text-gray-700">Sesi Bulan Depan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Log Sesi Selesai -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-info text-white rounded-top-4 py-3 px-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                        <h5 class="card-title mb-0 fw-bold"><i class="bi bi-check2-circle me-2"></i>Log Sesi Selesai</h5>
                        <!-- Filter -->
                        <form method="GET" class="d-flex gap-2 align-items-center">
                            <select name="filter_course" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Semua Kursus</option>
                                <?php $__currentLoopData = $allCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($course->id); ?>" <?php if($filterCourse == $course->id): ?> selected <?php endif; ?>><?php echo e($course->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select name="filter_trainer" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Semua Pelatih</option>
                                <?php $__currentLoopData = $allTrainers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($trainer->id); ?>" <?php if($filterTrainer == $trainer->id): ?> selected <?php endif; ?>><?php echo e($trainer->user->name ?? '-'); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($filterCourse || $filterTrainer): ?>
                                <a href="<?php echo e(route('general-schedule.index')); ?>" class="btn btn-sm btn-light-danger">Reset</a>
                            <?php endif; ?>
                        </form>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-200 align-middle gy-2 mb-0">
                                <thead>
                                    <tr class="text-center fw-semibold text-gray-600 fs-7">
                                        <th class="text-start">Kursus</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Venue</th>
                                        <th>Pelatih</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $paginator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php
                                            $trainer = $session->course->trainers->first();
                                            $avatar = $trainer && $trainer->user && $trainer->user->avatar
                                                ? asset('storage/'.$trainer->user->avatar)
                                                : asset('assets/media/avatars/blank.png');
                                            $trainerName = $trainer && $trainer->user ? $trainer->user->name : '-';
                                        ?>
                                        <tr>
                                            <td class="fs-8 text-muted text-start"><?php echo e($session->course->name); ?></td>
                                            <td class="fs-8 text-center"><?php echo e(\Carbon\Carbon::parse($session->session_date)->translatedFormat('d M Y')); ?></td>
                                            <td class="fs-8 text-center"><?php echo e(\Carbon\Carbon::parse($session->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($session->end_time)->format('H:i')); ?></td>
                                            <td class="fs-8 text-center"><?php echo e($session->course->venue->name ?? '-'); ?></td>
                                            <td class="fs-8 d-flex align-items-center gap-2 justify-content-center">
                                                <img src="<?php echo e($avatar); ?>" alt="Trainer" class="rounded-circle border" width="28" height="28">
                                                <span><?php echo e($trainerName); ?></span>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?php echo e(route('courses.show', $session->course->id)); ?>" class="btn btn-icon btn-sm btn-light-info" title="Detail Kursus">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada sesi selesai.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white py-3 border-0 rounded-bottom-4">
                        <div class="d-flex justify-content-center">
                            <?php echo e($paginator->links('vendor.pagination.bootstrap-5')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FullCalendar Metronic Assets -->
    <link href="<?php echo e(asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')); ?>" rel="stylesheet" type="text/css"/>
    <script src="<?php echo e(asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')); ?>"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('kt_fullcalendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'bootstrap5',
                initialView: 'dayGridMonth',
                now: '<?php echo e(now()->toDateString()); ?>',
                height: 500,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listWeek'
                },
                views: {
                    dayGridMonth: { buttonText: 'Bulan' },
                    listWeek: { buttonText: 'List Minggu' }
                },
                events: <?php echo $sessions->map(function ($session) {
                    $trainer = $session->course->trainers->first();
                    $avatar = $trainer && $trainer->user && $trainer->user->avatar
                        ? asset('storage/'.$trainer->user->avatar)
                        : asset('assets/media/avatars/blank.png');
                    $trainerName = $trainer && $trainer->user ? $trainer->user->name : '-';
                    return [
                        'title' => $session->course->name . ' (' . ($trainerName) . ')',
                        'start' => $session->session_date . 'T' . ($session->start_time ?? '00:00:00'),
                        'end'   => $session->session_date . 'T' . ($session->end_time ?? '23:59:59'),
                        'color' => $session->status == 'completed' ? '#50cd89' : ($session->status == 'canceled' ? '#f1416c' : '#009ef7'),
                        'extendedProps' => [
                            'status' => $session->status,
                            'course' => $session->course->name,
                            'students' => $session->course->students->count(),
                            'venue' => $session->course->venue->name ?? '-',
                            'trainer' => $trainerName,
                            'avatar' => $avatar,
                            'start_time' => $session->start_time,
                            'end_time' => $session->end_time,
                            'detail_url' => route('courses.show', $session->course->id)
                        ]
                    ];
                })->values()->toJson(); ?>,
                eventClick: function(info) {
                    var event = info.event;
                    var props = event.extendedProps;
                    var html = `
                        <div class="mb-2"><strong>Kursus:</strong> ${props.course}</div>
                        <div class="mb-2"><strong>Tanggal:</strong> ${event.start.toLocaleDateString('en-GB')}</div>
                        <div class="mb-2"><strong>Waktu:</strong> ${event.start.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})} - ${event.end ? event.end.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : '-'}</div>
                        <div class="mb-2"><strong>Status:</strong> <span class="badge bg-${props.status == 'completed' ? 'success' : (props.status == 'canceled' ? 'danger' : 'info')} text-white">${props.status}</span></div>
                        <div class="mb-2"><strong>Venue:</strong> ${props.venue}</div>
                        <div class="mb-2 d-flex align-items-center"><strong>Pelatih:</strong>
                            <img src="${props.avatar}" alt="Trainer" class="rounded-circle border ms-2 me-2" width="32" height="32">
                            <span>${props.trainer}</span>
                        </div>
                        <div class="mb-2"><strong>Jumlah Peserta:</strong> ${props.students}</div>
                        <div class="mt-3">
                            <a href="${props.detail_url}" class="btn btn-sm btn-light-primary rounded-pill px-3 shadow-sm" target="_blank">
                                <i class="bi bi-eye"></i> Detail Kursus
                            </a>
                        </div>
                    `;
                    Swal.fire({
                        title: 'Detail Sesi',
                        html: html,
                        icon: 'info',
                        confirmButtonText: 'Tutup',
                        customClass: { confirmButton: "btn btn-primary" }
                    });
                }
            });
            calendar.render();
        });
    </script>
    <style>
        .card {
            border-radius: 1.25rem !important;
        }
        .card-header {
            border-radius: 1.25rem 1.25rem 0 0 !important;
        }
        .card-footer {
            border-radius: 0 0 1.25rem 1.25rem !important;
        }
        .symbol {
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .btn-light-primary {
            background: linear-gradient(90deg, #e3f0ff 0%, #f6fafd 100%);
            color: #009ef7;
            border: none;
        }
        .btn-light-primary:hover {
            background: #009ef7;
            color: #fff;
        }
        .fs-8 { font-size: 0.88rem !important; }
        .fs-7 { font-size: 0.95rem !important; }
        .btn-icon { padding: 0.3rem 0.5rem !important; }
        .table th, .table td { vertical-align: middle !important; }
        /* Style dari students/show.blade.php */
        .symbol-60px { width: 60px; height: 60px; }
        .symbol-80px { width: 80px; height: 80px; }
        .text-gray-500 { color: #a1a5b7 !important; }
        .fw-bold { font-weight: 600 !important; }
        .fw-semibold { font-weight: 500 !important; }
        .badge-light-info { background: #e1f0ff; color: #009ef7; }
        .badge-light-success { background: #e8fff3; color: #50cd89; }
        .badge-light-primary { background: #e3f0ff; color: #009ef7; }
        .badge-light { background: #f5f8fa; color: #5e6278; }
        .rounded-4 { border-radius: 1.25rem !important; }
        @media (max-width: 576px) {
            .card-body, .card-header { padding: 1rem !important; }
            .table { font-size: 0.92rem; }
        }
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
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views\general-schedule\index.blade.php ENDPATH**/ ?>