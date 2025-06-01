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
        <!-- Row Pertama: Informasi Sesi dan Kursus -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Session Info</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Session:</strong> <?php echo e($session->id); ?> of <?php echo e($session->course->max_sessions); ?></p>
                        <p><strong>Date:</strong> <?php echo e(\Carbon\Carbon::parse($session->session_date)->translatedFormat('l, j F Y')); ?></p>
                        <p><strong>Time:</strong> <?php echo e(\Carbon\Carbon::parse($session->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($session->end_time)->format('H:i')); ?></p>
                        <p><strong>Venue:</strong> <?php echo e($session->course->venue->name ?? 'N/A'); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Course Info</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Course Name:</strong> <?php echo e($session->course->name); ?></p>
                        <p><strong>Course Type:</strong> <span class="badge bg-info"><?php echo e(ucfirst($session->course->type)); ?></span></p>
                        <p><strong>Trainer:</strong>
                            <?php if($session->course->trainers && $session->course->trainers->count()): ?>
                                <?php echo e($session->course->trainers->map(function($trainer) { return $trainer->user->name; })->join(', ')); ?>

                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </p>
                        <p><strong>Participant:</strong> <?php echo e($session->course->students->count()); ?> Peserta</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row Kedua: Daftar Murid dan Absensi -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">Student Attendance</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('attendance.store', $session->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <?php $__currentLoopData = $session->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card shadow-sm">
                                    <div class="card-body d-flex flex-column flex-sm-row align-items-center">
                                        <img src="<?php echo e($student->user->profile_picture ?? 'default-avatar.png'); ?>" alt="Profile Picture" class="rounded-circle me-3 mb-3 mb-sm-0" width="50" height="50">
                                        <div class="flex-grow-1 text-center text-sm-start">
                                            <p class="mb-0"><strong><?php echo e($student->user->name); ?></strong></p>
                                            <p class="mb-0 text-muted">Usia: 
                                                <?php if($student->birth_date): ?>
                                                    <?php echo e(\Carbon\Carbon::parse($student->birth_date)->age); ?> tahun
                                                <?php else: ?>
                                                    N/A
                                                <?php endif; ?>
                                            </p>
                                            <div class="btn-group mt-2" role="group" aria-label="Attendance Status">
                                                <input type="radio" class="btn-check" name="attendance[<?php echo e($student->id); ?>][status]" id="hadir-<?php echo e($student->id); ?>" value="hadir" autocomplete="off" 
                                                    <?php echo e($student->attendance && $student->attendance->status === 'hadir' ? 'checked' : ''); ?>>
                                                <label class="btn btn-outline-primary btn-sm" for="hadir-<?php echo e($student->id); ?>">Hadir</label>

                                                <input type="radio" class="btn-check" name="attendance[<?php echo e($student->id); ?>][status]" id="tidak-hadir-<?php echo e($student->id); ?>" value="tidak hadir" autocomplete="off" 
                                                    <?php echo e($student->attendance && $student->attendance->status === 'tidak hadir' ? 'checked' : ''); ?>>
                                                <label class="btn btn-outline-danger btn-sm" for="tidak-hadir-<?php echo e($student->id); ?>">Tidak Hadir</label>

                                                <input type="radio" class="btn-check" name="attendance[<?php echo e($student->id); ?>][status]" id="terlambat-<?php echo e($student->id); ?>" value="terlambat" autocomplete="off" 
                                                    <?php echo e($student->attendance && $student->attendance->status === 'terlambat' ? 'checked' : ''); ?>>
                                                <label class="btn btn-outline-warning btn-sm" for="terlambat-<?php echo e($student->id); ?>">Terlambat</label>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#scoreModal<?php echo e($student->id); ?>" id="score-button-<?php echo e($student->id); ?>">
                                            Score
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Box untuk Penilaian -->
                            <div class="modal fade" id="scoreModal<?php echo e($student->id); ?>" tabindex="-1" aria-labelledby="scoreModalLabel<?php echo e($student->id); ?>" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="scoreModalLabel<?php echo e($student->id); ?>">Score Materials for <?php echo e($student->user->name); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="score-form" action="<?php echo e(route('score.store', $student->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php $__currentLoopData = $session->course->materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="mb-3">
                                                        <p class="fw-bold"><?php echo e($material->name); ?></p>
                                                        <div class="d-flex align-items-center">
                                                            <!-- Skor -->
                                                            <div class="btn-group me-3" role="group" aria-label="Score Options">
                                                                <input type="radio" class="btn-check" name="scores[<?php echo e($material->id); ?>][score]" id="score-1-<?php echo e($student->id); ?>-<?php echo e($material->id); ?>" value="1" autocomplete="off">
                                                                <label class="btn btn-outline-secondary btn-sm" for="score-1-<?php echo e($student->id); ?>-<?php echo e($material->id); ?>">1</label>

                                                                <input type="radio" class="btn-check" name="scores[<?php echo e($material->id); ?>][score]" id="score-2-<?php echo e($student->id); ?>-<?php echo e($material->id); ?>" value="2" autocomplete="off">
                                                                <label class="btn btn-outline-secondary btn-sm" for="score-2-<?php echo e($student->id); ?>-<?php echo e($material->id); ?>">2</label>

                                                                <input type="radio" class="btn-check" name="scores[<?php echo e($material->id); ?>][score]" id="score-3-<?php echo e($student->id); ?>-<?php echo e($material->id); ?>" value="3" autocomplete="off">
                                                                <label class="btn btn-outline-secondary btn-sm" for="score-3-<?php echo e($student->id); ?>-<?php echo e($material->id); ?>">3</label>
                                                            </div>
                                                            <!-- Catatan -->
                                                            <textarea name="scores[<?php echo e($material->id); ?>][remarks]" class="form-control" rows="2" placeholder="Remarks (optional)"></textarea>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <button type="submit" class="btn btn-primary">Save Scores</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Absensi dan Skoring</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Objek untuk menyimpan data skoring sementara
        let scoringData = {};

        // Event listener untuk tombol Save Scores di modal box
        document.querySelectorAll('.score-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const studentId = this.getAttribute('action').split('/').pop(); // Ambil studentId dari URL
                scoringData[studentId] = {}; // Buat objek untuk murid ini

                // Ambil semua skor dan catatan dari form
                this.querySelectorAll('input[type="radio"]:checked').forEach(input => {
                    const materialId = input.name.match(/\[(\d+)\]/)[1]; // Ambil materialId dari nama input
                    scoringData[studentId][materialId] = {
                        score: input.value,
                        remarks: this.querySelector(`textarea[name="scores[${materialId}][remarks]"]`).value || null
                    };
                });

                // Update tombol Score untuk murid ini
                const scoreButton = document.querySelector(`#score-button-${studentId}`);
                scoreButton.innerHTML = '✔ Scored';
                scoreButton.classList.add('btn-success');
                scoreButton.classList.remove('btn-primary');

                // Tutup modal
                const modal = document.querySelector(`#scoreModal${studentId}`);
                modal.querySelector('.btn-close').click();
            });
        });

        document.querySelector('form[action="<?php echo e(route('attendance.store', $session->id)); ?>"]').addEventListener('submit', function (e) {
            e.preventDefault(); // Mencegah form dikirimkan secara default

            const formData = new FormData(this);

            // Tambahkan data skoring ke formData
            for (const studentId in scoringData) {
                for (const materialId in scoringData[studentId]) {
                    formData.append(`scores[${studentId}][${materialId}][score]`, scoringData[studentId][materialId].score);
                    formData.append(`scores[${studentId}][${materialId}][remarks]`, scoringData[studentId][materialId].remarks);
                }
            }

            // Kirim form menggunakan fetch
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json' // Ensure the server returns JSON
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Parse JSON response
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    alert('Scores saved successfully!');
                } else {
                    alert('Error saving scores!');
                }
            })
            .catch(error => console.error('Error:', error));

            console.log('Form Data:', Array.from(formData.entries()));
        });

        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
            button.addEventListener('click', function () {
                console.log('Modal opened:', this.getAttribute('data-bs-target'));
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
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views/attendance/show.blade.php ENDPATH**/ ?>