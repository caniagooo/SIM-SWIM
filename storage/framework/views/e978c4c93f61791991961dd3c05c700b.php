<!-- Assign Trainer Modal -->
<div class="modal fade" id="assignTrainerModal-<?php echo e($course->id); ?>" tabindex="-1" aria-labelledby="assignTrainerModalLabel-<?php echo e($course->id); ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('courses.assign', $course->id)); ?>" method="POST" class="form-assign-trainer">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="assignTrainerModalLabel-<?php echo e($course->id); ?>">Pilih Pelatih</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="trainers-<?php echo e($course->id); ?>" class="form-label">Pelatih</label>
                        <select name="trainers[]" id="trainers-<?php echo e($course->id); ?>" class="form-select" multiple required>
                            <?php $__currentLoopData = $allTrainers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($trainer->id); ?>" <?php echo e($course->trainers->contains($trainer->id) ? 'selected' : ''); ?>>
                                    <?php echo e($trainer->user->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <small class="text-muted">Pilih satu atau lebih pelatih untuk kursus ini.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div><?php /**PATH C:\Users\JITU\swim\resources\views\courses\partials\assign-trainer-modal.blade.php ENDPATH**/ ?>