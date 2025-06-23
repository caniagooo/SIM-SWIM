<div>
    <div class="border rounded p-3 shadow-sm">
        <h5 class="text-muted mb-3">Calendar</h5>
        <div class="d-flex flex-wrap">
            <?php $__currentLoopData = range(1, 31); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="border p-2 m-1 text-center" style="width: 100px; cursor: pointer;" wire:click="selectDate('<?php echo e(now()->startOfMonth()->addDays($day - 1)->toDateString()); ?>')">
                    <?php echo e(now()->startOfMonth()->addDays($day - 1)->format('d')); ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div class="mt-4">
        <h5 class="text-muted">Time Slots</h5>
        
    </div>

    <div class="mt-4">
        <h5 class="text-muted">Summary</h5>
        <?php if($summary): ?>
            <p><strong>Course:</strong> <?php echo e($summary['course']); ?></p>
            <p><strong>Students:</strong> <?php echo e($summary['students']); ?></p>
            <p><strong>Trainer(s):</strong> <?php echo e($summary['trainers']); ?></p>
        <?php else: ?>
            <p class="text-muted">Select a date to see the summary.</p>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\Users\JITU\swim\resources\views\livewire\calendar.blade.php ENDPATH**/ ?>