<!-- Modal Penilaian Modern Metronic -->
<div class="modal fade" id="gradeModal<?php echo e($student->id); ?>" tabindex="-1" aria-labelledby="gradeModalLabel<?php echo e($student->id); ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <form method="POST" action="<?php echo e(route('grades.store', [$course->id, $student->id])); ?>" class="w-100">
            <?php echo csrf_field(); ?>
            <div class="modal-content rounded-4 shadow-lg border-0">
                <div class="modal-header bg-primary px-8 py-5 rounded-top-4 d-flex align-items-center">
                    <div class="symbol symbol-60px me-4">
                        <img src="<?php echo e($student->user->avatar ? asset('storage/'.$student->user->avatar) : asset('assets/media/avatars/default-avatar.png')); ?>"
                             alt="Avatar" class="symbol-label rounded-circle border border-3 border-white" width="56" height="56">
                    </div>
                    <div>
                        <div class="fw-bold fs-3 text-white"><?php echo e($student->user->name); ?></div>
                        <div class="fs-7 text-white">Usia: 
                            <?php
                                $birth = $student->birth_date ?? null;
                                $age = $birth ? \Carbon\Carbon::parse($birth)->age : '-';
                            ?>
                            <?php echo e($age); ?>

                            tahun
                        </div>
                    </div>
                    <button type="button" class="btn btn-icon btn-active-light-primary ms-auto" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-2x">
                            <i class="bi bi-x-lg text-white"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body px-8 py-6 bg-light rounded-bottom-4">
                    <?php $__currentLoopData = $course->materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $grade = $student->grades->where('material_id', $material->id)->first();
                        ?>
                        <div class="mb-6">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-semibold text-gray-800 fs-5">
                                    <i class="bi bi-journal-bookmark me-2 text-info"></i><?php echo e($material->name); ?>

                                </span>
                                <div class="btn-group btn-group-sm" role="group" aria-label="Score">
                                    <?php for($i=1;$i<=5;$i++): ?>
                                        <input type="radio"
                                            class="btn-check"
                                            name="grades[<?php echo e($material->id); ?>][score]"
                                            id="score-<?php echo e($student->id); ?>-<?php echo e($material->id); ?>-<?php echo e($i); ?>"
                                            value="<?php echo e($i); ?>"
                                            <?php if(optional($grade)->score == $i): echo 'checked'; endif; ?>
                                        >
                                        <label class="btn btn-light-primary fw-bold px-4 py-2"
                                            for="score-<?php echo e($student->id); ?>-<?php echo e($material->id); ?>-<?php echo e($i); ?>"><?php echo e($i); ?></label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <input type="text"
                                name="grades[<?php echo e($material->id); ?>][remarks]"
                                class="form-control form-control-solid form-control-sm mt-2"
                                placeholder="Catatan (opsional)"
                                value="<?php echo e($grade->remarks ?? ''); ?>">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="modal-footer py-4 px-8 border-0 d-flex justify-content-end bg-white rounded-bottom-4">
                    <button type="submit" class="btn btn-primary btn-sm px-8 py-2 rounded-pill">
                        <i class="bi bi-save me-2"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\Users\JITU\swim\resources\views/courses/partials/score-student-modal.blade.php ENDPATH**/ ?>