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
            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <div class="card card-custom">
                <div class="card-header border-0 pt-6">
                    <h3 class="card-title">Manajemen Murid</h3>
                    <div class="card-toolbar">
                        <a href="<?php echo e(route('students.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Murid
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <!-- Filter dan Search -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <!-- Input Search -->
                        <div class="input-group w-50">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" id="search-input" class="form-control form-control-sm" placeholder="Cari...">
                        </div>

                        <!-- Filter Kelompok Usia -->
                        <div class="d-flex align-items-center">
                            <select id="filter-age-group" class="form-select form-select-sm me-2">
                                <option value="">Semua</option>
                                <?php $__currentLoopData = $students->pluck('age_group')->unique(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ageGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($ageGroup); ?>"><?php echo e(ucfirst($ageGroup)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <button id="clear-filter" class="btn btn-light-danger btn-sm">
                                <i class="fas fa-times"></i> 
                            </button>
                        </div>
                    </div>

                    <table id="students_table" class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="text-start text-gray-800 fw-bold fs-7 text-uppercase gs-0">
                                <th>Profile</th>
    
                                <th>Tanggal Lahir</th>
                                <th>Kelompok Usia</th>
                                <th>Eksistensi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <!-- Profile Picture & Nama -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-50px me-3">
                                            <img src="<?php echo e($student->user->profile_picture ?? asset('assets/media/avatars/default-avatar.png')); ?>" alt="Avatar">
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-800 fw-bold"><?php echo e($student->user->name); ?></span>
                                            <span class="text-gray-600"><?php echo e($student->user->email); ?></span>
                                        </div>
                                    </div>
                                </td>
                                
                                

                                <!-- Tanggal Lahir & Usia -->
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-800 fw-bold"><?php echo e($student->birth_date); ?></span>
                                        <span class="text-gray-600"><?php echo e(\Carbon\Carbon::parse($student->birth_date)->age); ?> tahun</span>
                                    </div>
                                </td>


                                <!-- Kelompok Usia -->
                                <td>
                                    <span class="text-gray-800 fw-bold"><?php echo e(ucfirst($student->age_group)); ?></span>
                                </td>

                                <!-- Eksistensi -->
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-800 fw-bold"><?php echo e($student->courses_count); ?> kursus</span>
                                        <span class="text-gray-600"><?php echo e($student->sessions_count); ?> sesi</span>
                                    </div>
                                </td>

                                <!-- Aksi -->
                                <td>
                                    <div class="d-flex justify-content-start">
                                        <a href="<?php echo e(route('students.show', $student->id)); ?>" class="btn btn-light-info btn-sm me-2">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a href="<?php echo e(route('students.edit', $student->id)); ?>" class="btn btn-light-warning btn-sm me-2">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="<?php echo e(route('students.destroy', $student->id)); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-light-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
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

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            var table = $('#students_table').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    }
                },
                dom: '<"top">rt<"bottom"lp><"clear">'
            });

            // Input Search
            $('#search-input').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Filter Kelompok Usia
            $('#filter-age-group').on('change', function() {
                table.column(4).search(this.value).draw();
            });

            // Clear Filter
            $('#clear-filter').on('click', function() {
                $('#filter-age-group').val('');
                table.column(4).search('').draw();
            });
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
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views/students/index.blade.php ENDPATH**/ ?>