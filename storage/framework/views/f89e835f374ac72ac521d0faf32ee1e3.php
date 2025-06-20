<!-- Assign Materials Modal -->
<div class="modal fade" id="assignMaterialsModal-<?php echo e($course->id); ?>" tabindex="-1" aria-labelledby="assignMaterialsModalLabel-<?php echo e($course->id); ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo e(route('courses.assign', $course->id)); ?>" method="POST" class="form-assign-materials">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="assignMaterialsModalLabel-<?php echo e($course->id); ?>">Pilih Materi Kursus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 mb-4">
                        <div class="fs-6">
                            <div class="fw-bold">Catatan terkait murid:</div>
                        </div>
                        <i class="fs-6"><?php echo e($course->basic_skills ?: '-'); ?></i>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Pilih Materi:</strong></label>
                        <div class="accordion accordion-icon-toggle" id="materialsAccordion-<?php echo e($course->id); ?>">
                            <?php
                                $groupedMaterials = $allMaterials->groupBy('level');
                                $selectedMaterialIds = $course->materials->pluck('id')->toArray();
                            ?>
                            <?php $__currentLoopData = $groupedMaterials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level => $materials): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-<?php echo e($course->id); ?>-<?php echo e($level); ?>">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse-<?php echo e($course->id); ?>-<?php echo e($level); ?>"
                                            aria-expanded="false"
                                            aria-controls="collapse-<?php echo e($course->id); ?>-<?php echo e($level); ?>">
                                            <span class="fw-bold">Level <?php echo e($level); ?></span>
                                        </button>
                                    </h2>
                                    <div id="collapse-<?php echo e($course->id); ?>-<?php echo e($level); ?>"
                                        class="accordion-collapse collapse"
                                        aria-labelledby="heading-<?php echo e($course->id); ?>-<?php echo e($level); ?>"
                                        data-bs-parent="#materialsAccordion-<?php echo e($course->id); ?>">
                                        <div class="accordion-body p-0">
                                            <div class="list-group list-group-flush">
                                                <?php $__empty_1 = true; $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <label class="list-group-item d-flex align-items-center py-3 px-3" style="border-bottom: 1px solid #f1f1f1;">
                                                        <input 
                                                            type="checkbox" 
                                                            name="materials[]" 
                                                            value="<?php echo e($material->id); ?>" 
                                                            class="form-check-input material-checkbox-<?php echo e($course->id); ?> me-3 ms-1"
                                                            style="margin-left: 0.5rem; margin-right: 1rem;"
                                                            data-estimasi="<?php echo e($material->estimated_sessions); ?>"
                                                            data-minscore="<?php echo e($material->minimum_score); ?>"
                                                            <?php echo e(in_array($material->id, $selectedMaterialIds) ? 'checked' : ''); ?>

                                                        >
                                                        <div class="flex-grow-1">
                                                            <div class="fw-semibold fs-6 mb-1"><?php echo e($material->name); ?></div>
                                                            <div class="d-flex flex-wrap gap-3 small text-muted">
                                                                <span><i class="bi bi-clock me-1"></i> Estimasi: <span class="fw-bold"><?php echo e($material->estimated_sessions); ?></span> sesi</span>
                                                                <span><i class="bi bi-star me-1"></i> Min. Skor: <span class="fw-bold"><?php echo e($material->minimum_score); ?></span></span>
                                                            </div>
                                                        </div>
                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <div class="text-muted px-3 py-2">Tidak ada materi pada level ini.</div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div class="border-top pt-3 mt-3">
                        <div class="row text-center">
                            <div class="col">
                                <div class="fw-bold fs-6">Materi Terpilih</div>
                                <div id="selectedCount-<?php echo e($course->id); ?>"></div>
                            </div>
                            <div class="col">
                                <div class="fw-bold fs-6">Total Estimasi Sesi</div>
                                <div id="totalSessions-<?php echo e($course->id); ?>"></div>
                            </div>
                            <div class="col">
                                <div class="fw-bold fs-6">Rata-rata Min. Skor</div>
                                <div id="avgMinScore-<?php echo e($course->id); ?>"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div><?php /**PATH C:\Users\JITU\swim\resources\views/courses/partials/assign-materials-modal.blade.php ENDPATH**/ ?>