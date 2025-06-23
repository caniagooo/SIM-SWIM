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
    <!--begin::Forgot Password Form-->
    <form class="form w-100 " novalidate="novalidate" id="kt_password_reset_form" action="<?php echo e(route('password.email')); ?>">
    <?php echo csrf_field(); ?>

    <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-gray-900 fw-bolder mb-3">Confirm Password</h1>
            <!--end::Title-->
            <!--begin::Link-->
            <div class="text-gray-500 fw-semibold fs-6">This is a secure area of the application. Please confirm your password before continuing.</div>
            <!--end::Link-->
        </div>
        <!--begin::Heading-->
        <!--begin::Input group=-->
        <div class="fv-row mb-8 fv-plugins-icon-container">
            <!--begin::Email-->
            <input placeholder="Password" type="password" name="password" autocomplete="current-password" class="form-control bg-transparent">
            <!--end::Email-->
        </div>
        <!--begin::Actions-->
        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="button" id="kt_password_reset_submit" class="btn btn-primary me-4">
                <?php echo $__env->make('partials.general._button-indicator', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </button>
            <a href="<?php echo e(route('login')); ?>" class="btn btn-light">Cancel</a>
        </div>
        <!--end::Actions-->
        <div></div>
    </form>
    <!--end::Forgot Password Form-->

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala6488acc797ee40bc55ed6344dee8ea1)): ?>
<?php $attributes = $__attributesOriginala6488acc797ee40bc55ed6344dee8ea1; ?>
<?php unset($__attributesOriginala6488acc797ee40bc55ed6344dee8ea1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala6488acc797ee40bc55ed6344dee8ea1)): ?>
<?php $component = $__componentOriginala6488acc797ee40bc55ed6344dee8ea1; ?>
<?php unset($__componentOriginala6488acc797ee40bc55ed6344dee8ea1); ?>
<?php endif; ?>
<?php /**PATH C:\Users\JITU\swim\resources\views\pages\auth\confirm-password.blade.php ENDPATH**/ ?>