<?php $__env->startSection('content'); ?>

    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center text-center p-10">
                <!--begin::Card-->
                <div class="card card-flush w-lg-650px py-5">
                    <!--begin::Card body-->
                    <div class="card-body py-15 py-lg-20">
                        <?php echo e($slot); ?>

                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Root-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\JITU\swim\resources\views\layout\_system.blade.php ENDPATH**/ ?>