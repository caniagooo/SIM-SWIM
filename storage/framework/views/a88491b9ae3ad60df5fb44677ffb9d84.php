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
        $stats = [
            'last_month' => $sessions->where('session_date', '<', now()->startOfMonth())->count(),
            'this_month' => $sessions->where('session_date', '>=', now()->startOfMonth())->where('session_date', '<=', now()->endOfMonth())->count(),
            'next_month' => $sessions->where('session_date', '>', now()->endOfMonth())->count(),
        ];
        // Ambil sesi completed saja untuk log, paginasi manual (10 per halaman)
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
            <!-- Kalender List Mode -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h4 class="card-title mb-0">Jadwal Sesi (List Calendar)</h4>
                    </div>
                    <div class="card-body">
                        <div id="kt_fullcalendar" style="min-height: 600px;"></div>
                    </div>
                </div>
            </div>
            <!-- Statistik & Log Sesi -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm mb-5">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title mb-0">Statistik Sesi</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px bg-light-primary me-3">
                                    <i class="bi bi-calendar2-check text-primary fs-2"></i>
                                </div>
                                <div>
                                    <div class="fs-5 fw-bold"><?php echo e($stats['last_month'] ?? 0); ?></div>
                                    <div class="fs-8 text-gray-600">Sesi Bulan Lalu</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px bg-light-success me-3">
                                    <i class="bi bi-calendar2-week text-success fs-2"></i>
                                </div>
                                <div>
                                    <div class="fs-5 fw-bold"><?php echo e($stats['this_month'] ?? 0); ?></div>
                                    <div class="fs-8 text-gray-600">Sesi Bulan Ini</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-40px bg-light-info me-3">
                                    <i class="bi bi-calendar2-plus text-info fs-2"></i>
                                </div>
                                <div>
                                    <div class="fs-5 fw-bold"><?php echo e($stats['next_month'] ?? 0); ?></div>
                                    <div class="fs-8 text-gray-600">Sesi Bulan Depan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Log Sesi Lewat (Completed) -->
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Log Sesi Selesai</h5>
                    </div>
                    <div class="card-body" style="max-height: 420px; overflow-y: auto;">
                        <?php $__empty_1 = true; $__currentLoopData = $paginator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="mb-3 pb-2 border-bottom">
                                <div class="fw-semibold"><?php echo e($session->course->name); ?></div>
                                <div class="fs-8 text-gray-600">
                                    <?php echo e(\Carbon\Carbon::parse($session->session_date)->translatedFormat('d M Y')); ?>,
                                    <?php echo e(\Carbon\Carbon::parse($session->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($session->end_time)->format('H:i')); ?>

                                </div>
                                <div class="fs-8 text-gray-500 mb-1">
                                    <i class="bi bi-geo-alt"></i> <?php echo e($session->course->venue->name ?? '-'); ?>

                                </div>
                                <span class="badge bg-success text-white mb-2">
                                    <?php echo e(ucfirst($session->status)); ?>

                                </span>
                                <div>
                                    <a href="<?php echo e(route('courses.show', $session->course->id)); ?>" class="btn btn-sm btn-light-primary">
                                        <i class="bi bi-eye"></i> Detail Kursus
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-muted">Belum ada sesi yang selesai.</div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer bg-white py-2">
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
                initialView: 'listDay',
                now: '<?php echo e(now()->toDateString()); ?>',
                height: 600,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'listDay,listWeek,dayGridMonth'
                },
                views: {
                    listDay: { buttonText: 'Hari Ini' },
                    listWeek: { buttonText: 'Minggu Ini' },
                    dayGridMonth: { buttonText: 'Bulan' }
                },
                events: <?php echo $sessions->map(function ($session) {
                    return [
                        'title' => $session->course->name,
                        'start' => $session->session_date . 'T' . ($session->start_time ?? '00:00:00'),
                        'end'   => $session->session_date . 'T' . ($session->end_time ?? '23:59:59'),
                        'color' => $session->status == 'completed' ? '#50cd89' : ($session->status == 'canceled' ? '#f1416c' : '#009ef7'),
                        'extendedProps' => [
                            'status' => $session->status,
                            'course' => $session->course->name,
                            'students' => $session->course->students->count(),
                            'venue' => $session->course->venue->name ?? '-'
                        ]
                    ];
                })->values()->toJson(); ?>,
                eventClick: function(info) {
                    var event = info.event;
                    var props = event.extendedProps;
                    var html = `
                        <div class="mb-2"><strong>Course:</strong> ${props.course}</div>
                        <div class="mb-2"><strong>Date:</strong> ${event.start.toLocaleDateString('en-GB')}</div>
                        <div class="mb-2"><strong>Time:</strong> ${event.start.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})} - ${event.end ? event.end.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : '-'}</div>
                        <div class="mb-2"><strong>Status:</strong> <span class="badge bg-${props.status == 'completed' ? 'success' : (props.status == 'canceled' ? 'danger' : 'info')} text-white">${props.status}</span></div>
                        <div class="mb-2"><strong>Venue:</strong> ${props.venue}</div>
                        <div class="mb-2"><strong>Estimated Students:</strong> ${props.students}</div>
                    `;
                    Swal.fire({
                        title: 'Session Detail',
                        html: html,
                        icon: 'info',
                        confirmButtonText: 'Close',
                        customClass: { confirmButton: "btn btn-primary" }
                    });
                }
            });
            calendar.render();
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
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views/general-schedule/index.blade.php ENDPATH**/ ?>