
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
    <div class="container">
        <h1 class="mb-4">Add Material</h1>
        <form action="<?php echo e(route('course-materials.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label for="level" class="form-label">Level</label>
                <input type="text" name="level" id="level" class="form-control" value="<?php echo e(old('level')); ?>" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
            </div>
            <div class="mb-3">
                <label for="estimated_sessions" class="form-label">Estimated Sessions</label>
                <input type="number" name="estimated_sessions" id="estimated_sessions" class="form-control" value="<?php echo e(old('estimated_sessions')); ?>" required>
            </div>
            <div class="mb-3">
                <label for="minimum_score" class="form-label">Minimum Score</label>
                <input type="number" name="minimum_score" id="minimum_score" class="form-control" value="<?php echo e(old('minimum_score')); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
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
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views/course-materials/create.blade.php ENDPATH**/ ?>