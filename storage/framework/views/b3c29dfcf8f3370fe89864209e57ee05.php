<?php if (isset($component)) { $__componentOriginala6488acc797ee40bc55ed6344dee8ea1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala6488acc797ee40bc55ed6344dee8ea1 = $attributes; } ?>
<?php $component = App\View\Components\AuthLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AuthLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<h3>Attendance Summary for <?php echo e($course->name); ?></h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Student</th>
            <th>Total Sessions</th>
            <th>Attended Sessions</th>
            <th>Attendance Percentage</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $attendanceSummary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $summary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($summary['student']->user->name); ?></td>
                <td><?php echo e($summary['total_sessions']); ?></td>
                <td><?php echo e($summary['attended_sessions']); ?></td>
                <td><?php echo e(number_format($summary['attendance_percentage'], 2)); ?>%</td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala6488acc797ee40bc55ed6344dee8ea1)): ?>
<?php $attributes = $__attributesOriginala6488acc797ee40bc55ed6344dee8ea1; ?>
<?php unset($__attributesOriginala6488acc797ee40bc55ed6344dee8ea1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala6488acc797ee40bc55ed6344dee8ea1)): ?>
<?php $component = $__componentOriginala6488acc797ee40bc55ed6344dee8ea1; ?>
<?php unset($__componentOriginala6488acc797ee40bc55ed6344dee8ea1); ?>
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views\Attendance\summary.blade.php ENDPATH**/ ?>