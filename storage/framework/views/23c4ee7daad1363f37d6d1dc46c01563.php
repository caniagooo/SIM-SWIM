<?php if (isset($component)) { $__componentOriginal1c2c063e3d1cf13aed2c850beccc389e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c2c063e3d1cf13aed2c850beccc389e = $attributes; } ?>
<?php $component = App\View\Components\SystemLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('system-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SystemLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php echo $__env->make('pages/system.not_found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c2c063e3d1cf13aed2c850beccc389e)): ?>
<?php $attributes = $__attributesOriginal1c2c063e3d1cf13aed2c850beccc389e; ?>
<?php unset($__attributesOriginal1c2c063e3d1cf13aed2c850beccc389e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c2c063e3d1cf13aed2c850beccc389e)): ?>
<?php $component = $__componentOriginal1c2c063e3d1cf13aed2c850beccc389e; ?>
<?php unset($__componentOriginal1c2c063e3d1cf13aed2c850beccc389e); ?>
<?php endif; ?>
<?php /**PATH C:\Users\JITU\swim\resources\views/errors/404.blade.php ENDPATH**/ ?>