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
    <!--begin::Verify Email Form-->
    <div class="w-100">

        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-gray-900 fw-bolder mb-3">Verify Email</h1>
            <!--end::Title-->
            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another</div>
            <!--end::Subtitle=-->

            <!--begin::Session Status-->
            <?php if(session('status') === 'verification-link-sent'): ?>
                <p class="font-medium text-sm text-gray-500 mt-4">
                    <?php echo e(__('A new verification link has been sent to the email address you provided during registration.')); ?>

                </p>
            <?php endif; ?>
        <!--end::Session Status-->
        </div>

        <!--begin::Actions-->
        <div class="d-flex flex-wrap justify-content-center pb-lg-0">

            <form method="POST" action="<?php echo e(route('verification.send')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-lg btn-primary fw-bolder me-4"><?php echo e(__('Resend Verification Email')); ?></button>
            </form>

            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-lg btn-light-primary fw-bolder me-4"><?php echo e(__('Log out')); ?></button>
            </form>
        </div>
        <!--end::Actions-->
    </div>

    <!--end::Verify Email Form-->
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
<?php /**PATH C:\Users\JITU\swim\resources\views\pages\auth\verify-email.blade.php ENDPATH**/ ?>