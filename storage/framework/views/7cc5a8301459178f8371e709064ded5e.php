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
    
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container-xxl" id="kt_content_container">
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">Edit Venue</h3>
                </div>
                <form action="<?php echo e(route('venues.update', $venue->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Venue</label>
                            <input type="text" name="name" class="form-control" value="<?php echo e($venue->name); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Kepemilikan</label>
                            <select name="ownership" class="form-control" required>
                                <option value="club" <?php echo e($venue->ownership == 'club' ? 'selected' : ''); ?>>Milik Klub</option>
                                <option value="third_party" <?php echo e($venue->ownership == 'third_party' ? 'selected' : ''); ?>>Kerjasama</option>
                                <option value="private" <?php echo e($venue->ownership == 'private' ? 'selected' : ''); ?>>Pribadi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="address" class="form-control" required><?php echo e($venue->address); ?></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?php echo e(route('venues.index')); ?>" class="btn btn-secondary">Batal</a>
                    </div>
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
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views\venues\edit.blade.php ENDPATH**/ ?>