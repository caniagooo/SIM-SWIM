<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" <?php echo printHtmlAttributes('html'); ?>>
<!--begin::Head-->
<head>
    <base href=""/>
    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content=""/>
    <link rel="canonical" href="<?php echo e(url()->current()); ?>"/>

    <?php echo includeFavicon(); ?>


    <!--begin::Fonts-->
    <?php echo includeFonts(); ?>

    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <?php $__currentLoopData = getGlobalAssets('css'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo sprintf('<link rel="stylesheet" href="%s">', asset($path)); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <!--end::Global Stylesheets Bundle-->
    

    <!--begin::Vendor Stylesheets(used by this page)-->
    <?php $__currentLoopData = getVendors('css'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo sprintf('<link rel="stylesheet" href="%s">', asset($path)); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <!--end::Vendor Stylesheets-->

    <!--begin::Custom Stylesheets(optional)-->
    <?php $__currentLoopData = getCustomCss(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo sprintf('<link rel="stylesheet" href="%s">', asset($path)); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <!--end::Custom Stylesheets--> 

    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    


    
    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<!--end::Head-->

<!--begin::Body-->
<body <?php echo printHtmlClasses('body'); ?> <?php echo printHtmlAttributes('body'); ?>>

<?php echo $__env->make('partials/theme-mode/_init', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('content'); ?>

<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<?php $__currentLoopData = getGlobalAssets(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo sprintf('<script src="%s"></script>', asset($path)); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!--end::Global Javascript Bundle-->

<!--begin::Vendors Javascript(used by this page)-->
<?php $__currentLoopData = getVendors('js'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo sprintf('<script src="%s"></script>', asset($path)); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!--end::Vendors Javascript-->

<!--begin::Custom Javascript(optional)-->
<?php $__currentLoopData = getCustomJs(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo sprintf('<script src="%s"></script>', asset($path)); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!--end::Custom Javascript-->

<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php echo $__env->yieldPushContent('scripts'); ?>
<!--end::Javascript-->

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('success', (message) => {
            toastr.success(message);
        });
        Livewire.on('error', (message) => {
            toastr.error(message);
        });

        Livewire.on('swal', (message, icon, confirmButtonText) => {
            if (typeof icon === 'undefined') {
                icon = 'success';
            }
            if (typeof confirmButtonText === 'undefined') {
                confirmButtonText = 'Ok, got it!';
            }
            Swal.fire({
                text: message,
                icon: icon,
                buttonsStyling: false,
                confirmButtonText: confirmButtonText,
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        });
    });
</script>

<?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
<!--end::Body-->

</html>
<?php /**PATH C:\Users\JITU\swim\resources\views/layout/master.blade.php ENDPATH**/ ?>