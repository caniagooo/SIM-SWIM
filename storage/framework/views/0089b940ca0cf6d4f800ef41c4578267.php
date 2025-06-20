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
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container-xxl" id="kt_content_container">
            <div class="card card-custom">
                <div class="card-header border-0 pt-6">
                    <h3 class="card-title">Detail Murid</h3>
                    <div class="card-toolbar">
                        <a href="<?php echo e(route('students.index')); ?>" class="btn btn-light-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab-info" data-bs-toggle="tab">
                                <i class="fas fa-user"></i> Informasi Murid
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-analytics" data-bs-toggle="tab">
                                <i class="fas fa-chart-line"></i> Analitik
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Tab 1: Informasi Murid -->
                        <div class="tab-pane fade show active" id="tab-info">
                            <!-- Row 1 -->
                            <div class="row mb-4 align-items-stretch">
                                <div class="col-md-4 border-end">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body text-center">
                                            <div class="symbol symbol-100px mb-3">
                                                <img src="<?php echo e($student->user->profile_picture ?? asset('assets/media/avatars/default-avatar.png')); ?>" alt="Avatar" class="rounded-circle">
                                            </div>
                                            <h5 class="text-gray-800 fw-bold"><?php echo e($student->user->name); ?></h5>
                                            <p class="text-gray-600">Organisasi: -</p>
                                            <a href="https://wa.me/<?php echo e($student->user->phone_number); ?>" class="btn btn-success btn-sm mb-2" target="_blank">
                                                <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 border-end">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                <tr>
                                                    <th>Email</th>
                                                    <td><?php echo e($student->user->email); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Lahir</th>
                                                    <td><?php echo e(\Carbon\carbon::parse( $student->birth_date)->format('d-m-Y')); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Usia</th>
                                                    <td><?php echo e(\Carbon\Carbon::parse($student->birth_date)->age); ?> tahun </td>
                                                </tr>
                                                <tr>
                                                    <th>Terdaftar</th>
                                                    <td><?php echo e(\Carbon\Carbon::parse($student->user->created_at)->format('m-Y')); ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                <tr>
                                                    <th>Jumlah Kursus</th>
                                                    <td><?php echo e($student->courses_count); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Total Sesi</th>
                                                    <td><?php echo e($student->sessions_count); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td><?php echo e($student->status); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Total Nilai Kumulatif</th>
                                                    <td>-</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pemisah antara Row 1 dan Row 2 -->
                            <hr class="my-5">

                            <!-- Row 2 -->
                            <div class="row mb-4">
                                <div class="col-12 #border-end">
                                    <h5 class="mb-3">Kursus yang Pernah Diikuti</h5>
                                    <table id="courses_table" class="table align-middle table-row-dashed fs-6 gy-5">
                                        <thead>
                                            <tr class="text-start text-gray-800 fw-bold fs-7 text-uppercase gs-0">
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
                                                <td><?php echo e($loop->iteration); ?></td>
                                                <td>
                                                    <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#courseDetailModal<?php echo e($course->id); ?>">
                                                        <?php echo e($course->name); ?>

                                                    </a>
                                                </td>
                                                <td><?php echo e($course->max_sessions); ?></td>
                                                <td><?php echo e($course->venue->name ?? '-'); ?></td>
                                                <td><?php echo e($course->status); ?></td>
                                                <td>-</td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: Analitik -->
                        <div class="tab-pane fade" id="tab-analytics">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="mb-3">Timeline Sesi Latihan</h5>
                                    <div id="chart-timeline" style="height: 300px;"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mb-3">Daftar Materi yang Pernah Diikuti</h5>
                                    <table id="materials_table" class="table align-middle table-row-dashed fs-6 gy-5">
                                        <thead>
                                            <tr class="text-start text-gray-800 fw-bold fs-7 text-uppercase gs-0">
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
                                                <td><?php echo e($i); ?></td>
                                                <td>Materi <?php echo e($i); ?></td>
                                                <td>Kursus <?php echo e($i); ?></td>
                                                <td><?php echo e(now()->subDays($i)->format('Y-m-d')); ?></td>
                                                <td><?php echo e(rand(70, 100)); ?></td>
                                                <td>Pelatih <?php echo e($i); ?></td>
                                            </tr>
                                            <?php endfor; ?>
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

    <!-- Modal Detail Kursus -->
    <?php $__currentLoopData = $student->courses->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="courseDetailModal<?php echo e($course->id); ?>" tabindex="-1" aria-labelledby="courseDetailModalLabel<?php echo e($course->id); ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="courseDetailModalLabel<?php echo e($course->id); ?>">Detail Kursus: <?php echo e($course->name); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
            // Inisialisasi DataTables
            $('#courses_table').DataTable({
                responsive: true,
                paginate: true,
                lengthChange: false,
                searching: false,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    }
                }
            });

            $('#materials_table').DataTable({
                responsive: true,
                paginate: true,
                lengthChange: false,
                paginglength: 5,
                searching: false,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    }
                }
            });

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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $attributes = $__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $component = $__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views\students\show.blade.php ENDPATH**/ ?>