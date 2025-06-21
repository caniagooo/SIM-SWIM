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
        // 5 sesi terdekat (belum lewat)
        $upcomingSessions = $sessions->where('session_date', '>=', now()->toDateString())
            ->sortBy(function($s) { return $s->session_date . ' ' . $s->start_time; })
            ->take(5);
        // Sesi completed untuk datatables
        $completedSessions = $sessions->where('status', 'completed')->sortByDesc('session_date')->values();
        $perPage = 10;
        $page = request('page', 1);
        $total = $completedSessions->count();
        $logSessions = $completedSessions->slice(($page-1)*$perPage, $perPage);
        $paginator = new Illuminate\Pagination\LengthAwarePaginator(
            $logSessions,
            $total,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    ?>

    <div class="container-xxl mt-6">
        <div class="row g-5">
            <!-- Kiri: Kalender & Statistik -->
            <div class="col-12 col-lg-7">
                <div class="card border-0 shadow-lg rounded-4 mb-5">
                    <div class="card-header bg-gradient-info text-white rounded-top-4 py-4 px-4">
                        <h4 class="card-title mb-0 fw-bold"><i class="bi bi-calendar3-event me-2"></i>Kalender Sesi</h4>
                    </div>
                    <div class="card-body p-4">
                        <div id="kt_fullcalendar" style="min-height: 500px;"></div>
                    </div>
                </div>
                <div class="row g-4">
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
            <!-- Kanan: Jadwal Terdekat & Log Selesai -->
            <div class="col-12 col-lg-5">
                <!-- 5 Jadwal Sesi Terdekat -->
                <div class="card border-0 shadow-lg rounded-4 mb-5">
                    <div class="card-header bg-gradient-primary text-white rounded-top-4 py-4 px-4">
                        <h5 class="card-title mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>5 Jadwal Sesi Terdekat</h5>
                    </div>
                    <div class="card-body p-4">
                        <?php $__empty_1 = true; $__currentLoopData = $upcomingSessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $trainer = $session->course->trainers->first();
                                $avatar = $trainer && $trainer->user && $trainer->user->avatar
                                    ? asset('storage/'.$trainer->user->avatar)
                                    : asset('assets/media/avatars/blank.png');
                                $trainerName = $trainer && $trainer->user ? $trainer->user->name : '-';
                            ?>
                            <div class="d-flex align-items-center mb-4 pb-3 border-bottom gap-3">
                                <img src="<?php echo e($avatar); ?>" alt="Trainer" class="rounded-circle border shadow-sm" width="40" height="40">
                                <div class="flex-grow-1">
                                    <div class="fs-7 text-muted mb-1"><?php echo e($session->course->name); ?></div>
                                    <div class="fw-semibold"><?php echo e(\Carbon\Carbon::parse($session->session_date)->translatedFormat('d M Y')); ?>,
                                        <?php echo e(\Carbon\Carbon::parse($session->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($session->end_time)->format('H:i')); ?>

                                    </div>
                                    <div class="fs-8 text-gray-500">
                                        <i class="bi bi-geo-alt"></i> <?php echo e($session->course->venue->name ?? '-'); ?>

                                        &nbsp;|&nbsp;
                                        <i class="bi bi-person-badge"></i> <?php echo e($trainerName); ?>

                                    </div>
                                </div>
                                <a href="<?php echo e(route('courses.show', $session->course->id)); ?>" class="btn btn-sm btn-light-primary rounded-pill px-3 shadow-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-muted">Tidak ada sesi terdekat.</div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- DataTable Sesi Completed -->
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-header bg-gradient-success text-white rounded-top-4 py-4 px-4">
                        <h5 class="card-title mb-0 fw-bold"><i class="bi bi-check2-circle me-2"></i>Log Sesi Selesai</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fs-8">Kursus</th>
                                        <th class="fs-8">Tanggal</th>
                                        <th class="fs-8">Waktu</th>
                                        <th class="fs-8">Venue</th>
                                        <th class="fs-8">Pelatih</th>
                                        <th class="fs-8">Aksi</th>
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
                                            <td class="fs-8 text-muted"><?php echo e($session->course->name); ?></td>
                                            <td class="fs-8"><?php echo e(\Carbon\Carbon::parse($session->session_date)->translatedFormat('d M Y')); ?></td>
                                            <td class="fs-8"><?php echo e(\Carbon\Carbon::parse($session->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($session->end_time)->format('H:i')); ?></td>
                                            <td class="fs-8"><?php echo e($session->course->venue->name ?? '-'); ?></td>
                                            <td class="fs-8 d-flex align-items-center gap-2">
                                                <img src="<?php echo e($avatar); ?>" alt="Trainer" class="rounded-circle border" width="28" height="28">
                                                <span><?php echo e($trainerName); ?></span>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(route('courses.show', $session->course->id)); ?>" class="btn btn-sm btn-light-primary rounded-pill px-2 shadow-sm" title="Detail Kursus">
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
                        <div class="mb-2"><strong>Estimated Students:</strong> ${props.students}</div>
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
        .fs-8 { font-size: 0.85rem !important; }
        .fs-7 { font-size: 0.95rem !important; }
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
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views/general-schedule/index.blade.php ENDPATH**/ ?>