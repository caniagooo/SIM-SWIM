<!-- Modal Penilaian -->
<div class="modal fade" id="gradeModal<?php echo e($student->id); ?>" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="<?php echo e(route('grades.store', [$course->id, $student->id])); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Penilaian: <?php echo e($student->user->name); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php $__currentLoopData = $course->materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $grade = $student->grades->where('material_id', $material->id)->first();
                        ?>
                        <div class="mb-3">
                            <label class="form-label"><?php echo e($material->name); ?></label>
                            <select name="grades[<?php echo e($material->id); ?>][score]" class="form-select">
                                <option value="">-</option>
                                <?php for($i=1;$i<=5;$i++): ?>
                                    <option value="<?php echo e($i); ?>" <?php if(optional($grade)->score == $i): echo 'selected'; endif; ?>><?php echo e($i); ?></option>
                                <?php endfor; ?>
                            </select>
                            <input type="text" name="grades[<?php echo e($material->id); ?>][remarks]" class="form-control mt-1" placeholder="Catatan" value="<?php echo e($grade->remarks ?? ''); ?>">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div><?php /**PATH C:\Users\JITU\swim\resources\views/courses/partials/score-student-modal.blade.php ENDPATH**/ ?>