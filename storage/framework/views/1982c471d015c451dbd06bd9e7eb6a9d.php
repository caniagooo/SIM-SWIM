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
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title"><?php echo e(isset($session) ? 'Edit Session' : 'Add Session'); ?></h3>
            </div>
            <div class="card-body">
                <form action="<?php echo e(isset($session) ? route('sessions.update', [$course->id, $session->id]) : route('sessions.store', $course->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php if(isset($session)): ?>
                        <?php echo method_field('PUT'); ?>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="session_date" class="form-label">Session Date</label>
                        <input type="date" class="form-control" id="session_date" name="session_date" value="<?php echo e(old('session_date', $session->session_date ?? '')); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" value="<?php echo e(old('start_time', $session->start_time ?? '')); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" value="<?php echo e(old('end_time', $session->end_time ?? '')); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="scheduled" <?php echo e(old('status', $session->status ?? '') == 'scheduled' ? 'selected' : ''); ?>>Scheduled</option>
                            <option value="completed" <?php echo e(old('status', $session->status ?? '') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                            <option value="canceled" <?php echo e(old('status', $session->status ?? '') == 'canceled' ? 'selected' : ''); ?>>Canceled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php echo e(isset($session) ? 'Update Session' : 'Add Session'); ?></button>
                    <a href="<?php echo e(route('sessions.index', $course->id)); ?>" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
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
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views\sessions\form.blade.php ENDPATH**/ ?>