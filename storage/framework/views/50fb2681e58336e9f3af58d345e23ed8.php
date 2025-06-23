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
        <form id="course-form" method="POST" action="<?php echo e(route('courses.store')); ?>">
            <?php echo csrf_field(); ?>

            <!-- Progress Tab -->
            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="card-title">
                        <h2 class="fw-bold mb-0">
                            <span class="svg-icon svg-icon-2 me-2 text-primary">
                                <i class="bi-book"></i>
                            </span>
                            Pembuatan Kursus Baru
                        </h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="<?php echo e(route('courses.index')); ?>" class="btn btn-light-primary btn-sm">
                            <span class="svg-icon svg-icon-2 me-1">
                                <i class="bi-arrow-left"></i>
                            </span>
                            Kembali ke Daftar Kursus
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6" id="progressTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="step1-tab" data-bs-toggle="tab" data-bs-target="#step1" type="button" role="tab" aria-controls="step1" aria-selected="true">
                                Step 1: Detail Kursus
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="step2-tab" data-bs-toggle="tab" data-bs-target="#step2" type="button" role="tab" aria-controls="step2" aria-selected="false">
                                Step 2: Venue & Sesi
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="step3-tab" data-bs-toggle="tab" data-bs-target="#step3" type="button" role="tab" aria-controls="step3" aria-selected="false">
                                Step 3: Pelatih & Materi
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="progressTabContent">
                        <!-- Step 1 -->
                        <div class="tab-pane fade show active" id="step1" role="tabpanel" aria-labelledby="step1-tab">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-2">Tipe Kursus</label>
                                    <div class="d-flex gap-3">
                                        <input type="hidden" name="type" id="type" value="private">
                                        <div class="card course-type-card border-primary position-relative" data-type="private" style="cursor:pointer; min-width:200px;">
                                            <!-- Checkbox at top-right -->
                                            <div class="position-absolute top-0 end-0 m-2 z-index-2">
                                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input course-type-checkbox" type="checkbox" id="type-private-checkbox" value="private" disabled checked>
                                                </div>
                                            </div>
                                            <div class="card-body text-center py-3">
                                                <i class="bi bi-person fs-2 text-primary"></i>
                                                <div class="fw-bold mt-2">Private</div>
                                            </div>
                                        </div>
                                        <div class="card course-type-card position-relative" data-type="group" style="cursor:pointer; min-width:200px;">
                                            <!-- Checkbox at top-right -->
                                            <div class="position-absolute top-0 end-0 m-2 z-index-2">
                                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input course-type-checkbox" type="checkbox" id="type-group-checkbox" value="group" disabled>
                                                </div>
                                            </div>
                                            <div class="card-body text-center py-3">
                                                <i class="bi bi-people fs-2 text-primary"></i>
                                                <div class="fw-bold mt-2">Group</div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            // Update checkboxes when card is selected
                                            function updateTypeCheckbox(selectedType) {
                                                document.getElementById('type-private-checkbox').checked = selectedType === 'private';
                                                document.getElementById('type-group-checkbox').checked = selectedType === 'group';
                                            }
                                            // Patch into existing selectCard logic
                                            const typeInput = document.getElementById('type');
                                            function selectCardWithCheckbox(selectedType) {
                                                updateTypeCheckbox(selectedType);
                                                // Call original selectCard if exists
                                                if (typeof selectCard === 'function') {
                                                    selectCard(selectedType);
                                                }
                                            }
                                            // Patch event listeners
                                            document.querySelectorAll('.course-type-card').forEach(card => {
                                                card.addEventListener('click', function () {
                                                    selectCardWithCheckbox(card.dataset.type);
                                                });
                                            });
                                            // Initial state
                                            updateTypeCheckbox(typeInput.value);
                                        });
                                    </script>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="basic_skills" class="form-label">Catatan terkait murid</label>
                                    <textarea name="basic_skills" id="basic_skills" class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="students" class="form-label">Pilih Murid</label>
                                <div id="students-section">
                                    <!-- Private: Dropdown -->
                                    <div id="students-dropdown-section">
                                        <select class="form-select" name="students[]" id="student-private-dropdown">
                                            <option value="">-- Select Student --</option>
                                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $dob = $student->birth_date ?? null;
                                                    $age = $dob ? \Carbon\Carbon::parse($dob)->age : '-';
                                                ?>
                                            <option value="<?php echo e($student->id); ?>"><?php echo e($student->user->name); ?> | <?php echo e($student->user->email); ?> | <span class="text-muted">(<?php echo e($age); ?> tahun)</span></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <?php $__env->startPush('scripts'); ?>
                                        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                $('#student-private-dropdown').select2({
                                                    placeholder: '-- Select Student --',
                                                    allowClear: true,
                                                    width: '100%'
                                                });
                                            });
                                        </script>
                                    <?php $__env->stopPush(); ?>
                                    <?php $__env->startPush('styles'); ?>
                                        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                                    <?php $__env->stopPush(); ?>

                                    <!-- Group: Table with Checkbox & Search -->
                                    <div id="students-table-section" style="display: none;">
                                        <input type="text" id="student-search" class="form-control mb-2" placeholder="Search students by name or email">
                                        <div style="max-height: 300px; overflow-y: auto;">
                                            <table class="table table-bordered table-hover" id="students-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width:40px;">
                                                            <input type="checkbox" id="select-all-students">
                                                        </th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Tanggal Lahir</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="students-table-body">
                                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="student-checkbox"
                                                                    name="students[]"
                                                                    value="<?php echo e($student->id); ?>">
                                                            </td>
                                                            <td><?php echo e($student->user->name); ?></td>
                                                            <td><?php echo e($student->user->email); ?></td>
                                                            <td>
                                                                <?php
                                                                    $dob = $student->birth_date ?? null;
                                                                    $age = $dob ? \Carbon\Carbon::parse($dob)->age : '-';
                                                                ?>
                                                                <?php echo e($dob ? \Carbon\Carbon::parse($dob)->format('d M Y') : '-'); ?> 
                                                                <?php if($age !== '-'): ?> 
                                                                    <span class="text-muted">(<?php echo e($age); ?> tahun)</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <style>
                                .course-type-card {
                                    border-width: 1px;
                                    transition: border-color 0.2s, box-shadow 0.2s;
                                }
                                .course-type-card.selected, .course-type-card:hover {
                                    border-color: #0d6efd !important;
                                    box-shadow: 0 0 0 0.2rem rgba(13,110,253,.15);
                                }
                            </style>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    // Card selection logic
                                    const typeInput = document.getElementById('type');
                                    const cards = document.querySelectorAll('.course-type-card');
                                    function selectCard(selectedType) {
                                        cards.forEach(card => {
                                            if (card.dataset.type === selectedType) {
                                                card.classList.add('selected', 'border-primary');
                                                card.classList.remove('border-secondary');
                                            } else {
                                                card.classList.remove('selected', 'border-primary');
                                                card.classList.add('border-secondary');
                                            }
                                        });
                                        typeInput.value = selectedType;
                                        // Show/hide student selection
                                        if (selectedType === 'private') {
                                            document.getElementById('students-dropdown-section').style.display = '';
                                            document.getElementById('students-table-section').style.display = 'none';
                                            document.getElementById('student-private-dropdown').disabled = false;
                                            document.querySelectorAll('.student-checkbox').forEach(cb => cb.disabled = true);
                                        } else {
                                            document.getElementById('students-dropdown-section').style.display = 'none';
                                            document.getElementById('students-table-section').style.display = '';
                                            document.getElementById('student-private-dropdown').disabled = true;
                                            document.querySelectorAll('.student-checkbox').forEach(cb => cb.disabled = false);
                                        }
                                    }
                                    cards.forEach(card => {
                                        card.addEventListener('click', function () {
                                            selectCard(card.dataset.type);
                                        });
                                    });
                                    // Initial state
                                    selectCard(typeInput.value);

                                    // Student search for group
                                    const searchInput = document.getElementById('student-search');
                                    if (searchInput) {
                                        searchInput.addEventListener('input', function () {
                                            const filter = searchInput.value.toLowerCase();
                                            document.querySelectorAll('#students-table-body tr').forEach(row => {
                                                const name = row.children[1].textContent.toLowerCase();
                                                const email = row.children[2].textContent.toLowerCase();
                                                row.style.display = (name.includes(filter) || email.includes(filter)) ? '' : 'none';
                                            });
                                        });
                                    }
                                    // Select all checkbox
                                    const selectAll = document.getElementById('select-all-students');
                                    if (selectAll) {
                                        selectAll.addEventListener('change', function () {
                                            document.querySelectorAll('.student-checkbox').forEach(cb => {
                                                cb.checked = selectAll.checked;
                                            });
                                        });
                                    }
                                });
                            </script>
                        </div>

                        <!-- Step 2 -->
                        <div class="tab-pane fade" id="step2" role="tabpanel" aria-labelledby="step2-tab">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="venue_id" class="form-label fw-semibold">Venue</label>
                                    <select name="venue_id" id="venue_id" class="form-select" required>
                                        <option value="">-- Select Venue --</option>
                                        <?php $__currentLoopData = $venues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($venue->id); ?>"><?php echo e($venue->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="price" class="form-label fw-semibold">Harga Kursus</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" min="0" name="price" id="price" class="form-control" required>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row g-4 mt-1">
                                <div class="col-md-6">
                                    <label for="max_sessions" class="form-label fw-semibold">Total Sesi</label>
                                    <div class="input-group">
                                        <input type="number" min="1" name="max_sessions" id="max_sessions" class="form-control" required>
                                        <span class="input-group-text">Sesi</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="duration_days" class="form-label fw-semibold">Duration</label>
                                    <div class="input-group">
                                        <input type="number" min="1" name="duration_days" id="duration_days" class="form-control" required>
                                        <span class="input-group-text">hari</span>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row g-4 mt-1">
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label fw-semibold">Tanggal Mulai</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo e(now()->format('Y-m-d')); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="valid_until" class="form-label fw-semibold">Tanggal Berakhir</label>
                                    <input type="date" name="valid_until" id="valid_until" class="form-control" readonly>
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    function updateExpiration() {
                                        const startDate = document.getElementById('start_date').value;
                                        const duration = parseInt(document.getElementById('duration_days').value, 10);
                                        const validUntil = document.getElementById('valid_until');
                                        if (startDate && duration && duration > 0) {
                                            const date = new Date(startDate);
                                            date.setDate(date.getDate() + duration - 1);
                                            const yyyy = date.getFullYear();
                                            const mm = String(date.getMonth() + 1).padStart(2, '0');
                                            const dd = String(date.getDate()).padStart(2, '0');
                                            validUntil.value = `${yyyy}-${mm}-${dd}`;
                                        } else {
                                            validUntil.value = '';
                                        }
                                    }
                                    document.getElementById('start_date').addEventListener('change', updateExpiration);
                                    document.getElementById('duration_days').addEventListener('input', updateExpiration);
                                    // Initial calculation
                                    updateExpiration();
                                });
                            </script>
                        </div>

                        <!-- Step 3 -->
                        <div class="tab-pane fade" id="step3" role="tabpanel" aria-labelledby="step3-tab">
                            <div class="row">
                                <!-- Trainers List -->
                                <div class="row mb-4">
                                    <label class="form-label mb-2 fw-semibold fs-5">Pilih Pelatih</label>
                                    <?php
                                        $shuffledTrainers = $trainers->shuffle();
                                    ?>
                                    <div class="position-relative">
                                        <!-- Left Arrow -->
                                        <button type="button" id="trainers-prev" class="btn btn-light btn-sm position-absolute top-50 start-0 translate-middle-y z-index-2 shadow" style="left: -30px; border-radius: 50%; width: 36px; height: 36px; display: none;">
                                            <i class="bi bi-chevron-left fs-3"></i>
                                        </button>
                                        <!-- Right Arrow -->
                                        <button type="button" id="trainers-next" class="btn btn-light btn-sm position-absolute top-50 end-0 translate-middle-y z-index-2 shadow" style="right: -30px; border-radius: 50%; width: 36px; height: 36px; display: none;">
                                            <i class="bi bi-chevron-right fs-3"></i>
                                        </button>
                                        <div id="trainers-carousel-viewport" class="overflow-hidden w-100" style="min-height: 240px;">
                                            <div id="trainers-carousel" class="d-flex flex-row" style="gap: 2rem; transition: transform 0.3s;">
                                                <?php $__currentLoopData = $shuffledTrainers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="trainer-card-wrapper flex-shrink-0" style="width: 100%; max-width: 280px;">
                                                        <div class="card card-flush h-100 border border-solid  position-relative trainer-card box-shadow" style="cursor:pointer;">
                                                            <!-- Checkbox at top-right -->
                                                            <div class="position-absolute top-0 end-0 m-2 z-index-2">
                                                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                                    <input class="form-check-input trainer-checkbox" type="checkbox" name="trainers[]" value="<?php echo e($trainer->id); ?>" id="trainer-<?php echo e($trainer->id); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                                                                <div class="symbol symbol-60px symbol-circle mb-3">
                                                                    <img src="<?php echo e($trainer->user->profile_photo_url ?? asset('assets/media/avatars/default-avatar.png')); ?>" alt="<?php echo e($trainer->user->name); ?>">
                                                                </div>
                                                                <div class="fw-bold mb-2 text-center">
                                                                    <?php echo e($trainer->user->name); ?>

                                                                </div>
                                                                <div class="mb-1">
                                                                    <?php
                                                                        $dob = $trainer->user->date_of_birth ?? null;
                                                                        $age = $dob ? \Carbon\Carbon::parse($dob)->age : '-';
                                                                    ?>
                                                                    <span class="badge badge-light-info">
                                                                        <i class="ki-duotone ki-calendar fs-6 me-1"></i> Age: <?php echo e($age); ?>

                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <span class="badge badge-light-primary">
                                                                        <i class="ki-duotone ki-briefcase fs-6 me-1"></i>
                                                                        Kursus Aktif: <?php echo e($trainer->active_courses_count ?? 0); ?>

                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <style>

                                        #trainers-carousel-viewport {
                                            width: 100%;
                                            overflow: hidden;
                                            position: relative;
                                        }
                                        #trainers-carousel {
                                            transition: transform 0.3s;
                                            will-change: transform;
                                        }
                                        .trainer-card-wrapper {
                                            min-width: 200px;
                                            max-width: 250px;
                                            width: 100%;
                                        }
                                        @media (max-width: 991.98px) {
                                            .trainer-card-wrapper {
                                                min-width: 260px;
                                                max-width: 280px;
                                            }
                                        }
                                    </style>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            // Only allow one trainer to be selected
                                            document.querySelectorAll('.trainer-checkbox').forEach(function(checkbox) {
                                                checkbox.addEventListener('change', function() {
                                                    if (this.checked) {
                                                        document.querySelectorAll('.trainer-checkbox').forEach(function(cb) {
                                                            if (cb !== checkbox) cb.checked = false;
                                                        });
                                                    }
                                                });
                                            });
                                            // Card click toggles checkbox
                                            document.querySelectorAll('.trainer-card').forEach(function(card) {
                                                const checkbox = card.querySelector('.trainer-checkbox');
                                                card.addEventListener('click', function(e) {
                                                    if (e.target !== checkbox) {
                                                        checkbox.checked = !checkbox.checked;
                                                        checkbox.dispatchEvent(new Event('change'));
                                                    }
                                                });
                                                checkbox.addEventListener('click', function(e) {
                                                    e.stopPropagation();
                                                });
                                            });

                                            // Carousel logic
                                            const carousel = document.getElementById('trainers-carousel');
                                            const wrappers = carousel.querySelectorAll('.trainer-card-wrapper');
                                            const prevBtn = document.getElementById('trainers-prev');
                                            const nextBtn = document.getElementById('trainers-next');
                                            let visibleCount = 3;
                                            let currentIndex = 0;

                                            function updateVisibleCount() {
                                                if (window.innerWidth < 768) {
                                                    visibleCount = 1;
                                                } else if (window.innerWidth < 992) {
                                                    visibleCount = 2;
                                                } else {
                                                    visibleCount = 3;
                                                }
                                            }

                                            function getCardWidth() {
                                                // Get the actual width including gap
                                                const wrapper = wrappers[0];
                                                if (!wrapper) return 320;
                                                const style = window.getComputedStyle(wrapper);
                                                const width = wrapper.offsetWidth;
                                                const marginRight = parseInt(style.marginRight) || 16;
                                                return width + marginRight;
                                            }

                                            function updateCarousel() {
                                                const cardWidth = getCardWidth();
                                                // Prevent overflow: if last row, don't show empty space
                                                if (currentIndex + visibleCount > wrappers.length) {
                                                    currentIndex = Math.max(0, wrappers.length - visibleCount);
                                                }
                                                carousel.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
                                                prevBtn.style.display = currentIndex > 0 ? '' : 'none';
                                                nextBtn.style.display = (currentIndex + visibleCount) < wrappers.length ? '' : 'none';
                                            }

                                            prevBtn.addEventListener('click', function () {
                                                if (currentIndex > 0) {
                                                    currentIndex--;
                                                    updateCarousel();
                                                }
                                            });
                                            nextBtn.addEventListener('click', function () {
                                                if ((currentIndex + visibleCount) < wrappers.length) {
                                                    currentIndex++;
                                                    updateCarousel();
                                                }
                                            });

                                            window.addEventListener('resize', function () {
                                                updateVisibleCount();
                                                updateCarousel();
                                            });

                                            // Initial setup
                                            updateVisibleCount();
                                            updateCarousel();
                                        });
                                    </script>
                                <!-- Spacer between trainers and materials -->
                                
                                <!-- Materials List -->
                                <div class="row mb-3">
                                    <label class="form-label mb-2 fw-semibold fs-5">Select Materials</label>
                                    <div id="materialsAccordion" class="accordion accordion-icon-toggle">
                                        <?php
                                            $groupedMaterials = $materials->groupBy('level');
                                        ?>
                                        <?php $__currentLoopData = $groupedMaterials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level => $levelMaterials): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="accordion-item mb-2">
                                                <h2 class="accordion-header" id="headingLevel<?php echo e($level); ?>">
                                                    <button class="accordion-button collapsed px-4 py-3 fs-6 fw-bold text-gray-800 bg-light-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLevel<?php echo e($level); ?>" aria-expanded="false" aria-controls="collapseLevel<?php echo e($level); ?>">
                                                        <span class="svg-icon svg-icon-2 me-2">
                                                            <i class="ki-duotone ki-element-11 fs-2 text-primary"></i>
                                                        </span>
                                                        <span>
                                                            <span class="text-muted">Level</span>
                                                            <span class="ms-1 text-primary"><?php echo e($level); ?></span>
                                                        </span>
                                                    </button>
                                                </h2>
                                                <div id="collapseLevel<?php echo e($level); ?>" class="accordion-collapse collapse" aria-labelledby="headingLevel<?php echo e($level); ?>" data-bs-parent="#materialsAccordion">
                                                    <div class="accordion-body p-0">
                                                        <div class="table-responsive" style="max-height: 220px; overflow-y: auto;">
                                                            <table class="table align-middle table-row-dashed gy-3 mb-0">
                                                                <thead class="bg-light-primary">
                                                                    <tr class="fw-semibold text-gray-700">
                                                                        <th style="width:60px;"></th>
                                                                        <th>Materi</th>
                                                                        <th>Est. Sesi</th>
                                                                        <th>Min. Score</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $__currentLoopData = $levelMaterials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex justify-content-center">
                                                                                    <div class="form-check form-check-sm form-check-custom form-check-solid ms-2">
                                                                                        <input class="form-check-input material-checkbox" type="checkbox" name="materials[]" value="<?php echo e($material->id); ?>" data-estimated-sessions="<?php echo e($material->estimated_sessions ?? 0); ?>" data-min-score="<?php echo e($material->minimum_score ?? 0); ?>">
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <span class="fw-semibold"><?php echo e($material->name); ?></span>
                                                                            </td>
                                                                            <td>
                                                                                <span class="badge badge-light-primary fs-7"><?php echo e($material->estimated_sessions ?? '-'); ?></span>
                                                                            </td>
                                                                            <td>
                                                                                <span class="badge badge-light-success fs-7"><?php echo e($material->minimum_score ?? '-'); ?></span>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex align-items-center gap-4">
                                            <div class="d-flex align-items-center">
                                                <span class="svg-icon svg-icon-2 text-primary me-1">
                                                    <i class="ki-duotone ki-check-circle"></i>
                                                </span>
                                                <span class="fw-semibold">Terpilih: <span id="selected-materials-count" class="text-primary">0</span></span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="svg-icon svg-icon-2 text-warning me-1">
                                                    <i class="ki-duotone ki-calendar"></i>
                                                </span>
                                                <span class="fw-semibold">Est. Sesi: <span id="selected-materials-sessions" class="text-warning">0</span></span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <span class="svg-icon svg-icon-2 text-success me-1">
                                                    <i class="ki-duotone ki-chart-line-up"></i>
                                                </span>
                                                <span class="fw-semibold">Avg. Min. Score: <span id="selected-materials-minscore" class="text-success">0</span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        function updateMaterialCounts() {
                                            const checkboxes = document.querySelectorAll('.material-checkbox:checked');
                                            let count = 0;
                                            let totalSessions = 0;
                                            let totalMinScore = 0;
                                            let minScoreCount = 0;

                                            checkboxes.forEach(function(cb) {
                                                count++;
                                                let est = parseInt(cb.getAttribute('data-estimated-sessions')) || 0;
                                                let minScore = parseFloat(cb.getAttribute('data-min-score'));
                                                totalSessions += est;
                                                if (!isNaN(minScore) && minScore > 0) {
                                                    totalMinScore += minScore;
                                                    minScoreCount++;
                                                }
                                            });

                                            document.getElementById('selected-materials-count').textContent = count;
                                            document.getElementById('selected-materials-sessions').textContent = totalSessions;
                                            document.getElementById('selected-materials-minscore').textContent = minScoreCount > 0 ? (totalMinScore / minScoreCount).toFixed(2) : '0';
                                        }
                                        document.querySelectorAll('.material-checkbox').forEach(function (cb) {
                                            cb.addEventListener('change', updateMaterialCounts);
                                        });
                                        updateMaterialCounts();
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">Prev</button>
                    <div>
                        <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn" style="display: none;">Submit</button>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const tabs = ['step1', 'step2', 'step3'];
                        let currentTab = 0;

                        const prevBtn = document.getElementById('prevBtn');
                        const nextBtn = document.getElementById('nextBtn');
                        const submitBtn = document.getElementById('submitBtn');

                        function showTab(index) {
                            tabs.forEach((tab, i) => {
                                const tabPane = document.getElementById(tab);
                                const tabBtn = document.getElementById(tab + '-tab');
                                if (i === index) {
                                    tabPane.classList.add('show', 'active');
                                    tabBtn.classList.add('active');
                                    tabBtn.setAttribute('aria-selected', 'true');
                                } else {
                                    tabPane.classList.remove('show', 'active');
                                    tabBtn.classList.remove('active');
                                    tabBtn.setAttribute('aria-selected', 'false');
                                }
                            });

                            prevBtn.style.display = index === 0 ? 'none' : '';
                            nextBtn.style.display = index === tabs.length - 1 ? 'none' : '';
                            submitBtn.style.display = index === tabs.length - 1 ? '' : 'none';
                        }

                        prevBtn.addEventListener('click', function () {
                            if (currentTab > 0) {
                                currentTab--;
                                showTab(currentTab);
                            }
                        });

                        nextBtn.addEventListener('click', function () {
                            if (currentTab < tabs.length - 1) {
                                currentTab++;
                                showTab(currentTab);
                            }
                        });

                        // Also handle tab click (if user clicks tab header)
                        tabs.forEach((tab, i) => {
                            document.getElementById(tab + '-tab').addEventListener('click', function () {
                                currentTab = i;
                                showTab(currentTab);
                            });
                        });

                        showTab(currentTab);
                    });
                </script>
            </div>
        </form>
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
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views\courses\create.blade.php ENDPATH**/ ?>