<!--begin:: Avatar -->
<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
    <a href="<?php echo e(route('user-management.users.show', $user)); ?>">
        <?php if($user->profile_photo_url): ?>
            <div class="symbol-label">
                <img src="<?php echo e($user->profile_photo_url); ?>" class="w-100"/>
            </div>
        <?php else: ?>
            <div class="symbol-label fs-3 <?php echo e(app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', $user->name)); ?>">
                <?php echo e(substr($user->name, 0, 1)); ?>

            </div>
        <?php endif; ?>
    </a>
</div>
<!--end::Avatar-->
<!--begin::User details-->
<div class="d-flex flex-column">
    <a href="<?php echo e(route('user-management.users.show', $user)); ?>" class="text-gray-800 text-hover-primary mb-1">
        <?php echo e($user->name); ?>

    </a>
    <span><?php echo e($user->email); ?></span>
</div>
<!--begin::User details-->
<?php /**PATH C:\Users\JITU\swim\resources\views/pages/apps/user-management/users/columns/_user.blade.php ENDPATH**/ ?>