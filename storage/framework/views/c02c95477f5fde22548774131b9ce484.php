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
    <div class="container py-3">
        <!-- Header Card -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center p-4">
                <a href="<?php echo e(route('students.index')); ?>" class="btn btn-sm btn-light btn-active-light-primary" title="Kembali ke daftar murid">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="row g-3 mb-4">
            <!-- Kolom Kiri: Foto & Nama -->
            <div class="col-12 col-md-4 col-lg-3">
                <div class="card card-flush border-0 shadow-sm h-100 text-center">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                        <img src="<?php echo e($student->user->profile_picture ?? asset('assets/media/avatars/default-avatar.png')); ?>"
                             alt="Avatar" class="symbol symbol-80px symbol-circle border mb-3" width="80" height="80">
                        <h5 class="fw-bold mb-1"><?php echo e($student->user->name); ?></h5>
                        <div class="mt-2">
                            <span class="text-gray-500 fs-8">Last Login</span>
                            <div class="fw-semibold">
                                <?php echo e($student->user->last_login_at ? \Carbon\Carbon::parse($student->user->last_login_at)->diffForHumans() : '-'); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kolom Tengah: Informasi Pribadi -->
            <div class="col-12 col-md-8 col-lg-5">
                <div class="card card-flush border-0 shadow-sm h-100">
                    <div class="card-body py-10 px-4">
                        <div class="mb-2">
                            <span class="text-gray-500 fs-8">Email</span>
                            <div class="fw-semibold"><?php echo e($student->user->email); ?></div>
                        </div>
                        <div class="mb-2">
                            <span class="text-gray-500 fs-8">No. HP</span>
                            <div class="fw-semibold d-flex align-items-center gap-2">
                                <?php echo e($student->user->phone_number ?? '-'); ?>

                                <?php if(!empty($student->user->phone_number)): ?>
                                    <?php
                                        $waNumber = preg_replace('/[^0-9]/', '', $student->user->phone_number);
                                        if (substr($waNumber, 0, 1) === '0') {
                                            $waNumber = '62' . substr($waNumber, 1);
                                        }
                                    ?>
                                    <a href="https://wa.me/<?php echo e($waNumber); ?>" target="_blank" class="btn btn-sm btn-icon btn-success" title="Chat WhatsApp">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-2">
                            <span class="text-gray-500 fs-8">Tanggal Lahir</span>
                            <div class="fw-semibold"><?php echo e(\Carbon\Carbon::parse($student->birth_date)->format('d-m-Y')); ?></div>
                        </div>
                        <div>
                            <span class="text-gray-500 fs-8">Usia</span>
                            <div class="fw-semibold"><?php echo e(\Carbon\Carbon::parse($student->birth_date)->age); ?> tahun</div>
                        </div>
                        <div class="mt-3">
                            <span class="text-gray-500 fs-8">Terdaftar Sejak</span>
                            <div class="fw-semibold"><?php echo e(\Carbon\Carbon::parse($student->user->created_at)->format('d M Y')); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kolom Kanan: Informasi Kursus -->
            <div class="col-12 col-lg-4">
                <div class="card card-flush border-0 shadow-sm h-100">
                    <div class="card-body py-10 px-4">
                        <div class="mb-2">
                            <span class="text-gray-500 fs-8">Total Kursus</span>
                            <div class="fw-bold"><?php echo e($student->courses_count); ?></div>
                        </div>
                        <div class="mb-2">
                            <span class="text-gray-500 fs-8">Total Sesi</span>
                            <div class="fw-bold"><?php echo e($student->sessions_count); ?></div>
                        </div>
                        <div class="mb-2">
                            <span class="text-gray-500 fs-8">Nilai Kumulatif</span>
                            <div class="fw-bold">-</div>
                        </div>
                        <div class="mb-2">
                            <span class="text-gray-500 fs-8">Rata-rata Nilai</span>
                            <div class="fw-bold">-</div>
                        </div>
                        <div class="mt-3">
                            <span class="text-gray-500 fs-8">Progress</span>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" style="width: 60%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-pills nav-pills-custom mb-3" id="studentTabs" role="tablist">
            <?php
                $activeTab = request()->get('tab', 'courses');
                $tabList = [
                    'courses' => ['icon' => 'bi-journal-bookmark', 'label' => 'Kursus'],
                    'materials' => ['icon' => 'bi-book', 'label' => 'Materi & Nilai'],
                    'analytics' => ['icon' => 'bi-bar-chart-line', 'label' => 'Analitik'],
                ];
            ?>
            <?php $__currentLoopData = $tabList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tabKey => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="nav-item flex-fill text-center" role="presentation" style="min-width: 110px;">
                    <button
                        class="nav-link w-100 py-2 px-1 <?php echo e($activeTab === $tabKey ? 'active' : ''); ?>"
                        id="<?php echo e($tabKey); ?>-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#<?php echo e($tabKey); ?>"
                        type="button"
                        role="tab"
                        aria-controls="<?php echo e($tabKey); ?>"
                        aria-selected="<?php echo e($activeTab === $tabKey ? 'true' : 'false'); ?>"
                        tabindex="<?php echo e($activeTab === $tabKey ? '0' : '-1'); ?>"
                        style="font-size: 1rem; font-weight: 500; border: none; background: none;"
                    >
                        <i class="bi <?php echo e($tab['icon']); ?> me-1"></i> <?php echo e($tab['label']); ?>

                    </button>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <style>
            .nav-pills-custom {
                background: #f5f8fa;
                border-radius: 0.5rem;
                overflow: hidden;
                border: 1px solid #e4e6ef;
                margin-bottom: 1rem;
            }
            .nav-pills-custom .nav-link {
                border-radius: 0;
                font-weight: 500;
                color: #5e6278;
                transition: background 0.2s, color 0.2s, border-bottom 0.2s;
                border: none;
                background: none;
                padding: 0.85rem 0.5rem;
                font-size: 1rem;
                position: relative;
            }
            .nav-pills-custom .nav-link.active,
            .nav-pills-custom .nav-link:focus,
            .nav-pills-custom .nav-link:hover {
                background: #fff !important;
                color: #009ef7 !important;
                border-bottom: 2.5px solid #009ef7;
                z-index: 2;
            }
            .nav-pills-custom .nav-link:not(.active):hover {
                background: #f1faff !important;
                color: #009ef7 !important;
            }
            .nav-pills-custom .nav-link i {
                font-size: 1.1em;
                vertical-align: middle;
                margin-right: 0.25em;
            }
            .nav-pills-custom .nav-link.active i {
                color: #009ef7;
            }
            .nav-pills-custom .nav-link:disabled {
                color: #b5b5c3 !important;
                background: none !important;
                cursor: not-allowed;
            }
            @media (max-width: 576px) {
                .nav-pills-custom .nav-link {
                    font-size: 0.95rem;
                    padding: .5rem .1rem;
                }
                .card-body, .card-header { padding: 1rem !important; }
                .table { font-size: 0.92rem; }
                .symbol-60px { width: 48px !important; height: 48px !important; }
            }
            .symbol-60px { width: 60px; height: 60px; }
            .fs-7 { font-size: 0.95rem !important; }
            .fs-8 { font-size: 0.88rem !important; }
        </style>

        <div class="tab-content" id="studentTabsContent">
            <!-- Kursus Tab -->
            <div class="tab-pane fade show active" id="courses" role="tabpanel">
                <div class="card card-flush border-0 shadow-sm mb-3">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-200 align-middle gy-2 mb-0">
                                <thead>
                                    <tr class="text-center fw-semibold text-gray-600 fs-7">
                                        <th>#</th>
                                        <th>Nama Kursus</th>
                                        <th>Jumlah Sesi</th>
                                        <th>Venue</th>
                                        <th>Status</th>
                                        <th>Nilai Kumulatif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $student->courses->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-center text-gray-500 fs-8"><?php echo e($loop->iteration); ?></td>
                                        <td>
                                            <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#courseDetailModal<?php echo e($course->id); ?>">
                                                <?php echo e($course->name); ?>

                                            </a>
                                        </td>
                                        <td class="text-center fs-8"><?php echo e($course->max_sessions); ?></td>
                                        <td class="text-center fs-8"><?php echo e($course->venue->name ?? '-'); ?></td>
                                        <td class="text-center">
                                            <span class="badge badge-light-<?php echo e($course->status === 'aktif' ? 'success' : 'secondary'); ?>">
                                                <?php echo e(ucfirst($course->status)); ?>

                                            </span>
                                        </td>
                                        <td class="text-center fs-8">-</td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Materi & Nilai Tab -->
            <div class="tab-pane fade" id="materials" role="tabpanel">
                <div class="card card-flush border-0 shadow-sm mb-3">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-200 align-middle gy-2 mb-0">
                                <thead>
                                    <tr class="text-center fw-semibold text-gray-600 fs-7">
                                        <th>#</th>
                                        <th>Nama Materi</th>
                                        <th>Nama Kursus</th>
                                        <th>Tanggal Penilaian</th>
                                        <th>Nilai</th>
                                        <th>Nama Pelatih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                    <tr>
                                        <td class="text-center text-gray-500 fs-8"><?php echo e($i); ?></td>
                                        <td class="fs-8">Materi <?php echo e($i); ?></td>
                                        <td class="fs-8">Kursus <?php echo e($i); ?></td>
                                        <td class="fs-8"><?php echo e(now()->subDays($i)->format('Y-m-d')); ?></td>
                                        <td class="fs-8"><?php echo e(rand(70, 100)); ?></td>
                                        <td class="fs-8">Pelatih <?php echo e($i); ?></td>
                                    </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Analitik Tab -->
            <div class="tab-pane fade" id="analytics" role="tabpanel">
                <div class="card card-flush border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="mb-3">Timeline Sesi Latihan</h5>
                        <div id="chart-timeline" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail Kursus -->
        <?php $__currentLoopData = $student->courses->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="courseDetailModal<?php echo e($course->id); ?>" tabindex="-1" aria-labelledby="courseDetailModalLabel<?php echo e($course->id); ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="courseDetailModalLabel<?php echo e($course->id); ?>">Detail Kursus: <?php echo e($course->name); ?></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nama Pelatih:</strong> <?php echo e($course->coach_name ?? '-'); ?></p>
                        <p><strong>Venue:</strong> <?php echo e($course->venue->name ?? '-'); ?></p>
                        <p><strong>Status:</strong> <?php echo e($course->status); ?></p>
                        <p><strong>Jumlah Sesi:</strong> <?php echo e($course->max_sessions); ?></p>
                        <p><strong>Nilai Kumulatif:</strong> -</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <script>
            $(document).ready(function() {
                // Dummy chart untuk timeline sesi latihan
                var options = {
                    series: [{
                        name: 'Sesi Latihan',
                        data: [10, 15, 25, 30, 40, 50]
                    }],
                    chart: {
                        type: 'line',
                        height: 300
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
                    }
                };
                var chart = new ApexCharts(document.querySelector("#chart-timeline"), options);
                chart.render();
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
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views/students/show.blade.php ENDPATH**/ ?>